<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TimesheetDetail
 *
 * @property int $id
 * @property string $description
 * @property \Illuminate\Support\Carbon $started_at
 * @property \Illuminate\Support\Carbon|null $ended_at
 * @property int $timesheet_id
 * @property-read \App\Models\Timesheet $timesheet
 * @method static \Illuminate\Database\Eloquent\Builder|TimesheetDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TimesheetDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TimesheetDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|TimesheetDetail whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimesheetDetail whereEndedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimesheetDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimesheetDetail whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimesheetDetail whereTimesheetId($value)
 * @mixin \Eloquent
 */
class TimesheetDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'started_at',
        'ended_at',
        'description'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime'
    ];

    public function timesheet() {
        return $this->belongsTo(Timesheet::class);
    }
}
