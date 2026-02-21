@extends('layouts.app')

@section('title', 'التصنيفات')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">التصنيفات</h1>
    <div>
        <a href="{{ route('categories.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> إضافة تصنيف
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">قائمة التصنيفات</h5>
    </div>
    <div class="card-body p-0">
        @if($categories->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>الاسم</th>
                        <th>عدد الدورات</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $cat)
                    <tr>
                        <td><strong>{{ $cat->name }}</strong></td>
                        <td>{{ $cat->courses_count }}</td>
                        <td>
                            <a href="{{ route('categories.edit', $cat) }}" class="btn btn-sm btn-outline-warning me-1"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('categories.destroy', $cat) }}" method="POST" class="d-inline" onsubmit="return confirm('حذف هذا التصنيف؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($categories->hasPages())
        <div class="p-3 border-top">
            {{ $categories->links() }}
        </div>
        @endif
        @else
        <div class="text-center py-5">
            <i class="bi bi-tags display-4 text-muted"></i>
            <h5 class="mt-3">لا توجد تصنيفات</h5>
            <a href="{{ route('categories.create') }}" class="btn btn-primary mt-2"><i class="bi bi-plus-circle"></i> إضافة تصنيف</a>
        </div>
        @endif
    </div>
</div>
@endsection
