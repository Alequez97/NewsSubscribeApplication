<?php

class DatabaseWorker implements IDatabaseWorker
{
    private $db;

    public function __construct(IDatabaseConnection $db)
    {
        $this->db = $db;
    }

    public function Create(string $tableName, array $properties)
    {
        try
        {
            $this->db->Open();
            $result = $this->db->CreateRow($tableName, $properties);
            $this->db->Close();
            return $result;
        }
        catch (Exception $e)
        {
            throw $e;
        }
    }

    public function Read(string $tableName, int $id)
    {
        try
        {
            $this->db->Open();
            $result = $this->db->ReadRow($tableName, $id);
            $this->db->Close();
            return $result;
        }
        catch (Exception $e)
        {
            throw $e;
        }
    }

    public function ReadAll($tableName)
    {
        try
        {
            $this->db->Open();
            $objects = $this->db->ReadRows($tableName);
            $this->db->Close();
    
            return $objects;
        }
        catch (Exception $e)
        {
            throw $e;
        }
    }

    public function Update(string $tableName, int $id, array $properties)
    {
        try
        {
            $this->db->Open();
            $objects = $this->db->UpdateRow($tableName, $id, $properties);
            $this->db->Close();
    
            return $objects;
        }
        catch (Exception $e)
        {
            throw $e;
        }
    }

    public function Delete($tableName, $id)
    {
        try
        {
            $this->db->Open();
            $result = $this->db->DeleteData($tableName, $id);
            $this->db->Close();
    
            return $result;
        }
        catch (Exception $e)
        {
            throw $e;
        }
    }

    public function ExecuteQuery($query)
    {
        try
        {
            $this->db->Open();
            $result = $this->db->ExecuteQuery($query);
            $this->db->Close();
    
            return $result;
        }
        catch (Exception $e)
        {
            throw $e;
        }
    }

}
