@extends('layout')

@section('content')
    <div class="box form-card">
        <h2>Daftar</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <label>Nama lengkap</label>
            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}">
            @error('nama_lengkap') <div class="muted" style="color:#b91c1c">{{ $message }}</div> @enderror

            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}">
            @error('email') <div class="muted" style="color:#b91c1c">{{ $message }}</div> @enderror

            <label>Username</label>
            <input type="text" name="username" value="{{ old('username') }}">
            @error('username') <div class="muted" style="color:#b91c1c">{{ $message }}</div> @enderror

            <label>Password</label>
            <input type="password" name="password">
            @error('password') <div class="muted" style="color:#b91c1c">{{ $message }}</div> @enderror

            <label>Ulangi password</label>
            <input type="password" name="password_confirmation">

            <label>No. HP</label>
            <input type="text" name="no_hp" value="{{ old('no_hp') }}">
            @error('no_hp') <div class="muted" style="color:#b91c1c">{{ $message }}</div> @enderror

            <label>Alamat</label>
            <textarea name="alamat" rows="3">{{ old('alamat') }}</textarea>
            @error('alamat') <div class="muted" style="color:#b91c1c">{{ $message }}</div> @enderror

            <button type="submit" style="margin-top:16px;width:100%">Daftar</button>
        </form>
    </div>
@endsection
