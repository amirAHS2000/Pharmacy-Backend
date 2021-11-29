<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// information of medicine producer companies
class Comp extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',     // name of company
        'country'   // country of production
    ];

    public function med()
    {
        return $this->hasMany(Med::class);
    }

}
