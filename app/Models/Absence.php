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

    const TYPE_UNKNOWN = 'unknown';

    public $timestamps = false;

    protected $fillable = [
        'started_at',
        'ended_at',
        'description',
        'type',
        'requested_at',
        'accepted_at',
        'rejected_at'
    ];


    public function accept() {
        $this->setAttribute('accepted_at', now());
        $this->acceptedBy()->associate(auth()->user());
    }


    public function reject() {
        $this->setAttribute('rejected_by', now());
        $this->rejectedBy()->associate(auth()->user());
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
