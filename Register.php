<?php
ob_start();  //begin buffering the output
?>
<html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<title>Contract CMS</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link href="css/register.css" rel="stylesheet">

</head>


<body class="text-center">

<h1>Sign Up</h1>

<?php

require_once('RegisterValidation.php');
//validation
if (!empty($_POST)) {
    $fName = $_POST["fName"];
    $lName = $_POST["lName"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $role = $_POST["formRoles"];
    $emailError = "";

    if (duplicateEmail($email)) {
        $emailError = "This email already exist.";

    } else {
        $emailError = "";
        $_COOKIE['email'] = $email;
        Register($fName, $lName, $email, $password, $role);
        Header("Location:Login.php");
    }
}

ob_flush();
?>

<form method="post" class="form-register" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

    <div class="form-group">
        <label for="fName" class="sr-only">First Name</label>
        <input name="fName" type="text" class="form-control" id="fName" placeholder="First Name" required>
    </div>

    <div class="form-group">
        <label for="LName" class="sr-only">Last Name:</label>
        <input name="lName" class="form-control" type="text" id="lName" placeholder="Last Name" required>
    </div>

    <div class="form-group">

        <label for="Email" class="sr-only">Email</label>
        <input name="email" class="form-control" type="email" id="email" placeholder="Email" required>
    </div>

    <?php if (!empty($emailError)) {
        echo "        
        <div class='alert alert-warning'>
            <strong>Warning!</strong> This email already exists.
        </div>
        ";
    } ?>

    <div class="form-group">
        <label for="password" class="sr-only">Password</label>
        <input name="password" class="form-control" type="password" id="password" placeholder="Password" required>
    </div>

    <div class="form-group">
        <select name="formRoles" class="custom-select custom-select-lg mb-3">
            <option value="employee">Employee</option>
            <option value="manager">Manager</option>
            <option value="salesAssociate">Sales Associate</option>
            <option value="admin">Admin</option>
            <option value="client">Client</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary"> Register</button>

</form>
</body>
</html>
