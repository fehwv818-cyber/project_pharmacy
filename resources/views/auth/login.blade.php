@extends('layouts.app')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="col-md-5">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <h3 class="text-info fw-bold"><i class="fa-solid fa-staff-snake ms-2"></i> تسجيل الدخول</h3>
                    <p class="text-muted small">نظام إدارة صيدليتي الذكية</p>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger py-2">
                        @foreach($errors->all() as $error)
                            <div class="small">{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('login.submit') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold">البريد الإلكتروني</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">كلمة المرور</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-info text-dark fw-bold w-100 py-2">دخول للسيستم</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection