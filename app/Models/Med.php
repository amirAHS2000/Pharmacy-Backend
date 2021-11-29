<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//Information Of Medicines That Exist In Inventory

/**
 * @method static find(int $id)
 */
class Med extends Model
{
    use HasFactory;

    protected $fillable = [
        'pharm_id',
        'inv',      // int : number of medicines remaining
        'exp_date', // date : expiration date of medicine
        'price',    // int : price of medicine
        'add_info',  // additional information of medicine
        'comp_id',
    ];

    protected $casts = [
        'inv' => 'integer',
        'exp_date' => 'date',
        'price' => 'integer',
    ];

    public function comp()
    {
        return $this->belongsTo(Comp::class);
    }

    public function pharm()
    {
        return $this->belongsTo(Pharm::class);
    }

}
