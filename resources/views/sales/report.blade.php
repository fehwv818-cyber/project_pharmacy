@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-primary fw-bold"><i class="fa-solid fa-chart-pie ms-2"></i> تقارير المبيعات والأرباح</h2>
    <a href="{{ route('sales.create') }}" class="btn btn-primary">الذهاب لشاشة البيع</a>
</div>

<!-- كروت إجمالية للتقارير -->
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card shadow-sm border-start border-primary border-4">
            <div class="card-body">
                <h5 class="card-title text-muted">إجمالي المبيعات</h5>
                <h3 class="text-primary fw-bold">{{ $totalSalesAmount }} ج.م</h3>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow-sm border-start border-success border-4">
            <div class="card-body">
                <h5 class="card-title text-muted">إجمالي الأرباح الصافية</h5>
                <h3 class="text-success fw-bold">{{ $totalProfitAmount }} ج.م</h3>
            </div>
        </div>
    </div>
</div>

<!-- جدول سجل الفواتير والمبيعات -->
<div class="card shadow-sm">
    <div class="card-header bg-transparent fw-bold">
        <i class="fa-solid fa-list-check ms-1"></i> تفاصيل عمليات البيع السابقة
    </div>
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>اسم الدواء</th>
                    <th>الكمية المباعة</th>
                    <th>إجمالي السعر</th>
                    <th>الربح المحقق</th>
                    <th>وقت العملية</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sales as $sale)
                    <tr>
                        <td class="fw-bold text-primary">{{ $sale->medicine->name ?? 'دواء محذوف' }}</td>
                        <td>{{ $sale->quantity }}</td>
                        <td>{{ $sale->total_price }} ج.م</td>
                        <td><span class="text-success fw-bold">+{{ $sale->profit }} ج.م</span></td>
                        <td>{{ $sale->created_at->format('Y-m-d h:i A') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">لا توجد عمليات بيع مسجلة حتى الآن.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection