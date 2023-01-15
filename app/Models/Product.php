<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table="product";
    protected $fillable=[
        'name',
        'price',
        'photo_product',
        'description',
        'quantity',
        'sold_total',
        'product_rating',
        'store_id',
        'category_id'
    ];

    public function store(){
        return $this->hasOne(Store::class, 'store_id', 'id');
    }

    public function category(){
        return $this->hasOne(Category::class, 'category_id', 'id');
    }

    public function order(){
        return $this->hasMany(Order::class, 'product_id', 'id');
    }
}
