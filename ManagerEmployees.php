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
//read user email
$email = $_COOKIE['email'];
$host = 'ddc353.encs.concordia.ca';
$username = 'ddc353_1';
$password = '353DBpro';
$db = 'ddc353_1';
$db_port = '3306';

$connection = mysqli_connect($host, $username, $password, $db, $db_port);
if ($connection->connect_error) {
    die("error failure" . $connection->connect_error);
} else {

    //find  contracts name and id
    $sql2 = $connection->prepare("SELECT * FROM tasks");
    //bind params bind the email question mark. Refer to SQL prepared statements;
    $sql2->execute();
    $dropdown = $sql2->get_result();
    $sql2->fetch();
    $sql2->close();



    $sql1 = $connection->prepare("SELECT employee.employee_fname,employee.employee_lname,employee.employee_id,task_id FROM employee INNER JOIN users ON users.employee_id = employee.manager_id WHERE users.email =?");
    //bind params bind the email question mark. Refer to SQL prepared statements;
    $sql1->bind_param("s", $email);
    $sql1->execute();
    $resultUser= $sql1->get_result();
    $sql1->fetch();
    $sql1->close();




}


if (isset($_POST['taskID']) && isset($_POST['eid'])) {
    $tid = $_POST['taskID'];
    $eid = $_POST['eid'];
    $host = 'ddc353.encs.concordia.ca';
    $username = 'ddc353_1';
    $password = '353DBpro';
    $db = 'ddc353_1';
    $db_port = '3306';

    $connection = mysqli_connect($host, $username, $password, $db, $db_port);

    if ($connection->connect_error) {
        die("error failure" . $connection->connect_error);
    } else {
        $sql3 = $connection->prepare("UPDATE employee SET employee.task_id  = ? where employee_id = ?");
        $sql3->bind_param("ss",$tid,$eid);
        $sql3->execute();
        $sql3->close();
    }

    if (isset($_GET['id'])) {
        $cid = $_GET['id'];
    }

    Header('Location: ' . $_SERVER['PHP_SELF']);
    Exit();


}

ob_flush();

?>


<!--<div class="sidebar">-->
<!--    <div class="title">CMS</div>-->
<!--    <div class="lielement"> <a>test</a></div>-->
<!--    <div class="lielement"><a>test2</a></div>-->
<!---->
<!--</div>-->
<div id="content">
    <div class="form-group">

        <table class="table table-bordered">
            <thead>
            <tr>
                <th scope="col">Employee ID</th>
                <th scope="col">Employee Name</th>
                <th scope="col">Employee Task</th>
                <th scope="col"></th>



            </tr>
            </thead>
            <tbody>
            <?php while ($row = $resultUser->fetch_assoc()) { ?>
                <tr>
                    <th scope="row"><?php echo $row['employee_id']?></th>
                    <td><?php echo $row['employee_fname'] . " " . $row['employee_lname']?></td>
                    <td><?php echo $row['task_id']?></td>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <td>
                        <input type='hidden' name='eid' value= <?php echo $row['employee_id'] ?>>
                        <select name="taskID">


                            <option value="Set up infrastructure for client">Set up infrastructure for client</option>
                            <option value="Provisioning of resources">Provisioning of resources</option>
                            <option value="Assigning tasks to resources">Assigning tasks to resources</option>
                            <option value="Allocating a dedicated point of contact">Allocating a dedicated point of contact</option>

                        </select>
                        <button type="submit" class="btn btn-primary">Update</button>
                        </td>
                    </form>

                </tr>
            <?php } ?>

            </tbody>
        </table>

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
