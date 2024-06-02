<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected $fillable = [
        'name', 'description', 'product_type', 'price', 'price_per_day',
        'available_from', 'available_to', 'stock_quantity', 'rental_available', 'image', 'user_id', 'validated'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }
    protected $casts = [
        'available_from' => 'date',
        'available_to' => 'date',
    ];

    protected $dates = [
        'available_from',
        'available_to',
    ];
}
