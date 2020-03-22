<?php


namespace App\Traits;


use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

trait MediaTrait
{
    use HasMediaTrait;

    /**
     * @param  Media|null  $media
     * @throws InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('xs')
            ->fit(Manipulations::FIT_CROP, 100, 100)
            ->width(100)
            ->height(100)
            ->sharpen(10);

        $this->addMediaConversion('thumb')
            ->width(360)
            ->height(360)
            ->sharpen(10);

        $this->addMediaConversion('banner')
            ->width(1200)
            ->height(1200)
            ->sharpen(10);
    }

    /**
     * @param  string  $collection
     * @return string
     */
    public function getXs($collection = 'cover')
    {
        if ($this->hasMedia($collection)) {
            return $this->getFirstMedia($collection)->getFullUrl('xs');
        }

        return asset('images/no-image.png');
    }

    /**
     * @param  string  $collection
     * @return string
     */
    public function getThumb($collection = 'cover')
    {
        if ($this->hasMedia($collection)) {
            return $this->getFirstMedia($collection)->getFullUrl('thumb');
        }

        return asset('images/no-image.png');
    }

    /**
     * @param  string  $collection
     * @return string
     */
    public function getBanner($collection = 'cover')
    {
        if ($this->hasMedia($collection)) {
            return $this->getFirstMedia($collection)->getFullUrl('banner');
        }

        return asset('images/no-image.png');
    }
}