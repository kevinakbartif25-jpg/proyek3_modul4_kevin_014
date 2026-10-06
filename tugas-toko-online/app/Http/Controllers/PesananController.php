<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PesananController extends Controller
{
    public function checkout(Request $request)
    {
        $request->validate([
            'alamat_pengiriman' => ['required', 'string', 'max:500'],
        ]);

        $keranjang = session('keranjang', []);

        if (empty($keranjang)) {
            return redirect()->route('keranjang')->with('error', 'Keranjang masih kosong.');
        }

        try {
            $idOrder = DB::transaction(function () use ($keranjang, $request) {
                // kunci baris barang supaya stok tidak balapan antar pembeli
                $barang = Barang::whereIn('id_barang', array_keys($keranjang))
                    ->lockForUpdate()
                    ->get()
                    ->keyBy('id_barang');

                $total = 0;
                $detail = [];

                foreach ($keranjang as $id => $jumlah) {
                    $b = $barang[$id] ?? null;

                    if (! $b) {
                        throw new \RuntimeException('Ada barang yang sudah tidak tersedia.');
                    }

                    if ($jumlah > $b->stok) {
                        throw new \RuntimeException("Stok {$b->nama_barang} tidak cukup (tersisa {$b->stok}).");
                    }

                    // harga selalu dari database, bukan dari browser
                    $total += $b->harga * $jumlah;

                    $detail[] = [
                        'id_barang' => $b->id_barang,
                        'harga_satuan' => $b->harga,
                        'jumlah_beli' => $jumlah,
                    ];
                }

                $idOrder = 'ORD' . now()->format('ymd') . strtoupper(Str::random(6));

                Order::create([
                    'id_order' => $idOrder,
                    'id_user' => Auth::id(),
                    'tanggal_order' => now(),
                    'total_harga' => $total,
                    'alamat_pengiriman' => $request->input('alamat_pengiriman'),
                ]);

                foreach ($detail as $d) {
                    DB::table('order_details')->insert($d + ['id_order' => $idOrder]);

                    Barang::where('id_barang', $d['id_barang'])
                        ->decrement('stok', $d['jumlah_beli']);
                }

                return $idOrder;
            });
        } catch (\RuntimeException $e) {
            return redirect()->route('keranjang')->with('error', $e->getMessage());
        }

        session()->forget('keranjang');

        return redirect()->route('pesanan.show', $idOrder)
            ->with('success', 'Checkout berhasil. Pesanan Anda tercatat.');
    }

    public function index()
    {
        $orders = Order::where('id_user', Auth::id())
            ->orderByDesc('tanggal_order')
            ->get();

        return view('pesanan', compact('orders'));
    }

    public function show(string $id)
    {
        $order = Order::with('details.barang')
            ->where('id_user', Auth::id())   // hanya pesanan milik sendiri
            ->where('id_order', $id)
            ->firstOrFail();

        return view('pesanan_detail', compact('order'));
    }
}
