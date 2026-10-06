@extends('layout')

@section('content')
    <h2>Keranjang Belanja</h2>

    @forelse ($items as $item)
        <div class="item">
            <div class="info">
                <strong>{{ $item['barang']->nama_barang }}</strong><br>
                Rp {{ number_format($item['barang']->harga, 0, ',', '.') }} x {{ $item['jumlah'] }}
                = Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                <div class="muted">Stok tersedia: {{ $item['barang']->stok }}</div>
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
                    <button type="submit" class="danger">Hapus</button>
                </form>
            </div>
        </div>
    @empty
        <div class="empty">Keranjang masih kosong. <a href="{{ route('index') }}">Belanja dulu</a></div>
    @endforelse

    @if (count($items) > 0)
        <div class="box total">Total: Rp {{ number_format($total, 0, ',', '.') }}</div>

        <div class="box">
            <form method="POST" action="{{ route('checkout') }}">
                @csrf
                <label for="alamat_pengiriman">Alamat pengiriman</label>
                <textarea id="alamat_pengiriman" name="alamat_pengiriman" rows="3">{{ old('alamat_pengiriman', auth()->user()->alamat) }}</textarea>
                @error('alamat_pengiriman') <div class="muted" style="color:#b91c1c">{{ $message }}</div> @enderror

                <button type="submit" style="margin-top:12px">Checkout</button>
            </form>
        </div>

        <form method="POST" action="{{ route('keranjang.kosongkan') }}">
            @csrf
            <button type="submit" class="danger">Kosongkan keranjang</button>
        </form>
    @endif
@endsection
