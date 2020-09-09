<!DOCTYPE html>
<html lang="en">
<head>
<!--
	Add Patient page for Ortho SC company
	Will add a new patient to the patient inside Patient Data
	
	Name: LeeWayne Barrineau
	Date: 11/11/2019
	File Name: Add_Patient.html
--->
	<title> Add Patient</title>
	<meta charset="utf-8" />
	<link href="Admin_Styles.css" rel="stylesheet"/>
	<script	src="New_Patient_Data.js" async></script>
	<script src="Admin_Options.js" async></script>
	<script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>
<?php
	//NECESSARY VARIABLES
	$errormsg = "";
	$showform = 1;
	//DATABASE CONNECTION
	require_once "connectPatient.php";

		if( isset($_POST['buttonSubmit']) )
		{
			

			//Data Cleansing
			$formfield['fffirstName'] = trim($_POST['firstName']);
			$formfield['fflastName'] = trim($_POST['lastName']);
			$formfield['ffphoneNumber'] = trim($_POST['phoneNumber']);
			$formfield['ffbirthDay'] = trim($_POST['birthDay']);
			$formfield['ffstreetBox'] = trim($_POST['streetBox']);
			$formfield['ffcityName'] = trim($_POST['cityName']);
			$formfield['ffstateBox'] = trim($_POST['stateBox']);
			$formfield['ffzipCode'] = trim($_POST['zipCode']);
			$formfield['ffmailingBox'] = trim($_POST['mailingBox']);
		
			/*  ****************************************************************************
     		CHECK FOR EMPTY FIELDS
    		**************************************************************************** */
			if(empty($formfield['fffirstName'])){$errormsg .= "<p>Your first name is empty.</p>";}
			if(empty($formfield['fflastName'])){$errormsg .= "<p>Your last name is empty.</p>";}
			if(empty($formfield['ffphoneNumber'])){$errormsg .= "<p>Your phone is empty.</p>";}
			if(empty($formfield['ffmailingBox'])){$errormsg .= "<p>Your mailing option is empty.</p>";}

			/*  ****************************************************************************
			DISPLAY ERRORS
			**************************************************************************** */
			if($errormsg != "")
			{
				echo "<div class='error'><p>THERE ARE ERRORS!</p>";
				echo $errormsg;
				echo "</div>";
			}
			else
			{
				try
				{
					//enter data into database
					$sqlinsert = 'INSERT INTO PatientInfo 
						(PatientInfoId,
						PatientInfoFirstName,
						PatientInfoLastName,
						PatientInfoPhone
						,PatientInfoBirthDay,
						PatientInfoStreet,
						PatientInfoCity,
						PatientInfoState,
						PatientInfoZip,
						PatientInfoMailing)
					VALUES 
						(NULL,
						:bvfirstName, 
						:bvlastName,
						:bvphoneNumber,
						:bvbirthDay,
						:bvstreetBox,
						:bvcityBox,
						:bvstateBox,
						:bvzipCode,
						:bvmailingBox)';
					$stmtinsert = $db->prepare($sqlinsert);
					$stmtinsert->bindvalue(':bvfirstName', $formfield['fffirstName']);
					$stmtinsert->bindvalue(':bvlastName', $formfield['fflastName']);
					$stmtinsert->bindvalue(':bvphoneNumber', $formfield['ffphoneNumber']);
					$stmtinsert->bindvalue(':bvbirthDay', $formfield['ffbirthDay']);
					$stmtinsert->bindvalue(':bvstreetBox', $formfield['ffstreetBox']);
					$stmtinsert->bindvalue(':bvcityBox', $formfield['ffcityName']);
					$stmtinsert->bindvalue(':bvstateBox', $formfield['ffstateBox']);
					$stmtinsert->bindvalue(':bvzipCode', $formfield['ffzipCode']);
					$stmtinsert->bindvalue(':bvmailingBox', $formfield['ffmailingBox']);
					$stmtinsert->execute();
					
					echo '<p>Patient was Added.</p>';
				}//try
				catch(PDOException $e)
				{
					echo 'ERROR!!!' .$e->getMessage();
					exit();
				}
			}//else statement end
			
		}//if isset submit


	$sqlselect = "SELECT * from PatientInfo"; 
	
	/*
	$sqlselect = "SELECT * from PatientInfo 
				where PatientInfoFirstName like CONCAT('%', :bvfirstName, '%')
				AND PatientInfoPhone like CONCAT('%', :bvphoneNumber, '%')
				AND PatientInfoZip like CONCAT('%', :bvzipCode, '%')";
	*/
	/*WHERE PatientInfoFirstName = :bvfirstName";*/

	$result = $db-> query($sqlselect);


	?>
<body>
	<header>
		<div id="navArea">
				<nav id="navHeadBar">
					<ul>
						<li><a href="https://www.orthosc.org"><i class="fas fa-home"></i></a></li>
						<li><a href="Add_Patient.php">Add new Patient</a></li>
						<li><a href="Search_Form.php">Search Patients</a></li>
						<li><a href="Edit_Patient_Info.php">Edit Patient Info</a></li>
					</ul>
				</nav>
			</div>
	</header>
	<div id="topLogo"><a href="https://www.orthosc.org"><img src="OrthoSc.png" alt="OrthoLogo"></a></div>
	<form id="patientForm" name="patientForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
					<h1> New Patient Form</h1>
						<p>* Required<p>
					<fieldset id="patientInfo">
							<table>
								<tr>
									<td>
										<label for="firstName">First Name*</label>
									</td>
									<td><input name="firstName" id="firstName" type="text" 
										value = <?php echo $formfield['fffirstName'];?>>
									</td>
								</tr>
								<tr>
									<td><label for="lastName">Last Name*</label></td>
									<td><input name="lastName" id="lastName" type="text" 
										value = <?php echo $formfield['fflastName']; ?>
									></td>
								</tr>
								<tr>
									<td><label for="phoneNumber">Phone Number*</label></td>
									<td><input name="phoneNumber" id="phoneNumber" type="tel" pattern="^\d{10}$|^(\(\d{3}\)\s*)?\d{3}[\s-]?\d{4}$"
										 placeholder="(nnn) nnn-nnnn" 
										value = <?php echo $formfield['ffphoneNumber']; ?>>
										</td>
								</tr>
								<tr>
									<td><label for="birthDay">Birthday</label></td>
									<td><input name="birthDay" id="birthDay" type="date"
										value = <?php echo $formfield['ffbirthDay']; ?>
									></td>
								</tr>
								<tr>
									<td><label for="streetBox">Street</label></td>
									<td><input name="streetBox" id="streetBox" type="text"
										value = <?php echo $formfield['ffstreetBox']; ?>
									></td>
								</tr>
								<tr>
									<td><label for="cityName">City</label></td>
									<td><input name="cityName" id="cityName" type="text"
										value = <?php echo $formfield['ffcityName']; ?>
									></td>
								</tr>
								<tr>
									<td><label for="stateBox">State</label></td>
									<td><select name="stateBox" id="stateBox">
											<option value="AL"  <?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "AL" ){echo ' selected';}?>>Alabama</option>
											<option value="AK"  <?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "AK" ){echo ' selected';}?>>Alaska</option>
											<option value="AZ"  <?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "AZ" ){echo ' selected';}?>>Arizona</option>
											<option value="AR"  <?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "AR" ){echo ' selected';}?>>Arkansas</option>
											<option value="CA"	<?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "CA" ){echo ' selected';}?>>California</option>
											<option value="CO"	<?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "CO" ){echo ' selected';}?>>Colorado</option>
											<option value="CT"	<?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "CT" ){echo ' selected';}?>>Connecticut</option>
											<option value="DE"	<?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "DE" ){echo ' selected';}?>>Delaware</option>
											<option value="DC"	<?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "DC" ){echo ' selected';}?>>District Of Columbia</option>
											<option value="FL"  <?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "FL" ){echo ' selected';}?>>Florida</option>
											<option value="GA"	<?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "GA" ){echo ' selected';}?>>Georgia</option>
											<option value="HI"	<?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "HI" ){echo ' selected';}?>>Hawaii</option>
											<option value="ID"	<?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "ID" ){echo ' selected';}?>>Idaho</option>
											<option value="IL"	<?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "IL" ){echo ' selected';}?>>Illinois</option>
											<option value="IN"	<?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "IN" ){echo ' selected';}?>>Indiana</option>
											<option value="IA"	<?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "IA" ){echo ' selected';}?>>Iowa</option>
											<option value="KS"	<?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "KS" ){echo ' selected';}?>>Kansas</option>
											<option value="KY"	<?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "KY" ){echo ' selected';}?>>Kentucky</option>
											<option value="LA"	<?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "LA" ){echo ' selected';}?>>Louisiana</option>
											<option value="ME"	<?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "ME" ){echo ' selected';}?>>Maine</option>
											<option value="MD"	<?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "MD" ){echo ' selected';}?>>Maryland</option>
											<option value="MA"	<?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "MA" ){echo ' selected';}?>>Massachusetts</option>
											<option value="MI"	<?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "MI" ){echo ' selected';}?>>Michigan</option>
											<option value="MN"	<?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "MN" ){echo ' selected';}?>>Minnesota</option>
											<option value="MS"	<?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "MS" ){echo ' selected';}?>>Mississippi</option>
											<option value="MO"	<?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "MO" ){echo ' selected';}?>>Missouri</option>
											<option value="MT"	<?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "MT" ){echo ' selected';}?>>Montana</option>
											<option value="NE"	<?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "NE" ){echo ' selected';}?>>Nebraska</option>
											<option value="NV"	<?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "NV" ){echo ' selected';}?>>Nevada</option>
											<option value="NH"	<?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "NH" ){echo ' selected';}?>>New Hampshire</option>
											<option value="NJ"	<?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "NJ" ){echo ' selected';}?>>New Jersey</option>
											<option value="NM"	<?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "NM" ){echo ' selected';}?>>New Mexico</option>
											<option value="NY"	<?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "NY" ){echo ' selected';}?>>New York</option>
											<option value="NC"	<?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "NC" ){echo ' selected';}?>>North Carolina</option>
											<option value="ND"	<?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "ND" ){echo ' selected';}?>>North Dakota</option>
											<option value="OH"	<?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "OH" ){echo ' selected';}?>>Ohio</option>
											<option value="OK"	<?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "OK" ){echo ' selected';}?>>Oklahoma</option>
											<option value="OR"	<?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "OR" ){echo ' selected';}?>>Oregon</option>
											<option value="PA"	<?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "PA" ){echo ' selected';}?>>Pennsylvania</option>
											<option value="RI"	<?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "RI" ){echo ' selected';}?>>Rhode Island</option>
											<option value="SC"	<?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "SC" ){echo ' selected';}?>>South Carolina</option>
											<option value="SD"	<?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "SD" ){echo ' selected';}?>>South Dakota</option>
											<option value="TN"	<?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "TN" ){echo ' selected';}?>>Tennessee</option>
											<option value="TX"	<?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "TX" ){echo ' selected';}?>>Texas</option>
											<option value="UT"	<?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "UT" ){echo ' selected';}?>>Utah</option>
											<option value="VT"	<?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "VT" ){echo ' selected';}?>>Vermont</option>
											<option value="VA"	<?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "VA" ){echo ' selected';}?>>Virginia</option>
											<option value="WA"	<?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "WA" ){echo ' selected';}?>>Washington</option>
											<option value="WV"	<?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "WV" ){echo ' selected';}?>>West Virginia</option>
											<option value="WI"	<?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "WI" ){echo ' selected';}?>>Wisconsin</option>
											<option value="WY"	<?php if( isset($_POST['stateBox']) && $formfield['ffstateBox'] == "WY" ){echo ' selected';}?>>Wyoming</option>
										</select>
									</td>
								</tr>
								<tr>
									<td><label for="zipCode">Zip</label></td>
									<td><input name="zipCode" id="zipCode" type="text" pattern="^\d{5}"
											placeholder="NNNNN"
											value = <?php echo $formfield['ffzipCode']; ?>>
									</td>
								</tr>
								<tr>
									<td><label for="mailingBox">Would you like to join our mailing list? </label></td>
									<td><input type="radio" name="mailingBox" id="mailingBox"value="Y"
											<?php if( isset($_POST['mailingBox']) && $formfield['ffmailingBox'] == "Y" ){echo ' checked';}?>>Yes
										<input type="radio" name="mailingBox" id="mailingBox"value="N" 
											<?php if( isset($_POST['mailingBox']) && $formfield['ffmailingBox'] == "N" ){echo ' checked';}
												  elseif(isset($_POST['mailingBox']) && $formfield['ffmailingBox'] == "Y" ){}
												  else{echo 'checked';}
												?>
										>No
									</td>
								</tr>
							</table>
					</fieldset>
			<fieldset id="submitButton">
				<input id="buttonSubmit" type="submit" name="buttonSubmit" value="Add Patient">
			</fieldset>

	</form>	
	<section>
		
	<?php 
		if( isset($_POST['buttonSubmit']) ){
	
		echo '<table><tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Phone Number</th>
			  <th>Birth Day</th><th>Street</th><th>City</th><th>State Abbrevation</th>
			  <th>Zip Code</th><th>Mailing Option</th>
		</tr>';
		while ( $row = $result-> fetch() )
			{
				echo '</td><td> ' . $row['PatientInfoFirstName'] . 
				'</td><td> ' . $row['PatientInfoLastName'] . '</td><td> '. $row['PatientInfoPhone'] .  
				'</td><td> '. $row['PatientInfoBirthDay'] .'</td><td> '. $row['PatientInfoStreet'] .
				'</td><td> '. $row['PatientInfoCity'] .'</td><td> '. $row['PatientInfoState'] .
				'</td><td> '. $row['PatientInfoZip'] .
				'</td><td> '.'</td><td> '. $row['PatientInfoMailing'] .'</td></tr>';
			}
		echo'</table>';
		}
		?>
	</section>
	<footer>
			<div id="navArea">
				<nav id="navFootBar">
					<ul>
						<li><a href="https://www.orthosc.org"><i class="fas fa-home"></i></a></li>
						<li><a href="Add_Patient.php">Add new Patient</a></li>
						<li><a href="Search_Form.php">Search Patients</a></li>
						<li><a href="Edit_Patient_Info.php">Edit Patient Info</a></li>
					</ul>
				</nav>
			</div>
	</footer>
</body>
</html>
	