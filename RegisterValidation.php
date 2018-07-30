<?php
$host = 'ddc353.encs.concordia.ca';
$username = 'ddc353_1';
$password = '353DBpro';
$db = 'ddc353_1';
$db_port = '3306';

function Register($fName, $lName, $email, $pw)
{
    $host = 'ddc353.encs.concordia.ca';
    $username = 'ddc353_1';
    $password = '353DBpro';
    $db = 'ddc353_1';
    $db_port = '3306';
    $connection = mysqli_connect($host, $username, $password, $db, $db_port);
    if ($connection->connect_error) {
        die("error failure" . $connection->connect_error);
    } else {
        $sql = $connection->prepare("INSERT INTO users (email,password) VALUES(?,?)");
        $sql->bind_param("ss", $email, $pw);
        $sql->execute();
        $connection->close();
    }
}

?>
