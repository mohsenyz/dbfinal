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
 * App\Models\Employee
 *
 * @property mixed company
 * @property int $id
 * @property string $first_name
 * @property string|null $phone_number
 * @property string|null $last_name
 * @property string $username
 * @property string $password
 * @property string|null $national_id
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $company_id
 * @property-read \App\Models\Contract|null $activeContract
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Assistance[] $assistances
 * @property-read int|null $assistances_count
 * @property-read \App\Models\Company|null $company
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Contract[] $contracts
 * @property-read int|null $contracts_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Deduction[] $deductions
 * @property-read int|null $deductions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Earning[] $earnings
 * @property-read int|null $earnings_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Loan[] $loans
 * @property-read int|null $loans_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Deduction[] $reportedDeductions
 * @property-read int|null $reported_deductions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Deduction[] $reportedEarnings
 * @property-read int|null $reported_earnings_count
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newQuery()
 * @method static \Illuminate\Database\Query\Builder|Employee onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee query()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee system()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereNationalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|Employee withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Employee withoutTrashed()
 * @mixin \Eloquent
 */
class Employee extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, SoftDeletes;

    const ROLE_EMPLOYEE = 'employee',
        ROLE_ADMIN = 'admin';

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

    public function isAdmin(): bool
    {
        return $this->getAttribute('role') == self::ROLE_ADMIN;
    }

    public function isEmployee(): bool
    {
        return $this->getAttribute('role') == self::ROLE_EMPLOYEE;
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }
}
