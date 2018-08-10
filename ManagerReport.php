<?php
ob_start();  //begin buffering the output
?>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Contract CMS</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>

        .sidebar {
            width: 250px;
            background-color: #7386D5;
            height: 100%;
            position: fixed;
            float: left;
            z-index: 2;
            top: 0px;
            left: 0px;
        }

        .lielement a {
            diplay: block;
            font-family: 'Poppins', sans-serif;
            color: #fff;
            font-size: 1.1em;
            font-weight: 300;
            line-height: 1.7em;
            margin: 10px;
            padding: 10px;
            font-weight: 400;
            text-decoration: none !important;
        }

        .title {
            margin-top: 10px;
            font-size: 2.1em;
            font-family: 'Poppins', sans-serif;
            line-height: 1.7em;
            font-weight: 300;
            text-align: center;
            color: #fff;
        }

        #content {
            margin-top: 25px;
            margin-left: 25%;
        }

    </style>

</head>


<body>
<!---->
<?php
require 'DB.php';
//validation


//removes employee from contract
if (isset($_POST['eid'])) {
    $eid = $_POST['eid'];
    $host = 'ddc353.encs.concordia.ca';
    $username = 'ddc353_1';
    $password = '353DBpro';
    $db = 'ddc353_1';
    $db_port = '3306';

    $connection = mysqli_connect($host, $username, $password, $db, $db_port);

    if ($connection->connect_error) {
        die("error failure" . $connection->connect_error);
    } else {
        $sql3 = $connection->prepare("UPDATE employee SET contract_id = NULL where employee_id = ?");
        $sql3->bind_param("s", $eid);
        $sql3->execute();
        $sql3->close();
    }

    if (isset($_GET['id'])) {
        $cid = $_GET['id'];
    }

    Header('Location: ' . $_SERVER['PHP_SELF'] . "?id=" . $cid);
    Exit();


}

if (isset($_GET['id'])) {
//read user email
    $cid = $_GET['id'];
    $email = $_COOKIE['email'];
    $host = 'ddc353.encs.concordia.ca';
    $username = 'ddc353_1';
    $password = '353DBpro';
    $db = 'ddc353_1';
    $db_port = '3306';

    $connection = mysqli_connect($host, $username, $password, $db, $db_port);
    if ($connection->connect_error) {
        die("error failure" . $connection->connect_error);
    } else {

        $sql1 = $connection->prepare("SELECT SUM(hours) FROM tasks WHERE tasks.contract_id = ?;");
        //bind params bind the email question mark. Refer to SQL prepared statements;
        $sql1->bind_param("s", $cid);
        $sql1->execute();
        $sql1->bind_result($contracthours);
        $sql1->fetch();
        $sql1->close();


        $sql1 = $connection->prepare("SELECT contract.company_name,contract.contract_id FROM contract WHERE contract.contract_id = ?");
        //bind params bind the email question mark. Refer to SQL prepared statements;
        $sql1->bind_param("s", $cid);
        $sql1->execute();
        $sql1->bind_result($contractname, $contractid);
        $sql1->fetch();
        $sql1->close();

        //find users for manager to add
        $sql2 = $connection->prepare("SELECT employee.employee_fname,employee.employee_lname,employee.employee_id  FROM users INNER JOIN employee ON employee.manager_id = users.employee_id INNER JOIN contract on contract.contract_type = employee.employee_contract_type WHERE users.email = ? && contract.contract_id = ? && employee.contract_id is NULL;");
        $sql2->bind_param("ss", $email, $cid);
        $sql2->execute();
        $resultEmployee = $sql2->get_result();
        $sql2->close();

        //find users in contract
        $sql = $connection->prepare("SELECT employee.employee_id,employee.employee_fname,employee.employee_lname,contract.contract_id,contract.company_name FROM employee INNER JOIN contract ON contract.contract_id = employee.contract_id  WHERE contract.contract_id = ?");
        $sql->bind_param("s", $cid);
        $sql->execute();
        $result = $sql->get_result();
        $rowNum = $sql->num_rows;
        $sql->close();

    }
}

//Checks for employee to be added
if (isset($_POST['addEid'])) {
    $addEid = $_POST['addEid'];
    $host = 'ddc353.encs.concordia.ca';
    $username = 'ddc353_1';
    $password = '353DBpro';
    $db = 'ddc353_1';
    $db_port = '3306';
    $connection = mysqli_connect($host, $username, $password, $db, $db_port);
    if (isset($_GET['id'])) {
        $cid = $_GET['id'];
    }

    if ($connection->connect_error) {
        die("error failure" . $connection->connect_error);
    } else {
        echo "cid" . $cid . $addEid;
        $sql4 = $connection->prepare("UPDATE employee SET contract_id = ? WHERE employee_id = ?");
        $sql4->bind_param("ss", $cid, $addEid);
        $sql4->execute();
        $sql4->close();
        Header('Location: ' . $_SERVER['PHP_SELF'] . "?id=" . $cid);
        Exit();
    }


}


ob_flush();

?>


<!--<div class="sidebar">-->
<!--    <div class="title">CMS</div>-->
<!--    <div class="lielement"> <a>test</a></div>-->
<!--    <div class="lielement"><a>test2</a></div>-->
<!---->
<!--</div>-->
<div id="content">
    <div class="form-group">
        <div class="card" style="width: 25rem;">
            <div class="card-header">
                <?php echo $contractname ?>
            </div>
            <ul class="list-group list-group-flush">
                <p><?php echo "Hours worked" . $contracthours ?></p>
                <p><?php echo "Number of Employees " . $rowNum ?></p>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-sm-6">
                                <?php echo $row['employee_fname'] . $row['employee_lname'] ?>
                            </div>
                            <!--makes it so that this form posts back to itself. Refer to php forms-->
                        </div>
                    </li>
                <?php } ?>


            </ul>


        </div>


    </div>
</div>


</body>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

</html>
