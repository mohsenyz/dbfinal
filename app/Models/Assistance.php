<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Assistance
 *
 * @property int $id
 * @property int $amount
 * @property string $paid_at
 * @property string $requested_at
 * @property string $accepted_at
 * @property string $rejected_at
 * @property int $requested_by
 * @property int $accepted_by
 * @property int $rejected_by
 * @property-read \App\Models\Employee $acceptedBy
 * @property-read \App\Models\Employee $employee
 * @property-read \App\Models\Employee $rejectedBy
 * @method static \Illuminate\Database\Eloquent\Builder|Assistance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Assistance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Assistance query()
 * @method static \Illuminate\Database\Eloquent\Builder|Assistance whereAcceptedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Assistance whereAcceptedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Assistance whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Assistance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Assistance wherePaidAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Assistance whereRejectedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Assistance whereRejectedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Assistance whereRequestedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Assistance whereRequestedBy($value)
 * @mixin \Eloquent
 */
class Assistance extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'paid_at',
        'requested_at',
        'accepted_at',
        'rejected_at'
    ];

    public function employee() {
        return $this->belongsTo(Employee::class, 'requested_by');
    }

    public function acceptedBy() {
        return $this->belongsTo(Employee::class, 'accepted_by');
    }

    public function rejectedBy() {
        return $this->belongsTo(Employee::class, 'rejected_by');
    }

    public function accept() {
        $this->setAttribute('accepted_at', now());
        $this->acceptedBy()->associate(auth()->user());
    }


    public function reject() {
        $this->setAttribute('rejected_by', now());
        $this->rejectedBy()->associate(auth()->user());
    }


    public function pay() {
        $this->setAttribute('paid_at', now());
    }
}
