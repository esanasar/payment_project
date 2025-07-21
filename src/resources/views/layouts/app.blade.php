<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>سیستم مدیریت هزینه</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Vazirmatn', sans-serif; }
        .table th { background-color: #f8f9fa; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('expenses.pending') }}">مدیریت هزینه</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('expenses.create') }}">ثبت درخواست جدید</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('expenses.pending') }}">درخواست‌های در انتظار</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('expenses.approved') }}">درخواست‌های تایید شده</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="container mt-4">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html> 