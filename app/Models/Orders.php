<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'total',
        'user_id',
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    public function OreHasProducts()
    {
        return $this->hasMany(OrderHasProducts::class, 'order_id', 'id');
    }
}
