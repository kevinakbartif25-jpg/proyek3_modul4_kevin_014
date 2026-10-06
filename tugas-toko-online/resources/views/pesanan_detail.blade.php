@extends('layout')

@section('content')
    <h2>Detail Pesanan {{ $order->id_order }}</h2>

    <div class="box">
        <div>Tanggal: {{ $order->tanggal_order->format('d-m-Y H:i') }}</div>
        <div>Alamat pengiriman: {{ $order->alamat_pengiriman }}</div>
    </div>

    <table>
        <tr>
            <th>Barang</th>
            <th>Harga satuan</th>
            <th>Jumlah</th>
            <th>Subtotal</th>
        </tr>
        @foreach ($order->details as $d)
            <tr>
                <td>{{ $d->barang->nama_barang ?? $d->id_barang }}</td>
                <td>Rp {{ number_format($d->harga_satuan, 0, ',', '.') }}</td>
                <td>{{ $d->jumlah_beli }}</td>
                <td>Rp {{ number_format($d->harga_satuan * $d->jumlah_beli, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </table>

    <div class="box total">Total bayar: Rp {{ number_format($order->total_harga, 0, ',', '.') }}</div>

    <a href="{{ route('pesanan') }}" class="btn gray">Kembali</a>
@endsection
