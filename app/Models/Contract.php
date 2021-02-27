<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
