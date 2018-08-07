<?php
ob_start();  
?>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <title>Client Dashboard</title>
    <style>

</style>

</head>


<body>

    <?php 
    require 'DB.php';
    $connection = DB::getConnection();

    $clientEmail = $_COOKIE['email'];


    $query = "SELECT * FROM contract WHERE email_id = '$clientEmail'";
    $client = DB::getInstance()->getResult($query);
    $endDate = $client['service_end_date'];

    $query = "SELECT contract.contract_id, contract.contract_type, 
    contract.service_type, contract.acv, contract.service_start_date, 
    contract.service_end_date, employee.employee_fname, employee.employee_lname 
    FROM contract INNER JOIN employee ON contract.responsible_person_id = employee.employee_id 
    WHERE contract.email_id = '$clientEmail'";
    $result = mysqli_query($connection, $query);

   

    ob_flush();
    ?>

<div class="container">
    <div class ="header">
        <h1><?php echo $client["company_name"] ?></h1>
    </div>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Home</a></li>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Contracts
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="#">Active</a></li>
          <li><a href="#">Terminated</a></li>
          <li><a href="ClientContracts.php">All</a></li>
        </ul>
      </li>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Ratings
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="#">Give Rating</a></li>
          <li><a href="#">View Ratings</a></li>
        </ul>
      </li>
    </ul>
  </div>
</nav>

    <div class ="section-container">
        <h4> Here are your contracts </h4>
        <?php 
        echo "<table class='table table-striped'> 
        <tr>
            <th>Contract ID</th>
            <th>Type of Contract</th>
            <th>Type of Service</th>
            <th>ACV</th>
            <th>Supervising Manager</th>
            <th>Service Start Date</th>
            <th>Service End Date</th>
        </tr>";
        while($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>" . $row['contract_id'] . "</td>";
            echo "<td>" . $row['contract_type'] . "</td>";
            echo "<td>" . $row['service_type'] . "</td>";
            echo "<td>" . $row['acv'] . "</td>";
            echo "<td>" . $row['employee_fname'] . " " . $row['employee_lname'] . "</td>";
            echo "<td>" . $row['service_start_date'] . '</td>';
            echo "<td>" . $row['service_end_date'] . "</td>";
            echo "</tr>";
        }
        echo "</table>"
         ?>       
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