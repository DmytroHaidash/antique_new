<?php

namespace App\Models;

use App\Traits\MediaTrait;
use App\Traits\SluggableTrait;
use App\Traits\TranslatableTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\Author
 *
 * @property int $id
 * @property string $slug
 * @property array $name
 * @property array|null $biography
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Exhibit[] $exhibits
 * @property-read mixed $sluggable_title
 * @property-read mixed $translations
 * @property-read Collection|Publication[] $publications
 * @method static Builder|Author findSimilarSlugs($attribute, $config, $slug)
 * @method static Builder|Author newModelQuery()
 * @method static Builder|Author newQuery()
 * @method static Builder|Author query()
 * @method static Builder|Author whereBiography($value)
 * @method static Builder|Author whereCreatedAt($value)
 * @method static Builder|Author whereId($value)
 * @method static Builder|Author whereName($value)
 * @method static Builder|Author whereSlug($value)
 * @method static Builder|Author whereUpdatedAt($value)
 * @mixin Eloquent
 * @property int $lives_from
 * @property int|null $lives_to
 * @property int $sort_order
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\Models\Media[] $media
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Author whereLivesFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Author whereLivesTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Author whereSortOrder($value)
 */
class Author extends Model implements HasMedia
{
    use HasTranslations, SluggableTrait, TranslatableTrait, MediaTrait;

    protected $fillable = [
        'slug',
        'name',
        'biography',
        'lives_from',
        'lives_to',
        'sort_order'
    ];

    public $translatable = [
        'name',
        'biography'
    ];

    /**
     * @return HasMany
     */
    public function exhibits(): HasMany
    {
        return $this->hasMany(Exhibit::class);
    }

    /**
     * @return HasMany
     */
    public function publications(): HasMany
    {
        return $this->hasMany(Publication::class);
    }

    /**
     * @return array|Request|string
     */
    public function getSluggableTitleAttribute()
    {
        return request('ru.name');
    }
}
