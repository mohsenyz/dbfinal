<?php


namespace App\Repositories;


use App\Models\Salary;

class EmployeeSalaryRepository extends BaseRepository
{

    public function updateSalary($data, $id) {
        return $this->update('salaries', $data, "`id` = ?", [$id]);
    }

    public function updateSalaryByContract($data, $id) {
        return $this->update('salaries', $data, "`contract_id` = ?", [$id]);
    }

    public function findSalaryById($id) {
        return Salary::fromQuery('select * from `salaries` where `id` = ?', [
            $id
        ])->first();
    }


    public function createSalary($data, $contractId) {
        $this->insert('salaries', array_merge($data, [
            'contract_id' => $contractId
        ]));
        return $this->findSalaryById($this->lastId());
    }

}
