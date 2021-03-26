<?php

interface IDatabaseWorker
{
    public function Create(string $tableName, array $properties);

    public function Read(string $tableName, int $id);
    public function ReadAll(string $tableName);

    public function Update(string $tableName, int $id, array $properties);

    public function Delete(string $tableName, int $id);

    public function ExecuteQuery(string $query);
}

?>