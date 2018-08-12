<?php
include 'DB.php';
ob_start();

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
    <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css" integrity="sha384-nn4HPE8lTHyVtfCBi5yW9d20FjT8BJwUXyWZT9InLYax14RDjBj46LmSztkmNP9w" crossorigin="anonymous">
    <style>
        .center-div
        {
            margin: auto;
            width: 500px;
        }
        .header-div
        {
            margin: auto;
            width: 50%;
        }
        .button-div
        {
            margin: 0 auto;
            width: 50%;
        }
    </style>
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
    <h2 class='card-title'> Number of employees with Premium Employee plan with working hours less than 60 hrs/month. </h2>
</div>

<div class="center-div">
    <form id="edit" class="pure-form pure-form-aligned" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <fieldset>
            <div class="pure-control-group">
                <select class="form-control" style="width: 30%" name="year" >
                    <option selected="selected"><?php echo $_POST['year'];?></option>
                    <option value="2015">2015</option>
                    <option value="2016">2016</option>
                    <option value="2017">2017</option>
                    <option value="2018">2018</option>
                </select>
            </div>
            <div class="pure-control-group">
                <button type="submit" name="submitButton" class="pure-button pure-button-primary">Check</button>
            </div>
        </fieldset>
    </form>
</div>

<div style='padding-left:20px ;width: 50%;margin: 0 auto;'>
    <table class='table table-bordered' >
        <thead class='thread-light>'>
        <tr>
            <th scope='col' >Employee Name</th>
            <th scope='col' >Employee Assurance Plan </th>
            <th scope='col' >Year</th>
            <th scope='col' >Hours per Month</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $connection = DB::getConnection();

        if(empty($_POST['year'])){
            $year = 2017;
        }else{
            $year = (int)$_POST['year'];
        }

        $query = "SELECT 
                    t.employee_id,
                    ROUND(SUM(t.hours)/12, 0) AS 'HoursPMonth',
                    CONCAT(e.employee_fname, ' ', e.employee_lname) AS 'Name',
                    e.employee_insurance_plan AS 'Assurance',
                    YEAR(first_deliverable) AS 'Year'
                FROM
                    tasks AS t
                        INNER JOIN
                    employee AS e ON t.employee_id = e.employee_id
                        INNER JOIN
                    contract AS c ON t.contract_id = c.contract_id
                WHERE
                    e.employee_insurance_plan = 'Premium' AND
                    YEAR(c.service_end_date) = '$year'
                GROUP BY t.employee_id
                HAVING (SUM(t.hours) / 12) < 60";

        $result = mysqli_query($connection, $query);

        if (isset($_POST['submitButton'])) {
            // echo $query;
        }


        // loop through results of database query, displaying them in the table
        while($row = mysqli_fetch_array( $result ))
        {
            // echo out the contents of each row into a table
            echo "<tr>";
            echo '<td>' . $row['Name'] . '</td>';
            echo '<td>' . $row['Assurance'] . '</td>';
            echo '<td>' . $row['Year'] . '</td>';
            echo '<td>' . $row['HoursPMonth'] . '</td>';
            echo "</tr>";
        }

        $connection->close();
        ?>

        </tbody>
    </table>
</body>
</html>