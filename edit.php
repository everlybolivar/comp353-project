<?php
include 'DB.php';
session_start();
    ?>
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
    <html>
    <head>
        <title>Edit Record</title>
        <link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css" integrity="sha384-nn4HPE8lTHyVtfCBi5yW9d20FjT8BJwUXyWZT9InLYax14RDjBj46LmSztkmNP9w" crossorigin="anonymous">
         <style>
            .center-div
            {
                margin: auto;
                width: 500px;
            }
            .header-div
            {
                margin: auto;
                width: 50%;
            }
            .button-div
            {
                margin: 0 auto;
                width: 50%;
            }
        </style>
    </head>
    <body>

    <?php
    $admin= $_COOKIE['admin'];

    // Redirect to login if no admin cookie
    if (!$admin) {
        header('Location: ../Login.php');
    }

    $connection = DB::getConnection();
    $id = (int)$_GET['id'];
    $query = "SELECT contract.contract_id,
        contract.company_name,
        contract.service_type,
        contract.contract_type,
        contract.service_start_date,    
        contract.acv,
        contract.initial_cost,
        employee.employee_fname,
        employee.employee_lname,
        employee.employee_id,
        contract.contact_number,
        contract.email_id,   
        contract.address,
        contract.city,
        contract.province,
        contract.postal_code,
        employee.employee_id
    FROM contract
    INNER JOIN employee ON contract.responsible_person_id = employee.employee_id
    WHERE contract.contract_id=$id";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_array($result);

    $contract_id=$row['contract_id'];
    $company_name=$row['company_name'];
    $service_type=$row['service_type'];
    $contract_type=$row['contract_type'];
    $service_start_date=$row['service_start_date'];
    $acv=$row['acv'];
    $initial_cost=$row['initial_cost'];
    $employee_fname=$row['employee_fname'];
    $employee_lname=$row['employee_lname'];
    $contact_number=$row['contact_number'];
    $email_id=$row['email_id'];
    $address=$row['address'];
    $city=$row['city'];
    $province=$row['province'];
    $postal_code=$row['postal_code'];
    $employee_id=$row['employee_id'];

    $query2 = "SELECT employee_id, employee_fname, employee_lname
    FROM employee   
    INNER JOIN department ON department.department_id=employee.department_id
    WHERE department_type='Managers'";
    $emplist = mysqli_query($connection, $query2);
    $connection->close();
    // display data in table
    ?>
<div class="center-div">
    <div class="header-div">
        <h3>Edit Contract</h3>
    </div>
    <form id="edit" class="pure-form pure-form-aligned" action="update.php" method="post">

        <fieldset>

            <div class="pure-control-group">
                <label for="foo">Contract Number:</label>
                <input id="foo" type="text" readonly name="contract_id" value="<?=$contract_id;?>">
            </div>
            <div class="pure-control-group">
                <label for="foo">Company Name:</label>
                <input id="foo" type="text" name="company_name" value="<?=$company_name;?>">
            </div>
            <div class="pure-control-group">
                <label for="foo">Email:</label>
                <input id="foo" type="email" name="email_id" value="<?=$email_id;?>">
            </div>
            <div class="pure-control-group">
                <label for="foo">Contract Type:</label>
                <select id="state" name="contract_type">
                    <option selected="selected" ><?=$contract_type?></option>
                    <option value="Gold">Gold</option>
                    <option value="Premium">Premium</option>
                    <option value="Diamond">Diamond</option>
                    <option value="Silver">Silver</option>
                </select>
            </div>
            <div class="pure-control-group">
                <label for="foo">Service Type:</label>
                <select id="state" name="service_type">
                    <option selected="selected" ><?=$service_type?></option>
                    <option value="On-premises">On-premises</option>
                    <option value="Cloud">Cloud</option>
                </select></div>
            <div class="pure-control-group">
                <label for="foo">Service Start Date:</label>
                <input id="foo" type="text" name="service_start_date" value="<?=$service_start_date;?>">
            </div>
            <div class="pure-control-group">
                <label for="foo">ACV($):</label>
                <input id="foo" type="text" name="acv" value="<?=(double)$acv;?>">
            </div>
            <div class="pure-control-group">
                <label for="foo">Initial Cost($):</label>
                <input id="foo" type="text" name="initial_cost" value="<?=(double)$initial_cost;?>">
            </div>
            <div class="pure-control-group">
                <label for="foo">Possible Managers:</label>
                <select id="state" name="new_manager">
                    <?php
                    echo '<option selected="selected" value='.$employee_id.' >'.$employee_fname.' '.$employee_lname.'</option>';
                    while($emp = mysqli_fetch_array($emplist)){
                        echo '<option value="'.$emp['employee_id'].'">'.$emp['employee_fname'].' '.$emp['employee_lname'].'</option>';
                    }
                    $connection->close();
                    ?>
                </select>

            </div>
            <div class="pure-control-group">
                <label for="foo">Contact Number:</label>
                <input id="foo" type="text" name="contact_number" value="<?=$contact_number;?>">
            </div>
                      <div class="pure-control-group">
                <label for="foo">Address:</label>
                <input id="foo" type="text" name="address" value="<?=$address;?>">
            </div>
            <div class="pure-control-group">
                <label for="foo">City:</label>
                <input id="foo" type="text" name="city" value="<?=$city;?>">
            </div>
            <div class="pure-control-group">
                <label for="state">Province:</label>
                <select id="state" name="province">
                    <option selected="selected" ><?=$province?></option>
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
            </div>
            <div class="pure-control-group">
                <label for="foo">Postal Code:</label>
                <input id="foo" type="text" name="postal_code" value="<?=$postal_code;?>">
            </div>
            <div class="button-div">
             <button type="submit" class="pure-button pure-button-primary">Submit</button>
            </div>
        </fieldset>
    </form>
    </body>
    </html>
