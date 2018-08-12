<?php


$admin= $_COOKIE['admin'];

// Redirect to login if no employee cookie
if (!$admin) {
    header('Location:Login.php');
}

?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    </head>
	<body>
    <div style="width: 250px;margin: 0 auto;">
        <h1 class="display-4">Reports</h1>
		</div>
    <div class="w3-display-middle" >
        <table>
            <thead>
            <tr>
                <td>
                    <div>
                        <a href="AdminDashboard.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true" >View Contract</a>
                    </div>

                </td>
                <td>
                    <div>
                        <a href="ViewPayment.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true" >View Payment</a>
                    </div>
                </td>
            </tr>
            </thead>
        </table>
        <table>
            <thead>
            <tr>
                <td>
                <div>
                    <a href="Report_1.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Report #1</a>
                </div>
                </td>
                <td>
                <div>
                    <a href="Report_2.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Report #2</a>
                </div>
                </td>
                <td>
                <div>
                    <a href="Report_3.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true" >Report #3</a>
                </div>
                </td>
            </tr>
            </thead>
        </table>

	</body>
</html>