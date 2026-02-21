@extends('layouts.app')

@section('title', 'إدارة الدورات')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">إدارة الدورات</h1>
    <div>
        <a href="{{ route('courses.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> إضافة دورة
        </a>
    </div>
</div>

{{-- Search --}}
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('courses.index') }}" class="row g-2">
            <div class="col-md-8">
                <input type="text" name="search" class="form-control" value="{{ request('search') }}"
                       placeholder="بحث بالعنوان أو الوصف...">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-secondary w-100">
                    <i class="bi bi-search"></i> بحث
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">قائمة الدورات</h5>
    </div>
    <div class="card-body p-0">
        @if($courses->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>الصورة</th>
                        <th>العنوان</th>
                        <th>السعر</th>
                        <th>المتعلمين</th>
                        <th>التصنيفات / المهارات / القادة</th>
                        <th>النشر</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($courses as $course)
                    <tr>
                        <td>
                            @if($course->thumbnail_image)
                                <img src="{{ asset('storage/' . $course->thumbnail_image) }}" alt="" class="rounded" style="height: 48px; width: 64px; object-fit: cover;">
                            @else
                                <div class="bg-secondary bg-opacity-25 rounded d-inline-flex align-items-center justify-content-center text-secondary" style="height: 48px; width: 64px;">
                                    <i class="bi bi-image"></i>
                                </div>
                            @endif
                        </td>
                        <td><strong>{{ $course->title }}</strong></td>
                        <td>${{ number_format($course->price, 2) }}</td>
                        <td>{{ $course->learner_count }}</td>
                        <td>
                            <span class="badge bg-primary me-1">{{ $course->categories_count }}</span>
                            <span class="badge bg-success me-1">{{ $course->skills_count }}</span>
                            <span class="badge bg-info">{{ $course->leaders_count }}</span>
                        </td>
                        <td>
                            <form action="{{ route('courses.toggle-published', $course) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm {{ $course->is_published ? 'btn-success' : 'btn-outline-secondary' }}">
                                    {{ $course->is_published ? 'منشور' : 'غير منشور' }}
                                </button>
                            </form>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('courses.show', $course) }}" class="btn btn-outline-primary" title="عرض"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('courses.edit', $course) }}" class="btn btn-outline-warning" title="تعديل"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('courses.destroy', $course) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذه الدورة؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="حذف"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($courses->hasPages())
        <div class="p-3 border-top">
            {{ $courses->links() }}
        </div>
        @endif
        @else
        <div class="text-center py-5">
            <i class="bi bi-journal-plus display-4 text-muted"></i>
            <h5 class="mt-3">لا توجد دورات</h5>
            <p class="text-muted">ابدأ بإضافة دورة جديدة</p>
            <a href="{{ route('courses.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> إضافة دورة
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
