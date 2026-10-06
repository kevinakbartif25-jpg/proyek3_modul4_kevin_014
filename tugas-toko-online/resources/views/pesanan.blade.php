@extends('layout')

@section('content')
    <h2>Riwayat Pesanan</h2>

    @if ($orders->isEmpty())
        <div class="empty">Belum ada pesanan.</div>
    @else
        <table>
            <tr>
                <th>ID Pesanan</th>
                <th>Tanggal</th>
                <th>Total</th>
                <th></th>
            </tr>
            @foreach ($orders as $o)
                <tr>
                    <td>{{ $o->id_order }}</td>
                    <td>{{ $o->tanggal_order->format('d-m-Y H:i') }}</td>
                    <td>Rp {{ number_format($o->total_harga, 0, ',', '.') }}</td>
                    <td><a href="{{ route('pesanan.show', $o->id_order) }}">Detail</a></td>
                </tr>
            @endforeach
        </table>
    @endif
@endsection
