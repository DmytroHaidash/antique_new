<?php

namespace App\Models;

use App\Traits\MediaTrait;
use App\Traits\SluggableTrait;
use App\Traits\TranslatableTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\Exhibition
 *
 * @method static Builder|Exhibition newModelQuery()
 * @method static Builder|Exhibition newQuery()
 * @method static Builder|Exhibition query()
 * @mixin Eloquent
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Exhibition whereCreatedAt($value)
 * @method static Builder|Exhibition whereId($value)
 * @method static Builder|Exhibition whereUpdatedAt($value)
 * @property-read mixed $sluggable_title
 * @property-read mixed $translations
 * @property-read Collection|Media[] $media
 * @method static Builder|Exhibition findSimilarSlugs($attribute, $config, $slug)
 * @property string $slug
 * @property array $title
 * @property array|null $description
 * @property array|null $body
 * @property int $city_id
 * @property Carbon|null $starts_at
 * @property Carbon|null $ends_at
 * @property-read City $city
 * @method static Builder|Exhibition whereBody($value)
 * @method static Builder|Exhibition whereCityId($value)
 * @method static Builder|Exhibition whereDescription($value)
 * @method static Builder|Exhibition whereEndsAt($value)
 * @method static Builder|Exhibition whereSlug($value)
 * @method static Builder|Exhibition whereStartsAt($value)
 * @method static Builder|Exhibition whereTitle($value)
 */
class Exhibition extends Model implements HasMedia
{
    use HasTranslations, MediaTrait, SluggableTrait, TranslatableTrait;

    public $translatable = [
        'title',
        'body',
        'description'
    ];

    protected $fillable = [
        'slug',
        'title',
        'description',
        'body',
        'starts_at',
        'ends_at',
        'city_id',
        'place_id'
    ];

    protected $dates = [
        'starts_at',
        'ends_at'
    ];

    protected $with = [
        'city',
        'place'
    ];

    /**
     * @return BelongsTo
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * @return BelongsTo
     */
    public function place(): BelongsTo
    {
        return $this->belongsTo(Place::class);
    }
}
