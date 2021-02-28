<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PayCheck
 *
 * @property int $id
 * @property int $gross_profit
 * @property int $net_profit
 * @property int $tax_amount
 * @property string $start_date
 * @property string $end_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $employee_id
 * @method static \Illuminate\Database\Eloquent\Builder|PayCheck newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayCheck newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayCheck query()
 * @method static \Illuminate\Database\Eloquent\Builder|PayCheck whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayCheck whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayCheck whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayCheck whereGrossProfit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayCheck whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayCheck whereNetProfit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayCheck whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayCheck whereTaxAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayCheck whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PayCheck extends Model
{
    use HasFactory;
}
