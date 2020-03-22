<?php

namespace App\Models;

use App\Traits\MediaTrait;
use App\Traits\SluggableTrait;
use App\Traits\TranslatableTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\Models\Media;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\Post
 *
 * @property-read mixed $sluggable_title
 * @property-read mixed $translations
 * @property-read Collection|Media[] $media
 * @method static Builder|Post findSimilarSlugs($attribute, $config, $slug)
 * @method static Builder|Post newModelQuery()
 * @method static Builder|Post newQuery()
 * @method static Builder|Post query()
 * @mixin Eloquent
 * @property int $id
 * @property string $slug
 * @property array $title
 * @property array|null $description
 * @property array|null $body
 * @property bool $published
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Post whereBody($value)
 * @method static Builder|Post whereCategoryId($value)
 * @method static Builder|Post whereCreatedAt($value)
 * @method static Builder|Post whereDescription($value)
 * @method static Builder|Post whereId($value)
 * @method static Builder|Post whereSlug($value)
 * @method static Builder|Post whereTitle($value)
 * @method static Builder|Post whereUpdatedAt($value)
 * @property-read Category $category
 * @property-read Collection|Category[] $categories
 * @method static Builder|Post wherePublished($value)
 */
class Post extends Model implements HasMedia
{
    use HasTranslations, SluggableTrait, TranslatableTrait, MediaTrait;

    protected $fillable = [
        'slug',
        'title',
        'description',
        'body',
        'video',
        'published',
        'published_at'
    ];

    protected $dates = ['published_at'];

    public $translatable = [
        'title',
        'description',
        'body'
    ];

    /**
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * @return MorphMany
     */
    public function meta(): MorphMany
    {
        return $this->morphMany(Meta::class, 'metable');
    }

    protected static function boot()
    {
        parent::boot();

        self::addGlobalScope('latest', function (Builder $builder) {
            $builder->orderByDesc('published_at');
        });
    }
}
