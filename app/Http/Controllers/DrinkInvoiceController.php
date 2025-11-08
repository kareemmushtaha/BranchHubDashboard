<?php

namespace App\Http\Controllers;

use App\Models\DrinkInvoice;
use App\Models\DrinkInvoiceItem;
use App\Models\User;
use App\Models\Drink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DrinkInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DrinkInvoice::with(['user', 'items.drink'])
            ->orderBy('created_at', 'desc');

        // Search by invoice ID or user name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by payment status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $perPage = $request->get('per_page', 15);
        $invoices = $query->paginate($perPage)->withQueryString();

        return view('drink-invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $userId = $request->get('user_id');
        $user = $userId ? User::find($userId) : null;
        $drinks = Drink::where('status', 'available')->get();

        return view('drink-invoices.create', compact('user', 'drinks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $invoice = DrinkInvoice::create([
            'user_id' => $request->user_id,
            'total_price' => 0,
            'payment_status' => 'pending',
            'amount_bank' => 0,
            'amount_cash' => 0,
            'remaining_amount' => 0,
            'note' => $request->note
        ]);

        return redirect()->route('drink-invoices.show', $invoice)
            ->with('success', 'تم إنشاء فاتورة المشروبات بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(DrinkInvoice $drinkInvoice)
    {
        $drinkInvoice->load(['user', 'items.drink']);
        $drinks = Drink::where('status', 'available')->get();

        return view('drink-invoices.show', compact('drinkInvoice', 'drinks'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DrinkInvoice $drinkInvoice)
    {
        $drinkInvoice->load(['user', 'items.drink']);
        return view('drink-invoices.edit', compact('drinkInvoice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DrinkInvoice $drinkInvoice)
    {
        $request->validate([
            'amount_bank' => 'nullable|numeric|min:0',
            'amount_cash' => 'nullable|numeric|min:0',
            'payment_status' => 'required|in:pending,paid,partial,cancelled',
            'note' => 'nullable|string'
        ]);

        $drinkInvoice->update([
            'amount_bank' => $request->amount_bank ?? 0,
            'amount_cash' => $request->amount_cash ?? 0,
            'payment_status' => $request->payment_status,
            'note' => $request->note
        ]);

        $drinkInvoice->updateRemainingAmount();

        return redirect()->route('drink-invoices.show', $drinkInvoice)
            ->with('success', 'تم تحديث الفاتورة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DrinkInvoice $drinkInvoice)
    {
        $drinkInvoice->delete();

        return redirect()->route('drink-invoices.index')
            ->with('success', 'تم حذف الفاتورة بنجاح');
    }

    /**
     * Add drink to invoice
     */
    public function addDrink(Request $request, DrinkInvoice $drinkInvoice)
    {
        $request->validate([
            'drink_id' => 'required|exists:drinks,id',
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string'
        ]);

        $drink = Drink::findOrFail($request->drink_id);
        $quantity = $request->quantity ?? 1;
        $totalPrice = $drink->price * $quantity;

        DrinkInvoiceItem::create([
            'drink_invoice_id' => $drinkInvoice->id,
            'drink_id' => $request->drink_id,
            'quantity' => $quantity,
            'price' => $totalPrice,
            'status' => 'ordered',
            'note' => $request->note
        ]);

        $drinkInvoice->updateTotal();

        return redirect()->back()->with('success', 'تم إضافة المشروب بنجاح');
    }

    /**
     * Remove drink from invoice
     */
    public function removeDrink(DrinkInvoice $drinkInvoice, DrinkInvoiceItem $item)
    {
        if ($item->drink_invoice_id !== $drinkInvoice->id) {
            return redirect()->back()->with('error', 'المشروب لا ينتمي لهذه الفاتورة');
        }

        $item->delete();
        $drinkInvoice->updateTotal();

        return redirect()->back()->with('success', 'تم حذف المشروب بنجاح');
    }

    /**
     * Update drink item date
     */
    public function updateDrinkDate(Request $request, DrinkInvoice $drinkInvoice, DrinkInvoiceItem $item)
    {
        if ($item->drink_invoice_id !== $drinkInvoice->id) {
            return redirect()->back()->with('error', 'المشروب لا ينتمي لهذه الفاتورة');
        }

        $request->validate([
            'created_at' => 'required|date'
        ]);

        $oldDate = $item->created_at->format('Y-m-d H:i:s');
        $newDate = \Carbon\Carbon::parse($request->created_at);

        DB::table('drink_invoice_items')
            ->where('id', $item->id)
            ->update([
                'created_at' => $newDate,
                'updated_at' => now()
            ]);

        $item->refresh();

        return redirect()->back()->with('success', 'تم تحديث تاريخ ووقت المشروب بنجاح');
    }

    /**
     * Generate PDF invoice for the drink invoice
     */
    public function generateInvoice(DrinkInvoice $drinkInvoice)
    {
        try {
            // Load the drink invoice with relationships
            $drinkInvoice->load(['user', 'items.drink']);
            
            // Generate PDF using DOMPDF
            $pdf = \PDF::loadView('drink-invoices.invoice-pdf', compact('drinkInvoice'));
            
            // Set basic PDF options
            $pdf->setPaper('A4', 'portrait');
            
            $filename = 'drink_invoice_' . $drinkInvoice->id . '_' . date('Y-m-d_H-i-s') . '.pdf';
            
            return $pdf->download($filename);
            
        } catch (\Exception $e) {
            \Log::error('Error generating drink invoice PDF', [
                'drink_invoice_id' => $drinkInvoice->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->with('error', 'حدث خطأ في إنشاء الفاتورة: ' . $e->getMessage());
        }
    }

    /**
     * Show invoice as HTML page for printing
     */
    public function showInvoice(DrinkInvoice $drinkInvoice)
    {
        try {
            // Load the drink invoice with relationships
            $drinkInvoice->load(['user', 'items.drink']);
            
            return view('drink-invoices.invoice-pdf', compact('drinkInvoice'));
            
        } catch (\Exception $e) {
            \Log::error('Error showing drink invoice', [
                'drink_invoice_id' => $drinkInvoice->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->with('error', 'حدث خطأ في عرض الفاتورة: ' . $e->getMessage());
        }
    }
}
