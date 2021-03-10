<?php


namespace App\Repositories;


use App\Models\Installment;
use Illuminate\Support\Facades\DB;

class InstallmentRepository extends BaseRepository
{

    public function listInstallmentByLoanId($id) {
        return Installment::fromQuery('select * from `installments` where `loan_id` = ?', [
            $id
        ]);
    }

    public function updateInstallment($data, $id) {
        return $this->update('installments', $data, "`id` = ?", [$id]);
    }

    public function findInstallmentById($id) {
        return Installment::fromQuery('select * from `installments` where `id` = ?', [
            $id
        ])->first();
    }


    public function createInstallment($data, $loanId) {
        $this->insert('installments', array_merge($data, [
            'loan_id' => $loanId
        ]));
        return $this->findInstallmentById($this->lastId());
    }


    public function deleteInstallment($id) {
        return DB::delete('delete from `installments` where `id` = ?', [$id]);
    }

}
