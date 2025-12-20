<?php

namespace App\Http\Controllers;

use App\Models\DrinkInvoice;
use App\Models\DrinkInvoiceItem;
use App\Models\User;
use App\Models\Drink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DrinkInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('view drink invoices');
        
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
     * Check if user can create a new invoice
     */
    private function canCreateInvoice($userId)
    {
        // التحقق من وجود فواتير غير مدفوعة أو مدفوعة جزئياً
        $unpaidInvoices = DrinkInvoice::where('user_id', $userId)
            ->whereIn('payment_status', ['pending', 'partial'])
            ->exists();
        
        return !$unpaidInvoices;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $this->authorize('create drink invoices');
        
        $userId = $request->get('user_id');
        $user = $userId ? User::find($userId) : null;
        
        // التحقق من إمكانية إنشاء فاتورة جديدة
        if ($user && !$this->canCreateInvoice($user->id)) {
            return redirect()->back()
                ->with('error', 'لا يمكن إنشاء فاتورة جديدة. يجب أن تكون جميع الفواتير السابقة مدفوعة بالكامل أولاً.');
        }
        
        $drinks = Drink::where('status', 'available')->get();

        return view('drink-invoices.create', compact('user', 'drinks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create drink invoices');
        
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'created_at' => 'nullable|date_format:Y-m-d\TH:i',
        ]);

        // التحقق من إمكانية إنشاء فاتورة جديدة
        if (!$this->canCreateInvoice($request->user_id)) {
            return redirect()->back()
                ->with('error', 'لا يمكن إنشاء فاتورة جديدة. يجب أن تكون جميع الفواتير السابقة مدفوعة بالكامل أولاً.')
                ->withInput();
        }

        $invoice = DrinkInvoice::create([
            'user_id' => $request->user_id,
            'total_price' => 0,
            'payment_status' => 'pending',
            'amount_bank' => 0,
            'amount_cash' => 0,
            'remaining_amount' => 0,
            'note' => $request->note
        ]);

        if ($request->filled('created_at')) {
            $customCreatedAt = Carbon::createFromFormat('Y-m-d\TH:i', $request->created_at);
            $invoice->created_at = $customCreatedAt;
            $invoice->updated_at = $customCreatedAt;
            $invoice->save();
        }

        return redirect()->route('drink-invoices.show', $invoice)
            ->with('success', 'تم إنشاء فاتورة المشروبات بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(DrinkInvoice $drinkInvoice)
    {
        $this->authorize('view drink invoices');
        
        $drinkInvoice->load(['user', 'items.drink']);
        $drinks = Drink::where('status', 'available')->get();

        return view('drink-invoices.show', compact('drinkInvoice', 'drinks'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DrinkInvoice $drinkInvoice)
    {
        $this->authorize('edit drink invoices');
        
        $drinkInvoice->load(['user', 'items.drink']);
        return view('drink-invoices.edit', compact('drinkInvoice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DrinkInvoice $drinkInvoice)
    {
        $this->authorize('edit drink invoices');
        
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

        // تحديث المبلغ المتبقي فقط دون تغيير حالة الدفع (لأنها محددة يدوياً)
        $totalPaid = $drinkInvoice->amount_bank + $drinkInvoice->amount_cash;
        $drinkInvoice->remaining_amount = max(0, $drinkInvoice->total_price - $totalPaid);
        $drinkInvoice->save();

        return redirect()->route('drink-invoices.show', $drinkInvoice)
            ->with('success', 'تم تحديث الفاتورة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DrinkInvoice $drinkInvoice)
    {
        $this->authorize('delete drink invoices');
        
        $drinkInvoice->delete();

        return redirect()->route('drink-invoices.index')
            ->with('success', 'تم حذف الفاتورة بنجاح');
    }

    /**
     * Add drink to invoice
     */
    public function addDrink(Request $request, DrinkInvoice $drinkInvoice)
    {
        $this->authorize('add drink to invoice');
        
        // منع إضافة مشروبات للفاتورة المدفوعة بالكامل
        if ($drinkInvoice->payment_status == 'paid') {
            return redirect()->back()->with('error', 'لا يمكن إضافة مشروبات للفاتورة المدفوعة بالكامل');
        }

        $request->validate([
            'drink_id' => 'required|exists:drinks,id',
            'quantity' => 'required|integer|min:1',
            'created_at' => 'nullable|date_format:Y-m-d\TH:i',
            'note' => 'nullable|string'
        ]);

        $drink = Drink::findOrFail($request->drink_id);
        $quantity = $request->quantity ?? 1;
        $unitPrice = $drink->price; // حفظ سعر الوحدة في وقت الإضافة
        $totalPrice = $unitPrice * $quantity;

        $itemData = [
            'drink_invoice_id' => $drinkInvoice->id,
            'drink_id' => $request->drink_id,
            'unit_price' => $unitPrice, // حفظ سعر الوحدة
            'quantity' => $quantity,
            'price' => $totalPrice,
            'status' => 'ordered',
            'note' => $request->note
        ];

        $item = DrinkInvoiceItem::create($itemData);

        // تحديث تاريخ الإنشاء إذا تم تحديده
        if ($request->filled('created_at')) {
            $customCreatedAt = Carbon::createFromFormat('Y-m-d\TH:i', $request->created_at);
            DB::table('drink_invoice_items')
                ->where('id', $item->id)
                ->update([
                    'created_at' => $customCreatedAt,
                    'updated_at' => $customCreatedAt
                ]);
        }

        $drinkInvoice->updateTotal();

        return redirect()->back()->with('success', 'تم إضافة المشروب بنجاح');
    }

    /**
     * Remove drink from invoice
     */
    public function removeDrink(DrinkInvoice $drinkInvoice, DrinkInvoiceItem $item)
    {
        $this->authorize('remove drink from invoice');
        
        // منع حذف المشروبات من الفاتورة المدفوعة بالكامل
        if ($drinkInvoice->payment_status == 'paid') {
            return redirect()->back()->with('error', 'لا يمكن حذف مشروبات من الفاتورة المدفوعة بالكامل');
        }

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
        $this->authorize('update drink invoice date');
        
        // منع تعديل المشروبات في الفاتورة المدفوعة بالكامل
        if ($drinkInvoice->payment_status == 'paid') {
            return redirect()->back()->with('error', 'لا يمكن تعديل مشروبات الفاتورة المدفوعة بالكامل');
        }

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
     * Update drink item unit price and quantity
     */
    public function updateDrinkPrice(Request $request, DrinkInvoice $drinkInvoice, DrinkInvoiceItem $item)
    {
        $this->authorize('update drink invoice price');
        
        // منع تعديل المشروبات في الفاتورة المدفوعة بالكامل
        if ($drinkInvoice->payment_status == 'paid') {
            return redirect()->back()->with('error', 'لا يمكن تعديل مشروبات الفاتورة المدفوعة بالكامل');
        }

        if ($item->drink_invoice_id !== $drinkInvoice->id) {
            return redirect()->back()->with('error', 'المشروب لا ينتمي لهذه الفاتورة');
        }

        $request->validate([
            'unit_price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1'
        ]);

        $newUnitPrice = $request->unit_price;
        $newQuantity = $request->quantity;
        $newTotalPrice = $newUnitPrice * $newQuantity;

        $item->update([
            'unit_price' => $newUnitPrice,
            'quantity' => $newQuantity,
            'price' => $newTotalPrice
        ]);

        // تحديث إجمالي الفاتورة
        $drinkInvoice->updateTotal();

        return redirect()->back()->with('success', 'تم تحديث السعر والكمية بنجاح');
    }

    /**
     * Generate PDF invoice for the drink invoice
     */
    public function generateInvoice(DrinkInvoice $drinkInvoice)
    {
        $this->authorize('generate drink invoice');
        
        try {
            // Load the drink invoice with relationships
            $drinkInvoice->load(['user', 'items' => function($query) {
                $query->orderBy('created_at', 'asc');
            }, 'items.drink']);
            
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
        $this->authorize('view drink invoices');
        
        try {
            // Load the drink invoice with relationships
            $drinkInvoice->load(['user', 'items' => function($query) {
                $query->orderBy('created_at', 'asc');
            }, 'items.drink']);
            
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
