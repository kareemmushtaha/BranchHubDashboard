@extends('layouts.app')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    /* تنسيق Select2 ليتوافق مع Bootstrap 5 و RTL */
    .select2-container--default .select2-selection--multiple {
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        min-height: 38px;
    }
    
    .select2-container--default.select2-container--focus .select2-selection--multiple {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
    
    .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
        background-color: #0d6efd;
        color: white;
    }
    
    /* إصلاح اتجاه النص والبحث في RTL */
    .select2-search__field {
        direction: rtl;
        text-align: right;
    }
    
    .select2-results__option {
        direction: rtl;
        text-align: right;
    }
    
    .select2-container .select2-selection--multiple .select2-selection__rendered {
        display: flex;
        flex-wrap: wrap;
        gap: 4px;
        padding: 4px;
    }
    
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #e9ecef;
        border: 1px solid #ced4da;
        border-radius: 4px;
        padding: 2px 6px;
        margin-left: 5px;
        margin-right: 0;
        color: #495057;
    }
    
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        margin-right: -4px;
        margin-left: 6px;
        border-left: 1px solid #ced4da;
        border-right: none;
        padding-left: 4px;
        color: #dc3545;
    }
    
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
        background-color: transparent;
        color: #bb2d3b;
    }

    .ck-editor__editable_inline {
        min-height: 200px;
        text-align: right;
    }
</style>
@endsection

@section('content')
@php
    $selectedCategories = old('category_ids', $course->categories->pluck('id')->toArray());
    $selectedSkills = old('skill_ids', $course->skills->pluck('id')->toArray());
    $selectedLeaders = old('leader_ids', $course->leaders->pluck('id')->toArray());
@endphp

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">تعديل الدورة: {{ $course->title }}</h1>
    <div>
        <a href="{{ route('courses.show', $course) }}" class="btn btn-info me-2">
            <i class="bi bi-eye"></i> عرض
        </a>
        <a href="{{ route('courses.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> العودة
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <form action="{{ route('courses.update', $course) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">البيانات الأساسية</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="title" class="form-label">العنوان <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $course->title) }}" required>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">السعر <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $course->price) }}" required>
                            @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="short_description" class="form-label">وصف مختصر</label>
                            <input type="text" class="form-control @error('short_description') is-invalid @enderror" id="short_description" name="short_description" value="{{ old('short_description', $course->short_description) }}">
                            @error('short_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label for="description" class="form-label">الوصف الكامل</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5">{{ old('description', $course->description) }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">الصور</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            @if($course->cover_image)
                                <p class="text-muted small mb-2">الغلاف الحالي:</p>
                                <img src="{{ asset('storage/' . $course->cover_image) }}" alt="" class="img-thumbnail mb-2" style="max-height: 100px;">
                            @endif
                            <label for="cover_image" class="form-label">استبدال صورة الغلاف</label>
                            <input type="file" class="form-control @error('cover_image') is-invalid @enderror" id="cover_image" name="cover_image" accept="image/*">
                            @error('cover_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            @if($course->thumbnail_image)
                                <p class="text-muted small mb-2">المصغرة الحالية:</p>
                                <img src="{{ asset('storage/' . $course->thumbnail_image) }}" alt="" class="img-thumbnail mb-2" style="max-height: 100px;">
                            @endif
                            <label for="thumbnail_image" class="form-label">استبدال الصورة المصغرة</label>
                            <input type="file" class="form-control @error('thumbnail_image') is-invalid @enderror" id="thumbnail_image" name="thumbnail_image" accept="image/*">
                            @error('thumbnail_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">الإحصائيات (يدوي)</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="learner_count" class="form-label">عدد المتعلمين</label>
                            <input type="number" min="0" class="form-control" id="learner_count" name="learner_count" value="{{ old('learner_count', $course->learner_count) }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="likes_count" class="form-label">عدد الإعجابات</label>
                            <input type="number" min="0" class="form-control" id="likes_count" name="likes_count" value="{{ old('likes_count', $course->likes_count) }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="review_count" class="form-label">عدد التقييمات</label>
                            <input type="number" min="0" class="form-control" id="review_count" name="review_count" value="{{ old('review_count', $course->review_count) }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">التصنيفات والمهارات والقادة</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="category_ids" class="form-label">التصنيفات</label>
                            <select name="category_ids[]" id="category_ids" multiple class="form-select" size="5">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ in_array($cat->id, $selectedCategories) ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="skill_ids" class="form-label">المهارات</label>
                            <select name="skill_ids[]" id="skill_ids" multiple class="form-select" size="5">
                                @foreach($skills as $skill)
                                    <option value="{{ $skill->id }}" {{ in_array($skill->id, $selectedSkills) ? 'selected' : '' }}>{{ $skill->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="leader_ids" class="form-label">القادة (المدربون)</label>
                            <select name="leader_ids[]" id="leader_ids" multiple class="form-select" size="5">
                                @foreach($leaders as $leader)
                                    <option value="{{ $leader->id }}" {{ in_array($leader->id, $selectedLeaders) ? 'selected' : '' }}>{{ $leader->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_published" value="1" id="is_published" {{ old('is_published', $course->is_published) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_published">منشور (يظهر في الصفحة العامة)</label>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="{{ route('courses.index') }}" class="btn btn-secondary me-md-2">إلغاء</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg"></i> حفظ التغييرات
                </button>
            </div>
        </form>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">معلومات</h5>
            </div>
            <div class="card-body">
                <p class="small text-muted mb-1"><strong>تاريخ الإنشاء:</strong><br>{{ $course->created_at->format('Y-m-d H:i') }}</p>
                <p class="small text-muted mb-0"><strong>آخر تحديث:</strong><br>{{ $course->updated_at->format('Y-m-d H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/translations/ar.js"></script>
<script>
    $(document).ready(function() {
        // تفعيل Select2 للقوائم المنسدلة
        $('#category_ids').select2({
            placeholder: "اختر التصنيفات",
            allowClear: true,
            dir: "rtl",
            width: '100%'
        });

        $('#skill_ids').select2({
            placeholder: "اختر المهارات",
            allowClear: true,
            dir: "rtl",
            width: '100%'
        });

        $('#leader_ids').select2({
            placeholder: "اختر القادة",
            allowClear: true,
            dir: "rtl",
            width: '100%'
        });

        // تفعيل CKEditor لوصف الدورة
        ClassicEditor
            .create(document.querySelector('#description'), {
                language: 'ar',
                toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo' ]
            })
            .catch(error => {
                console.error(error);
            });
    });
</script>
@endsection

