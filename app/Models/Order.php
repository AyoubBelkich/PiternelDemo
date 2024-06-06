<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'items', 'total_price', 'address', 'city', 'postal_code', 'country', 'phone', 'shipping_method', 'status'
    ];
    
    protected $casts = [
        'items' => 'array',
    ];
}
