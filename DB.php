<?php
include('config.php');

class db extends mysqli
{

    private static $instance = null;

    private $host = DBHOST;
    private $username = DBUSER;
    private $password = DBPWD;
    private $db = DBNAME;
    private $db_port = DBPORT;

    public static function getInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public static function getConnection() {
        $connection = mysqli_connect(DBHOST, DBUSER, DBPWD, DBNAME, DBPORT);
        if ($connection->connect_error) {
            die("error failure" . $connection->connect_error);
        }
        return $connection;
    }

    public function dbquery($query)
    {
        $connection = mysqli_connect($this->host, $this->username, $this->password, $this->db, $this->db_port);
        if ($connection->connect_error) {
            die("error failure" . $connection->connect_error);
        }
        $connection->query($query);
    }

    public function getResult($query)
    {
        $connection = mysqli_connect($this->host, $this->username, $this->password, $this->db, $this->db_port);
        if ($connection->connect_error) {
            die("error failure" . $connection->connect_error);
        }
        $sql = $connection->query($query);
        $result = $sql->fetch_assoc();
        return $result;
    }
}