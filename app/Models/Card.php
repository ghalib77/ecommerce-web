<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $table="card";
    protected $fillable=[
        'card_type',
        'card_number',
        'cvv',
        'expired_date',
        'user_id'
    ];
    protected $dateFormat='Y-m';
}
