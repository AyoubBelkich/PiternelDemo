<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeletedProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'product_type',
        'price',
        'price_per_day',
        'available_from',
        'available_to',
        'stock_quantity',
        'image',
        'rental_available',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function warnings()
    {
        return $this->hasMany(Warning::class, 'deleted_product_id');
    }
}
