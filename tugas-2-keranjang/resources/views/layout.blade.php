<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Toko Alat Tulis</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f3f4f6; margin: 0; }
        header { background: #fff; padding: 16px 32px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 1px 4px rgba(0,0,0,.1); }
        header a { text-decoration: none; color: #111; }
        .brand { font-size: 22px; font-weight: bold; }
        .btn-cart { background: #2563eb; color: #fff !important; padding: 8px 16px; border-radius: 4px; }
        main { max-width: 760px; margin: 24px auto; padding: 0 16px; }
        .item { background: #fff; display: flex; align-items: center; gap: 16px; padding: 12px 16px; border-radius: 8px; margin-bottom: 10px; box-shadow: 0 1px 3px rgba(0,0,0,.08); }
        .img { width: 48px; height: 48px; background: #e5e7eb; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-weight: bold; color: #6b7280; }
        .info { flex: 1; }
        .actions { display: flex; align-items: center; gap: 6px; }
        .actions form { margin: 0; }
        button { padding: 6px 12px; border: 0; border-radius: 4px; background: #2563eb; color: #fff; cursor: pointer; }
        button.danger { background: #dc2626; }
        button.gray { background: #6b7280; }
        .total { background: #fff; padding: 16px; border-radius: 8px; font-size: 18px; font-weight: bold; margin: 16px 0; }
        .error { background: #fee2e2; color: #b91c1c; padding: 10px; border-radius: 4px; margin-bottom: 12px; }
        .empty { background: #fff; padding: 24px; border-radius: 8px; text-align: center; color: #6b7280; }
    </style>
</head>
<body>
    <header>
        <a href="{{ route('index') }}" class="brand">Toko Alat Tulis</a>
        <a href="{{ route('keranjang') }}" class="btn-cart">Keranjang ({{ array_sum(session('keranjang', [])) }})</a>
    </header>

    <main>
        @if (session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif

        @yield('content')
    </main>
</body>
</html>