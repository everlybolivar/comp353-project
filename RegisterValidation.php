<?php
$host = 'ddc353.encs.concordia.ca';
$username = 'ddc353_1';
$password = '353DBpro';
$db = 'ddc353_1';
$db_port = '3306';

function Register($fName, $lName, $email, $pw, $role)
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
        $inital = $fName[0].$lName[0];

        if($role == "employee"){
            $id = 7;
            $sql = $connection->prepare("INSERT INTO employee (employee_fname,employee_lname,employee_initial,department_id) VALUES(?,?,?,?)");
            $sql->bind_param("ssss", $fName, $lName,$inital,$id);
            $sql->execute();

        }

        if($role == "manager"){
            $id = 1;
            $sql = $connection->prepare("INSERT INTO employee (employee_fname,employee_lname,employee_initial,department_id) VALUES(?,?,?,?)");
            $sql->bind_param("ssss", $fName, $lName,$inital,$id);
            $sql->execute();

        }

        if($role == "admin"){
            $id = 13;
            $sql = $connection->prepare("INSERT INTO employee (employee_fname,employee_lname,employee_initial,department_id) VALUES(?,?,?,?)");
            $sql->bind_param("ssss", $fName, $lName,$inital,$id);
            $sql->execute();

        }

        if($role == "salesAssociate"){
            $id = 14;
            $sql = $connection->prepare("INSERT INTO employee (employee_fname,employee_lname,employee_initial,department_id) VALUES(?,?,?,?)");
            $sql->bind_param("ssss", $fName, $lName,$inital,$id);
            $sql->execute();

        }


        $employee_id = $connection->insert_id;
        $sql = $connection->prepare("INSERT INTO users (email,password,employee_id) VALUES(?,?,?)");
        $sql->bind_param("sss", $email,$pw,$employee_id);
        $sql->execute();

        $connection->close();
    }
}

?>
