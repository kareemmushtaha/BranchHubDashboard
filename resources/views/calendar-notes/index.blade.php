@extends('layouts.app')

@section('title', 'التقويم والملاحظات')

@section('styles')
<style>
    .calendar-card {
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.08);
        background: #fff;
    }
    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 0.5rem;
    }
    .calendar-day {
        min-height: 120px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        padding: 0.75rem;
        text-decoration: none;
        color: inherit;
        position: relative;
        transition: all 0.2s ease;
        background: #fff;
    }
    .calendar-day:hover {
        border-color: #0d6efd;
        box-shadow: 0 8px 20px rgba(13, 110, 253, 0.15);
    }
    .calendar-day.muted {
        background: #f8fafc;
        color: #9ca3af;
    }
    .calendar-day.today {
        border-color: #22c55e;
    }
    .calendar-day.selected {
        border-color: #0d6efd;
        background: #e7f1ff;
    }
    .calendar-day .day-number {
        font-weight: 700;
        font-size: 1.25rem;
        margin-bottom: 0.25rem;
    }
    .calendar-day .note-count {
        position: absolute;
        top: 0.75rem;
        left: 0.75rem;
    }
    .weekday-header {
        font-weight: 700;
        color: #334155;
        text-align: center;
    }
    .notes-panel {
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.08);
        background: #fff;
    }
</style>
@endsection

@section('content')
@php
    $monthNames = [
        1 => 'يناير',
        2 => 'فبراير',
        3 => 'مارس',
        4 => 'أبريل',
        5 => 'مايو',
        6 => 'يونيو',
        7 => 'يوليو',
        8 => 'أغسطس',
        9 => 'سبتمبر',
        10 => 'أكتوبر',
        11 => 'نوفمبر',
        12 => 'ديسمبر',
    ];
    $currentMonthLabel = $monthNames[$currentMonth->month] . ' ' . $currentMonth->format('Y');
    $weekdayLabels = ['السبت', 'الأحد', 'الإثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة'];
@endphp
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card calendar-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a class="btn btn-outline-secondary btn-sm" href="{{ route('calendar-notes.index', ['month' => $prevMonth->month, 'year' => $prevMonth->year]) }}">
                    <i class="bi bi-chevron-right"></i> الشهر السابق
                </a>
                <div class="text-center">
                    <h4 class="mb-0">{{ $currentMonthLabel }}</h4>
                    <small class="text-muted">اختر اليوم لإضافة أو استعراض الملاحظات</small>
                </div>
                <a class="btn btn-outline-secondary btn-sm" href="{{ route('calendar-notes.index', ['month' => $nextMonth->month, 'year' => $nextMonth->year]) }}">
                    الشهر التالي <i class="bi bi-chevron-left"></i>
                </a>
            </div>
            <div class="calendar-grid mb-3">
                @foreach ($weekdayLabels as $label)
                    <div class="weekday-header">{{ $label }}</div>
                @endforeach
            </div>
            <div class="calendar-grid">
                @foreach ($weeks as $week)
                    @foreach ($week as $day)
                        @php
                            $dateKey = $day->toDateString();
                            $isSameMonth = $day->month === $currentMonth->month;
                            $isSelected = $selectedDate->isSameDay($day);
                            $isToday = $day->isToday();
                            $noteCount = $calendarSummary->get($dateKey);
                        @endphp
                        <a href="{{ route('calendar-notes.index', ['month' => $currentMonth->month, 'year' => $currentMonth->year, 'date' => $dateKey]) }}"
                           class="calendar-day {{ $isSameMonth ? '' : 'muted' }} {{ $isSelected ? 'selected' : '' }} {{ $isToday ? 'today' : '' }}">
                            <div class="day-number">{{ $day->day }}</div>
                            <div class="small text-muted">{{ $monthNames[$day->month] }}</div>
                            @if ($noteCount)
                                <span class="badge bg-primary note-count">{{ $noteCount }} ✎</span>
                            @endif
                            @if ($isToday)
                                <span class="badge bg-success position-absolute bottom-0 start-0 m-2">اليوم</span>
                            @endif
                        </a>
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="notes-panel card p-4">
            <h5 class="mb-3">
                ملاحظات يوم {{ $selectedDate->format('Y-m-d') }}
            </h5>
            <form method="POST" action="{{ route('calendar-notes.store') }}" class="mb-4">
                @csrf
                <div class="mb-3">
                    <label class="form-label">التاريخ</label>
                    <input type="date" name="note_date" class="form-control" value="{{ $selectedDate->toDateString() }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">عنوان الملاحظة (اختياري)</label>
                    <input type="text" name="title" class="form-control" placeholder="أدخل عنواناً قصيراً">
                </div>
                <div class="mb-3">
                    <label class="form-label">التفاصيل</label>
                    <textarea name="content" rows="3" class="form-control" placeholder="دوّن ملاحظاتك اليومية أو خطط الأيام القادمة" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-plus-circle"></i> إضافة ملاحظة
                </button>
            </form>

            <div class="notes-list">
                @forelse ($notesForSelectedDate as $note)
                    @php
                        $canModifyNote = auth()->user()?->user_type === 'admin' || auth()->id() === $note->user_id;
                    @endphp
                    <div class="card mb-3 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">{{ $note->title ?? 'ملاحظة بدون عنوان' }}</h6>
                                    <small class="text-muted">
                                        {{ $note->created_at->format('H:i') }}
                                        @if($note->user?->name)
                                            • {{ $note->user->name }}
                                        @endif
                                    </small>
                                </div>
                                @if ($canModifyNote)
                                    <div class="ms-2">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#edit-note-{{ $note->id }}">
                                            تعديل
                                        </button>
                                        <form action="{{ route('calendar-notes.destroy', $note) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذه الملاحظة؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">حذف</button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                            <p class="mt-3 mb-0 text-secondary">{{ $note->content }}</p>
                            @if ($canModifyNote)
                                <div class="collapse mt-3" id="edit-note-{{ $note->id }}">
                                    <form action="{{ route('calendar-notes.update', $note) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-2">
                                            <label class="form-label small">التاريخ</label>
                                            <input type="date" name="note_date" class="form-control" value="{{ $note->note_date->toDateString() }}" required>
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label small">العنوان</label>
                                            <input type="text" name="title" class="form-control" value="{{ $note->title }}">
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label small">المحتوى</label>
                                            <textarea name="content" rows="2" class="form-control" required>{{ $note->content }}</textarea>
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-success w-100">حفظ التعديلات</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted">
                        لا توجد ملاحظات لهذا اليوم بعد.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

