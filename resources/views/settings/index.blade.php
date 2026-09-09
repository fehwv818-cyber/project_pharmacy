@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-transparent text-info fw-bold border-bottom">
                <i class="fa-solid fa-gear ms-1"></i> إعدادات الصيدلية العامة
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success bg-success text-white border-0">{{ session('success') }}</div>
                @endif

                <form action="{{ route('settings.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-bold">اسم الصيدلية</label>
                        <input type="text" name="pharmacy_name" class="form-control" value="{{ $settings['pharmacy_name'] ?? 'صيدليتي الذكية' }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">رقم التليفون</label>
                        <input type="text" name="phone" class="form-control" value="{{ $settings['phone'] ?? '' }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">عنوان الصيدلية</label>
                        <input type="text" name="address" class="form-control" value="{{ $settings['address'] ?? '' }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">عملة البيع (مثال: ج.م)</label>
                        <input type="text" name="currency" class="form-control" value="{{ $settings['currency'] ?? 'ج.م' }}">
                    </div>

                    <button type="submit" class="btn btn-info text-dark fw-bold w-100 py-2">حفظ التعديلات</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection