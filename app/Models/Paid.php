<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paid extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'amount',
        'name',
        'email',
        'phone',
        'bank_name',
        'branch',
        'account_no',
        'account_holder_name',
        'ifsc',
        'upi_id',
    ];
}
