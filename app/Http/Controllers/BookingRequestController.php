<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookingRequest;

class BookingRequestController extends Controller
{
    /**
     * Display a listing of booking requests
     */
    public function index()
    {
        $bookingRequests = BookingRequest::orderBy('created_at', 'desc')->paginate(15);
        
        return view('booking-requests.index', compact('bookingRequests'));
    }

    /**
     * Store a newly created booking request
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'plan_type' => 'required|in:daily,weekly,monthly',
            'notes' => 'nullable|string|max:1000'
        ]);

        BookingRequest::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'تم إرسال طلب الحجز بنجاح!'
        ]);
    }

    /**
     * Update the status of a booking request
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled'
        ]);

        $bookingRequest = BookingRequest::findOrFail($id);
        $bookingRequest->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث حالة الطلب بنجاح!'
        ]);
    }

    /**
     * Show booking request details
     */
    public function show($id)
    {
        $bookingRequest = BookingRequest::findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $bookingRequest->id,
                'name' => $bookingRequest->name,
                'phone' => $bookingRequest->phone,
                'plan_type' => $bookingRequest->plan_type,
                'plan_type_arabic' => $bookingRequest->plan_type_arabic,
                'status' => $bookingRequest->status,
                'status_arabic' => $bookingRequest->status_arabic,
                'status_badge_class' => $bookingRequest->status_badge_class,
                'notes' => $bookingRequest->notes,
                'created_at' => $bookingRequest->created_at->format('Y/m/d H:i'),
                'updated_at' => $bookingRequest->updated_at->format('Y/m/d H:i'),
                'created_at_human' => $bookingRequest->created_at->diffForHumans(),
                'updated_at_human' => $bookingRequest->updated_at->diffForHumans()
            ]
        ]);
    }

    /**
     * Remove a booking request
     */
    public function destroy($id)
    {
        $bookingRequest = BookingRequest::findOrFail($id);
        $bookingRequest->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف الطلب بنجاح!'
        ]);
    }
}
