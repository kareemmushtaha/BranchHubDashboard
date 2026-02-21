@extends('layouts.app')

@section('title', 'تفاصيل المدرب')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">تفاصيل المدرب: {{ $leader->name }}</h1>
    <div>
        <a href="{{ route('leaders.edit', $leader) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> تعديل
        </a>
        <a href="{{ route('leaders.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> العودة
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card text-center">
            <div class="card-body py-4">
                @if($leader->photo)
                    <img src="{{ asset('storage/app/public/' . $leader->photo) }}" alt="{{ $leader->name }}" class="rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover;">
                @else
                    <span class="rounded-circle bg-secondary text-white d-inline-flex align-items-center justify-content-center mb-3" style="width: 120px; height: 120px; font-size: 2.5rem;">{{ substr($leader->name, 0, 1) }}</span>
                @endif
                <h4 class="card-title mb-1">{{ $leader->name }}</h4>
                @if($leader->job_title)
                    <p class="text-primary mb-1"><i class="bi bi-briefcase me-1"></i>{{ $leader->job_title }}</p>
                @endif
                <p class="text-muted mb-0">{{ $leader->email }}</p>
                @if($leader->linkedin)
                    <a href="{{ $leader->linkedin }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2"><i class="bi bi-linkedin me-1"></i> LinkedIn</a>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-8 mb-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="bi bi-person-lines-fill me-1"></i> المعلومات الأساسية</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tbody>
                        <tr>
                            <th class="text-muted" style="width: 180px;">الاسم</th>
                            <td>{{ $leader->name }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">البريد الإلكتروني</th>
                            <td><a href="mailto:{{ $leader->email }}">{{ $leader->email }}</a></td>
                        </tr>
                        <tr>
                            <th class="text-muted">الهاتف</th>
                            <td>{{ $leader->phone ?? '—' }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">المسمى الوظيفي</th>
                            <td>{{ $leader->job_title ?? '—' }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">وصف الوظيفة</th>
                            <td>{{ $leader->job_description ?? '—' }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">LinkedIn</th>
                            <td>
                                @if($leader->linkedin)
                                    <a href="{{ $leader->linkedin }}" target="_blank" dir="ltr">{{ $leader->linkedin }}</a>
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="text-muted">عدد الدورات</th>
                            <td><span class="badge bg-primary">{{ $leader->courses_count }}</span></td>
                        </tr>
                        <tr>
                            <th class="text-muted">تاريخ الإضافة</th>
                            <td>{{ $leader->created_at->format('Y-m-d') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        @if($leader->cv)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="bi bi-file-text me-1"></i> السيرة الذاتية (CV)</h5>
            </div>
            <div class="card-body">
                <div class="mb-0">{!! $leader->cv !!}</div>
            </div>
        </div>
        @endif

        @if($leader->courses->count() > 0)
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="bi bi-journal-bookmark me-1"></i> الدورات ({{ $leader->courses->count() }})</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>اسم الدورة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($leader->courses as $course)
                            <tr>
                                <td>{{ $course->title }}</td>
                                <td>
                                    <a href="{{ route('courses.show', $course) }}" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
