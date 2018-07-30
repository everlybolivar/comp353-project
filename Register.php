<?php
ob_start();  //begin buffering the output
?>
<html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<title>Contract CMS</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
      integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>


<body>

<h1>Sign Up </h1>

<?php

require_once('RegisterValidation.php');
//validation
$fName = $lName = $email = $password = "";
$fNameCheck = empty($_POST["fName"]);
$lNameCheck = empty($_POST["lName"]);
$emailCheck = empty($_POST["email"]);
$passwordCheck = empty($_POST["password"]);

if ($fNameCheck) {
    $fNameEmpty = "Please enter your first name";
}
if ($lNameCheck) {
    $lNameEmpty = "Please enter your last name";
}
if ($emailCheck) {
    $emailEmpty = "Please enter your email";
}
if ($passwordCheck) {
    $pwdEmpty = "Please enter a password";
}

if (!$fNameCheck && !$lNameCheck && !$emailCheck && !$passwordCheck) {
    $_COOKIE['fName'] = $_POST["fName"];
    $_COOKIE['lName'] = $_POST["lName"];
    $_COOKIE['email'] = $_POST["email"];
    $_COOKIE['password'] = $_POST["password"];
    Register($_POST["fName"], $_POST["lName"], $_POST["email"], $_POST["password"]);
    header('Location:Login.php');
}
ob_flush();
?>


<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

    <div class="form-group">
        <label for="fName">First Name:</label>
        <input name="fName" type="text" , id="fName" placeholder="Enter Your First Name">
        <span class="error"> <?php echo $fNameEmpty; ?> </span>
    </div>


    <div class="form-group">
        <label for="LName">Last Name:</label>
        <input name="lName" type="text" , id="lName" placeholder="Enter Your Last Name">
    </div>

    <div class="form-group">
        <label for="Email">Email:</label>
        <input name="email" type="email" , id="email" placeholder="Enter Email">
    </div>


    <div class="form-group">
        <label for="password">Password</label>
        <input name="password" type="password" , id="password" placeholder="Enter Password">
    </div>

    <button type="submit" class="btn btn-primary"> Register</button>

</form>
</body>
</html>
