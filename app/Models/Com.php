<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// information of medicine producer companies
class Com extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',     // name of company
        'country'   // country of production
    ];

}
