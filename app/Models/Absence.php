<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Absence
 *
 * @property int $id
 * @property string $started_at
 * @property string $ended_at
 * @property string $description
 * @property string $type
 * @property string $requested_at
 * @property string $accepted_at
 * @property int $requested_by
 * @property int $accepted_by
 * @method static \Illuminate\Database\Eloquent\Builder|Absence newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Absence newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Absence query()
 * @method static \Illuminate\Database\Eloquent\Builder|Absence whereAcceptedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Absence whereAcceptedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Absence whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Absence whereEndedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Absence whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Absence whereRequestedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Absence whereRequestedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Absence whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Absence whereType($value)
 * @mixin \Eloquent
 */
class Absence extends Model
{
    use HasFactory;
}
