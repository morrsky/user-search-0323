<?php

declare(strict_types=1);

namespace App\Infrastructure\Adapter\Database;

use InvalidArgumentException;
use PDO;
use PDOException;
use RunTimeException;

class PdoAdapter implements DatabaseAdapterInterface
{
    protected $fetchMode = \PDO::FETCH_ASSOC;

    protected $connection;

    protected $statement;


    public function connect($config=null,$driver=null)
    {
        if ($this->connection) {
            return;
        }

        $dsn = match(strtolower($driver)) {
            'sqlite' => sprintf('sqlite:%s', $config['name']),
            'mysql' => sprintf('mysql:host=%s;dbname=%s;', $config['host'], $config['name']),
            default => throw new InvalidArgumentException(sprintf("Unknown database driver '%s' in %s.", $driver, __CLASS__))
        };

        $options = ($config['options'])??null;

        try {
            $this->connection = new PDO($dsn, $config['username'], $config['password'],$options);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch(PDOException $e){
            throw new RunTimeException($e->getMessage());
        }
    }

    public function getStatement() {
        if ($this->statement === null) {
            throw new \PDOException(
                "There is no PDOStatement object for use.");
        }
        return $this->statement;
    }

    public function disconnect() {
        $this->connection = null;
    }

    public function prepare($sql, array $options = array()) {
        $this->connect();

        try {
            $this->statement = $this->connection->prepare($sql, $options);

            return $this;
        } catch (PDOException $e) {
            throw new RunTimeException($e->getMessage());
        }
    }

    public function execute(array $parameters = array()) {

        try {
            $this->getStatement()->execute($parameters);

            return $this;
        } catch (PDOException $e) {
            throw new RunTimeException($e->getMessage());
        }
    }

    public function countAffectedRows() {
        try {
            return $this->getStatement()->rowCount();
        } catch (\PDOException $e) {
            throw new \RunTimeException($e->getMessage());
        }
    }

    /**
     * countAffectedRows iin Alias
     */
    public function count() {
        try {
            return $this->getStatement()->rowCount();
        } catch (\PDOException $e) {
            throw new \RunTimeException($e->getMessage());
        }
    }

    public function fetch($fetchStyle = null, $cursorOrientation = PDO::FETCH_DEFAULT, $cursorOffset = 0) {
        if ($fetchStyle === null) {
            $fetchStyle = $this->fetchMode;
        }

        try {
            return $this->getStatement()->fetch($fetchStyle, $cursorOrientation, $cursorOffset);
        } catch (\PDOException $e) {
            throw new \RunTimeException($e->getMessage());
        }
    }

    public function fetchOne($fetchStyle = null, $column=0)
    {
        if ($fetchStyle === PDO::FETCH_CLASS && ! empty($column)) {
            return $this->getStatement()->fetchObject($column);
        }
    }

    public function fetchQuery($sql,$fetchStyle=null)
    {
        if ($fetchStyle === null) {
            $fetchStyle = $this->fetchMode;
        }
        try {
            $sth = $this->connection->prepare($sql);
            $sth->execute();

            return $sth->fetch();
        } catch (\PDOException $e) {
            throw new \RunTimeException($e->getMessage());
        }
    }

    public function fetchAll($fetchStyle = null, $column = 0) {
        if ($fetchStyle === PDO::FETCH_CLASS && ! empty($column)) {
            return $this->getStatement()->fetchAll($fetchStyle, $column);
        }

        if ($fetchStyle === null) {
            $fetchStyle = $this->fetchMode;
        }

        try {
            return $fetchStyle === \PDO::FETCH_COLUMN ? $this->getStatement()->fetchAll($fetchStyle, $column) : $this->getStatement()->fetchAll($fetchStyle);
        } catch (\PDOException $e) {
            throw new \RunTimeException($e->getMessage());
        }
    }

    public function select($dataset, $bind = array(), $where = "", $options = array()) {
        if (count($bind) > 0) {
            foreach ($bind as $col => $value) {
                unset($bind[$col]);
                $bind[":" . $col] = $value;
            }
        }
        if (isset($options['fields'])) {
            $fields = $options['fields'];
        } else {
            $fields = '*';
        }
        $sql = "SELECT " . $fields . " FROM " . $dataset . " ";

        if (strlen($where) > 2) {
            $sql .= "WHERE " . $where;
        }

        $this->prepare($sql)
            ->execute($bind);

        return $this;
    }

//    public function query($sql, array $bind = array()) {
//        if (is_array($bind)) {
//            foreach ($bind as $col => $value) {
//                unset($bind[$col]);
//                $bind[":" . $col] = $value;
//            }
//        }
//
//        $this->prepare($sql)
//            ->execute($bind);
//        return $this;
//    }

    public function insert($dataset, array $bind) {
        $cols = implode(", ", array_keys($bind));
        $values = implode(", :", array_keys($bind));
        foreach ($bind as $col => $value) {
            unset($bind[$col]);
            $bind[":" . $col] = $value;
        }

        $sql = "INSERT INTO " . $dataset
            . " (" . $cols . ")  VALUES (:" . $values . ")";
        return (int) $this->prepare($sql)
            ->execute($bind)
            ->countAffectedRows();
    }

//
//    public function delete($dataset, $where = "") {
//        $sql = "DELETE FROM " . $dataset . (($where) ? " WHERE " . $where : " ");
//        return $this->prepare($sql)
//            ->execute()
//            ->countAffectedRows();
//    }
}
