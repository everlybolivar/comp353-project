<?php
include 'DB.php';


$admin= $_COOKIE['admin'];

// Redirect to login if no employee cookie
if (!$admin) {
    header('Location:../Login.php');
}

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
    <h2 class='card-title'>Average of days for the First Deliverable for each month in the 2017</h2>
</div>
<div style='padding-left:20px ;width: 50%;margin: 0 auto;'>
    <table class='table table-bordered' >
        <thead class='thread-light>'>
        <tr>
            <th scope='col' >Contract Number</th>
            <th scope='col' >Amount</th>
            <th scope='col' >Payee</th>
            <th scope='col' >Payment Date</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $connection = DB::getConnection();

        for($i = 0; $i<12; $i++)
        {
            $query = "	SELECT contract_id, amount, payee, payment_date FROM payment;";

            $result = mysqli_query($connection, $query);

            // display data in table

            // loop through results of database query, displaying them in the table
            while($row = mysqli_fetch_array( $result )) {
                // echo out the contents of each row into a table
                echo "<tr>";
                echo '<td>' . $row['contract_id'] . '#</td>';
                echo '<td>' . $row['amount']. '$</td>';
                echo '<td>' . $row['payee'] . '</td>';
                echo '<td>' . $row['payment_date'] . '</td>';
                echo "</tr>";
            }
        }
        $connection->close();
        ?>

        </tbody>
    </table>
</body>
</html>