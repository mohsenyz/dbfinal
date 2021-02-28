<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Salary
 *
 * @property int $id
 * @property int $medical_allowance
 * @property int $incentive
 * @property int $base
 * @property int $contract_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Contract $contract
 * @method static \Illuminate\Database\Eloquent\Builder|Salary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Salary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Salary query()
 * @method static \Illuminate\Database\Eloquent\Builder|Salary whereBase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Salary whereContractId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Salary whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Salary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Salary whereIncentive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Salary whereMedicalAllowance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Salary whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Salary extends Model
{
    use HasFactory;

    protected $fillable = [
        'medical_allowance',
        'incentive',
        'base'
    ];

    public function contract() {
        return $this->belongsTo(Contract::class);
    }
}
