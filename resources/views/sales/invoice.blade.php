@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm p-4" id="printableArea">
                <!-- رأس الفاتورة -->
                <div class="text-center border-bottom pb-3 mb-4">
                    <h2><i class="fa-solid fa-clinic-medical text-primary"></i> نظام صيدليتي الذكية</h2>
                    <p class="text-muted mb-0">فاتورة مبيعات رسمية</p>
                </div>

                <!-- معلومات الفاتورة -->
                <div class="row mb-3">
                    <div class="col-6">
                        <strong>رقم الفاتورة:</strong> #{{ $sale->id }}
                    </div>
                    <div class="col-6 text-end">
                        <strong>تاريخ ووقت البيع:</strong> {{ $sale->created_at->format('Y-m-d H:i') }}
                    </div>
                </div>

                <!-- جدول تفاصيل الدواء -->
                <div class="table-responsive mb-4">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>اسم الدواء</th>
                                <th>الكمية المباعة</th>
                                <th>إجمالي السعر</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-bold">{{ $sale->medicine->name ?? 'غير متوفر' }}</td>
                                <td>{{ $sale->quantity }}</td>
                                <td class="text-success fw-bold">{{ number_format($sale->total_price, 2) }} ج.م</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- الإجمالي النهائي -->
                <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded mb-4">
                    <h4 class="mb-0">الإجمالي المستحق:</h4>
                    <h3 class="text-success fw-bold mb-0">{{ number_format($sale->total_price, 2) }} ج.م</h3>
                </div>

                <!-- أزرار التحكم (طباعة أو رجوع) -->
                <div class="text-center d-print-none">
                    <button onclick="window.print()" class="btn btn-primary px-4 me-2">
                        <i class="fa-solid fa-print ms-1"></i> طباعة الفاتورة
                    </button>
                    <a href="{{ route('reports.index') }}" class="btn btn-secondary px-4">
                        <i class="fa-solid fa-arrow-right ms-1"></i> العودة للتقارير
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection