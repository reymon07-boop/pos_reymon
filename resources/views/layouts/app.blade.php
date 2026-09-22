<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>

    @vite([
    'resources/css/app.css',
    'resources/js/app.js'
    ])

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    html,
    body {
        width: 100%;
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
        /* Background dasar dibuat gelap netral agar tidak bocor warna putih */
        background-color: #6a556d;
        color: #5a6370;
        overflow-x: hidden;
    }

    .main-content {
        width: 100%;
        min-height: 100vh;
        padding: 0;
        /* Di-set 0 agar child component bisa mengambil alih secara full screen */
        margin: 0;
    }

    /* Card */

    .card {

        border: none;

        border-radius: 22px;

        overflow: hidden;

        box-shadow:
            0 10px 35px rgba(15, 23, 42, .08);

        transition: .3s;

    }

    .card:hover {

        transform: translateY(-2px);

        box-shadow:
            0 18px 40px rgba(15, 23, 42, .12);

    }

    /* Button */

    .btn {

        border-radius: 12px;

        font-weight: 600;

        transition: .25s;

    }

    .btn:hover {

        transform: translateY(-2px);

    }



    .table {

        margin-bottom: 0;

    }

    .table thead th {

        background: #16a34a;

        color: white;

        border: none;

        text-align: center;

        vertical-align: middle;

        font-weight: 600;

    }

    .table tbody td {

        vertical-align: middle;

    }

    .table tbody tr {

        transition: .25s;

    }

    .table tbody tr:hover {

        background: #f0fdf4;

    }

    /* Image */

    img {

        border-radius: 12px;

    }

    /* Badge */

    .badge {

        font-size: .85rem;

        padding: 8px 14px;

        border-radius: 30px;

    }



    .alert-modern {

        border: none;

        border-radius: 18px;

        font-weight: 600;

        padding: 16px 20px;

        box-shadow: 0 10px 25px rgba(0, 0, 0, .08);

        animation: slideDown .5s;

    }

    @keyframes slideDown {

        from {

            opacity: 0;

            transform: translateY(-20px);

        }

        to {

            opacity: 1;

            transform: translateY(0);

        }

    }



    ::-webkit-scrollbar {

        width: 9px;

    }

    ::-webkit-scrollbar-track {

        background: #1f16a3;

    }

    ::-webkit-scrollbar-thumb {

        background: #1f16a3;

        border-radius: 20px;

    }

    ::-webkit-scrollbar-thumb:hover {

        background: #1f16a3;

    }

    /* Pagination */

    .pagination {

        justify-content: end;

    }

    .page-link {

        color: #1f16a3;

        border-radius: 10px !important;

        margin: 0 3px;

    }

    .page-item.active .page-link {

        background: #1f16a3;

        border-color: #1f16a3;

    }
    </style>

</head>

<body>

    <div class="main-content">

        @if(session('success'))

        <div class="alert alert-success alert-modern m-4">

            <i class="bi bi-check-circle-fill me-2"></i>

            {{ session('success') }}

        </div>

        @endif

        @yield('content')

    </div>

</body>

</html>