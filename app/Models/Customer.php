<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'status',
        'api_token',
        'bank_name',
        'branch',
        'account_no',
        'account_holder_name',
        'ifsc',
        'upi_id',
    ];
}
