<?php

namespace App\Models;

use App\Repositories\EmployeeAssistanceRepository;
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

    public $timestamps = false;

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

    public function pay() {
        resolve(EmployeeAssistanceRepository::class)
            ->updateAssistance([
                'paid_at' => now(),
            ], $this->getAttribute('id'));
    }

    public function accept() {
        resolve(EmployeeAssistanceRepository::class)
            ->updateAssistance([
                'accepted_at' => now(),
                'accepted_by' => auth()->user()->id
            ], $this->getAttribute('id'));
    }


    public function reject() {
        resolve(EmployeeAssistanceRepository::class)
            ->updateAssistance([
                'rejected_at' => now(),
                'rejected_by' => auth()->user()->id
            ], $this->getAttribute('id'));
    }
}
