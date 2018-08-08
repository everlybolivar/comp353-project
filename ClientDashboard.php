<?php
ob_start();  
?>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <title>Client Dashboard</title>
</head>


<body>

    <?php 
    require 'DB.php';
    $connection = DB::getConnection();

    $clientEmail = $_COOKIE['email'];
    $clientID = $_COOKIE['clientID'];

    if ($clientID != NULL) {
        header('Location:Login.php');
    }

    $sql = "SELECT * FROM contract WHERE email_id = '$clientEmail'";
    $client = DB::getInstance()->getResult($sql);



    $query = "SELECT contract.contract_id, contract.contract_type,
    contract.service_type, contract.acv, contract.service_start_date, 
    contract.service_end_date, employee.employee_fname, employee.employee_lname 
    FROM contract INNER JOIN employee ON contract.responsible_person_id = employee.employee_id 
    WHERE contract.email_id = '$clientEmail' ";
    $result = mysqli_query($connection, $query);


    function getAllContracts() {
        $clientEmail = $_COOKIE['email'];
        $query = "SELECT contract.contract_id, contract.contract_type,
        contract.service_type, contract.acv, contract.service_start_date, 
        contract.service_end_date, employee.employee_fname, employee.employee_lname 
        FROM contract INNER JOIN employee ON contract.responsible_person_id = employee.employee_id 
        WHERE contract.email_id = '$clientEmail' ";
        return $query;
    }

    function getActiveContracts() {
        $clientEmail = $_COOKIE['email'];
        $query = "SELECT contract.contract_id, contract.contract_type,
        contract.service_type, contract.acv, contract.service_start_date, 
        contract.service_end_date, employee.employee_fname, employee.employee_lname 
        FROM contract 
        INNER JOIN employee 
        ON contract.responsible_person_id = employee.employee_id 
        WHERE contract.email_id = '$clientEmail' && contract.service_end_date IS NULL";
        return $query;
    }

    function getExpiredContracts() {
        $clientEmail = $_COOKIE['email'];
        $query = "SELECT contract.contract_id, contract.contract_type,
        contract.service_type, contract.acv, contract.service_start_date, 
        contract.service_end_date, employee.employee_fname, employee.employee_lname 
        FROM contract 
        INNER JOIN employee 
        ON contract.responsible_person_id = employee.employee_id 
        WHERE contract.email_id = '$clientEmail' && contract.service_end_date IS NOT NULL";
        return $query;
    }

    if(isset($_GET['all'])){
        $query = getAllContracts();
        $result = mysqli_query($connection, $query);
    }

    if(isset($_GET['active'])){
        $query = getActiveContracts();
        $result = mysqli_query($connection, $query);
    }

    if(isset($_GET['expired'])){
        $query= getExpiredContracts();
        $result = mysqli_query($connection, $query);
    }

    ob_flush();
    ?>

    <div class="container">
        <div class ="header">
            <h1><?php echo $client["company_name"] ?></h1>
        </div>

        <nav class="navbar navbar-inverse">
          <div class="container-fluid">
            <ul class="nav navbar-nav">
              <li class="active"><a href="ClientDashboard.php">Contracts</a></li>
              <li class="dropdown"><a href="Rating.php">Review Management</a></li>
          </ul>
      </div>
  </nav>

  <div class ="section-container">
    <h4> Here are your contracts </h4>
    <form method="get">
        <input type="submit" class='btn' name="all" value="View All Contracts"/>
        <input type="submit" class='btn' name="active" value="View Active Contracts"/>
        <input type="submit" class='btn' name="expired" value="View Expired Contracts"/>
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
        <th></th>
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
            echo '<td>'; 
            if($row['service_end_date'] == Null) {
                echo "<center>Contract must be completed before review</center>";
            }
            else { 
                echo '<center><a href="rateServices.php?id=' . $row['contract_id'] . '" class="btn" role="button">Rate Service</a></center>'; }
            echo '</td>';
            echo "</tr>";
        }
        echo "</table>"
        ?>       
    </div>
</form>
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