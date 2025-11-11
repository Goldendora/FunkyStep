<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total',
        'status',
        'payment_method',
        'payment_provider',
        'payment_reference',
        'raw_payload',
    ];

    protected $casts = [
        'raw_payload' => 'array',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
