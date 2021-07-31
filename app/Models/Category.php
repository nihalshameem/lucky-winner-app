<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable=['name','image','status'];

     /**
     * Get the cash cards associated with the category.
     */
    public function cash_card()
    {
        return $this->hasOne('App\CashCard');
    }
}
