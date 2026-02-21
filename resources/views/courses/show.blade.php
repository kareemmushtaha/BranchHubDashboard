@extends('layouts.app')

@section('title', $course->title)

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">{{ $course->title }}</h1>
    <div>
        <a href="{{ route('courses.edit', $course) }}" class="btn btn-warning me-2">
            <i class="bi bi-pencil"></i> تعديل
        </a>
        <a href="{{ route('courses.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> العودة
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        @if($course->cover_image)
            <img src="{{ asset('storage/app/public/' . $course->cover_image) }}" alt="{{ $course->title }}" class="img-fluid rounded mb-3">
        @endif
        @if($course->short_description)
            <p class="lead text-muted">{{ $course->short_description }}</p>
        @endif
        @if($course->description)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">الوصف الكامل</h5>
                </div>
                <div class="card-body">
                    <div>{!! $course->description !!}</div>
                </div>
            </div>
        @endif
    </div>
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">إحصائيات الدورة</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="d-flex justify-content-between py-2 border-bottom"><span class="text-muted">السعر</span><strong class="text-primary">${{ number_format($course->price, 2) }}</strong></li>
                    <li class="d-flex justify-content-between py-2 border-bottom"><span class="text-muted">المتعلمين</span><strong>{{ $course->learner_count }}</strong></li>
                    <li class="d-flex justify-content-between py-2 border-bottom"><span class="text-muted">الإعجابات</span><strong>{{ $course->likes_count }}</strong></li>
                    <li class="d-flex justify-content-between py-2 border-bottom"><span class="text-muted">التقييمات</span><strong>{{ $course->review_count }}</strong></li>
                    <li class="d-flex justify-content-between py-2"><span class="text-muted">الحالة</span>
                        <span class="badge {{ $course->is_published ? 'bg-success' : 'bg-secondary' }}">{{ $course->is_published ? 'منشور' : 'غير منشور' }}</span>
                    </li>
                </ul>
            </div>
        </div>
        @if($course->categories->isNotEmpty())
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">التصنيفات</h5>
            </div>
            <div class="card-body">
                @foreach($course->categories as $cat)
                    <span class="badge bg-primary me-1 mb-1">{{ $cat->name }}</span>
                @endforeach
            </div>
        </div>
        @endif
        @if($course->skills->isNotEmpty())
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">المهارات</h5>
            </div>
            <div class="card-body">
                @foreach($course->skills as $skill)
                    <span class="badge bg-success me-1 mb-1">{{ $skill->name }}</span>
                @endforeach
            </div>
        </div>
        @endif
        @if($course->leaders->isNotEmpty())
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">القادة</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    @foreach($course->leaders as $leader)
                    <li class="d-flex align-items-center mb-3">
                        @if($leader->photo)
                            <img src="{{ asset('storage/app/public/' . $leader->photo) }}" alt="" class="rounded-circle me-2" style="width: 40px; height: 40px; object-fit: cover;">
                        @else
                            <span class="rounded-circle bg-secondary text-white d-inline-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px;">{{ substr($leader->name, 0, 1) }}</span>
                        @endif
                        <span>{{ $leader->name }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
