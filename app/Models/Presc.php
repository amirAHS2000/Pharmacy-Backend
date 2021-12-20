<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presc extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'doctor',
        'total_price',
        'paid',
        'patient_id'
    ];

    protected $casts = [
        'date' => 'date',
        'total_price' => 'integer',
        'paid' => 'boolean',
        'patient_id' => 'integer'
    ];

    public function patient(){
        return $this->belongsTo(Patient::class);
    }

    public function contents(){
        return $this->hasMany(PrescContent::class);
    }
}
