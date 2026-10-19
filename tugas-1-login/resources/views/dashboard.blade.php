 <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
</head>
<body>
    <header>
        <h1>Dashboard</h1>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </header>

    <main>
        <h2>Selamat datang, {{ auth()->user()->nama_lengkap }}!</h2>
        <p>Halaman ini hanya bisa dibuka setelah login.</p>
        <p>Username: {{ auth()->user()->username }}</p>
        <p>Role Anda: <strong>{{ auth()->user()->role }}</strong></p>

        @if (session('status'))
            <p style="color: green;">{{ session('status') }}</p>
        @endif

        @if ($errors->any())
            <div style="color: red;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @can('manage-roles')
            <hr>
            <h3>Manajemen Role Pengguna (Admin Only)</h3>
            <table border="1" cellpadding="8" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Nama Lengkap</th>
                        <th>Role Saat Ini</th>
                        <th>Aksi Ubah Role</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $u)
                        <tr>
                            <td>{{ $u->id }}</td>
                            <td>{{ $u->username }}</td>
                            <td>{{ $u->nama_lengkap }}</td>
                            <td><strong>{{ $u->role }}</strong></td>
                            <td>
                                <form action="{{ route('admin.users.role.update', $u->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <select name="role">
                                        <option value="customer" {{ $u->role === 'customer' ? 'selected' : '' }}>customer</option>
                                        <option value="staff" {{ $u->role === 'staff' ? 'selected' : '' }}>staff</option>
                                    </select>
                                    <button type="submit">Simpan</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endcan
    </main>
</body>
</html>