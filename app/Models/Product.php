<?php

namespace App\Models;

use App\Traits\MediaTrait;
use App\Traits\SluggableTrait;
use App\Traits\SortableTrait;
use App\Traits\TranslatableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\Sortable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\Translatable\HasTranslations;


class Product extends Model implements HasMedia, Sortable
{
    use SluggableTrait, SortableTrait, HasTranslations, TranslatableTrait, MediaTrait, SoftDeletes;

    public $translatable = [
        'title',
        'description',
        'body',
    ];

    protected $fillable = [
        'slug',
        'title',
        'description',
        'body',
        'price',
        'is_published',
        'views_count',
        'in_stock',
        'sort_order',
        'publish_price'
    ];


    protected $casts = [
        'views_count' => 'integer',
    ];

    /**
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(ProductCategories::class, 'category_product',  'product_id', 'category_id');
    }

    public function accountings():HasOne
    {
        return $this->hasOne(Accounting::class);
    }
    /**
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * @return MorphMany
     */
    public function meta(): MorphMany
    {
        return $this->morphMany(Meta::class, 'metable');
    }

    /**
     * Store viewed articles and count up
     */
    public function handleViewed()
    {
        if (!session()->has('viewed_products')) {
            session()->put('viewed_products', []);
        }

        $viewed = collect(session()->get('viewed_products'));

        if (!$viewed->contains($this->id)) {
            $viewed->prepend($this->id);
            session()->put('viewed_products', $viewed->all());

            $this->update([
                'views_count' => $this->views_count + 1,
            ]);
        }
    }

    protected static function boot()
    {
        parent::boot();

        self::addGlobalScope('sortById', function (Builder $builder) {
            $builder->orderByDesc('in_stock')->orderBy('sort_order');
        });
    }
}
