<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'img_path'
    ];

    public function pharms(): HasMany
    {
        return $this->hasMany(Pharm::class, 'cat_id');
    }
}
