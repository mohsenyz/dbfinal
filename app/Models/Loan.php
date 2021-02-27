<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'description'
    ];


    public function employee() {
        return $this->belongsTo(Employee::class, 'requested_by');
    }

    public function acceptedBy() {
        return $this->belongsTo(Employee::class, 'accepted_by');
    }
}
