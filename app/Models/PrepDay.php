<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use phpDocumentor\Reflection\Types\Self_;

class PrepDay extends Model
{
    use HasFactory;

    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string[]
     */
    protected $fillable = [
        'day',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function biology()
    {
        return $this->sets()->whereIn('subject', ['Biology']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    private function sets()
    {
        return $this->hasMany(SubjectsSet::class, 'day_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function chemistry()
    {
        return $this->sets()->whereIn('subject', ['Chemistry']);
    }

    public function english()
    {
        return $this->sets()->whereIn('subject', ['English']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function physics()
    {
        return $this->sets()->whereIn('subject', ['Physics']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sciences()
    {
        return $this->sets()->whereIn('subject', ['Biology', 'Chemistry', 'Physics']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function humanities()
    {
        return $this->sets()->whereIn('subject', ['Geography', 'RS', 'History']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function classics()
    {
        return $this->sets()->whereIn('subject', ['Class Civ']);
    }
}
