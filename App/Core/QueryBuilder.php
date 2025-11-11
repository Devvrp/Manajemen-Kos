<?php

class QueryBuilder
{
    private $pdo;
    private $table;
    private $query;
    private $bindings = [];
    private $selects = ['*'];
    private $joins = [];
    private $wheres = [];
    private $orderBy = '';
    private $limit = '';
    private $offset = '';
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    public function table($table)
    {
        $this->reset();
        $this->table = $table;
        return $this;
    }
    private function reset()
    {
        $this->table = '';
        $this->query = '';
        $this->bindings = [];
        $this->selects = ['*'];
        $this->joins = [];
        $this->wheres = [];
        $this->orderBy = '';
        $this->limit = '';
        $this->offset = '';
    }
    public function select($columns = ['*'])
    {
        $this->selects = is_array($columns) ? $columns : func_get_args();
        return $this;
    }
    public function where($column, $operator, $value = null)
    {
        if (func_num_args() === 2) {
            $value = $operator;
            $operator = '=';
        }
        $placeholder = $this->addBinding($value);
        $this->wheres[] = "$column $operator $placeholder";
        return $this;
    }
    public function whereNull($column)
    {
        $this->wheres[] = "$column IS NULL";
        return $this;
    }
    public function whereNotNull($column)
    {
        $this->wheres[] = "$column IS NOT NULL";
        return $this;
    }
    public function join($table, $first, $operator, $second)
    {
        $this->joins[] = "JOIN $table ON $first $operator $second";
        return $this;
    }
    public function orderBy($column, $direction = 'ASC')
    {
        $this->orderBy = "ORDER BY $column " . strtoupper($direction);
        return $this;
    }
    public function limit($count)
    {
        $this->limit = "LIMIT " . (int)$count;
        return $this;
    }
    public function offset($count)
    {
        $this->offset = "OFFSET " . (int)$count;
        return $this;
    }
    private function buildSelectQuery()
    {
        $this->query = "SELECT " . implode(', ', $this->selects);
        $this->query .= " FROM " . $this->table;
        if (!empty($this->joins)) {
            $this->query .= " " . implode(' ', $this->joins);
        }
        if (!empty($this->wheres)) {
            $this->query .= " WHERE " . implode(' AND ', $this->wheres);
        }
        $this->query .= " " . $this->orderBy;
        $this->query .= " " . $this->limit;
        $this->query .= " " . $this->offset;
    }
    public function get()
    {
        $this->buildSelectQuery();
        $stmt = $this->pdo->prepare($this->query);
        $stmt->execute($this->bindings);
        return $stmt->fetchAll();
    }
    public function first()
    {
        $this->limit(1);
        $this->buildSelectQuery();
        $stmt = $this->pdo->prepare($this->query);
        $stmt->execute($this->bindings);
        return $stmt->fetch();
    }
    public function insert($data)
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = [];
        foreach ($data as $value) {
            $placeholders[] = $this->addBinding($value);
        }
        $placeholderString = implode(', ', $placeholders);
        $this->query = "INSERT INTO {$this->table} ($columns) VALUES ($placeholderString)";
        $stmt = $this->pdo->prepare($this->query);
        return $stmt->execute($this->bindings);
    }
    public function update($whereColumn, $id, $data)
    {
        $sets = [];
        foreach ($data as $column => $value) {
            $placeholder = $this->addBinding($value);
            $sets[] = "$column = $placeholder";
        }
        $setString = implode(', ', $sets);
        $idPlaceholder = $this->addBinding($id);
        $this->query = "UPDATE {$this->table} SET $setString WHERE $whereColumn = $idPlaceholder";
        $stmt = $this->pdo->prepare($this->query);
        return $stmt->execute($this->bindings);
    }
    public function delete($whereColumn, $id)
    {
        $idPlaceholder = $this->addBinding($id);
        $this->query = "DELETE FROM {$this->table} WHERE $whereColumn = $idPlaceholder";
        $stmt = $this->pdo->prepare($this->query);
        return $stmt->execute($this->bindings);
    }
    private function addBinding($value)
    {
        $placeholder = ':binding_' . count($this->bindings);
        $this->bindings[$placeholder] = $value;
        return $placeholder;
    }
}