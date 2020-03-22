<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    protected $fillable = [
        'title'
    ];

    public function accountings(): HasMany
    {
        return $this->hasMany(Accounting::class);
    }
}
