<?php

namespace App\Models;

use App\Traits\MediaTrait;
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
use Illuminate\Support\Carbon;
use Spatie\EloquentSortable\Sortable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\Models\Media;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\Category
 *
 * @property-read Collection|Category[] $children
 * @property-read mixed $sluggable_title
 * @property-read mixed $translations
 * @property-read Category $parent
 * @property-read Collection|Post[] $posts
 * @method static Builder|Category findSimilarSlugs($attribute, $config, $slug)
 * @method static Builder|Category newModelQuery()
 * @method static Builder|Category newQuery()
 * @method static Builder|Category query()
 * @mixin Eloquent
 * @property int $id
 * @property string $slug
 * @property array $title
 * @property array|null $description
 * @property int $parent_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Category whereCreatedAt($value)
 * @method static Builder|Category whereDescription($value)
 * @method static Builder|Category whereId($value)
 * @method static Builder|Category whereParentId($value)
 * @method static Builder|Category whereSlug($value)
 * @method static Builder|Category whereTitle($value)
 * @method static Builder|Category whereUpdatedAt($value)
 * @method static Builder|Category onlyParents()
 * @property-read Collection|Media[] $media
 * @property int $sort_order
 * @method static Builder|Category ordered($direction = 'asc')
 * @method static Builder|Category whereSortOrder($value)
 */
class Category extends Model implements HasMedia, Sortable
{
    use HasTranslations, SluggableTrait, TranslatableTrait, MediaTrait, SortableTrait;

    protected $fillable = [
        'slug',
        'parent_id',
        'title',
        'description',
        'sort_order'
    ];

    public $translatable = [
        'title',
        'description'
    ];

    protected $with = [
        'posts'
    ];

    /**
     * @return BelongsToMany
     */
    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }

    /**
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeOnlyParents(Builder $query): Builder
    {
        return $query->whereNull('parent_id')->with('children');
    }
}
