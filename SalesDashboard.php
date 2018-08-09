<?php
	require 'DB.php';
	/*
		Assumptions: Set service start date as the current date
	*/

    $connection = DB::getConnection();
	
	$sales= $_COOKIE['sales'];

	// Redirect to login if no employee cookie
	if (!$sales) {
	    header('Location:Login.php');
	}

	//Set POST variables
 	$company_name=$_POST['company_name'];
    
    $service_type=$_POST['service_type'];
    $service_start_date = date("Y-m-d");
    $service_end_date = date("Y-m-d");
    $first_deliverable = date("Y-m-d");
    $second_deliverable = date("Y-m-d");
    $third_deliverable = date("Y-m-d");
    $fourth_deliverable = date("Y-m-d");
    
    $contract_type=$_POST['contract_type'];
    $acv=$_POST['acv'];
    $initial_cost=$_POST['initial_cost'];
    
    $responsible_person_id=$_POST['responsible_person_id'];
    $contact_number=$_POST['contact_number'];
    $email_id=$_POST['email_id'];
    $address=$_POST['address'];
    $province=$_POST['province'];
    $city=$_POST['city'];
    $postal_code=$_POST['postal_code'];

    //Set service_end_date based on the contract selected
    if ($contract_type === 'Premium') { //Premium Contract
		$service_end_date = date('Y-m-d', strtotime($Date. ' + 10 days'));
		$first_deliverable = date('Y-m-d', strtotime($Date. ' + 3 days'));
	    $second_deliverable = date('Y-m-d', strtotime($Date. ' + 5 days'));
	    $third_deliverable = date('Y-m-d', strtotime($Date. ' + 10 days'));
	    $fourth_deliverable = NULL;

    } else if ($contract_type === 'Diamond') { //Diamond Contract
		$service_end_date = date('Y-m-d', strtotime($Date. ' + 18 days'));
		$first_deliverable = date('Y-m-d', strtotime($Date. ' + 6 days'));
	    $second_deliverable = date('Y-m-d', strtotime($Date. ' + 11 days'));
	    $third_deliverable = date('Y-m-d', strtotime($Date. ' + 18 days'));
	    $fourth_deliverable = NULL;

    } else if ($contract_type === 'Gold') { //Gold Contract
    	$service_end_date = date('Y-m-d', strtotime($Date. ' + 20 days'));
    	$first_deliverable = date('Y-m-d', strtotime($Date. ' + 8 days'));
	    $second_deliverable = date('Y-m-d', strtotime($Date. ' + 14 days'));
	    $third_deliverable = date('Y-m-d', strtotime($Date. ' + 20 days'));
	    $fourth_deliverable = NULL;

    } else if ($contract_type === 'Silver') { //Silver Contract
    	$service_end_date = date('Y-m-d', strtotime($Date. ' + 28 days'));
    	$first_deliverable = date('Y-m-d', strtotime($Date. ' + 5 days'));
	    $second_deliverable = date('Y-m-d', strtotime($Date. ' + 15 days'));
	    $third_deliverable = date('Y-m-d', strtotime($Date. ' + 20 days'));
	    $fourth_deliverable = date('Y-m-d', strtotime($Date. ' + 28 days'));
    }
    

    if (is_null($fourth_deliverable)) {
    	
    	$query = "INSERT INTO contract (company_name, service_type, service_start_date, first_deliverable, second_deliverable, third_deliverable, fourth_deliverable, service_end_date, contract_type, acv, initial_cost, responsible_person_id, 
	                                    contact_number, email_id, address, province, city, postal_code) 
			      VALUES (
			         					'$company_name',
							            '$service_type',
							            '$service_start_date',
							            '$first_deliverable',
							            '$second_deliverable',
							            '$third_deliverable',
							            NULL, 
							            '$service_end_date',
							            '$contract_type', 
							            '$acv', 
							            '$initial_cost', 
							            '$responsible_person_id', 
							            '$contact_number', 
							            '$email_id', 
							            '$address', 
							            '$province', 
							            '$city', 
							            '$postal_code' 
							        )";
    } else { 
    	
    	$query = "INSERT INTO contract (company_name, service_type, service_start_date, first_deliverable, second_deliverable, third_deliverable, fourth_deliverable, service_end_date, contract_type, acv, initial_cost, responsible_person_id, 
	                                    contact_number, email_id, address, province, city, postal_code) 
			         		
			         		VALUES  (
			         					'$company_name',
							            '$service_type',
							            '$service_start_date',
							            '$first_deliverable',
							            '$second_deliverable',
							            '$third_deliverable',
							            '$fourth_deliverable', 
							            '$service_end_date',
							            '$contract_type', 
							            '$acv', 
							            '$initial_cost', 
							            '$responsible_person_id', 
							            '$contact_number', 
							            '$email_id', 
							            '$address', 
							            '$province', 
							            '$city', 
							            '$postal_code' 
							        )";
    }
    
	
	if (isset($_POST['submitButton'])) {
	   	if ($connection->query($query) === TRUE) {
    		echo "New record created successfully";
		} else {
	    	echo "Error: " . $connection->error . "<br>";
		}
	}   

	$query2 = "SELECT employee_id, employee_fname, employee_lname
			   FROM employee 
			   INNER JOIN department ON department.department_id=employee.department_id
			   WHERE department_type='Managers'";

	$emplist = mysqli_query($connection, $query2);

?>

<!DOCTYPE html>
<html>
	<head>
		<link href="css/salesdashboard.css" rel="stylesheet">
	</head>
	<body onload="document.createContract.reset();">
		<div class="centerThis">
			<h3>Create Contract</h3>
		</div>
		<form name='createContract' method="POST" action="">
			<table class="center">
				<tbody>
					<tr>
						<td>Company Name:</td>
						<td><input name="company_name" type="text" /></td>
					</tr>
					<tr>
						<td>Service Type:</td>
						<td>
							<select name="service_type">
								<option value="Cloud">Cloud</option>
								<option value="On-premises">On-premises</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>Contract Type:</td> 
						<td>
							<select name="contract_type">
								<option value="Premium">Premium</option>
								<option value="Diamond">Diamond</option>
								<option value="Gold">Gold</option>
								<option value="Silver">Silver</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>ACV:</td> 
						<td><input name="acv" type="text" />
						</td>
					</tr>
					<tr>
						<td>Initial Cost:</td> 
						<td><input name="initial_cost" type="text" /></td>
					</tr>
					<tr>
						<td>Responsible Person ID:</td>
						<td> 
							<select name="responsible_person_id">
								<?php
									echo '<option selected="selected" value='.$employee_id.' >'.$employee_fname.' '.$employee_lname.'</option>';
									
									while($emp = mysqli_fetch_array($emplist)) {
										echo '<option value="'.$emp['employee_id'].'">'.$emp['employee_fname'].' '.$emp['employee_lname'].'</option>';
									}
									
									$connection->close();
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td>Contact Number:</td>
						<td><input name="contact_number" type="text" /></td>
					</tr>
					<tr>
						<td>Email ID:</td>
						<td><input name="email_id" type="text" /></td>
					</tr>
					<tr>
						<td>Address:</td>
						<td><input name="address" type="text" /></td>
					</tr>
					<tr>
						<td>Province:</td>
						<td>
							<select name="province">
								<option value="Alberta">Alberta</option>
								<option value="British Columbia">British Columbia</option>
								<option value="Manitoba">Manitoba</option>
								<option value="New Brunswick">New Brunswick</option>
								<option value="Newfoundland and Labrador">Newfoundland and Labrador</option>
								<option value="Nova Scotia">Nova Scotia</option>
								<option value="Ontario">Ontario</option>
								<option value="Prince Edward Island">Prince Edward Island</option>
								<option value="Quebec">Quebec</option>
								<option value="Saskatchewan">Saskatchewan</option>
								<option value="Northwest Territories">Northwest Territories</option>
								<option value="Nunavut">Nunavut</option>
								<option value="Yukon">Yukon</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>City:</td>
						<td><input name="city" type="text" /></td>
					</tr>
					<tr>
						<td>Postal Code:</td>
						<td><input name="postal_code" type="text" /></td>
					</tr>
				</tbody>
			</table>
		<br/>
		<div class="centerThis">
		<input type="Submit" name="submitButton" class="center"/></form>
	</div>
	</body>
</html>