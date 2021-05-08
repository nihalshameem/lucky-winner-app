<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashCard extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'image',
        'amount',
        'status',
    ];
}
