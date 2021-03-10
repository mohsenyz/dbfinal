<?php


namespace App\Repositories;


use Illuminate\Support\Facades\DB;

class BaseRepository
{

    protected function getColumns($data) {
        return implode(',', array_keys($data));
    }

    protected function generateValuesHolder($numOfValues) {
        $arr = [];
        for ($i = 0; $i < count($numOfValues); $i++)
            $arr[] = '?';
        return implode(', ', $arr);
    }

    protected function insert($tableName, $data) {
        $columns = $this->getColumns($data);
        $values = $this->generateValuesHolder($data);
        return DB::insert( "insert into `$tableName` ($columns) values ($values)", array_values($data));
    }


    protected function update($tableName, $data, $whereQuery, $whereBindings = []) {
        $set = [];
        foreach ($data as $key => $value) {
            $set[] = "`$key` = ?";
        }
        $setPart = implode(",", $set);
        return DB::insert(
            "update `$tableName` set $setPart where $whereQuery",
            array_merge(array_values($data), $whereBindings)
        );
    }


    protected function lastId() {
        return DB::getPdo()->lastInsertId();
    }

}
