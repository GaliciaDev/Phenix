<?php

namespace App\Database;

interface DatabaseInterface
{
    public function connect();
    public function query($sql);
    public function fetch($result);
    public function insert($table, $data);
    public function update($table, $data, $where);
    public function beginTransaction();
    public function commitTransaction();
    public function rollbackTransaction();
    public function close();
}
