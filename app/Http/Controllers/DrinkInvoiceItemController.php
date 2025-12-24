<?php

namespace App\Http\Controllers;

use App\Models\DrinkInvoiceItem;
use App\Models\User;
use App\Models\Drink;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DrinkInvoiceItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('show drink-invoice-items');
        
        $query = DrinkInvoiceItem::with(['drink', 'invoice.user']);

        // Default to today's date range if no dates are provided
        $today = Carbon::today()->format('Y-m-d');
        $dateFrom = $request->filled('date_from') ? $request->date_from : $today;
        $dateTo = $request->filled('date_to') ? $request->date_to : $today;

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $dateFrom);
        } else {
            // Default: show today's items
            $query->whereDate('created_at', '>=', $today);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $dateTo);
        } else {
            // Default: show today's items
            $query->whereDate('created_at', '<=', $today);
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->whereHas('invoice', function ($q) use ($request) {
                $q->where('user_id', $request->user_id);
            });
        }

        // Filter by drink
        if ($request->filled('drink_id')) {
            $query->where('drink_id', $request->drink_id);
        }

        // Calculate total price of all matching items (before pagination)
        $totalPrice = (clone $query)->sum('price');

        // Sort by created_at descending (newest first)
        $query->orderBy('created_at', 'desc')
              ->orderBy('id', 'desc');

        $perPage = $request->get('per_page', 15);
        $items = $query->paginate($perPage)->withQueryString();

        // Get only subscription users for the dropdown
        $users = User::where('status', 'active')
            ->where('user_type', 'subscription')
            ->orderBy('name')
            ->get();

        // Get all available drinks for the dropdown
        $drinks = Drink::where('status', 'available')
            ->orderBy('name')
            ->get();

        return view('drink-invoice-items.index', compact('items', 'dateFrom', 'dateTo', 'users', 'drinks', 'totalPrice'));
    }
}

