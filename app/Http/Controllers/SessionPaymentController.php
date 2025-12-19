<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\SessionPayment;
use Illuminate\Http\Request;

class SessionPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('view session payments');
        $query = SessionPayment::with(['session.user'])
            ->orderBy('created_at', 'desc');

        // Search by session ID or user name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('session', function ($sessionQuery) use ($search) {
                      $sessionQuery->where('id', 'like', "%{$search}%")
                          ->orWhereHas('user', function ($userQuery) use ($search) {
                              $userQuery->where('name', 'like', "%{$search}%");
                          });
                  });
            });
        }

        // Filter by payment status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Pagination
        $perPage = $request->get('per_page', 15);
        $payments = $query->paginate($perPage)->withQueryString();

        // Statistics
        $stats = [
            'total_payments' => SessionPayment::count(),
            'pending_payments' => SessionPayment::where('payment_status', 'pending')->count(),
            'paid_payments' => SessionPayment::where('payment_status', 'paid')->count(),
            'partial_payments' => SessionPayment::where('payment_status', 'partial')->count(),
            'total_revenue' => SessionPayment::where('payment_status', '!=', 'cancelled')->sum('total_price'),
        ];

        // Add refund-related statistics
        $refundStats = [
            'total_refunds' => SessionPayment::whereRaw('(amount_bank + amount_cash) > total_price')->sum(\Illuminate\Support\Facades\DB::raw('(amount_bank + amount_cash) - total_price')),
            'refund_sessions' => SessionPayment::whereRaw('(amount_bank + amount_cash) > total_price')->count(),
            'total_remaining' => SessionPayment::whereRaw('(amount_bank + amount_cash) < total_price')->sum(\Illuminate\Support\Facades\DB::raw('total_price - (amount_bank + amount_cash)')),
        ];

        $stats = array_merge($stats, $refundStats);

        return view('session-payments.index', compact('payments', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $this->authorize('create session payments');
        // Get available sessions that don't have payments yet
        $sessions = Session::whereDoesntHave('payment')
            ->with(['user', 'drinks'])
            ->where('session_status', '!=', 'cancelled')
            ->orderBy('created_at', 'desc')
            ->get();

        // Pre-select session if provided
        $selectedSessionId = $request->get('session_id');

        return view('session-payments.create', compact('sessions', 'selectedSessionId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create session payments');
        // Calculate refund amount to determine if note is required
        $session = Session::find($request->session_id);
        $sessionTotal = 0;
        if ($session) {
            $session->load('overtimes');
            $sessionTotal = $session->calculateInternetCost() + $session->drinks->sum('price') + $session->calculateOvertimeCost();
        }
        $totalPaid = ($request->amount_bank ?? 0) + ($request->amount_cash ?? 0);
        $refundAmount = max(0, $totalPaid - $sessionTotal);

        $request->validate([
            'session_id' => 'required|exists:user_sessions,id',
            'total_price' => 'required|numeric|min:0',
            'amount_bank' => 'nullable|numeric|min:0',
            'amount_cash' => 'nullable|numeric|min:0',
            'payment_status' => 'required|in:pending,paid,partial,cancelled',
            'note' => $refundAmount > 0 ? 'required|string|max:1000' : 'nullable|string|max:1000',
        ], [
            'note.required' => 'الملاحظة مطلوبة عندما يكون هناك مبلغ مستحق للزبون',
        ]);

        // Calculate remaining amount
        $totalPaid = ($request->amount_bank ?? 0) + ($request->amount_cash ?? 0);
        $remainingAmount = max(0, $request->total_price - $totalPaid);

        // Auto-update payment status based on amounts
        $paymentStatus = $request->payment_status;
        if ($totalPaid >= $request->total_price) {
            $paymentStatus = 'paid';
            $remainingAmount = 0;
        } elseif ($totalPaid > 0) {
            $paymentStatus = 'partial';
        }

        $payment = SessionPayment::create([
            'session_id' => $request->session_id,
            'total_price' => $request->total_price,
            'amount_bank' => $request->amount_bank ?? 0,
            'amount_cash' => $request->amount_cash ?? 0,
            'payment_status' => $paymentStatus,
            'remaining_amount' => $remainingAmount,
            'note' => $request->note,
        ]);

        return redirect()->route('session-payments.index')
            ->with('success', 'تم إنشاء دفعة الجلسة بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(SessionPayment $sessionPayment)
    {
        $this->authorize('view session payments');
        $sessionPayment->load(['session.user', 'session.drinks']);
        return view('session-payments.show', compact('sessionPayment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SessionPayment $sessionPayment)
    {
        $this->authorize('edit session payments');
        // السماح بتعديل المدفوعة بغض النظر عن حالة الجلسة
        // يمكن تعديل المدفوعة حتى لو كانت الجلسة نشطة أو مكتملة
        $sessionPayment->load(['session.user', 'session.drinks']);
        return view('session-payments.edit', compact('sessionPayment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SessionPayment $sessionPayment)
    {
        $this->authorize('edit session payments');
        // السماح بتحديث المدفوعة بغض النظر عن حالة الجلسة
        // يمكن تحديث المدفوعة حتى لو كانت الجلسة نشطة أو مكتملة

        // Calculate refund amount to determine if note is required
        $sessionTotal = 0;
        if ($sessionPayment->session) {
            $sessionPayment->session->load('overtimes');
            $sessionTotal = $sessionPayment->session->calculateInternetCost() + $sessionPayment->session->drinks->sum('price') + $sessionPayment->session->calculateOvertimeCost();
        }
        $totalPaid = ($request->amount_bank ?? 0) + ($request->amount_cash ?? 0);
        $refundAmount = max(0, $totalPaid - $sessionTotal);

        // Simple validation - allow all fields to be optional except total_price
        $request->validate([
            'total_price' => 'required|numeric|min:0',
            'amount_bank' => 'nullable|numeric|min:0',
            'amount_cash' => 'nullable|numeric|min:0',
            'payment_status' => 'required|in:pending,paid,partial,cancelled',
            'note' => 'nullable|string|max:1000',
        ], [
            'total_price.required' => 'السعر الإجمالي مطلوب',
            'total_price.numeric' => 'السعر الإجمالي يجب أن يكون رقماً',
            'total_price.min' => 'السعر الإجمالي يجب أن يكون أكبر من صفر',
            'amount_bank.numeric' => 'المبلغ المدفوع بنكياً يجب أن يكون رقماً',
            'amount_bank.min' => 'المبلغ المدفوع بنكياً يجب أن يكون أكبر من أو يساوي صفر',
            'amount_cash.numeric' => 'المبلغ المدفوع كاش يجب أن يكون رقماً',
            'amount_cash.min' => 'المبلغ المدفوع كاش يجب أن يكون أكبر من أو يساوي صفر',
            'payment_status.required' => 'حالة الدفع مطلوبة',
            'payment_status.in' => 'حالة الدفع غير صحيحة',
        ]);

        // Ensure numeric values and handle empty values
        $totalPrice = floatval($request->total_price);
        $amountBank = $request->amount_bank !== null && $request->amount_bank !== '' ? floatval($request->amount_bank) : 0;
        $amountCash = $request->amount_cash !== null && $request->amount_cash !== '' ? floatval($request->amount_cash) : 0;
        
        // Calculate remaining amount
        $totalPaid = $amountBank + $amountCash;
        $remainingAmount = max(0, $totalPrice - $totalPaid);

        // Auto-update payment status based on amounts
        $paymentStatus = $request->payment_status;
        if ($totalPaid >= $totalPrice) {
            $paymentStatus = 'paid';
            $remainingAmount = 0;
        } elseif ($totalPaid > 0) {
            $paymentStatus = 'partial';
        } else {
            $paymentStatus = 'pending';
        }

        try {
            // Log the data being updated
            \Log::info('Updating SessionPayment', [
                'payment_id' => $sessionPayment->id,
                'request_data' => $request->all(),
                'processed_data' => [
                    'total_price' => $totalPrice,
                    'amount_bank' => $amountBank,
                    'amount_cash' => $amountCash,
                    'payment_status' => $paymentStatus,
                    'remaining_amount' => $remainingAmount,
                    'note' => $request->note,
                ]
            ]);

            $sessionPayment->update([
                'total_price' => $totalPrice,
                'amount_bank' => $amountBank,
                'amount_cash' => $amountCash,
                'payment_status' => $paymentStatus,
                'remaining_amount' => $remainingAmount,
                'note' => $request->note,
            ]);

            \Log::info('SessionPayment updated successfully', [
                'payment_id' => $sessionPayment->id
            ]);

            return redirect()->route('sessions.show', $sessionPayment->session_id)
                ->with('success', 'تم تحديث دفعة الجلسة بنجاح');
        } catch (\Exception $e) {
            \Log::error('Error updating SessionPayment', [
                'payment_id' => $sessionPayment->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'حدث خطأ أثناء تحديث المدفوعة: ' . $e->getMessage());
        }
    }

    /**
     * Show invoice as HTML page for printing.
     */
    public function showInvoice(SessionPayment $sessionPayment)
    {
        $this->authorize('view session payment invoice');
        try {
            // Load the session payment with relationships
            $sessionPayment->load(['session.user', 'session.drinks.drink', 'session.overtimes']);
            
            return view('session-payments.invoice-html-english', compact('sessionPayment'));
            
        } catch (\Exception $e) {
            \Log::error('Error showing invoice', [
                'session_payment_id' => $sessionPayment->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->with('error', 'حدث خطأ في عرض الفاتورة: ' . $e->getMessage());
        }
    }

    /**
     * Generate PDF invoice for the session payment.
     */
    public function generateInvoice(Request $request, SessionPayment $sessionPayment)
    {
        $this->authorize('generate session payment invoice');
        try {
            // Load the session payment with relationships
            $sessionPayment->load(['session.user', 'session.drinks.drink', 'session.overtimes']);
            
            // Get invoice date from request, default to current date
            $invoiceDate = $request->get('invoice_date', now()->format('Y-m-d'));
            
            // Use DOMPDF with HTML entities for Arabic support
            return $this->generateDOMPDF($sessionPayment, $invoiceDate);
            
        } catch (\Exception $e) {
            \Log::error('Error generating invoice PDF', [
                'session_payment_id' => $sessionPayment->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->with('error', 'حدث خطأ في إنشاء الفاتورة: ' . $e->getMessage());
        }
    }
    

    
    /**
     * Generate PDF using DOMPDF with English content
     */
    private function generateDOMPDF(SessionPayment $sessionPayment, $invoiceDate = null)
    {
        // Use provided invoice date or default to current date
        $invoiceDate = $invoiceDate ? \Carbon\Carbon::parse($invoiceDate) : now();
        
        $pdf = \PDF::loadView('session-payments.invoice-pdf-english', compact('sessionPayment', 'invoiceDate'));
        
        // Set basic PDF options
        $pdf->setPaper('A4', 'portrait');
        
        $filename = 'invoice_' . $sessionPayment->session->id . '_' . date('Y-m-d_H-i-s') . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SessionPayment $sessionPayment)
    {
        $this->authorize('delete session payments');
        $sessionPayment->delete();
        
        return redirect()->route('session-payments.index')
            ->with('success', 'تم حذف دفعة الجلسة بنجاح');
    }
}
