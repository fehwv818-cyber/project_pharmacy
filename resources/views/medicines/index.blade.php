@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-info fw-bold"><i class="fa-solid fa-pills ms-2"></i> قائمة الأدوية</h2>
    <a href="{{ route('medicines.create') }}" class="btn btn-info text-dark fw-bold">
        <i class="fa-solid fa-plus ms-1"></i> إضافة دواء جديد
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success bg-success text-white border-0">{{ session('success') }}</div>
@endif

<!-- نموذج البحث -->
<form action="{{ route('medicines.index') }}" method="GET" class="mb-4">
    <div class="input-group">
        <input type="text" name="search" class="form-control" placeholder="ابحث باسم الدواء أو الباركود..." value="{{ request('search') }}">
        <button class="btn btn-outline-info" type="submit"><i class="fa-solid fa-magnifying-glass"></i> بحث</button>
        @if(request('search'))
            <a href="{{ route('medicines.index') }}" class="btn btn-outline-secondary">إلغاء البحث</a>
        @endif
    </div>
</form>

<!-- جدول الأدوية -->
<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th>الصورة</th>
                    <th>اسم الدواء</th>
                    <th>الباركود</th>
                    <th>سعر الشراء</th>
                    <th>سعر البيع</th>
                    <th>المخزن</th>
                    <th>تاريخ الصلاحية</th>
                    <th class="text-center">التحكم</th>
                </tr>
            </thead>
            <tbody>
                @forelse($medicines as $medicine)
                    <tr>
                        <!-- عرض صورة الدواء -->
                        <td>
                            @if($medicine->image)
                                <img src="{{ asset('storage/' . $medicine->image) }}" alt="{{ $medicine->name }}" width="45" height="45" class="rounded object-fit-cover shadow-sm border">
                            @else
                                <span class="badge bg-secondary">بدون صورة</span>
                            @endif
                        </td>
                        <td class="fw-bold text-info">{{ $medicine->name }}</td>
                        <td>{{ $medicine->barcode ?? '---' }}</td>
                        <td>{{ $medicine->purchase_price }} ج.م</td>
                        <td>{{ $medicine->selling_price }} ج.م</td>
                        <td>
                            <span class="badge {{ $medicine->stock_quantity <= 5 ? 'bg-danger' : 'bg-success' }}">
                                {{ $medicine->stock_quantity }}
                            </span>
                        </td>
                        <td>{{ $medicine->expire_date }}</td>
                        <td class="text-center">
                            <a href="{{ route('medicines.edit', $medicine->id) }}" class="btn btn-sm btn-warning text-dark fw-bold">تعديل</a>
                            <form action="{{ route('medicines.destroy', $medicine->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">حذف</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">لا توجد أدوية مسجلة حالياً.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection