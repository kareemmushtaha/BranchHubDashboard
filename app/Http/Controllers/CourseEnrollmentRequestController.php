<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseEnrollmentRequest;

class CourseEnrollmentRequestController extends Controller
{
    /**
     * Display a listing of course enrollment requests (dashboard).
     */
    public function index(Request $request)
    {
        $query = CourseEnrollmentRequest::orderBy('created_at', 'desc');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by course
        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        $enrollmentRequests = $query->paginate(15);

        return view('course-enrollment-requests.index', compact('enrollmentRequests'));
    }

    /**
     * Store a newly created enrollment request (public, no auth).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id'    => 'required|exists:courses,id',
            'course_title' => 'required|string|max:255',
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|max:255',
            'phone'        => 'required|string|max:30',
            'message'      => 'nullable|string|max:2000',
        ]);

        CourseEnrollmentRequest::create([
            'course_id'    => $request->course_id,
            'course_title' => $request->course_title,
            'name'         => $request->name,
            'email'        => $request->email,
            'phone'        => $request->phone,
            'message'      => $request->message,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'تم إرسال طلب التسجيل بنجاح! سنتواصل معك قريباً.',
            ]);
        }

        return redirect()->back()->with('success', 'تم إرسال طلب التسجيل بنجاح! سنتواصل معك قريباً.');
    }

    /**
     * Update the status of an enrollment request.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $enrollmentRequest = CourseEnrollmentRequest::findOrFail($id);
        $enrollmentRequest->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث حالة الطلب بنجاح!',
        ]);
    }

    /**
     * Show enrollment request details (JSON for modal).
     */
    public function show($id)
    {
        $enrollmentRequest = CourseEnrollmentRequest::findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => [
                'id'                => $enrollmentRequest->id,
                'course_title'      => $enrollmentRequest->course_title,
                'name'              => $enrollmentRequest->name,
                'email'             => $enrollmentRequest->email,
                'phone'             => $enrollmentRequest->phone,
                'message'           => $enrollmentRequest->message,
                'status'            => $enrollmentRequest->status,
                'status_arabic'     => $enrollmentRequest->status_arabic,
                'status_badge_class'=> $enrollmentRequest->status_badge_class,
                'created_at'        => $enrollmentRequest->created_at->format('Y/m/d H:i'),
                'updated_at'        => $enrollmentRequest->updated_at->format('Y/m/d H:i'),
                'created_at_human'  => $enrollmentRequest->created_at->diffForHumans(),
                'updated_at_human'  => $enrollmentRequest->updated_at->diffForHumans(),
            ],
        ]);
    }

    /**
     * Remove an enrollment request.
     */
    public function destroy($id)
    {
        $enrollmentRequest = CourseEnrollmentRequest::findOrFail($id);
        $enrollmentRequest->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف الطلب بنجاح!',
        ]);
    }
}
