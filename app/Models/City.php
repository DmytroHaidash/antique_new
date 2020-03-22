<?php

namespace App\Models;

use App\Traits\TranslatableTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Spatie\Translatable\HasTranslations;

/**
 * App\Models\City
 *
 * @property-read mixed $translations
 * @method static Builder|City newModelQuery()
 * @method static Builder|City newQuery()
 * @method static Builder|City query()
 * @mixin Eloquent
 * @property int $id
 * @property string $country
 * @property array $name
 * @property string $lat
 * @property string $lng
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|City whereCountry($value)
 * @method static Builder|City whereCreatedAt($value)
 * @method static Builder|City whereId($value)
 * @method static Builder|City whereLat($value)
 * @method static Builder|City whereLng($value)
 * @method static Builder|City whereName($value)
 * @method static Builder|City whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Exhibition[] $exhibitions
 */
class City extends Model
{
    use HasTranslations, TranslatableTrait;

    protected $fillable = [
        'country',
        'name',
    ];

    public $translatable = [
        'name',
    ];

    /**
     * @return HasMany
     */
    public function exhibitions(): HasMany
    {
        return $this->hasMany(Exhibition::class);
    }
}
