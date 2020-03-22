<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    public static $STATUSES = [
        'processing',
        'no_dial',
        'completed',
        'declined',
    ];

    protected $fillable = [
        'product_id',
        'user_id',
        'name',
        'contact',
        'message',
        'comment',
        'price',
        'status',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    /**
     * @return mixed
     */
    public static function ordered()
    {
        return self::orderByRaw("FIELD(status , 'processing') DESC")
            ->orderByRaw("FIELD(status , 'no_dial') DESC")
            ->orderByRaw("FIELD(status , 'completed') DESC");
    }
}
