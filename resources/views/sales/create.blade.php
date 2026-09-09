@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">

        @if(session('invoice'))
            <div class="card shadow-sm mb-4 border-primary" id="printableInvoiceCard">
                <div class="card-header bg-primary text-white fw-bold d-flex justify-content-between align-items-center">
                    <span><i class="fa-solid fa-receipt ms-1"></i> تفاصيل فاتورة البيع الأخيرة</span>
                    <button onclick="window.print()" class="btn btn-sm btn-light fw-bold text-primary">
                        <i class="fa-solid fa-print ms-1"></i> طباعة الفاتورة
                    </button>
                </div>
                <div class="card-body bg-white text-dark rounded-bottom" id="printableInvoice">
                    <div class="text-center mb-3">
                        <h4 class="fw-bold text-primary">صيدليتي الذكية</h4>
                        <p class="text-muted mb-1 small">فاتورة مبيعات معتمدة</p>
                        <hr>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6"><strong>اسم الدواء:</strong> {{ session('invoice')['medicine_name'] }}</div>
                        <div class="col-6"><strong>الكمية:</strong> {{ session('invoice')['quantity'] }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6"><strong>سعر الوحدة:</strong> {{ session('invoice')['unit_price'] }} ج.م</div>
                        <div class="col-6"><strong>الإجمالي الكلي:</strong> <span class="text-success fw-bold">{{ session('invoice')['total_price'] }} ج.م</span></div>
                    </div>
                    <div class="text-center mt-3 text-muted small border-top pt-2">
                        شکراً لتعاملكم معنا - تمنياتنا بالشفاء العاجل
                    </div>
                </div>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-header bg-transparent text-primary fw-bold border-bottom">
                <i class="fa-solid fa-cash-register ms-1"></i> شاشة البيع وسحب المخزون والبحث الفوري بالباركود
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success bg-success text-white border-0">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('sales.store') }}" method="POST">
                    @csrf

                    <!-- خانة البحث الفوري والباروكد الاحترافية -->
                    <div class="mb-4 position-relative">
                        <label for="search-medicine" class="form-label fw-bold">بحث فوري أو مسح الباركود:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                            <input type="text" id="search-medicine" class="form-control form-control-lg" placeholder="اكتب اسم الدواء أو استخدم جهاز قراءة الباركود هنا..." autofocus autocomplete="off">
                        </div>
                        <!-- قائمة النتائج المنسدلة الفورية -->
                        <div id="search-results" class="list-group position-absolute w-100 shadow-sm" style="z-index: 1000; max-height: 250px; overflow-y: auto;"></div>
                    </div>

                    <div class="mb-3">
                        <label for="medicineSelect" class="form-label">الدواء المحدد للفاتورة</label>
                        <select name="medicine_id" id="medicineSelect" class="form-select" required>
                            <option value="">-- اختر الدواء المطلوب --</option>
                            @foreach($medicines as $medicine)
                                <option value="{{ $medicine->id }}" data-barcode="{{ $medicine->barcode }}">
                                    {{ $medicine->name }} (المتاح: {{ $medicine->stock_quantity }}) - السعر: {{ $medicine->selling_price }} ج.م
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="quantity" class="form-label">الكمية المراد بيعها</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" min="1" value="1" required>
                    </div>

                    <button type="submit" class="btn btn-primary fw-bold w-100 py-2 mt-3">إتمام البيع وخصم المخزون</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search-medicine');
    const resultsContainer = document.getElementById('search-results');
    const selectBox = document.getElementById('medicineSelect');

    let debounceTimer;

    searchInput.addEventListener('input', function () {
        clearTimeout(debounceTimer);
        let query = this.value.trim();

        if (query.length < 1) {
            resultsContainer.innerHTML = '';
            return;
        }

        // استخدام الـ Debounce لتقليل طلبات السيرفر
        debounceTimer = setTimeout(() => {
            fetch(`/api/medicines/search?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    resultsContainer.innerHTML = '';
                    
                    if (data.length === 0) {
                        resultsContainer.innerHTML = '<div class="list-group-item text-muted">لا توجد نتائج مطابقة</div>';
                        return;
                    }

                    // لو الدواء تطابق تماماً بالباركود المدخل، اختاره فورا في القائمة وحدد خانة الكمية
                    if (data.length === 1 && data[0].barcode === query) {
                        selectMedicine(data[0].id);
                        searchInput.value = '';
                        resultsContainer.innerHTML = '';
                        return;
                    }

                    data.forEach(medicine => {
                        let item = document.createElement('a');
                        item.href = '#';
                        item.className = 'list-group-item list-group-item-action d-flex justify-content-between align-items-center';
                        item.innerHTML = `
                            <span><strong>${medicine.name}</strong> (السعر: ${medicine.selling_price} ج.م)</span>
                            <span class="badge bg-primary rounded-pill">المخزون: ${medicine.stock_quantity}</span>
                        `;
                        item.addEventListener('click', function (e) {
                            e.preventDefault();
                            selectMedicine(medicine.id);
                            searchInput.value = '';
                            resultsContainer.innerHTML = '';
                            document.getElementById('quantity').focus();
                        });
                        resultsContainer.appendChild(item);
                    });
                });
        }, 300);
    });

    // دالة لاختيار الدواء تلقائياً في قائمة الـ Select الموجودة بالفورم
    function selectMedicine(medicineId) {
        selectBox.value = medicineId;
        // إطلاق حدث تغيير لضمان توافق أي سكريبتات أخرى لو وجدت
        selectBox.dispatchEvent(new Event('change'));
    }

    // إغلاق قائمة البحث لو الضغط برة العنصرين
    document.addEventListener('click', function (e) {
        if (!searchInput.contains(e.target) && !resultsContainer.contains(e.target)) {
            resultsContainer.innerHTML = '';
        }
    });
});
</script>
@endsection