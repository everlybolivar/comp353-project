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

    if (!$clientID) {
        header('Location:Login.php');
    }

    $sql = "SELECT * FROM contract WHERE email_id = '$clientEmail'";
    $client = DB::getInstance()->getResult($sql);
    $company = $client["company_name"];

    $contractID = $_GET['id'];
    $sql2 = "SELECT * FROM contract WHERE contract_id = '$contractID'";
    $contract = DB::getInstance()->getResult($sql2);

    $managerID = $contract["responsible_person_id"]; 
    $sql3 = "SELECT employee_fname, employee_lname FROM employee WHERE employee_id = '$managerID'";
    $manager = DB::getInstance()->getResult($sql3);

    $clientrate = $_POST['rating'];
    $query = "INSERT INTO ratings (contract_worked, manager_rated, rate)
    VALUES ($contractID, $managerID, $clientrate)";

    $confirmation = true;
    if (isset($_POST['submit_rating'] ) ) {
        if ($connection->query($query) === FALSE) {
            $confirmation = false ;
        } else {
            echo "Problem with rating.";
        }
    } 

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
              <li class="active"><a href="Rating.php">Management Review</a></li>
          </ul>
      </div>
  </nav>

  <div class ="section-container">
     <h2>Rate Services</h2>  
     <p> 
        You are rating <?php echo $manager['employee_fname'] . " " . $manager['employee_lname'] ?>'s Services for the work done on contract <?php echo $contractID ?>. 
        <br><br>
        <h4>Please select a rating between 1 (lowest) to 10 (highest).</h4>
        <form method = "POST">
            <label class="radio-inline"><input type="radio" name="rating" value="1">1</label>
            <label class="radio-inline"><input type="radio" name="rating" value="2">2</label>
            <label class="radio-inline"><input type="radio" name="rating" value="3">3</label>
            <label class="radio-inline"><input type="radio" name="rating" value="4">4</label>
            <label class="radio-inline"><input type="radio" name="rating" value="5">5</label>
            <label class="radio-inline"><input type="radio" name="rating" value="6">6</label>
            <label class="radio-inline"><input type="radio" name="rating" value="7">7</label>
            <label class="radio-inline"><input type="radio" name="rating" value="8">8</label>
            <label class="radio-inline"><input type="radio" name="rating" value="9">9</label>
            <label class="radio-inline"><input type="radio" name="rating" value="10">10</label>
            <p><br><input type="submit" class='btn btn-default' name="submit_rating" value="Submit Rating"/></p>
            <?php if (!$confirmation): ?>
                <div class="alert alert-danger" role="alert">
                    You have already reviewed this service.
                </div>
            <?php endif; ?>
        </form>
    </p>
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