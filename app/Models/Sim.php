<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sim extends Model
{
    use HasFactory;

    protected $fillable = [
        'pharm_id_1',
        'pharm_id_2',
    ];

    protected $casts = [
        'pharm_id_1' => 'integer',
        'pharm_id_2' => 'integer',
    ];
}
