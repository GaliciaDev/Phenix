<?php

namespace App\Database;

class MySQLConnection implements DatabaseInterface
{
    protected $connection;
    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function connect()
    {
        $this->connection = new \mysqli(
            $this->config['host'],
            $this->config['username'],
            $this->config['password'],
            $this->config['database']
        );

        if ($this->connection->connect_error) {
            throw new DatabaseException('Connection failed: ' . $this->connection->connect_error);
        }

        echo "Servicio MySQL conectado";
    }

    public function query($sql)
    {
        $result = $this->connection->query($sql);

        if ($result === false) {
            throw new DatabaseException('Query error: ' . $this->connection->error);
        }

        return $result;
    }

    public function fetch($result)
    {
        if ($result instanceof \mysqli_result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        throw new DatabaseException('Invalid result set');
    }

    public function insert($table, $data)
    {
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), '?'));
        $values = array_values($data);

        // Determinar tipos dinámicamente
        $types = '';
        foreach ($values as $value) {
            $types .= is_int($value) ? 'i' : (is_float($value) ? 'd' : 's');
        }

        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $this->connection->prepare($sql);

        if ($stmt === false) {
            throw new DatabaseException('Prepare error: ' . $this->connection->error);
        }

        $stmt->bind_param($types, ...$values);

        if ($stmt->execute() === false) {
            throw new DatabaseException('Insert error: ' . $stmt->error);
        }

        $insertId = $stmt->insert_id;
        $stmt->close();

        return $insertId;
    }

    public function update($table, $data, $where)
    {
        $set = [];
        $values = [];
        foreach ($data as $column => $value) {
            $set[] = "$column = ?";
            $values[] = $value;
        }
        $set = implode(", ", $set);

        $types = '';
        foreach ($values as $value) {
            $types .= is_int($value) ? 'i' : (is_float($value) ? 'd' : 's');
        }

        $sql = "UPDATE $table SET $set WHERE $where";
        $stmt = $this->connection->prepare($sql);

        if ($stmt === false) {
            throw new DatabaseException('Prepare error: ' . $this->connection->error);
        }

        $stmt->bind_param($types, ...$values);

        if ($stmt->execute() === false) {
            throw new DatabaseException('Update error: ' . $stmt->error);
        }

        $affectedRows = $stmt->affected_rows;
        $stmt->close();

        return $affectedRows;
    }

    public function beginTransaction()
    {
        $this->connection->begin_transaction();
    }

    public function commitTransaction()
    {
        $this->connection->commit();
    }

    public function rollbackTransaction()
    {
        $this->connection->rollback();
    }

    public function close()
    {
        if ($this->connection) {
            $this->connection->close();
        }
    }
}

/* 
    Controllers
        
        
    
    Midelwares
        
        
    
    Requests
        
    
    Response
        

    Router
        

    utils
        PathManager.php


*/
