<?php 

namespace App\Repository;

use \PDO;
use App\Repository\Exception\DeleteException;
use App\Repository\Exception\InsertException;
use App\Repository\Exception\UpdateException;
use App\Repository\Exception\NotFoundException;
use App\Repository\Exception\NotPropertyFoundException;

abstract class Repository
{
    protected PDO $pdo;

    protected $table = null;
    protected $class = null;

    public function __construct(PDO $pdo)
    {
        $class = get_class($this);

        if ($this->table === null) {
            throw new NotPropertyFoundException('table', $class);
        }
        
        if ($this->class === null) {
            throw new NotPropertyFoundException('class', $class);
        }
        
        $this->pdo = $pdo;
    }

    public function insert(array $data) : int
    {
        dump($data);
        $sqlFields = [];
        $fields = [];
        foreach($data as $key => $value) {
            $fields[] = $key;
            $sqlFields[] = ":$key";
        }
        $query = $this->pdo->prepare("INSERT INTO {$this->table}(". implode(", ", $fields) .") VALUES (". implode(", ", $sqlFields). ")");
        $query->execute($data);

        if ($query === false) {
            throw new InsertException($this->table);
        }

        return (int)$this->pdo->lastInsertId();
    }

    public function update(array $data, int $id) : int
    {
        $sqlFields = [];
        $fields = [];
        foreach($data as $key => $value) {
            $fields[] = $key;
            $sqlFields[] = "$key = :$key";
        }
        $query = $this->pdo->prepare("UPDATE {$this->table} SET " . implode(', ', $sqlFields) . " WHERE id=:id");
        $query->execute(array_merge($data, ['id' => $id]));

        if ($query === false) {
            throw new UpdateException($this->table, $id);
        }

        return (int)$this->pdo->lastInsertId();
    }

    public function delete(int $id): bool
    {
        $sql = 'DELETE FROM ' . $this->table . ' WHERE id=:id';
        $stmt = $this->pdo->prepare($sql)->execute(['id' => $id]);

        if ($stmt === false) {
            throw new DeleteException($this->table, $id);
        }

        return true;
    }

    public function find(int $id) : object
    {
        $query = $this->pdo->prepare('SELECT * FROM '. $this->table .' WHERE id = :id');
        $query->execute(['id' => $id]);
        $query->setFetchMode(PDO::FETCH_CLASS, $this->class);
        $item = $query->fetch();

        if($item === null) {
            throw new NotFoundException($this->table, $id);
        }

        /**
         * @return object $item
         */
        return $item;
    }

    public function queryAndFetchAll(string $sql) : array
    {
        $query = $this->pdo->prepare($sql);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_CLASS, $this->class);
        $items = $query->fetchAll();

        if($items === null) {
            throw new NotFoundException($this->table);
        }

        /**
         * @return object[] $items
         */
        return $items;
    }

    /**
     * Vérifie si une valeur existe dans la table
     * @param string $field Champ à rechercher
     * @param mixed $value Valeur associée au champ
     */
    public function exists(string $field, $value, ?int $except = null) : bool 
    {
        $sql = "SELECT COUNT(id) FROM {$this->table} WHERE $field = ?";
        $params = [$value];
        if($except !== null) {
            $sql .= " AND id != ?";
            $params[] = $except;
        }
        $query = $this->pdo->prepare($sql);
        $query->execute($params);
        return (int)$query->fetch(PDO::FETCH_NUM)[0] > 0;
    }
}