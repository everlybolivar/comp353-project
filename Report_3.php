<?php
	include 'DB.php';

	/*
	$admin= $_COOKIE['admin'];

	// Redirect to login if no employee cookie
	if (!$admin) {
	    header('Location:../Login.php');
	}
	*/
	?>



        <!DOCTYPE html>

        <html>
        <head>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        </head>
        <body>
        <div class="w3-display-topleft">
            <a href="#"
               class="btn btn-primary btn-lg active"
               role="button"
               aria-pressed="true"
               onClick="document.location.href='Reports.php'">Back to Reports</a>
        </div>

        <div style='width:55%; margin:0 auto;' class='card-body'>
            <h2 class='card-title'>Average of days for the First Deliverable for each month in the 2017</h2>
        </div>
        <div style='padding-left:20px ;width: 50%;margin: 0 auto;'>
            <table class='table table-bordered' >
                <thead class='thread-light>'>
                <tr>
                    <th scope='col' style="border-left: hidden;border-top:hidden"></th>
                    <th scope='col' >Silver Contracts</th>
                    <th scope='col' >Gold Contracts</th>
                    <th scope='col' >Diamond Contracts</th>
                    <th scope='col' >Premium Contracts</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $connection = DB::getConnection();

                $months = array(
                    'January',
                    'February',
                    'March',
                    'April',
                    'May',
                    'June',
                    'July ',
                    'August',
                    'September',
                    'October',
                    'November',
                    'December',
                );
                for($i = 0; $i<12; $i++)
                {
                    $month_id=$i+1;
                    $query = "	SELECT 	silver_contract.S_AVG AS 'Silver',     
                            gold_contract.G_AVG AS 'Gold',
                            diamond_contract.D_AVG AS 'Diamond',
                            premium_contract.P_AVG AS 'Premium' 
                    FROM    
                    (
                        SELECT AVG(DATEDIFF(first_deliverable,service_start_date)) AS 'S_AVG'
                        FROM contract 
                        WHERE contract_type='Silver' 
                        AND YEAR(first_deliverable) = 2017
                        AND MONTH(first_deliverable)= '$month_id'
                    ) AS silver_contract,
                    (
                        SELECT AVG(DATEDIFF(first_deliverable,service_start_date)) AS 'G_AVG' 
                        FROM contract 
                        WHERE contract_type='Gold' 
                        AND YEAR(first_deliverable) = 2017
                        AND MONTH(first_deliverable)= '$month_id'
                    ) AS gold_contract,
                    (
                        SELECT AVG(DATEDIFF(first_deliverable,service_start_date)) AS 'D_AVG' 
                        FROM contract 
                        WHERE contract_type='Diamond' 
                        AND YEAR(first_deliverable) = 2017
                        AND MONTH(first_deliverable)= '$month_id'
                    ) AS diamond_contract,
                    (
                        SELECT AVG(DATEDIFF(first_deliverable,service_start_date)) AS 'P_AVG' 
                        FROM contract 
                        WHERE contract_type='Premium' 
                        AND YEAR(first_deliverable) = 2017
                        AND MONTH(first_deliverable)= '$month_id'
                    ) AS premium_contract;";

                    $result = mysqli_query($connection, $query);

                    // display data in table

                    // loop through results of database query, displaying them in the table
                    while($row = mysqli_fetch_array( $result )) {
                        // echo out the contents of each row into a table
                        echo "<tr>";
                        echo '<td>' . $months[$i] . '</td>';
                        if($row['Silver']=="")
                        {
                            echo '<td bgcolor="black"></td>';

                        }
                        else if($row['Silver']<=5)
                        {
                            echo '<td bgcolor="#7fffd4">' . (int)$row['Silver'] . ' day(s)</td>';
                        }
                        else
                        {
                            echo '<td bgcolor="#f08080">' . (int)$row['Silver'] . ' day(s)</td>';

                        }if($row['Gold']=="")
                        {
                            echo '<td bgcolor="black"></td>';

                        }
                        else if($row['Gold']<=8)
                        {
                            echo '<td bgcolor="#7fffd4">' . (int)$row['Gold'] . ' day(s)</td>';
                        }
                        else
                        {
                            echo '<td bgcolor="#f08080">' . (int)$row['Gold'] . ' day(s)</td>';

                        }if($row['Diamond']=="")
                        {
                            echo '<td bgcolor="black"></td>';

                        }
                        else if($row['Diamond']<=6)
                        {
                            echo '<td bgcolor="#7fffd4">' . (int)$row['Diamond'] . ' day(s)</td>';
                        }
                        else
                        {
                            echo '<td bgcolor="#f08080">' . (int)$row['Diamond'] . ' day(s)</td>';

                        }if($row['Premium']=="")
                        {
                            echo '<td bgcolor="black"></td>';

                        }
                        else if($row['Premium']<=3)
                        {
                            echo '<td bgcolor="#7fffd4">'. (int)$row['Premium'] . ' day(s)</td>';
                        }
                        else
                        {
                            echo '<td bgcolor="#f08080">' . (int)$row['Premium'] . ' day(s)</td>';

                        }
                        echo "</tr>";
                    }
                }
                $connection->close();
                ?>

                </tbody>
                </table>
        </body>
        </html>