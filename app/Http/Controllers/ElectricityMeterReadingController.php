<?php

namespace App\Http\Controllers;

use App\Models\ElectricityMeterReading;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ElectricityMeterReadingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $readings = ElectricityMeterReading::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('electricity-meter-readings.index', compact('readings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('electricity-meter-readings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'morning_reading' => 'nullable|numeric|min:0',
            'afternoon_reading' => 'nullable|numeric|min:0',
            'evening_reading' => 'nullable|numeric|min:0',
        ], [
            'morning_reading.numeric' => 'قراءة العداد صباحاً يجب أن تكون رقماً',
            'morning_reading.min' => 'قراءة العداد صباحاً يجب أن تكون أكبر من أو تساوي صفر',
            'afternoon_reading.numeric' => 'قراءة العداد عصراً يجب أن تكون رقماً',
            'afternoon_reading.min' => 'قراءة العداد عصراً يجب أن تكون أكبر من أو تساوي صفر',
            'evening_reading.numeric' => 'قراءة العداد مساءً يجب أن تكون رقماً',
            'evening_reading.min' => 'قراءة العداد مساءً يجب أن تكون أكبر من أو تساوي صفر',
        ]);

        // التحقق من أن على الأقل قيمة واحدة مدخلة
        if (empty($request->morning_reading) && empty($request->afternoon_reading) && empty($request->evening_reading)) {
            return back()->withErrors([
                'morning_reading' => 'يجب إدخال قراءة واحدة على الأقل (صباحاً، عصراً، أو مساءً)',
            ])->withInput();
        }

        $data = [
            'user_id' => Auth::id(),
        ];

        if ($request->filled('morning_reading')) {
            $data['morning_reading'] = $request->morning_reading;
        }

        if ($request->filled('afternoon_reading')) {
            $data['afternoon_reading'] = $request->afternoon_reading;
        }

        if ($request->filled('evening_reading')) {
            $data['evening_reading'] = $request->evening_reading;
        }

        ElectricityMeterReading::create($data);

        $readings = [];
        if ($request->filled('morning_reading')) $readings[] = 'صباحاً';
        if ($request->filled('afternoon_reading')) $readings[] = 'عصراً';
        if ($request->filled('evening_reading')) $readings[] = 'مساءً';

        return redirect()->route('electricity-meter-readings.index')
            ->with('success', 'تم إضافة قراءة العداد (' . implode('، ', $readings) . ') بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(ElectricityMeterReading $electricityMeterReading)
    {
        $electricityMeterReading->load('user');
        return view('electricity-meter-readings.show', compact('electricityMeterReading'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ElectricityMeterReading $electricityMeterReading)
    {
        return view('electricity-meter-readings.edit', compact('electricityMeterReading'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ElectricityMeterReading $electricityMeterReading)
    {
        $request->validate([
            'morning_reading' => 'nullable|numeric|min:0',
            'afternoon_reading' => 'nullable|numeric|min:0',
            'evening_reading' => 'nullable|numeric|min:0',
        ], [
            'morning_reading.numeric' => 'قراءة العداد صباحاً يجب أن تكون رقماً',
            'morning_reading.min' => 'قراءة العداد صباحاً يجب أن تكون أكبر من أو تساوي صفر',
            'afternoon_reading.numeric' => 'قراءة العداد عصراً يجب أن تكون رقماً',
            'afternoon_reading.min' => 'قراءة العداد عصراً يجب أن تكون أكبر من أو تساوي صفر',
            'evening_reading.numeric' => 'قراءة العداد مساءً يجب أن تكون رقماً',
            'evening_reading.min' => 'قراءة العداد مساءً يجب أن تكون أكبر من أو تساوي صفر',
        ]);

        // التحقق من أن على الأقل قيمة واحدة مدخلة
        if (empty($request->morning_reading) && empty($request->afternoon_reading) && empty($request->evening_reading)) {
            return back()->withErrors([
                'morning_reading' => 'يجب إدخال قراءة واحدة على الأقل (صباحاً، عصراً، أو مساءً)',
            ])->withInput();
        }

        $data = [];

        if ($request->has('morning_reading')) {
            $data['morning_reading'] = $request->morning_reading ?: null;
        }

        if ($request->has('afternoon_reading')) {
            $data['afternoon_reading'] = $request->afternoon_reading ?: null;
        }

        if ($request->has('evening_reading')) {
            $data['evening_reading'] = $request->evening_reading ?: null;
        }

        $electricityMeterReading->update($data);

        return redirect()->route('electricity-meter-readings.index')
            ->with('success', 'تم تحديث قراءة العداد بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ElectricityMeterReading $electricityMeterReading)
    {
        $electricityMeterReading->delete();

        return redirect()->route('electricity-meter-readings.index')
            ->with('success', 'تم حذف قراءة العداد بنجاح');
    }
}
