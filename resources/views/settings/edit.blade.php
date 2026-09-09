@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm p-4">
                <h3 class="mb-4"><i class="fa-solid fa-gears ms-2"></i> إعدادات الصيدلية</h3>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('settings.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-bold">اسم الصيدلية:</label>
                        <input type="text" name="pharmacy_name" class="form-control" value="{{ $setting->pharmacy_name }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">رقم الهاتف:</label>
                        <input type="text" name="phone" class="form-control" value="{{ $setting->phone }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">العنوان:</label>
                        <textarea name="address" class="form-control" rows="2">{{ $setting->address }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fa-solid fa-save ms-1"></i> حفظ التعديلات
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection