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

$connection = DB::getConnection();
$query = "SELECT e.employee_id, e.employee_fname, e.employee_lname, e.employee_contract_type, e.employee_insurance_plan, 
contract.province, manager.employee_fname as manager_first_name, manager.employee_lname as manager_last_name, d.department_name
FROM employee as e INNER JOIN contract ON e.contract_id = contract.contract_id 
INNER JOIN employee as manager ON e.manager_id = manager.employee_id
INNER JOIN department as d ON e.department_id = d.department_id
WHERE province = 'Quebec'";

$result = DB::getConnection()->query($query);

?>
<div class="w3-display-topleft">
    <a href="#"
       class="btn btn-primary btn-lg active"
       role="button"
       aria-pressed="true"
       onClick="document.location.href='Reports.php'">Back to Reports</a>
</div>

<div class="container">
    <div class="row">
        <div style='width:20%; margin:0 auto;' class='card-body'>
            <h2 class='card-title'>Quebec Employee Details</h2>
        </div>
        <div style='padding-left:20px ;'>
            <table class='table table-striped'>
                <tr>
                    <th>Employee ID</th>
                    <th>Employee Name</th>
                    <th>Employee Contract Type</th>
                    <th>Employee Insurance Plan</th>
                    <th>Supervising Manager</th>
                    <th>Department</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['employee_id'] . "</td>";
                    echo "<td>" . $row['employee_fname'] ." ". $row['employee_lname'] . "</td>";
                    echo "<td>" . $row['employee_contract_type'] . "</td>";
                    echo "<td>" . $row['employee_insurance_plan'] . "</td>";
                    echo "<td>" . $row['manager_first_name'] . " " . $row['manager_last_name'] . '</td>';
                    echo "<td>" . $row['department_name'] . "</td>";
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

