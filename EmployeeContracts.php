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

</head>


<body class="text-center">

<?php
require 'DB.php';
include 'Nav.php';

$connection = DB::getConnection();
$employeeID = $_COOKIE['employeeID'];

if (!$employeeID) {
    header('Location:Login.php');
}

function getCurrentContract()
{
    $query = "SELECT * FROM contract INNER JOIN employee ON contract.contract_id = employee.contract_id 
              WHERE employee.employee_id = '$_COOKIE[employeeID]'";
    return DB::getInstance()->getResult($query);
}

function getEmployee()
{
    $query = "SELECT * FROM employee WHERE employee_id = '$_COOKIE[employeeID]'";
    return DB::getInstance()->getResult($query);
}


$query = "SELECT *, tasks.contract_id as task_contract_id FROM tasks INNER JOIN contract ON tasks.contract_id = contract.contract_id 
          INNER JOIN employee ON contract.responsible_person_id = employee.employee_id
              WHERE tasks.employee_id = $_COOKIE[employeeID]";
$result = DB::getConnection()->query($query); // All contracts that employee has worked on

ob_flush();
?>

<div class="container">
    <div class="row">
        <div style='width:20%; margin:0 auto;' class='card-body'>
            <h2 class='card-title'><?php echo getEmployee()['employee_fname'] . " " . getEmployee()['employee_lname'] ?>
                's Contracts</h2>
        </div>
        <div style='padding-left:20px ;'>
            <table class='table table-striped'>
                <tr>
                    <th>Contract ID</th>
                    <th>Type of Contract</th>
                    <th>Type of Service</th>
                    <th>Supervising Manager</th>
                    <th>Service Start Date</th>
                    <th>Service End Date</th>
                    <th>Hours Worked</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['task_contract_id'] . "</td>";
                    echo "<td>" . $row['contract_type'] . "</td>";
                    echo "<td>" . $row['service_type'] . "</td>";
                    echo "<td>" . $row['employee_fname'] . " ". $row['employee_lname'] . "</td>";
                    echo "<td>" . $row['service_start_date'] . '</td>';
                    echo "<td>" . $row['service_end_date'] . "</td>";
                    echo "<td>" . $row["hours"] . "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
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

