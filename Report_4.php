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

$query = "SELECT company_name, service_type, MAX(counted) FROM
(
    SELECT company_name, service_type, COUNT(company_name) AS counted
    FROM contract
    GROUP BY company_name, service_type
) AS counts group by service_type";

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
            <h2 class='card-title'>Clients who have the highest number of contracts in each line of business</h2>
        </div>
        <div style='padding-left:20px ;'>
            <table class='table table-striped'>
                <tr>
                    <th>Client</th>
                    <th>Line of Business</th>
                    <th>Number of Contracts</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['company_name'] . "</td>";
                    echo "<td>" . $row['service_type'] . "</td>";
                    echo "<td>" . $row['MAX(counted)'] . "</td>";
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

