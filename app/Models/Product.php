<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * Campos que se pueden asignar masivamente.
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'image',
        'category',
        'brand',
        'sku',
        'discount',
        'total_sales',
        'rating',
        'is_active',
    ];

    /**
     * Casts automáticos para ciertos campos.
     */
    protected $casts = [
        'price' => 'decimal:2',
        'discount' => 'decimal:2',
        'rating' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Accesor para obtener el precio final con descuento aplicado.
     */
    public function getFinalPriceAttribute()
    {
        if ($this->discount > 0) {
            return $this->price - ($this->price * ($this->discount / 100));
        }
        return $this->price;
    }

    /**
     * Método para aumentar el contador de ventas.
     */
    public function incrementSales($quantity = 1)
    {
        $this->total_sales += $quantity;
        $this->save();
    }
    public function cartItems()
    {
        return $this->hasMany(\App\Models\CartItem::class);
    }

}
