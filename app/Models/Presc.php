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
        'delivered',
        'patient_id'
    ];

    protected $casts = [
        'date' => 'date',
        'total_price' => 'integer',
        'paid' => 'boolean',
        'delivered' => 'boolean',
        'patient_id' => 'integer'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function contents()
    {
        return $this->hasMany(PrescContent::class);
    }

    public function updateTotalPrice(){
        $list = $this->contents()->get();
        $price = 0;
        foreach ($list as $item){
            $price += $item->price;
        }
        $this->update(['total_price' => $price]);
    }
}
