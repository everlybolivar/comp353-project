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
    <link href="css/employeeDashboard.css" rel="stylesheet">
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

function getContract()
{
    $query = "SELECT * FROM contract INNER JOIN employee ON contract.contract_id = employee.contract_id 
              WHERE employee.employee_id = '$_COOKIE[employeeID]'";
    return DB::getInstance()->getResult($query);
}

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

function logHours($hours)
{
    $contract = getContract();
    if ($contract) {
        $queryCurrentHours = "SELECT hours FROM taskHours WHERE employee_id = '$_COOKIE[employeeID]' 
                              AND contract_id = '$contract[contract_id]'";
        echo $queryCurrentHours;
//        $result = DB::getInstance()->getResult($queryCurrentHours);
//        $currentHours = $result['hours'];

//        $newHours = $currentHours + $hours;
        $newHours = 65;

        $query = "UPDATE taskHours SET hours = $newHours WHERE employee_id = '$_COOKIE[employeeID]' 
                  AND contract_id = '$contract[contract_id]'";
        echo $query;
    }

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

if (array_key_exists('log', $_POST)) {
   logHours($_POST['hours']);
}

if (array_key_exists('view-contract', $_POST)) {
    header('Location:EmployeeContracts.php');

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
                    <th scope="row">Contract Type Preference</th>
                    <td><?php echo $employee["employee_contract_type"] ?></td>
                </tr>
                <tr>
                    <th scope="row">Current Contract</th>
                    <td><?php echo getContract()["company_name"] . " (" . getContract()["contract_type"] . ")" ?></td>
                </tr>
                <tr>
                    <th scope="row">Hours</th>
                    <td>30</td>
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

    <div class="row">
        <form class="form-inline" method="post">
            <div class="form-group mx-sm-3 mb-2">
                <label for="hours" class="sr-only">Hours</label>
                <input type="number" min="0" step="0.1" class="form-control" name="hours" placeholder="Log additional hours"/>
            </div>
            <button type="submit" name="log" class="btn btn-primary mb-2">Log</button>
            <button type="submit" name="view-contract" class="btn btn-info mb-2 view-contract">View Contracts</button>

        </form>

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
