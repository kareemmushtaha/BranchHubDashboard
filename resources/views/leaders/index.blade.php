@extends('layouts.app')

@section('title', 'المدربون')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">المدربون</h1>
    <div>
        <a href="{{ route('leaders.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> إضافة مدرب
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">قائمة المدربين</h5>
    </div>
    <div class="card-body p-0">
        @if($leaders->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>الصورة</th>
                        <th>الاسم</th>
                        <th>البريد</th>
                        <th>الدورات</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($leaders as $leader)
                    <tr>
                        <td>
                            @if($leader->photo)
                                <img src="{{ asset('storage/' . $leader->photo) }}" alt="" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                            @else
                                <span class="rounded-circle bg-secondary text-white d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">{{ substr($leader->name, 0, 1) }}</span>
                            @endif
                        </td>
                        <td><strong>{{ $leader->name }}</strong></td>
                        <td>{{ $leader->email }}</td>
                        <td>{{ $leader->courses_count }}</td>
                        <td>
                            <a href="{{ route('leaders.show', $leader) }}" class="btn btn-sm btn-outline-info me-1"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('leaders.edit', $leader) }}" class="btn btn-sm btn-outline-warning me-1"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('leaders.destroy', $leader) }}" method="POST" class="d-inline" onsubmit="return confirm('حذف هذا القائد؟');">
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
        @if($leaders->hasPages())
        <div class="p-3 border-top">
            {{ $leaders->links() }}
        </div>
        @endif
        @else
        <div class="text-center py-5">
            <i class="bi bi-person-badge display-4 text-muted"></i>
            <h5 class="mt-3">لا يوجد قادة</h5>
            <a href="{{ route('leaders.create') }}" class="btn btn-primary mt-2"><i class="bi bi-plus-circle"></i> إضافة قائد</a>
        </div>
        @endif
    </div>
</div>
@endsection
