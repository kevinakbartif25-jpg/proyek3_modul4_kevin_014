<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Toko Online</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f4f6;
            margin: 0;
            color: #111;
        }

        header {
            background: #fff;
            padding: 14px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .1);
            flex-wrap: wrap;
            gap: 8px;
        }

        header a {
            text-decoration: none;
            color: #111;
        }

        .brand {
            font-size: 22px;
            font-weight: bold;
        }

        nav {
            display: flex;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
        }

        nav form {
            margin: 0;
        }

        .btn-cart {
            background: #2563eb;
            color: #fff !important;
            padding: 8px 14px;
            border-radius: 4px;
        }

        main {
            max-width: 960px;
            margin: 24px auto;
            padding: 0 16px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 16px;
        }

        .card {
            background: #fff;
            border-radius: 8px;
            padding: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .08);
            display: flex;
            flex-direction: column;
        }

        .card .img {
            height: 140px;
            background: #e5e7eb;
            border-radius: 6px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }

        .card .img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .card .desc {
            color: #6b7280;
            font-size: 13px;
            flex: 1;
        }

        .item {
            background: #fff;
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 10px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .08);
        }

        .info {
            flex: 1;
        }

        .actions {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .actions form {
            margin: 0;
        }

        button,
        .btn {
            padding: 8px 14px;
            border: 0;
            border-radius: 4px;
            background: #2563eb;
            color: #fff;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
        }

        button.danger {
            background: #dc2626;
        }

        button.gray {
            background: #6b7280;
        }

        button:disabled {
            background: #d1d5db;
            cursor: not-allowed;
        }

        .box {
            background: #fff;
            padding: 16px;
            border-radius: 8px;
            margin: 16px 0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .08);
        }

        .total {
            font-size: 18px;
            font-weight: bold;
        }

        .alert {
            padding: 10px 14px;
            border-radius: 4px;
            margin-bottom: 12px;
            font-size: 14px;
        }

        .alert.error {
            background: #fee2e2;
            color: #b91c1c;
        }

        .alert.success {
            background: #dcfce7;
            color: #166534;
        }

        .empty {
            background: #fff;
            padding: 24px;
            border-radius: 8px;
            text-align: center;
            color: #6b7280;
        }

        label {
            display: block;
            margin: 12px 0 4px;
            font-size: 14px;
        }

        input[type=text],
        input[type=password],
        input[type=email],
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            box-sizing: border-box;
            font-family: inherit;
        }

        .form-card {
            max-width: 400px;
            margin: 0 auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
        }

        th,
        td {
            padding: 10px 12px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
            font-size: 14px;
        }

        th {
            background: #f9fafb;
        }

        .muted {
            color: #6b7280;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <header>
        <a href="{{ route('index') }}" class="brand">Toko Online</a>
        <nav>
            <a href="{{ route('index') }}">Barang</a>
            @auth
            <a href="{{ route('pesanan') }}">Pesanan Saya</a>
            <a href="{{ route('keranjang') }}" class="btn-cart">Keranjang ({{ array_sum(session('keranjang', [])) }})</a>
            <span class="muted">{{ auth()->user()->nama_lengkap }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="danger">Logout</button>
            </form>
            @else
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}" class="btn-cart">Daftar</a>
            @endauth
        </nav>
    </header>

    <main>
        @if (session('success'))
        <div class="alert success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
        <div class="alert error">{{ session('error') }}</div>
        @endif

        @yield('content')
    </main>
</body>

</html>