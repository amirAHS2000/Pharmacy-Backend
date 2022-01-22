<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrescContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'presc_id',
        'med_id',
        'price',
        'ins_buy'
    ];

    protected $casts = [
        'presc_id' => 'integer',
        'med_id' => 'integer',
        'price' => 'integer',
        'ins_buy' => 'boolean',
    ];

    public function presc()
    {
        return $this->belongsTo(Presc::class, 'presc_id', 'id');
    }

    public function med()
    {
        return $this->hasOne(Med::class, 'id', 'med_id');
    }
}
