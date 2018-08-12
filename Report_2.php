<?php
include 'DB.php';

/*
$admin= $_COOKIE['admin'];

// Redirect to login if no employee cookie
if (!$admin) {
    header('Location:../Login.php');
}
*/
?>



<!DOCTYPE html>

<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body>
<div class="w3-display-topleft">
    <a href="#"
       class="btn btn-primary btn-lg active"
       role="button"
       aria-pressed="true"
       onClick="document.location.href='Reports.php'">Back to Reports</a>
</div>

<div style='width:55%; margin:0 auto;' class='card-body'>
    <h2 class='card-title'>Number of Premium contracts delivered in more than 10 business days having more than 35 employees with “Silver Employee Plan. </h2>
</div>
<div style='padding-left:20px ;width: 50%;margin: 0 auto;'>
    <table class='table table-bordered' >
        <thead class='thread-light>'>
        <tr>
            <th scope='col' >Contract Number</th>
            <th scope='col' >Company Name</th>
            <th scope='col' >Contract Type</th>
            <th scope='col' >Start Date</th>
            <th scope='col' >End Date</th>
            <th scope='col' ># Silver Employees</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $connection = DB::getConnection();

        $query = "
            SELECT result.id,
                  result.start_date,
                  result.end_date,
                  result.contract_type,
                  result.emp_count,
                  result.company_name     
            FROM (
                SELECT 
                    contract.contract_id AS id,
                    contract.service_start_date AS start_date,
                    contract.service_end_date AS end_date,
                    contract.contract_type AS contract_type,
                    COUNT(*) AS emp_count,
                    contract.company_name AS company_name                   
                FROM
                    employee
                        INNER JOIN
                    contract ON employee.contract_id = contract.contract_id
                WHERE employee.employee_insurance_plan = 'Silver'
                GROUP BY id
                HAVING COUNT(*) > 35) AS result
                WHERE result.contract_type = 'Premium' AND datediff(result.end_date, result.start_date) > 10";

        $result = mysqli_query($connection, $query);

        // display data in table

        // loop through results of database query, displaying them in the table
        while($row = mysqli_fetch_array( $result )) {
            // echo out the contents of each row into a table
            echo "<tr>";
            echo '<td>' . $row['id'] . '</td>';
            echo '<td>' . $row['company_name'] . '</td>';
            echo '<td>' . $row['contract_type'] . '</td>';
            echo '<td>' . $row['start_date'] . '</td>';
            echo '<td>' . $row['end_date'] . '</td>';
            echo '<td>' . $row['emp_count'] . '</td>';

            echo "</tr>";
        }

        $connection->close();
        ?>

        </tbody>
    </table>
</body>
</html>