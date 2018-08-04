<?php
require 'DB.php';

function Register($fName, $lName, $email, $pw, $role)
{
    $connection = DB::getConnection();
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
