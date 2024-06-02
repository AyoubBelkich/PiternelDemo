<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warning extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'deleted_product_id',
        'reason'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deletedProduct()
    {
        return $this->belongsTo(DeletedProduct::class, 'deleted_product_id');
    }
}
