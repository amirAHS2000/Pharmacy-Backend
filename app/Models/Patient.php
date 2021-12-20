<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'nat_num',   // int : national number of patient
        'phone',        // int nullable : phone number of patient
        'ins_num',   // int : insurance number of patient
        'ins_id'        // int : id of patient's insurance
    ];

    protected $casts = [
        'ins_id' => 'integer',
    ];

    public function ins(){
        return $this->belongsTo(Ins::class);
    }

    public function prescs(){
        return $this->hasMany(Presc::class);
    }
}
