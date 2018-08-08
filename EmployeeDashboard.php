<?php
ob_start();  //begin buffering the output
?>
<html>

<style>
    .contract-type {
        padding-top: 20px;
    }

    .table td {
        text-align: center;
    }
</style>
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
include 'Nav.php';

$connection = DB::getConnection();

$employeeID = $_COOKIE['employeeID'];

// Redirect to login if no employee cookie
if (!$employeeID) {
    header('Location:Login.php');
}

$query = "SELECT * FROM contract INNER JOIN employee ON contract.contract_id = employee.contract_id WHERE employee.employee_id = '$employeeID'";
$contract = DB::getInstance()->getResult($query);

$query = "SELECT * FROM employee WHERE employee_id = '$employeeID'";
$employee = DB::getInstance()->getResult($query);
$managerID = $employee["manager_id"];

$query = "SELECT * FROM employee WHERE employee_id = '$managerID'";
$manager = DB::getInstance()->getResult($query);

function changeContractType($type)
{
    $query = "UPDATE employee SET employee_contract_type = '$type' WHERE employee_id = '$_COOKIE[employeeID]'";
    DB::getInstance()->dbquery($query);
    header("Refresh:0");
}

function changeInsurancePlan($insurance)
{
    $query = "UPDATE employee SET employee_insurance_plan = '$insurance' WHERE employee_id = '$_COOKIE[employeeID]'";
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

if (array_key_exists('Premium-Insurance', $_POST)) {
    changeInsurancePlan('Premium');
}

if (array_key_exists('Silver-Insurance', $_POST)) {
    changeInsurancePlan('Silver');
}

if (array_key_exists('Normal-Insurance', $_POST)) {
    changeInsurancePlan('Normal');
}

ob_flush();
?>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <table class="table">
                <thead class="thead">
                <tr>
                    <th colspan="2" class="text-center"><?php echo $employee["employee_fname"] . "'s " ?> Dashboard</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row">Contract Type</th>
                    <td><?php echo $employee["employee_contract_type"] ?></td>
                </tr>
                <tr>
                    <th scope="row">Current Contract</th>
                    <td>Current
                        Contract: <?php echo $contract["company_name"] . " (" . $contract["contract_type"] . ")" ?></td>
                </tr>
                <tr>
                    <th scope="row">Insurance Plan</th>
                    <td><?php echo $employee["employee_insurance_plan"] ?></td>
                </tr>
                <tr>
                    <th scope="row">Manager</th>
                    <td><?php echo $manager["employee_fname"] . " " . $manager["employee_lname"] ?> </td>
                </tr>
                </tbody>
            </table>

        </div>
    </div>
</div>

<div class="container contract-type">
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
        <div class="card" style="width: 18rem;">
            <div class="card-header">
                Insurance Plan
            </div>
            <form method="post">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        Premium
                        <input type="submit" name="Premium-Insurance" class="btn btn-outline-primary float-right"
                               value="Change"/>
                    </li>
                    <li class="list-group-item">
                        Silver
                        <input type="submit" name="Silver-Insurance" class="btn btn-outline-primary float-right"
                               value="Change"/>
                    </li>
                    <li class="list-group-item">Normal
                        <input type="submit" name="Normal-Insurance" class="btn btn-outline-primary float-right"
                               value="Change"/>
                    </li>
                </ul>
            </form>
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
