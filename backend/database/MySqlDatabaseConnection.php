<?php

class MySqlDatabaseConnection implements IDatabaseConnection
{

  protected $host;
  protected $user;
  protected $password;
  protected $databaseName;

  protected $connection;

  public function __construct($host, $user, $password, $databaseName)
  {
    $this->host = $host;
    $this->user = $user;
    $this->password = $password;
    $this->databaseName = $databaseName;
  }

  public function Open()
  {
    $this->connection = new mysqli($this->host, $this->user, $this->password, $this->databaseName) or die("Connect failed: %s\n" . $this->connection->error);
  }

  public function Close()
  {
    $this->connection->close();
  }

  public function CreateRow($tableName, $properties)
  {

    if (empty($properties)) return false;

    $keys = "";
    $values = "";

    foreach ($properties as $x => $x_value) {
      $keys .= "`$x`, ";
      $values .= "'$x_value', ";
    }

    $keys = substr($keys, 0, -2);
    $values = substr($values, 0, -2);

    $query = "INSERT INTO `$tableName` ($keys) VALUES ($values)";
    try
    {
      $result = $this->connection->query($query);
      return $result;
    }
    catch (Exception $e)
    {
      throw $e;
    }
    
  }

  public function ReadRows($tableName)
  {
    try {
      $result = $this->connection->query("SELECT * FROM `$tableName`");
      $objects = array();

      while ($row = $result->fetch_object()) {
        $objects[] = $row;
      }

      return $objects;
    } catch (Exception $e) {
      throw $e;
    }
  }

  public function ReadRow($tableName, $id)
  {
    try {
      $result = $this->connection->query("SELECT * FROM `$tableName` WHERE id=$id");

      $row = $result->fetch_object();
      return $row;
      
    } catch (Exception $e) {
      throw $e;
    }
  }

  public function UpdateRow(string $tableName, int $id, array $properties)
  {
    if (empty($properties)) return false;

    $query = "UPDATE `$tableName` SET ";

    $setProperties = "";

    foreach ($properties as $x => $x_value) {
      $setProperties .= $x . "='" . $x_value . "', ";
    }

    $setProperties = substr($setProperties, 0, -2);   //remove unneseccary space and coma
    $query .= $setProperties;
    $query .= " WHERE id=$id";

    try
    {
      $result = $this->connection->query($query);
      return $result;
    }
    catch (Exception $e)
    {
      throw $e;
    }
    
  }

  public function DeleteData(string $tableName, int $entityId)
  {
    try {
      $this->connection->query("DELETE FROM `$tableName` WHERE id=$entityId");
      return true;
    } catch (Exception $e) {
      throw $e;
    }
  }

  public function ExecuteQuery(string $query)
  {
    try {
      $result = $this->connection->query($query);
      return $result;
    } catch (Exception $e) {
      throw $e;
    }
  }
}
