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
//validation
$badLogin = "";
$fName = $lName = $email = $password = "";
$username = $_cookie["email"];


$host = 'ddc353.encs.concordia.ca';
$username = 'ddc353_1';
$password = '353DBpro';
$db = 'ddc353_1';
$db_port = '3306';


$connection = mysqli_connect($host, $username, $password, $db, $db_port);
if ($connection->connect_error) {
    die("error failure" . $connection->connect_error);
} else {
    $sql = $connection->prepare("SELECT * FROM contract INNER JOIN users ON users. WHERE email = ?");
    $sql->bind_param("s", $email);

}

ob_flush();

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
