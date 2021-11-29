<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

// Non-dynamic Information of Medicines

/**
 * @method static find(int $id)
 */
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

    public function med(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Med::class);
    }

    public function sim(): \Illuminate\Database\Eloquent\Collection
    {
        $one = $this->belongsToMany(Pharm::class, 'pharm_pharm', 'pharm_id_1', 'pharm_id_2')->get();
        $two = $this->belongsToMany(Pharm::class, 'pharm_pharm', 'pharm_id_2', 'pharm_id_1')->get();
        return $one->merge($two);
    }
}
