<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Earning
 *
 * @property int $id
 * @property string $type
 * @property int $amount
 * @property \Illuminate\Support\Carbon $reported_at
 * @property int $reported_by
 * @property int $reported_to
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Employee $employee
 * @property-read \App\Models\Employee $reportedBy
 * @method static \Illuminate\Database\Eloquent\Builder|Earning newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Earning newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Earning query()
 * @method static \Illuminate\Database\Eloquent\Builder|Earning whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Earning whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Earning whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Earning whereReportedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Earning whereReportedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Earning whereReportedTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Earning whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Earning whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Earning extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'amount',
        'reported_at'
    ];


    protected $casts = [
        'reported_at' => 'datetime',
    ];

    public function employee() {
        return $this->belongsTo(Employee::class, 'reported_to');
    }

    public function reportedBy() {
        return $this->belongsTo(Employee::class, 'reported_by');
    }
}
