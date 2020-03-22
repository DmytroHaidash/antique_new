<?php

namespace App\Models;

use App\Traits\SluggableTrait;
use App\Traits\TranslatableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Place extends Model
{
    use HasTranslations, TranslatableTrait, SluggableTrait;

    protected $fillable = [
        'slug',
        'title',
        'body'
    ];

    public $translatable = [
        'title',
        'body'
    ];

    /**
     * @return HasMany
     */
    public function exhibitions(): HasMany
    {
        return $this->hasMany(Exhibition::class);
    }
}
