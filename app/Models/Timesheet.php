<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Timesheet
 *
 * @property int $id
 * @property string $day_date
 * @property int $accepted_overtime_hours
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TimesheetDetail[] $details
 * @property-read int|null $details_count
 * @method static \Illuminate\Database\Eloquent\Builder|Timesheet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Timesheet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Timesheet query()
 * @method static \Illuminate\Database\Eloquent\Builder|Timesheet whereAcceptedOvertimeHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Timesheet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Timesheet whereDayDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Timesheet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Timesheet whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Timesheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'day_date',
        'accepted_overtime_hours'
    ];

    public function details() {
        return $this->hasMany(TimesheetDetail::class);
    }
}
