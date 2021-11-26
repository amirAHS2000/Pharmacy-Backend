<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//Information Of Medicines That Exist In Inventory
class Med extends Model
{
    use HasFactory;

    protected $fillable = [
        'inv',      // int : number of medicines remaining
        'exp_date', // date : expiration date of medicine
        'price',    // int : price of medicine
        'add_info'  // additional information of medicine
    ];

    protected $casts = [
        'inv' => 'integer',
        'exp_date' => 'date',
        'price' => 'integer',
    ];
}
