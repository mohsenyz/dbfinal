<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @property mixed company
 */
class Employee extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, SoftDeletes;


    /**
     * @var string[]
     */
    protected $fillable = [
        'first_name',
        'phone_number',
        'last_name',
        'username',
        'password',
        'national_id'
    ];


    protected $hidden = [
        'password',
        'remember_token',
        'deleted_at',
        'updated_at'
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime'
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }

    public function activeContract(): HasOne
    {
        return $this->hasOne(Contract::class)
            ->activeAt(now());
    }

    public function deductions() {
        return $this->hasMany(Deduction::class, 'reported_to');
    }

    public function reportedDeductions() {
        return $this->hasMany(Deduction::class, 'reported_by');
    }

    public function earnings() {
        return $this->hasMany(Earning::class, 'reported_to');
    }

    public function reportedEarnings() {
        return $this->hasMany(Deduction::class, 'reported_by');
    }

    public function assistances() {
        return $this->hasMany(Assistance::class, 'requested_by');
    }

    public function loans() {
        return $this->hasMany(Loan::class, 'requested_by');
    }

    public function scopeSystem($builder) {
        return $builder->whereNull('company_id');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }
}
