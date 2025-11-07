<?php

namespace App\Http\Controllers;

use App\Models\Drink;
use App\Models\SessionDrink;
use Illuminate\Http\Request;

class DrinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $drinks = Drink::orderBy('created_at', 'desc')->paginate(20);
        
        $stats = [
            'total_drinks' => Drink::count(),
            'available_drinks' => Drink::where('status', 'available')->count(),
            'unavailable_drinks' => Drink::where('status', 'unavailable')->count(),
            'total_sold' => SessionDrink::count(),
        ];

        return view('drinks.index', compact('drinks', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('drinks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'size' => 'required|in:small,medium,large',
            'status' => 'required|in:available,unavailable'
        ]);

        Drink::create([
            'name' => $request->name,
            'price' => $request->price,
            'size' => $request->size,
            'status' => $request->status
        ]);

        return redirect()->route('drinks.index')
            ->with('success', 'تم إضافة المشروب بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Drink $drink)
    {
        $salesStats = [
            'total_sold' => $drink->sessionDrinks()->count(),
            'total_revenue' => $drink->sessionDrinks()->sum('price'),
            'last_order' => $drink->sessionDrinks()->latest()->first()?->created_at,
        ];

        $recentOrders = $drink->sessionDrinks()
            ->with(['session.user'])
            ->latest()
            ->limit(10)
            ->get();

        return view('drinks.show', compact('drink', 'salesStats', 'recentOrders'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Drink $drink)
    {
        return view('drinks.edit', compact('drink'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Drink $drink)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'size' => 'required|in:small,medium,large',
            'status' => 'required|in:available,unavailable'
        ]);

        $drink->update([
            'name' => $request->name,
            'price' => $request->price,
            'size' => $request->size,
            'status' => $request->status
        ]);

        return redirect()->route('drinks.index')
            ->with('success', 'تم تحديث المشروب بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Drink $drink)
    {
        // التحقق من وجود طلبات مرتبطة
        if ($drink->sessionDrinks()->count() > 0) {
            return redirect()->back()
                ->with('error', 'لا يمكن حذف المشروب لوجود طلبات مرتبطة به');
        }

        $drink->delete();
        
        return redirect()->route('drinks.index')
            ->with('success', 'تم حذف المشروب بنجاح');
    }
}
