<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
