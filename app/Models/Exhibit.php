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
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Carbon;
use Spatie\EloquentSortable\Sortable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\Models\Media;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\Exhibit
 *
 * @method static Builder|Exhibit newModelQuery()
 * @method static Builder|Exhibit newQuery()
 * @method static Builder|Exhibit query()
 * @mixin Eloquent
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Exhibit whereCreatedAt($value)
 * @method static Builder|Exhibit whereId($value)
 * @method static Builder|Exhibit whereUpdatedAt($value)
 * @property-read mixed $sluggable_title
 * @property-read mixed $translations
 * @property-read Section $section
 * @method static Builder|Exhibit findSimilarSlugs($attribute, $config, $slug)
 * @property string $slug
 * @property array $title
 * @property array|null $body
 * @property array|null $props
 * @property int $section_id
 * @property-read Collection|Media[] $media
 * @method static Builder|Exhibit whereBody($value)
 * @method static Builder|Exhibit whereProps($value)
 * @method static Builder|Exhibit whereSectionId($value)
 * @method static Builder|Exhibit whereSlug($value)
 * @method static Builder|Exhibit whereTitle($value)
 * @property int|null $author_id
 * @property-read Author|null $author
 * @method static Builder|Exhibit whereAuthorId($value)
 * @property int $sort_order
 * @property-read Collection|Section[] $sections
 * @method static Builder|Exhibit ordered($direction = 'asc')
 * @method static Builder|Exhibit whereSortOrder($value)
 */
class Exhibit extends Model implements HasMedia, Sortable
{
    use HasTranslations, SluggableTrait, TranslatableTrait, MediaTrait, SortableTrait;

    public static $props = [
        'number',
        'origin',
        'time',
        'technique',
        'material',
        'dimensions'
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
        'author_id',
        'sort_order'
    ];


    /**
     * @return BelongsToMany
     */
    public function sections(): BelongsToMany
    {
        return $this->belongsToMany(Section::class);
    }

    /**
     * @return BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
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

        self::addGlobalScope('ordered', function (Builder $builder) {
            $builder->ordered();
        });
    }
}
