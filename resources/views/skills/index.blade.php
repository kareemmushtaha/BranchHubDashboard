@extends('layouts.app')

@section('title', 'المهارات')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">المهارات</h1>
    <div>
        <a href="{{ route('skills.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> إضافة مهارة
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">قائمة المهارات</h5>
    </div>
    <div class="card-body p-0">
        @if($skills->count() > 0)
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
                    @foreach($skills as $skill)
                    <tr>
                        <td><strong>{{ $skill->name }}</strong></td>
                        <td>{{ $skill->courses_count }}</td>
                        <td>
                            <a href="{{ route('skills.edit', $skill) }}" class="btn btn-sm btn-outline-warning me-1"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('skills.destroy', $skill) }}" method="POST" class="d-inline" onsubmit="return confirm('حذف هذه المهارة؟');">
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
        @if($skills->hasPages())
        <div class="p-3 border-top">
            {{ $skills->links() }}
        </div>
        @endif
        @else
        <div class="text-center py-5">
            <i class="bi bi-lightning display-4 text-muted"></i>
            <h5 class="mt-3">لا توجد مهارات</h5>
            <a href="{{ route('skills.create') }}" class="btn btn-primary mt-2"><i class="bi bi-plus-circle"></i> إضافة مهارة</a>
        </div>
        @endif
    </div>
</div>
@endsection
