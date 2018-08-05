<?php
ob_start();  //begin buffering the output
?>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Contract CMS</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>


<body>

<?php
require 'DB.php';

$connection = DB::getConnection();

$employeeID = $_COOKIE['employeeID'];

// Redirect to login if no employee cookie
if (!$employeeID) {
    header('Location:Login.php');
}

$query = "SELECT * FROM contract INNER JOIN employee ON contract.contract_id = employee.contract_id WHERE employee.employee_id = " . $employeeID . ";";
$contract = DB::getInstance()->getResult($query);

$query = "SELECT * FROM employee WHERE employee_id = " . $employeeID . ";";
$employee = DB::getInstance()->getResult($query);
$managerID = $employee["manager_id"];

$query = "SELECT * FROM employee WHERE employee_id = " . $managerID . ";";
$manager = DB::getInstance()->getResult($query);

function changeContractType($type)
{
    $query = "UPDATE employee SET employee_contract_type = '" . $type . "' WHERE employee_id = " . $_COOKIE['employeeID'] . ";";
    DB::getInstance()->dbquery($query);
    header("Refresh:0");
}

if (array_key_exists('Premium', $_POST)) {
    changeContractType('Premium');
}

if (array_key_exists('Diamond', $_POST)) {
    changeContractType('Diamond');
}

if (array_key_exists('Gold', $_POST)) {
    changeContractType('Gold');
}

if (array_key_exists('Silver', $_POST)) {
    changeContractType('Silver');
}

ob_flush();
?>

<div class="container col-centered">
    <div class="col-md-6 offset-md-4">
        <div class="row">
            <h2><?php echo $employee["employee_fname"] . "'s " ?> Dashboard</h2>
        </div>
        <div class="row">
            <h6>Contract Type: <?php echo $employee["employee_contract_type"] ?></h6>
        </div>
        <div class="row">
            <h6>Current Contract: <?php echo $contract["company_name"] . " (" . $contract["contract_type"] . ")" ?></h6>
        </div>
        <div class="row">
            <h6>Manager: <?php echo $manager["employee_fname"] . " " . $manager["employee_lname"] ?></h6>
        </div>
        <div class="row">
            <div class="card" style="width: 18rem;">
                <div class="card-header">
                    Contract Types
                </div>
                <form method="post">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            Premium
                            <input type="submit" name="Premium" class="btn btn-outline-primary float-right"
                                   value="Request"/>
                        </li>
                        <li class="list-group-item">
                            Gold
                            <input type="submit" name="Gold" class="btn btn-outline-primary float-right"
                                   value="Request"/>
                        </li>
                        <li class="list-group-item">Diamond
                            <input type="submit" name="Diamond" class="btn btn-outline-primary float-right"
                                   value="Request"/>
                        </li>
                        <li class="list-group-item">Silver
                            <input type="submit" name="Silver" class="btn btn-outline-primary float-right"
                                   value="Request"/>
                        </li>
                    </ul>
                </form>
            </div>
        </div>
    </div>
</div>


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
