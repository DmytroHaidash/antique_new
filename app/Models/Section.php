<?php

namespace App\Models;

use App\Traits\SluggableTrait;
use App\Traits\SortableTrait;
use App\Traits\TranslatableTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Carbon;
use Spatie\EloquentSortable\Sortable;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\Section
 *
 * @method static Builder|Section newModelQuery()
 * @method static Builder|Section newQuery()
 * @method static Builder|Section query()
 * @mixin Eloquent
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Section whereCreatedAt($value)
 * @method static Builder|Section whereId($value)
 * @method static Builder|Section whereUpdatedAt($value)
 * @property-read mixed $sluggable_title
 * @property-read mixed $translations
 * @property-read Collection|Media[] $media
 * @method static Builder|Section findSimilarSlugs($attribute, $config, $slug)
 * @property string $slug
 * @property array $title
 * @property array|null $description
 * @property string $type
 * @property-read Collection|Section[] $children
 * @property-read Collection|Exhibit[] $exhibits
 * @property-read Section $parent
 * @property-read Collection|Publication[] $publications
 * @method static Builder|Section onlyParents()
 * @method static Builder|Section whereDescription($value)
 * @method static Builder|Section whereSlug($value)
 * @method static Builder|Section whereTitle($value)
 * @method static Builder|Section whereType($value)
 * @property int|null $parent_id
 * @method static Builder|Section whereParentId($value)
 * @property int $sort_order
 * @method static Builder|Section ordered($direction = 'asc')
 * @method static Builder|Section whereSortOrder($value)
 */
class Section extends Model implements HasMedia, Sortable
{
    use HasTranslations, SluggableTrait, TranslatableTrait, HasMediaTrait, SortableTrait;

    protected $fillable = [
        'slug',
        'title',
        'body',
        'description',
        'parent_id',
        'type',
        'color',
        'sort_order'
    ];

    public $translatable = [
        'title',
        'body',
        'description'
    ];

    /**
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(Section::class, 'parent_id');
    }

    /**
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    /**
     * @return MorphMany
     */
    public function meta(): MorphMany
    {
        return $this->morphMany(Meta::class, 'metable');
    }
    /**
     * @return BelongsToMany
     */
    public function exhibits(): BelongsToMany
    {
        return $this->belongsToMany(Exhibit::class);
    }

    /**
     * @return BelongsToMany
     */
    public function publications(): BelongsToMany
    {
        return $this->belongsToMany(Publication::class);
    }

    /**
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeOnlyParents(Builder $query): Builder
    {
        return $query->whereNull('parent_id');
    }

    /**
     * @param  Media|null  $media
     * @throws InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->fit(Manipulations::FIT_CROP, 360, 360)
            ->width(360)
            ->height(360)
            ->sharpen(10);

        $this->addMediaConversion('banner')
            ->fit(Manipulations::FIT_CROP, 1920, 1080)
            ->width(1920)
            ->height(1080)
            ->sharpen(10);
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

    protected static function boot()
    {
        parent::boot();

        self::addGlobalScope('ordered', function (Builder $builder) {
            $builder->ordered();
        });
    }
}
