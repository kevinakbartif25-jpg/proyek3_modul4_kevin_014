<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    public function index()
    {
        $keranjang = session('keranjang', []);
        $barang = Barang::whereIn('id_barang', array_keys($keranjang))->get()->keyBy('id_barang');

        $items = [];
        $total = 0;

        foreach ($keranjang as $id => $jumlah) {
            if (! isset($barang[$id])) {
                continue;
            }

            $b = $barang[$id];
            $subtotal = $b->harga * $jumlah;
            $total += $subtotal;

            $items[] = [
                'barang' => $b,
                'jumlah' => $jumlah,
                'subtotal' => $subtotal,
            ];
        }

        return view('keranjang', compact('items', 'total'));
    }

    public function tambah(Barang $barang)
    {
        if ($barang->stok <= 0) {
            return back()->with('error', "{$barang->nama_barang} sedang habis.");
        }

        $keranjang = session('keranjang', []);
        $jumlah = ($keranjang[$barang->id_barang] ?? 0) + 1;

        if ($jumlah > $barang->stok) {
            return back()->with('error', "Stok {$barang->nama_barang} tidak cukup.");
        }

        $keranjang[$barang->id_barang] = $jumlah;
        session(['keranjang' => $keranjang]);

        return back()->with('success', "{$barang->nama_barang} dimasukkan ke keranjang.");
    }

    public function ubah(Request $request, Barang $barang)
    {
        $keranjang = session('keranjang', []);
        $jumlah = $keranjang[$barang->id_barang] ?? 0;

        if ($request->input('aksi') === 'tambah') {
            if ($jumlah + 1 > $barang->stok) {
                return back()->with('error', "Stok {$barang->nama_barang} tidak cukup.");
            }
            $jumlah++;
        } elseif ($request->input('aksi') === 'kurang') {
            $jumlah--;
        }

        if ($jumlah <= 0) {
            unset($keranjang[$barang->id_barang]);
        } else {
            $keranjang[$barang->id_barang] = $jumlah;
        }

        session(['keranjang' => $keranjang]);

        return back();
    }

    public function hapus(Barang $barang)
    {
        $keranjang = session('keranjang', []);
        unset($keranjang[$barang->id_barang]);
        session(['keranjang' => $keranjang]);

        return back();
    }

    public function kosongkan()
    {
        session()->forget('keranjang');

        return back();
    }
}
