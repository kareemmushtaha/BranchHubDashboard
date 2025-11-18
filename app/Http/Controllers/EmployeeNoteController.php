<?php

namespace App\Http\Controllers;

use App\Models\EmployeeNote;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class EmployeeNoteController extends Controller
{
    public function index(Request $request): View
    {
        $today = Carbon::today();
        $month = (int) $request->query('month', $today->month);
        $year = (int) $request->query('year', $today->year);
        $selectedDateInput = $request->query('date');

        if ($month < 1 || $month > 12) {
            $month = $today->month;
        }

        if ($year < 2000 || $year > 2100) {
            $year = $today->year;
        }

        $currentMonth = Carbon::create($year, $month, 1);
        $calendarStart = $currentMonth->copy()->startOfMonth()->startOfWeek(Carbon::SATURDAY);
        $calendarEnd = $currentMonth->copy()->endOfMonth()->endOfWeek(Carbon::FRIDAY);

        try {
            $selectedDate = $selectedDateInput
                ? Carbon::parse($selectedDateInput)
                : $today;
        } catch (\Exception $e) {
            $selectedDate = $today;
        }

        $notes = EmployeeNote::whereBetween('note_date', [$calendarStart->toDateString(), $calendarEnd->toDateString()])
            ->orderBy('note_date')
            ->get()
            ->groupBy(fn (EmployeeNote $note) => $note->note_date->toDateString());

        $days = [];
        $cursor = $calendarStart->copy();
        while ($cursor <= $calendarEnd) {
            $days[] = $cursor->copy();
            $cursor->addDay();
        }
        $weeks = array_chunk($days, 7);

        $selectedDateKey = $selectedDate->toDateString();
        $notesForSelectedDate = $notes->get($selectedDateKey, collect());

        $calendarSummary = $notes->map(fn ($group) => $group->count());

        $prevMonth = $currentMonth->copy()->subMonth();
        $nextMonth = $currentMonth->copy()->addMonth();

        return view('employee-notes.index', [
            'currentMonth' => $currentMonth,
            'weeks' => $weeks,
            'calendarSummary' => $calendarSummary,
            'selectedDate' => $selectedDate,
            'notesForSelectedDate' => $notesForSelectedDate,
            'prevMonth' => $prevMonth,
            'nextMonth' => $nextMonth,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'employee_name' => ['required', 'string', 'max:255'],
            'note_date' => ['required', 'date'],
            'title' => ['nullable', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:5000'],
        ]);

        EmployeeNote::create($data + ['user_id' => Auth::id()]);

        return redirect()
            ->route('employee-notes.index', [
                'month' => Carbon::parse($data['note_date'])->month,
                'year' => Carbon::parse($data['note_date'])->year,
                'date' => $data['note_date'],
            ])
            ->with('success', 'تمت إضافة ملاحظة الموظف بنجاح.');
    }

    public function update(Request $request, EmployeeNote $employeeNote): RedirectResponse
    {
        if (! $this->userCanModify($employeeNote)) {
            return redirect()->back()->with('error', 'لا تملك صلاحية تعديل هذه الملاحظة.');
        }

        $data = $request->validate([
            'employee_name' => ['required', 'string', 'max:255'],
            'note_date' => ['required', 'date'],
            'title' => ['nullable', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:5000'],
        ]);

        $employeeNote->update($data);

        return redirect()
            ->route('employee-notes.index', [
                'month' => Carbon::parse($data['note_date'])->month,
                'year' => Carbon::parse($data['note_date'])->year,
                'date' => $data['note_date'],
            ])
            ->with('success', 'تم تحديث ملاحظة الموظف بنجاح.');
    }

    public function destroy(EmployeeNote $employeeNote): RedirectResponse
    {
        if (! $this->userCanModify($employeeNote)) {
            return redirect()->back()->with('error', 'لا تملك صلاحية حذف هذه الملاحظة.');
        }

        $noteDate = $employeeNote->note_date->toDateString();

        $employeeNote->delete();

        $date = Carbon::parse($noteDate);

        return redirect()
            ->route('employee-notes.index', [
                'month' => $date->month,
                'year' => $date->year,
                'date' => $noteDate,
            ])
            ->with('success', 'تم حذف ملاحظة الموظف.');
    }

    protected function userCanModify(EmployeeNote $employeeNote): bool
    {
        $user = Auth::user();

        if (! $user) {
            return false;
        }

        if ($user->user_type === 'admin') {
            return true;
        }

        return $employeeNote->user_id === $user->id;
    }
}

