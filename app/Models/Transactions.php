<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $fillable = [
        'client_name',  
        'client_email', 
        'product_id', 
        'client_id',  
        'quantity',     
        'gateway',
        'external_id',
        'status',
        'amount',
        'card_last_numbers'
    ];
}