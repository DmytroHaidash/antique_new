<?php

namespace App\Models;

use App\Traits\SluggableTrait;
use App\Traits\TranslatableTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\Page
 *
 * @method static Builder|Page newModelQuery()
 * @method static Builder|Page newQuery()
 * @method static Builder|Page query()
 * @mixin Eloquent
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Page whereCreatedAt($value)
 * @method static Builder|Page whereId($value)
 * @method static Builder|Page whereUpdatedAt($value)
 * @property-read mixed $sluggable_title
 * @property-read mixed $translations
 * @property-read Collection|Media[] $media
 * @method static Builder|Page findSimilarSlugs($attribute, $config, $slug)
 * @property string $slug
 * @property array $title
 * @property array|null $body
 * @method static Builder|Page whereBody($value)
 * @method static Builder|Page whereSlug($value)
 * @method static Builder|Page whereTitle($value)
 * @property int|null $parent_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Page[] $children
 * @property-read \App\Models\Page|null $parent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page onlyParents()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereParentId($value)
 */
class Page extends Model implements HasMedia
{
    use HasTranslations, HasMediaTrait, SluggableTrait, TranslatableTrait;

    protected $fillable = [
        'slug',
        'title',
        'body',
        'parent_id',
        'published'
    ];

    public $translatable = [
        'title',
        'body'
    ];

    /**
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(Page::class, 'parent_id');
    }

    /**
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }
    /**
     * @return MorphMany
     */
    public function meta(): MorphMany
    {
        return $this->morphMany(Meta::class, 'metable');
    }

    /**
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeOnlyParents(Builder $query): Builder
    {
        return $query->whereNull('parent_id');
    }
}
