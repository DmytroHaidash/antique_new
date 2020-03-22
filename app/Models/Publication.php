<?php

namespace App\Models;

use App\Traits\SluggableTrait;
use App\Traits\SortableTrait;
use App\Traits\TranslatableTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;
use Spatie\EloquentSortable\Sortable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\Publication
 *
 * @property int $id
 * @property string $slug
 * @property array $title
 * @property array|null $body
 * @property int $section_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read mixed $sluggable_title
 * @property-read mixed $translations
 * @property-read Collection|Media[] $media
 * @property-read Section $section
 * @method static Builder|Publication findSimilarSlugs($attribute, $config, $slug)
 * @method static Builder|Publication newModelQuery()
 * @method static Builder|Publication newQuery()
 * @method static Builder|Publication query()
 * @method static Builder|Publication whereBody($value)
 * @method static Builder|Publication whereCreatedAt($value)
 * @method static Builder|Publication whereId($value)
 * @method static Builder|Publication whereSectionId($value)
 * @method static Builder|Publication whereSlug($value)
 * @method static Builder|Publication whereTitle($value)
 * @method static Builder|Publication whereUpdatedAt($value)
 * @mixin Eloquent
 * @property array|null $props
 * @property int|null $author_id
 * @property int $sort_order
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Section[] $sections
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Publication ordered($direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Publication whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Publication whereProps($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Publication whereSortOrder($value)
 */
class Publication extends Model implements HasMedia, Sortable
{
    use HasTranslations, SluggableTrait, TranslatableTrait, HasMediaTrait, SortableTrait;

    public static $props = [
        'isbn',
        'publisher',
        'publishing_year',
        'binding',
        'volume',
        'format',
        'circulation',
        'sort_order'
    ];

    public $translatable = [
        'title',
        'body',
        'props'
    ];

    protected $fillable = [
        'slug',
        'title',
        'body',
        'props',
        'sort_order'
    ];

    /**
     * @return BelongsToMany
     */
    public function sections(): BelongsToMany
    {
        return $this->belongsToMany(Section::class);
    }
}
