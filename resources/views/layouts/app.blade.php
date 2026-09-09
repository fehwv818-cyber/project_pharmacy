<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نظام إدارة الصيدلية - Pharoah Pharmacy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #0d6efd;
            --sidebar-bg: #f8f9fa;
            --body-bg: #f4f6f9;
            --card-bg: #ffffff;
            --text-color: #334155;
        }

        body {
            background-color: var(--body-bg);
            color: var(--text-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        .sidebar {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            width: 260px;
            background-color: var(--sidebar-bg);
            border-left: 1px solid #dee2e6;
            z-index: 1050;
            box-shadow: -2px 0 10px rgba(0, 0, 0, 0.03);
            transition: transform 0.3s ease-in-out;
        }

        .sidebar .brand {
            padding: 22px;
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary-color);
            border-bottom: 1px solid #dee2e6;
            text-align: center;
            background-color: #ffffff;
        }

        .sidebar .nav-link {
            color: #495057;
            padding: 12px 20px;
            margin: 8px 15px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            color: #ffffff;
            background-color: var(--primary-color);
            box-shadow: 0 4px 10px rgba(13, 110, 253, 0.25);
        }

        /* لو المستخدم مش مسجل دخول، محتوى الموقع هيملى الشاشة من غير هامش جانبي */
        .main-content {
            margin-right: 260px;
            padding: 30px;
            transition: margin 0.3s ease-in-out;
        }

        .main-content.full-width {
            margin-right: 0 !important;
        }

        .top-navbar {
            background-color: #ffffff;
            border-bottom: 1px solid #dee2e6;
            padding: 10px 20px;
            display: none;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1040;
        }

        .card {
            background-color: var(--card-bg) !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-content {
                margin-right: 0 !important;
                padding: 15px;
            }
            .top-navbar {
                display: flex;
            }
        }
    </style>
</head>
<body>

    @auth
        <!-- شريط التنقل العلوي للموبايل (يظهر للمسجلين دخول فقط) -->
        <div class="top-navbar">
            <button class="btn btn-outline-primary" id="sidebarToggle">
                <i class="fa-solid fa-bars"></i> القائمة
            </button>
            <span class="fw-bold text-primary"><i class="fa-solid fa-staff-snake"></i> صيدليتي الذكية</span>
        </div>

        <!-- القائمة الجانبية (تظهر للمسجلين دخول فقط) -->
        <div class="sidebar" id="appSidebar">
            <div class="brand d-flex justify-content-between align-items-center">
                <span><i class="fa-solid fa-staff-snake ms-1"></i> صيدليتي الذكية</span>
                <button class="btn btn-sm text-muted d-lg-none" id="sidebarClose">
                    <i class="fa-solid fa-xmark fs-5"></i>
                </button>
            </div>
            <ul class="nav flex-column mt-3">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="fa-solid fa-chart-line ms-2"></i> الرئيسية
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('medicines.*') ? 'active' : '' }}" href="{{ route('medicines.index') }}">
                        <i class="fa-solid fa-pills ms-2"></i> إدارة الأدوية
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('sales.*') ? 'active' : '' }}" href="{{ route('sales.create') }}">
                        <i class="fa-solid fa-cash-register ms-2"></i> شاشة البيع
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
                        <i class="fa-solid fa-chart-pie ms-2"></i> تقارير الأرباح
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}" href="{{ route('settings.index') }}">
                        <i class="fa-solid fa-gear ms-2"></i> إعدادات الصيدلية
                    </a>
                </li>
                
                <!-- زرار تسجيل الخروج -->
                <li class="nav-item mt-4 px-3">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100 text-start">
                            <i class="fa-solid fa-right-from-bracket ms-2"></i> تسجيل الخروج
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    @endauth

    <!-- محتوى الصفحة (لو مش مسجل دخول، هياخد عرض الشاشة بالكامل full-width) -->
    <div class="main-content @guest full-width @endguest">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>    
    <script>
        const sidebar = document.getElementById('appSidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarClose = document.getElementById('sidebarClose');

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('show');
            });
        }

        if (sidebarClose) {
            sidebarClose.addEventListener('click', () => {
                sidebar.classList.remove('show');
            });
        }

        document.addEventListener('click', (event) => {
            if (sidebar && window.innerWidth < 992) {
                if (!sidebar.contains(event.target) && sidebarToggle && !sidebarToggle.contains(event.target)) {
                    sidebar.classList.remove('show');
                }
            }
        });
    </script>
</body>
</html>