<?php

interface IDatabaseConnection
{
    public function Open();
    public function Close();

    public function CreateRow(string $tableName, array $properties);

    public function ReadRows(string $tableName);
    public function ReadRow(string $tableName, int $id);

    public function UpdateRow(string $tableName, int $id, array $properties);

    public function DeleteData(string $tableName, int $Id);

    public function ExecuteQuery(string $query);
    
}

?>