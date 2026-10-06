@extends('layout')

@section('content')
    <h2>Daftar barang</h2>

    @foreach ($barang as $b)
        <div class="item">
            <div class="img">{{ strtoupper(substr($b->nama, 0, 1)) }}</div>
            <div class="info">
                <strong>{{ $b->nama }}</strong><br>
                Rp {{ number_format($b->harga, 0, ',', '.') }} &middot; stok {{ $b->stok }}
            </div>
            <form method="POST" action="{{ route('keranjang.tambah', $b) }}">
                @csrf
                <button type="submit">Masukkan ke keranjang</button>
            </form>
        </div>
    @endforeach
@endsection