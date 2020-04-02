<?php

namespace App\Models;

use App\Http\Resources\ImgResource;
use App\Http\Resources\MediaResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class Accounting extends Model implements HasMedia
{
    use HasMediaTrait;

    protected $fillable = [
        'product_id',
        'date',
        'status_id',
        'price',
        'message',
        'supplier_id',
        'whom',
        'amount',
        'comment',
        'buer_id',
        'sell_price',
        'sell_date'
    ];

    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function status():BelongsTo
    {
        return $this->belongsTo(Status::class);
    }
    public function supplier():BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function buer():BelongsTo
    {
        return $this->belongsTo(Buer::class);
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function getImagesListAttribute()
    {
        return MediaResource::collection($this->getMedia('uploads'));
    }
}
