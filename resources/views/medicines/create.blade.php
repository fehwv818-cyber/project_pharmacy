@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-transparent text-info fw-bold border-bottom border-secondary">
                <i class="fa-solid fa-plus-circle ms-1"></i> إضافة دواء جديد للصيدلية
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('medicines.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">اسم الدواء</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">الباركود (اختياري)</label>
                        <input type="text" name="barcode" class="form-control" value="{{ old('barcode') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">صورة الدواء (اختياري)</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">سعر الشراء</label>
                            <input type="number" step="0.01" name="purchase_price" class="form-control" value="{{ old('purchase_price') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">سعر البيع</label>
                            <input type="number" step="0.01" name="selling_price" class="form-control" value="{{ old('selling_price') }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">الكمية بالمخزن</label>
                            <input type="number" name="stock_quantity" class="form-control" value="{{ old('stock_quantity') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">تاريخ الصلاحية</label>
                            <input type="date" name="expire_date" class="form-control" value="{{ old('expire_date') }}" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('medicines.index') }}" class="btn btn-secondary">إلغاء</a>
                        <button type="submit" class="btn btn-info text-dark fw-bold px-4">حفظ الدواء</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection