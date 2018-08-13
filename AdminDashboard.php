<?php
ob_start();  //begin buffering the output
?>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Admin Dashboard</title>
    <style>

    </style>

</head>


<body>
<div class="w3-display-topleft">
    <a href="#"
       class="btn btn-primary btn-lg active"
       role="button"
       aria-pressed="true"
       onClick="document.location.href='Reports.php'">Back to Reports</a>
</div>

<?php
include 'DB.php';
$connection = DB::getConnection();

$admin= $_COOKIE['admin'];

// Redirect to login if no employee cookie
if (!$admin) {
    header('Location:../Login.php');
}

$connection = DB::getConnection();
$query = "SELECT contract.contract_id,
        contract.company_name,
        contract.service_type,
        contract.contract_type,
        contract.service_start_date,    
        contract.first_deliverable,    
        contract.second_deliverable,    
        contract.third_deliverable,    
        contract.fourth_deliverable,    
        contract.service_end_date,    
        contract.acv,
        contract.initial_cost,
        employee.employee_fname,
        employee.employee_lname,
        contract.contact_number,
        contract.email_id,   
        contract.address,
        contract.city,
        contract.province,
        contract.postal_code
    FROM contract
    INNER JOIN employee ON contract.responsible_person_id = employee.employee_id
    ORDER BY contract.contract_id";

$result = mysqli_query($connection, $query);

// display data in table
echo "<div style='width:20%; margin:0 auto;' class='card-body'>
            <h2 class='card-title'>All Contracts</h2>
        </div>
        <div style='padding-left:20px ;'>
        <table class='table table-bordered' >
        <thead class='thread-light>'
         <tr> <th scope='col'>Contract Number</th> 
               <th scope='col'>Company Name</th> 
               <th scope='col'>Service Type</th> 
               <th scope='col'>Contract Type</th> 
               <th scope='col'>Service Start Date</th>
               <th scope='col'>First Deliverable</th>
               <th scope='col'>Second Deliverable</th>
               <th scope='col'>Third Deliverable</th>
               <th scope='col'>Fourth Deliverable</th>
               <th scope='col'>Service End Date</th>
               <th scope='col'>ACV</th> 
               <th scope='col'>Initial Cost</th> 
               <th scope='col'>Responsible Person Name</th> 
               <th scope='col'>Contract Number</th> 
               <th scope='col'>Email</th> 
               <th scope='col'>Address</th> 
               <th scope='col'>City</th> 
               <th scope='col'>Province</th> 
               <th scope='col'>Postal Code</th>   
                           
           </tr>
            </thead>  ";
// loop through results of database query, displaying them in the table
while($row = mysqli_fetch_array( $result )) {
    // echo out the contents of each row into a table
    echo "<tr>";
    echo '<td>' . $row['contract_id'] . '</td>';
    echo '<td>' . $row['company_name'] . '</td>';
    echo '<td>' . $row['service_type'] . '</td>';
    echo '<td>' . $row['contract_type'] . '</td>';
    echo '<td>' . $row['service_start_date'] . '</td>';
    echo '<td>' . $row['first_deliverable'] . '</td>';
    echo '<td>' . $row['second_deliverable'] . '</td>';
    echo '<td>' . $row['third_deliverable'] . '</td>';
    echo '<td>' . $row['fourth_deliverable'] . '</td>';
    echo '<td>' . $row['service_end_date'] . '</td>';
    echo '<td>' . $row['acv'] . '$</td>';
    echo '<td>' . $row['initial_cost'] . '$</td>';
    echo '<td>' . $row['employee_fname'] .' '.$row['employee_lname'] . '</td>';
    echo '<td>' . $row['contact_number'] . '</td>';
    echo '<td>' . $row['email_id'] . '</td>';
    echo '<td>' . $row['address'] . '</td>';
    echo '<td>' . $row['city'] . '</td>';
    echo '<td>' . $row['province'] . '</td>';
    echo '<td>' . $row['postal_code'] . '</td>';
    echo '<td><a href="edit.php?id=' . $row['contract_id'] . '" class="btn btn-info" role="button">Edit</a></td>';
    echo '<td><a href="delete.php?id=' . $row['contract_id'] . '" class="btn btn-danger" role="button">Delete</a></td>';
    echo "</tr>";
}
echo "</table></div>";

$connection->close();

?>



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

<?php ob_end_flush();?>