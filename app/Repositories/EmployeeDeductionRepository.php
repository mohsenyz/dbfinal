<?php


namespace App\Repositories;


use App\Models\Contract;
use App\Models\Deduction;
use App\Models\Salary;
use Illuminate\Support\Facades\DB;

class EmployeeDeductionRepository extends BaseRepository
{

    public function listDeductionsByEmployeeId($id) {
        return Deduction::fromQuery('select * from `deductions` where `reported_to` = ?', [
            $id
        ]);
    }

    public function sumOfAllDeductionsAmount() {
        return Deduction::fromQuery('select sum(amount) from `deductions`');
    }


    public function sumOfAllDeductionsAmountByEmployeeId($id) {
        return DB::select('select coalesce((sum(amount)), 0) as amount from `deductions` where `reported_to` = ?', [$id]);
    }

    public function updateDeduction($data, $id) {
        return $this->update('deductions', $data, "`id` = ?", [$id]);
    }


    public function findDeductionById($id) {
        return Deduction::fromQuery('select * from `deductions` where `id` = ?', [
            $id
        ])->first();
    }


    public function createDeduction($data, $employeeId) {
        $this->insert('deductions', array_merge($data, [
            'reported_to' => $employeeId
        ]));
        return $this->findDeductionById($this->lastId());
    }


    public function deleteDeduction($id) {
        return DB::delete('delete from `deductions` where `id` = ?', [$id]);
    }
}
