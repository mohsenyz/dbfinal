<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Deduction
 *
 * @property int $id
 * @property string $type
 * @property string $description
 * @property int $amount
 * @property \Illuminate\Support\Carbon $reported_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $reported_by
 * @property int $reported_to
 * @property-read \App\Models\Employee $reportedBy
 * @property-read \App\Models\Employee $reportedTo
 * @method static \Illuminate\Database\Eloquent\Builder|Deduction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Deduction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Deduction query()
 * @method static \Illuminate\Database\Eloquent\Builder|Deduction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deduction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deduction whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deduction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deduction whereReportedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deduction whereReportedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deduction whereReportedTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deduction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deduction whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Deduction extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'amount',
        'reported_at',
        'description',
    ];


    protected $casts = [
        'reported_at' => 'datetime',
    ];

    public function reportedBy() {
        return $this->belongsTo(Employee::class, 'reported_by');
    }

    public function employee() {
        return $this->belongsTo(Employee::class, 'reported_to');
    }
}
