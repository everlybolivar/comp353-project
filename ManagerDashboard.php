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
include 'Nav.php';
//validation

$connection = DB::getConnection();

$employeeID= $_COOKIE['employeeID'];

// Redirect to login if no employee cookie
if (!$employeeID) {
    header('Location:Login.php');
}

//read user email
$email = $_COOKIE['email'];

if (isset($_POST['filter'])) {
    $filter = $_POST['filter'];
    $connection = DB::getConnection();
    if ($connection->connect_error) {
        die("error failure" . $connection->connect_error);
    } else {
        if ($filter != 'All') {
            //find  contracts name and id
            $sql1 = $connection->prepare("SELECT contract.company_name,contract.contract_id,contract.service_start_date,contract.service_end_date,contract.responsible_person_id,employee.employee_fname,employee.employee_lname FROM users INNER JOIN contract ON contract.responsible_person_id = users.employee_id INNER JOIN employee ON employee.employee_id = contract.responsible_person_id WHERE users.email = ? && contract.contract_type = ? ORDER BY service_start_date ASC");
            //bind params bind the email question mark. Refer to SQL prepared statements;
            $sql1->bind_param("ss", $email, $filter);
            $sql1->execute();
            $resultContract = $sql1->get_result();
            $sql1->fetch();
            $sql1->close();
        } else {
            //find  contracts name and id
            $sql1 = $connection->prepare("SELECT contract.company_name,contract.contract_id,contract.service_start_date,contract.service_end_date,contract.responsible_person_id,employee.employee_fname,employee.employee_lname FROM users INNER JOIN contract ON contract.responsible_person_id = users.employee_id INNER JOIN employee ON employee.employee_id = contract.responsible_person_id WHERE users.email = ? ORDER BY service_start_date ASC");
            //bind params bind the email question mark. Refer to SQL prepared statements;
            $sql1->bind_param("s", $email);
            $sql1->execute();
            $resultContract = $sql1->get_result();
            $sql1->fetch();
            $sql1->close();
        }
    }

} else {
    $connection = DB::getConnection();
    if ($connection->connect_error) {
        die("error failure" . $connection->connect_error);
    } else {

        //find  contracts name and id
        $sql1 = $connection->prepare("SELECT contract.company_name,contract.contract_id,contract.service_start_date,contract.service_end_date,contract.responsible_person_id,employee.employee_fname,employee.employee_lname FROM users INNER JOIN contract ON contract.responsible_person_id = users.employee_id INNER JOIN employee ON employee.employee_id = contract.responsible_person_id WHERE users.email = ? ORDER BY service_start_date ASC");
        //bind params bind the email question mark. Refer to SQL prepared statements;
        $sql1->bind_param("s", $email);
        $sql1->execute();
        $resultContract = $sql1->get_result();
        $sql1->fetch();
        $sql1->close();
    }
}


ob_flush();

?>

<div id="content">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <div class="row">
                <div class="col-sm-2">
                    <select name="filter">
                        <option value="All">ALL</option>
                        <option value="Diamond">DIAMOND</option>
                        <option value="Premium">PREMIUM</option>
                        <option value="Gold">GOLD</option>
                        <option value="Silver">SILVER</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <button type="submit" class="btn btn-primary"> Sort</button>
                </div>
            </div>

        </div>
    </form>
    <div class="form-group">

        <table class="table table-bordered">
            <thead>
            <tr>
                <th scope="col">Contract ID</th>
                <th scope="col">Contract Name</th>
                <th scope="col">Contract manager</th>
                <th scope="col">Contract start date</th>
                <th scope="col">Contract end date</th>

                <th scope="col"></th>

            </tr>
            </thead>
            <tbody>
            <?php while ($row = $resultContract->fetch_assoc()) { ?>
                <?php if (strtotime($row['service_end_date']) < time() - (60 * 60 * 24)) { ?>
                    <tr class="table-danger">
                        <th scope="row"><?php echo $row['contract_id'] ?></th>
                        <td><?php echo $row['company_name'] ?></td>
                        <td><?php echo $row['employee_fname'] . " " . $row['employee_lname'] ?></td>
                        <td><?php echo $row['service_start_date'] ?></td>
                        <td><?php echo $row['service_end_date'] ?></td>

                        <td><a href="ManagerContract.php?id=<?php echo $row['contract_id']; ?>">Edit</a></td>

                    </tr>
                <?php } else { ?>
                    <tr class="table-success">
                        <th scope="row"><?php echo $row['contract_id'] ?></th>
                        <td><?php echo $row['company_name'] ?></td>
                        <td><?php echo $row['employee_fname'] . " " . $row['employee_lname'] ?></td>
                        <td><?php echo $row['service_start_date'] ?></td>
                        <td><?php echo $row['service_end_date'] ?></td>
                        <td><a href="ManagerContract.php?id=<?php echo $row['contract_id']; ?>">Edit</a></td>
                        <td><a href="ManagerReport.php?id=<?php echo $row['contract_id']; ?>">View Details</a></td>

                    </tr>
                <?php } ?>


            <?php } ?>

            </tbody>
        </table>

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

