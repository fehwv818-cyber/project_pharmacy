@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2><i class="fa-solid fa-chart-pie ms-2"></i> تقارير الأرباح والمبيعات</h2>
            <p class="text-muted">متابعة حركة المبيعات والأرباح اللحظية للصيدلية.</p>
        </div>
    </div>

    <!-- بطاقات الإحصائيات السريعة -->
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card p-3 border-start border-primary border-4 shadow-sm">
                <h5 class="text-muted fs-6">إجمالي المبيعات</h5>
                <h3 class="fw-bold text-primary mb-0">{{ number_format($totalSales ?? 0, 2) }} ج.م</h3>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-3 border-start border-success border-4 shadow-sm">
                <h5 class="text-muted fs-6">إجمالي الفواتير المصدرة</h5>
                <h3 class="fw-bold text-success mb-0">{{ $salesCount ?? 0 }} فاتورة</h3>
            </div>
        </div>
    </div>

    <!-- جدول آخر المبيعات -->
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold"><i class="fa-solid fa-history ms-2"></i> سجل آخر الفواتير والمبيعات</h5>
        </div>
        <div class="card-body">
            @if(isset($latestSales) && $latestSales->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            ين
                            <tr>
                                <th>رقم الفاتورة</th>
                                <th>إجمالي المبلغ</th>
                                <th>تاريخ البيع</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($latestSales as $sale)
                                <tr>
                                    <td>#{{ $sale->id }}</td>
                                    <td class="fw-bold text-success">{{ number_format($sale->total_amount, 2) }} ج.م</td>
                                    <td>{{ $sale->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <a href="{{ route('sales.invoice', $sale->id) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                            <i class="fa-solid fa-print"></i> عرض الفاتورة
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4 text-muted">
                    <i class="fa-solid fa-box-open fs-1 mb-2"></i>
                    <p>لا توجد مبيعات مسجلة حتى الآن. جرب إجراء عملية بيع جديدة من شاشة البيع!</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection