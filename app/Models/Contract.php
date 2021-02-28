<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Contract
 *
 * @property int $id
 * @property string|null $description
 * @property string $starts_at
 * @property string $ends_at
 * @property string $pay_check_period
 * @property int $required_working_horus
 * @property int $allowed_absence_hours
 * @property int $employee_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Salary|null $salary
 * @method static Builder|Contract activeAt(\Carbon\Carbon $time)
 * @method static Builder|Contract newModelQuery()
 * @method static Builder|Contract newQuery()
 * @method static Builder|Contract query()
 * @method static Builder|Contract whereAllowedAbsenceHours($value)
 * @method static Builder|Contract whereCreatedAt($value)
 * @method static Builder|Contract whereDescription($value)
 * @method static Builder|Contract whereEmployeeId($value)
 * @method static Builder|Contract whereEndsAt($value)
 * @method static Builder|Contract whereId($value)
 * @method static Builder|Contract wherePayCheckPeriod($value)
 * @method static Builder|Contract whereRequiredWorkingHorus($value)
 * @method static Builder|Contract whereStartsAt($value)
 * @method static Builder|Contract whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Contract extends Model
{
    use HasFactory;


    // Contract periods
    const PERIOD_MONTHLY = 'monthly';
    const PERIOD_YEARLY = 'yearly';


    protected $fillable = [
        'description',
        'starts_at',
        'ends_at',
        'pay_check_period',
        'required_working_hours',
        'allowed_absence_hours'
    ];

    public function scopeActiveAt(Builder $builder, Carbon $time): Builder
    {
        return $builder->whereDate('ends_at', '<=', $time)
            ->whereDate('starts_at', '>=', $time);
    }


    public function salary() {
        return $this->hasOne(Salary::class);
    }
}
