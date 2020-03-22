<?php

namespace App\Models;

use App\Traits\SortableTrait;
use App\Traits\TranslatableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\Sortable;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use Spatie\Translatable\HasTranslations;

class Contact extends Model implements HasMedia, Sortable
{
    use HasMediaTrait, TranslatableTrait, HasTranslations, SoftDeletes, SortableTrait;

    public $translatable = [
        'name',
        'position'
    ];

    protected $fillable = [
        'name',
        'position',
        'contacts',
        'sort_order'
    ];

    protected $casts = [
        'contacts' => 'array'
    ];

    /**
     * @param  Media|null  $media
     * @throws InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('cover')
            ->fit(Manipulations::FIT_CROP, 360, 540)
            ->width(360)
            ->height(540)
            ->sharpen(10);
    }
}
