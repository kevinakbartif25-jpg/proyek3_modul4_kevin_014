<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id_order';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_order', 'id_user', 'tanggal_order', 'total_harga', 'alamat_pengiriman',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_order' => 'datetime',
            'total_harga' => 'float',
        ];
    }

    public function details(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'id_order', 'id_order');
    }
}
