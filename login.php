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
//validation
    $badLogin = "";
    $fName = $lName = $email = $password = "";
    $emailCheck = empty($_POST["email"]);
    $passwordCheck = empty($_POST["password"]);
//validation for empty passwords
    if ($emailCheck) {
        $emailEmpty = "Please enter your email";
    }
    if ($passwordCheck) {
        $pwdEmpty = "Please enter a password";
    }

    if (!$emailCheck && !$passwordCheck) {
        $pw = $_POST["password"];
        $email = $_POST["email"];
        setcookie("email", $email, time() + (86400 * 30));

        $connection = DB::getConnection();
        if ($connection->connect_error) {
            die("error failure" . $connection->connect_error);
        } else {
            $sql = $connection->prepare("SELECT employee_id FROM users WHERE email = ? && password = ?");
        //bind params bind the email and pw to the question marks
            $sql->bind_param("ss", $email, $pw);

        // Execute query
            $sql->execute();

        // Store result to get properties
            $sql->store_result();
            $rowNum = $sql->num_rows;

        // Bind result to variable
            $sql->bind_result($employeeID);

        // Getting result
            $sql->fetch();
        //check to see if result returns more than one row
            if ($rowNum == 1) {

                // Handling of client logins, who are not referred in the employee table
                if ($employeeID == null) {
                    $sql = $connection->prepare("SELECT DISTINCT contract.email_id FROM contract INNER JOIN users ON users.email = contract.email_id WHERE users.email = ?");
                    $sql->bind_param("s", $email);
                    $sql->execute();
                    $sql->bind_result($clientEmail);
                    $sql = $sql->fetch();

                    if($clientEmail == $email) {
                        header('Location:ClientDashboard.php');
                        exit();
                    } else {
                        $badLogin = "Can't Login. Not a client. Please contact sales associate.";
                    }

                } else {

                    $sql = $connection->prepare("SELECT employee.department_id FROM employee INNER JOIN users ON users.employee_id = employee.employee_id WHERE users.email = ?");
                    $sql->bind_param("s", $email);
                    $sql->execute();
                    $sql->bind_result($out);
                    $sql = $sql->fetch();

            //out is the user type e.g admin,employee,manager etc. Refer to departments table
                    if ($out == 7) {
                        setcookie("employeeID", $employeeID, time() + (86400 * 30));
                        header('Location:EmployeeDashboard.php');
                        exit();
                    } else if ($out == 1) {
                        header('Location:ManagerDashboard.php');
                        exit();
                    } else if ($out == 13) {
                        header('Location:AdminDashboard.php');
                        exit();
                    } else if ($out == 14) {
                        header('Location:SalesDashboard.php');
                        exit();
                    } else {
                        $badLogin = "Can't Login. Renter Credentials";
                    }

                }
            }
        }
        ob_flush();
    }
    ?>


    <h1>Please Login </h1>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group">
            <label for="email">Login Email:</label>
            <input type="email" , name="email" id="email" placeholder="Enter Email">
        </div>


        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" , name="password" id="password" placeholder="Enter Password">
        </div>


        <button type="submit" class="btn btn-primary"> Login</button>
        <span class="error"> <?php echo $badLogin; ?> </span>

    </form>


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
