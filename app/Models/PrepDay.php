<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PrepDay extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    protected $fillable = [
        'day',
    ];

    /**
     * @return HasMany<SubjectsSet>
     */
    public function biology(): HasMany
    {
        return $this->sets()->whereIn('subject', ['Biology']);
    }

    /**
     * @return HasMany<SubjectsSet>
     */
    private function sets(): HasMany
    {
        return $this->hasMany(SubjectsSet::class, 'day_id');
    }

    /**
     * @return HasMany<SubjectsSet>
     */
    public function chemistry(): HasMany
    {
        return $this->sets()->whereIn('subject', ['Chemistry']);
    }

    /**
     * @return HasMany<SubjectsSet>
     */
    public function english(): HasMany
    {
        return $this->sets()->whereIn('subject', ['English']);
    }

    /**
     * @return HasMany<SubjectsSet>
     */
    public function physics(): HasMany
    {
        return $this->sets()->whereIn('subject', ['Physics']);
    }

    /**
     * @return HasMany<SubjectsSet>
     */
    public function sciences(): HasMany
    {
        return $this->sets()->whereIn('subject', ['Biology', 'Chemistry', 'Physics']);
    }

    /**
     * @return HasMany<SubjectsSet>
     */
    public function humanities(): HasMany
    {
        return $this->sets()->whereIn('subject', ['Geography', 'RS', 'History']);
    }

    /**
     * @return HasMany<SubjectsSet>
     */
    public function classics(): HasMany
    {
        return $this->sets()->whereIn('subject', ['Class Civ']);
    }
}
