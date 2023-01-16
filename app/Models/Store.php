<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $table='store';
    protected $fillable=[
        'name',
        'store_image',
        'user_id',
        'location'
    ];
    protected $guarded=[
        'id'
    ];

    public function user(){
        return $this->hasOne(User::class, 'user_id', 'id');
    }

    public function product(){
        return $this->hasMany(Product::class, 'store_id', 'id');
    }
}
