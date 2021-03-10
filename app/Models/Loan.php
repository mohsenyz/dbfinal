<?php

namespace App\Models;

use App\Repositories\EmployeeAbsenceRepository;
use App\Repositories\LoanRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Loan
 *
 * @property int $id
 * @property string $requested_at
 * @property string $paid_at
 * @property string $description
 * @property int $accepted_by
 * @property int $requested_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Employee $acceptedBy
 * @property-read \App\Models\Employee $employee
 * @method static \Illuminate\Database\Eloquent\Builder|Loan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Loan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Loan query()
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereAcceptedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan wherePaidAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereRequestedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereRequestedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Loan whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'requested_at',
        'paid_at'
    ];

    public function installments() {
        return $this->hasMany(Installment::class);
    }

    public function accept() {
        resolve(LoanRepository::class)
            ->updateLoan([
                'accepted_at' => now(),
                'accepted_by' => auth()->user()->id
            ], $this->getAttribute('id'));
    }


    public function reject() {
        resolve(LoanRepository::class)
            ->updateLoan([
                'rejected_at' => now(),
                'rejected_by' => auth()->user()->id
            ], $this->getAttribute('id'));
    }

    public function employee() {
        return $this->belongsTo(Employee::class, 'requested_by');
    }

    public function acceptedBy() {
        return $this->belongsTo(Employee::class, 'accepted_by');
    }

    public function rejectedBy() {
        return $this->belongsTo(Employee::class, 'rejected_by');
    }
}
