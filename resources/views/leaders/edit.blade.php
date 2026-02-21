@extends('layouts.app')

@section('title', 'تعديل المدرب')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">تعديل المدرب: {{ $leader->name }}</h1>
    <div>
        <a href="{{ route('leaders.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> العودة
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">بيانات المدرب</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('leaders.update', $leader) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">الاسم <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $leader->name) }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">البريد الإلكتروني <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $leader->email) }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">الهاتف</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $leader->phone) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="job_title" class="form-label">المسمى الوظيفي</label>
                            <input type="text" class="form-control @error('job_title') is-invalid @enderror" id="job_title" name="job_title" value="{{ old('job_title', $leader->job_title) }}" placeholder="مثال: مدرب تطوير ذاتي">
                            @error('job_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="linkedin" class="form-label"><i class="bi bi-linkedin text-primary"></i> رابط LinkedIn</label>
                            <input type="url" class="form-control @error('linkedin') is-invalid @enderror" id="linkedin" name="linkedin" value="{{ old('linkedin', $leader->linkedin) }}" placeholder="https://linkedin.com/in/username" dir="ltr">
                            @error('linkedin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label for="job_description" class="form-label">وصف الوظيفة</label>
                            <textarea class="form-control @error('job_description') is-invalid @enderror" id="job_description" name="job_description" rows="3" placeholder="وصف مختصر عن الوظيفة أو التخصص">{{ old('job_description', $leader->job_description) }}</textarea>
                            @error('job_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            @if($leader->photo)
                                <p class="text-muted small mb-1">الصورة الحالية:</p>
                                <img src="{{ asset('storage/' . $leader->photo) }}" alt="" class="rounded-circle mb-2" style="width: 50px; height: 50px; object-fit: cover;">
                            @endif
                            <label for="photo" class="form-label">استبدال الصورة</label>
                            <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" accept="image/*">
                            @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label for="cv" class="form-label">السيرة (CV)</label>
                            <textarea class="form-control @error('cv') is-invalid @enderror" id="cv" name="cv" rows="4">{{ old('cv', $leader->cv) }}</textarea>
                            @error('cv')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('leaders.index') }}" class="btn btn-secondary me-md-2">إلغاء</a>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg"></i> حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/translations/ar.js"></script>
<script>
    $(document).ready(function() {
        ClassicEditor
            .create(document.querySelector('#cv'), {
                language: 'ar',
                toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo' ]
            })
            .catch(error => {
                console.error(error);
            });
    });
</script>
@endsection
