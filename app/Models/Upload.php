<?php

namespace App\Models;

use App\Traits\MediaTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\Models\Media;

/**
 * App\Models\Upload
 *
 * @property int $id
 * @property int $uses
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|Media[] $media
 * @method static Builder|Upload newModelQuery()
 * @method static Builder|Upload newQuery()
 * @method static Builder|Upload query()
 * @method static Builder|Upload whereCreatedAt($value)
 * @method static Builder|Upload whereId($value)
 * @method static Builder|Upload whereUpdatedAt($value)
 * @method static Builder|Upload whereUses($value)
 * @mixin Eloquent
 */
class Upload extends Model implements HasMedia
{
    use MediaTrait;
}
