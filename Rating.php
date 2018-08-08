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

    if (!$clientEmail) {
        header('Location:Login.php');
    }

    $sql = "SELECT * FROM contract WHERE email_id = '$clientEmail'";
    $client = DB::getInstance()->getResult($sql);
    $company = $client["company_name"];

    $query = "SELECT contract.contract_id, contract.responsible_person_id,
    employee.employee_fname, employee.employee_lname, 
    ratings.rate 
    FROM (( employee INNER JOIN ratings ON employee.employee_id = ratings.manager_rated) 
    INNER JOIN contract ON ratings.contract_worked = contract.contract_id) 
    WHERE contract.company_name = '$company' ";
    $result = mysqli_query($connection, $query);

    ob_flush();
    ?>

    <div class="container">
        <div class ="header">
            <h1><?php echo $company ?></h1>
        </div>

        <nav class="navbar navbar-inverse">
          <div class="container-fluid">
            <ul class="nav navbar-nav">
              <li class="dropdown"><a href="ClientDashboard.php">Contracts</a></li>
              <li class="active"><a href="Rating.php">Review Management</a></li>
          </ul>
      </div>
  </nav>

  <div class ="section-container">
     <h2> Supervising Management Ratings </h2>
           <?php 
            
        echo "<table class='table table-striped'> 
        <tr>
        <th>Contract ID</th>
        <th>Supervising Manager</th>
        <th>Rating</th>
        <th></th>
        </tr>";
        while($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>" . $row['contract_id'] . "</td>";
            echo "<td>" . $row['employee_fname'] . " " . $row['employee_lname'] . "</td>";
            echo "<td>" . $row['rate'] . '</td>';
            echo '<td><a href="viewRating.php?id=' . $row['responsible_person_id'] . '" class="btn" role="button">More Contract Ratings</a></td>';
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