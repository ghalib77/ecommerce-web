<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table="order";
    protected $fillable=[
        'quantity',
        'payment_method',
        'product_id',
        'user_id'
    ];

    public function order(){
        return $this->hasOne(User::class, 'user_id', 'id');
    }

    public function product(){
        return $this->hasOne(Product::class, 'product_id', 'id');
    }
}
