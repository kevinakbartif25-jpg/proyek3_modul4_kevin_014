@extends('layout')

@section('content')
    <div class="box form-card">
        <h2>Login</h2>

        @error('login')
            <div class="alert error">{{ $message }}</div>
        @enderror

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="{{ old('username') }}" autofocus>
            @error('username') <div class="muted" style="color:#b91c1c">{{ $message }}</div> @enderror

            <label for="password">Password</label>
            <input type="password" id="password" name="password">
            @error('password') <div class="muted" style="color:#b91c1c">{{ $message }}</div> @enderror

            <button type="submit" style="margin-top:16px;width:100%">Masuk</button>
        </form>

        <p class="muted">Belum punya akun? <a href="{{ route('register') }}">Daftar</a></p>
    </div>
@endsection
