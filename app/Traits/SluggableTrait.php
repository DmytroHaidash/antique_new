<?php


namespace App\Traits;


use Cviebrock\EloquentSluggable\Sluggable;

trait SluggableTrait
{
    use Sluggable;

    /**
     * Set key for model
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'sluggable_title'
            ]
        ];
    }

    public function getSluggableTitleAttribute()
    {
        return request('ru.title');
    }
}