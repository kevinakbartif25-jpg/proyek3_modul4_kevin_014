<?php

namespace Tests\Feature;

use App\Models\Barang;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TokoOnlineTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_guest_sees_products_and_login_buttons(): void
    {
        $response = $this->get('/index');
        $response->assertStatus(200);
        $response->assertSee('Daftar Barang');
        $response->assertSee('Login untuk membeli');
        $response->assertSee('Stok habis'); // BRG009
    }

    public function test_guest_cart_redirects_to_login(): void
    {
        $response = $this->get('/keranjang');
        $response->assertRedirect('/login');
    }

    public function test_login_successful(): void
    {
        $response = $this->post('/login', [
            'username' => 'budi',
            'password' => 'rahasia123',
        ]);
        $response->assertRedirect('/index');
        $this->assertAuthenticated();
    }

    public function test_register_creates_user_with_id_and_logs_in(): void
    {
        $response = $this->post('/register', [
            'nama_lengkap' => 'Andi Wijaya',
            'email' => 'andi@example.com',
            'username' => 'andi',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'no_hp' => '08123456789',
            'alamat' => 'Jl. Dago No. 1',
        ]);

        $response->assertRedirect('/index');
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'username' => 'andi',
            'email' => 'andi@example.com',
        ]);
    }

    public function test_cart_operations_and_stock_limits(): void
    {
        $user = User::where('username', 'budi')->first();
        $this->actingAs($user);

        $barang = Barang::where('id_barang', 'BRG001')->first(); // stok 50

        // Tambah ke keranjang
        $response = $this->post(route('keranjang.tambah', $barang));
        $response->assertSessionHas('keranjang', ['BRG001' => 1]);

        // Cek halaman keranjang
        $response = $this->get(route('keranjang'));
        $response->assertStatus(200);
        $response->assertSee('Buku Tulis');

        // Tambah kuantitas (+)
        $this->post(route('keranjang.ubah', $barang), ['aksi' => 'tambah']);
        $this->assertEquals(2, session('keranjang')['BRG001']);

        // Kurang kuantitas (-)
        $this->post(route('keranjang.ubah', $barang), ['aksi' => 'kurang']);
        $this->assertEquals(1, session('keranjang')['BRG001']);

        // Hapus
        $this->post(route('keranjang.hapus', $barang));
        $this->assertArrayNotHasKey('BRG001', session('keranjang', []));

        // Stok 0 tidak bisa ditambah
        $stokNol = Barang::where('id_barang', 'BRG009')->first();
        $response = $this->post(route('keranjang.tambah', $stokNol));
        $response->assertSessionHas('error');
    }

    public function test_checkout_transaction_decrements_stock_and_creates_order(): void
    {
        $user = User::where('username', 'budi')->first();
        $this->actingAs($user);

        $barang = Barang::where('id_barang', 'BRG001')->first();
        $initialStock = $barang->stok;

        session(['keranjang' => ['BRG001' => 2]]);

        $response = $this->post(route('checkout'), [
            'alamat_pengiriman' => 'Jl. Merdeka No. 10, Bandung',
        ]);

        $response->assertRedirect();
        $this->assertEmpty(session('keranjang'));

        // Cek stok berkurang
        $this->assertEquals($initialStock - 2, $barang->fresh()->stok);

        // Cek database orders dan order_details
        $this->assertDatabaseHas('orders', [
            'id_user' => 'USR00001',
            'alamat_pengiriman' => 'Jl. Merdeka No. 10, Bandung',
            'total_harga' => $barang->harga * 2,
        ]);
        $this->assertDatabaseHas('order_details', [
            'id_barang' => 'BRG001',
            'jumlah_beli' => 2,
            'harga_satuan' => $barang->harga,
        ]);
    }

    public function test_order_isolation_siti_cannot_view_budi_order(): void
    {
        $budi = User::where('username', 'budi')->first();
        $this->actingAs($budi);

        session(['keranjang' => ['BRG002' => 1]]);
        $this->post(route('checkout'), [
            'alamat_pengiriman' => 'Alamat Budi',
        ]);

        $orderBudi = \App\Models\Order::where('id_user', $budi->id_user)->first();

        // Login as Siti
        $siti = User::where('username', 'siti')->first();
        $this->actingAs($siti);

        // Siti tries to access Budi's order
        $response = $this->get(route('pesanan.show', $orderBudi->id_order));
        $response->assertStatus(404);
    }
}
