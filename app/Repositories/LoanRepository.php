<?php


namespace App\Repositories;


use App\Models\Loan;
use Illuminate\Support\Facades\DB;

class LoanRepository extends BaseRepository
{

    public function listLoanByEmployeeId($id) {
        return Loan::fromQuery('select * from `loans` where `requested_by` = ?', [
            $id
        ]);
    }

    public function updateLoan($data, $id) {
        return $this->update('loans', $data, "`id` = ?", [$id]);
    }


    public function findLoanById($id) {
        return Loan::fromQuery('select * from `loans` where `id` = ?', [
            $id
        ])->first();
    }


    public function createLoan($data, $employeeId) {
        $this->insert('loans', array_merge($data, [
            'requested_by' => $employeeId
        ]));
        return $this->findLoanById($this->lastId());
    }


    public function deleteLoan($id) {
        return DB::delete('delete from `loans` where `id` = ?', [$id]);
    }

}
