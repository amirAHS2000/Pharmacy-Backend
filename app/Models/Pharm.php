<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Non-dynamic Information of Medicines
class Pharm extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',     // name of the medicine
        'guide',    // guide of how to use
        'usage',    // terms of when this medicine need to be used
        'keeping',  // information of how to keep the medicine
        'need_dr',  // bool : weather it needs to prescription of a doctor or not
    ];

    protected $casts = [
        'need_dr' => 'boolean'
    ];
}
