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

    <style>

        .sidebar {
            width: 250px;
            background-color: #7386D5;
            height: 100%;
            position: fixed;
            float: left;
            z-index: 2;
            top: 0px;
            left: 0px;
        }

        .lielement a {
            diplay: block;
            font-family: 'Poppins', sans-serif;
            color: #fff;
            font-size: 1.1em;
            font-weight: 300;
            line-height: 1.7em;
            margin: 10px;
            padding: 10px;
            font-weight: 400;
            text-decoration: none !important;
        }

        .title {
            margin-top: 10px;
            font-size: 2.1em;
            font-family: 'Poppins', sans-serif;
            line-height: 1.7em;
            font-weight: 300;
            text-align: center;
            color: #fff;
        }

        #content {
            margin-top: 25px;
            margin-left: 25%;
        }

    </style>

</head>


<body>
<!---->
<?php
require 'DB.php';
//validation

$connection = DB::getConnection();

if ($connection->connect_error) {
    die("error failure" . $connection->connect_error);
} else {
    $sql = $connection->prepare("SELECT employee.employee_id,employee.employee_fname,employee.employee_lname,contract.contract_id,contract.company_name 
                                     FROM users 
                                     INNER JOIN contract ON contract.responsible_person_id = users.employee_id 
                                     INNER JOIN employee ON employee.manager_id = contract.responsible_person_id 
                                     WHERE users.email = ?");
    $sql->bind_param("s", $email);
    $sql->execute();
    $result = $sql->get_result();
    while ($row = $result->fetch_assoc()) {
        echo $row['employee_fname'];
    }

}
ob_flush();

?>

<!---->
<!--<div class="sidebar"></div>-->
<!---->
<!---->
<!--<form method="post" action="--><?php //echo htmlspecialchars($_SERVER["PHP_SELF"]); ?><!--">-->
<!--    <div class="sidebar">-->
<!--        <div class="title">CMS</div>-->
<!--        <div class="lielement"> <a>test</a></div>-->
<!--        <div class="lielement"><a>test2</a></div>-->
<!---->
<!--    </div>-->
<!--    <div id ="content">-->
<!--        <div class="form-group">-->
<!--            <label for="email">Login Email:</label>-->
<!--            <input type="email" , name="email" id="email" placeholder="Enter Email">-->
<!--        </div>-->
<!--    </div>-->
<!---->
<!---->
<!--</form>-->


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
