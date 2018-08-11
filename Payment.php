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

    if (!$contractID) {
        header('Location:ClientDashboard.php');
    }

    $amt = $_POST['amt'];
    $date = DATE("Y-m-d");
    $query = "INSERT INTO payment (contract_id, amount, payee, payment_date)
    VALUES ('$contractID', '$amt', '$company', '$date')";

    $confirmation = FALSE;
    $fail = FALSE;
    if (isset($_POST['submit_pay'])) {
        if ($connection->query($query) === TRUE) {
            $confirmation = TRUE ;
        } else {
            $fail = TRUE;
        }
    }


    function getBalance() {
        $contractID = $_GET['id'];
        $sql2 = "SELECT acv+initial_cost FROM contract AS totalcost WHERE contract_id = '$contractID'";
        $contract = DB::getInstance()->getResult($sql2);
        $totalcost = $contract['acv+initial_cost'];

        $sql3 = "SELECT SUM(amount) from payment WHERE contract_id = '$contractID'";
        $payment = DB::getInstance()->getResult($sql3);
        $amtpaid = $payment['SUM(amount)'];

        $balance = $totalcost - $amtpaid;
        return $balance;
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
              <li class="active"><a href="ClientDashboard.php">Contracts</a></li>
              <li class="dropdown"><a href="Rating.php">Management Review</a></li>
          </ul>
      </div>
  </nav>

  <div class ="section-container">
    <h2>Contract Payments</h2>
    <form method="POST" class="form-inline">
        <?php
        echo '<div class="container-fluid">';
        if (getBalance() <= 0) {
            echo '<p> You have already paid off this contract. </p>';
        } else {
            echo '<p> You have a remaining balance of $' . getBalance() . ' for contract ' . $contractID . '.';
            echo '
            <div class="form-group">
            <label for="amount">Amount to pay: </label>
            <input type="number" min="0" step="0.1" class="form-control" name="amt" placeholder="Enter Amount">
            <p><br><input type="submit" class="btn btn-default" name="submit_pay" value="Submit Payment"/></p>
            </div>';
            if ($fail) {
                echo '<div class="alert alert-danger" role="alert">
                Problem with payment.
                </div>';
            }
        }
        if ($confirmation){
            echo '<div class="alert alert-success">
                <strong>Success!</strong> Payment confirmed.
                </div>';
        }
        echo '</div>';
        ?>
    </form>
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