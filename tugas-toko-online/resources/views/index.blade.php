@extends('layout')

@section('content')
    <h2>Daftar Barang</h2>

    <div class="grid">
        @foreach ($barang as $b)
            <div class="card">
                <div class="img">
                    <img src="{{ asset('images/' . $b->gambar) }}" alt="{{ $b->nama_barang }}" onerror="this.style.display='none'">
                </div>
                <strong>{{ $b->nama_barang }}</strong>
                <div>Rp {{ number_format($b->harga, 0, ',', '.') }}</div>
                <div class="muted">
                    @if ($b->stok > 0)
                        Stok: {{ $b->stok }}
                    @else
                        <span style="color:#b91c1c">Stok habis</span>
                    @endif
                </div>
                <div class="desc">{{ $b->deskripsi }}</div>

                <div style="margin-top:10px">
                    @guest
                        <a href="{{ route('login') }}" class="btn gray">Login untuk membeli</a>
                    @else
                        @if ($b->stok > 0)
                            <form method="POST" action="{{ route('keranjang.tambah', $b) }}">
                                @csrf
                                <button type="submit">Masukkan ke keranjang</button>
                            </form>
                        @else
                            <button type="button" disabled>Stok habis</button>
                        @endif
                    @endguest
                </div>
            </div>
        @endforeach
    </div>
@endsection
