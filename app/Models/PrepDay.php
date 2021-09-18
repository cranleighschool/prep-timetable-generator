<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrepDay extends Model
{
    use HasFactory;

    protected $fillable = [
        'day',
    ];

    public $timestamps = false;

    public function sciences() {
        return $this->hasMany(ScienceSet::class, "day_id")->whereIn('subject', ['Biology', 'Chemistry', 'Physics']);
    }
    public function humanities() {
        return $this->hasMany(ScienceSet::class, 'day_id')->whereIn('subject', ['Geography', 'RS', 'History']);
    }
    public function classics() {
        return $this->hasMany(ScienceSet::class, 'day_id')->whereIn('subject', ['Class Civ']);
    }


}
