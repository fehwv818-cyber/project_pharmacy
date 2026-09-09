@extends('layouts.app')

@section('content')
<h2 class="mb-4 text-info fw-bold">لوحة المؤشرات الرئيسية</h2>

<!-- كروت الإحصائيات -->
<div class="row g-4 mb-5">
    <div class="col-md-4">
        <div class="card shadow-sm border-start border-info border-4">
            <div class="card-body">
                <h5 class="card-title text-muted">إجمالي أنواع الأدوية</h5>
                <h3 class="text-info fw-bold">{{ $totalMedicines }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-start border-success border-4">
            <div class="card-body">
                <h5 class="card-title text-muted">إجمالي العلب بالمخزن</h5>
                <h3 class="text-success fw-bold">{{ $totalStock }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm border-start border-danger border-4">
            <div class="card-body">
                <h5 class="card-title text-muted">أدوية وشيك على النفاذ</h5>
                <h3 class="text-danger fw-bold">{{ $lowStockMedicines->count() }}</h3>
            </div>
        </div>
    </div>
</div>

<!-- جدول النواقص -->
<div class="card shadow-sm">
    <div class="card-header bg-transparent border-bottom border-secondary text-danger fw-bold">
        <i class="fa-solid fa-triangle-exclamation ms-2"></i> تنبيه الأدوية المنخفضة في المخزن
    </div>
    <div class="card-body">
        @if($lowStockMedicines->count() > 0)
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>اسم الدواء</th>
                        <th>الكمية المتبقية</th>
                        <th>سعر البيع</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lowStockMedicines as $medicine)
                        <tr>
                            <td>{{ $medicine->name }}</td>
                            <td><span class="badge bg-danger">{{ $medicine->stock_quantity }}</span></td>
                            <td>{{ $medicine->selling_price }} ج.م</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-muted mb-0">ممتاز! لا توجد أدوية منخفضة المخزن حالياً.</p>
        @endif
    </div>
</div>
@endsection