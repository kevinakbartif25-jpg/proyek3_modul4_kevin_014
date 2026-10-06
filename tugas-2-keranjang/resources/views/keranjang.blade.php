@extends('layout')

@section('content')
    <h2>Keranjang belanja Tanpa login</h2>

    @forelse ($items as $item)
        <div class="item">
            <div class="info">
                <strong>{{ $item['barang']->nama }}</strong><br>
                Rp {{ number_format($item['barang']->harga, 0, ',', '.') }} x {{ $item['jumlah'] }}
                = Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
            </div>

            <div class="actions">
                <form method="POST" action="{{ route('keranjang.ubah', $item['barang']) }}">
                    @csrf
                    <input type="hidden" name="aksi" value="kurang">
                    <button type="submit" class="gray">-</button>
                </form>

                <span>{{ $item['jumlah'] }}</span>

                <form method="POST" action="{{ route('keranjang.ubah', $item['barang']) }}">
                    @csrf
                    <input type="hidden" name="aksi" value="tambah">
                    <button type="submit" class="gray">+</button>
                </form>

                <form method="POST" action="{{ route('keranjang.hapus', $item['barang']) }}">
                    @csrf
                    <button type="submit" class="danger">hapus</button>
                </form>
            </div>
        </div>
    @empty
        <div class="empty">Keranjang masih kosong.</div>
    @endforelse

    @if (count($items) > 0)
        <div class="total">Total Rp {{ number_format($total, 0, ',', '.') }}</div>

        <form method="POST" action="{{ route('keranjang.kosongkan') }}">
            @csrf
            <button type="submit" class="danger">Kosongkan keranjang</button>
        </form>
    @endif
@endsection