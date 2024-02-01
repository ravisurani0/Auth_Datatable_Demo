<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderHasProducts extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'product_id',
        'qnt',
    ];

    public function Orders()
    {
        return  $this->belongsTo(Orders::class, 'order_id', 'id');
    }

    public function Products()
    {
        return  $this->belongsTo(Products::class, 'product_id', 'id');
    }

}
