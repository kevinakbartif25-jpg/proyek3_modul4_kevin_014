<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
</head>
<body>
    <div class="card">
        <h1>Login</h1>
        <p class="sub">Masuk untuk membuka dashboard</p>

        @error('login')
            <div class="error">{{ $message }}</div>
        @enderror

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="{{ old('username') }}" autofocus>
            @error('username')
                <div class="field-error">{{ $message }}</div>
            @enderror

            <label for="password">Password</label>
            <input type="password" id="password" name="password">
            @error('password')
                <div class="field-error">{{ $message }}</div>
            @enderror   

            <button type="submit">Masuk</button>
        </form>
    </div>
</body>
</html>