<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScratchCard extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'amount',
        'image',
        'bid_id',
        'cashcard_id',
        'user_id',
        'status',
    ];
}
