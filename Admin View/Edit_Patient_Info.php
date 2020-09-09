<!DOCTYPE html>
<html lang="en">
	<head>
<!--
	Edit Patient Info for Ortho SC company
	This page will allow the user to edit a patient info
	
	Name: LeeWayne Barrineau
	Date: 11/11/2019
	File Name: New_Patient.html
--->
	<title>Update Patient Info</title>
	<meta charset="utf-8" />
	<link href="Admin_Styles.css" rel="stylesheet"/>
	<script	src="New_Patient_Data.js" async></script>
	<script src="Admin_Options.js" async></script>
	<script src="https://kit.fontawesome.com/a076d05399.js"></script>
	</head>
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
	<?php
		//NECESSARY VARIABLES
		$errormsg = "";
		$showform = 0;
		//DATABASE CONNECTION
		require_once "connectPatient.php";
		
		if( isset($_POST['theedit']) ) {
			$showform = 1;
			$formfield['ffpatient_id'] = $_POST['patient_id'];
			$sqlselect = 'SELECT * from PatientInfo where PatientInfoId = :bvpatient_id';
			$result = $db->prepare($sqlselect);
			$result->bindValue(':bvpatient_id', $formfield['ffpatient_id']);
			$result->execute();
			$row = $result->fetch(); 
		}
		
		
		if( isset($_POST['buttonSubmit']) )
		{
			$showform = 2;
			$formfield['ffpatient_id'] = $_POST['patient_id'];
			echo '<p>The form was submitted.</p>';
			
			$formfield['fffirstName'] = trim($_POST['firstName']);
			$formfield['fflastName'] = trim($_POST['lastName']);
			$formfield['ffphoneNumber'] = trim($_POST['phoneNumber']);
			$formfield['ffbirthDay'] = trim($_POST['birthDay']);
			$formfield['ffstreetBox'] = trim($_POST['streetBox']);
			$formfield['ffcityName'] = trim($_POST['cityName']);
			$formfield['ffstateBox'] = trim($_POST['stateBox']);
			$formfield['ffzipCode'] = trim($_POST['zipCode']);
			$formfield['ffmailingBox'] = trim($_POST['mailingBox']);
			
			
			if(empty($formfield['fffirstName'])){$errormsg .= "<p>Your first name is empty.</p>";}
			if(empty($formfield['fflastName'])){$errormsg .= "<p>Your last name is empty.</p>";}
			if(empty($formfield['ffphoneNumber'])){$errormsg .= "<p>Your phone is empty.</p>";}
			if(empty($formfield['ffmailingBox'])){$errormsg .= "<p>Your mailing option is empty.</p>";}
			
			if($errormsg != "")
			{
				echo "<div class='error'><p>THERE ARE ERRORS!</p>";
				echo $errormsg;
				echo "</div>";
			}
			else{
				
				try{
					$sqlinsert = 'update PatientInfo set PatientInfoFirstName = :bvfirstName,
								  PatientInfoLastName = :bvlastName,
								  PatientInfoPhone = :bvphoneNumber,
								  PatientInfoBirthDay = :bvbirthDay,
								  PatientInfoStreet = :bvstreetBox,
								  PatientInfoCity = :bvcityBox,
								  PatientInfoState = :bvstateBox,
								  PatientInfoZip = :bvzipCode,
								  PatientInfoMailing = :bvmailingBox
								  where PatientInfoId = :bvpatient_id';
					
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
					$stmtinsert->bindValue(':bvpatient_id', $formfield['ffpatient_id']);
					$stmtinsert->execute();
					
					echo"<p>Patient's data was updated</p>";
					
				}catch(PDOException $e)
				{
					echo 'ERROR!!!' .$e->getMessage();
					exit();
				}	
			}
			
		}
		
		if($showform==1){
	?>
	<form id="editForm" name="editForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
					<h1> Update Patient Form</h1>
					<fieldset id="patientInfo">
							<table>
								<tr>
									<td>
										<label for="firstName">First Name*</label>
									</td>
									<td><input name="firstName" id="firstName" type="text" 
										value = <?php echo $row['PatientInfoFirstName'];?>
									/></td>
								</tr>
								<tr>
									<td><label for="lastName">Last Name*</label></td>
									<td><input name="lastName" id="lastName" type="text" 
										value = <?php echo $row['PatientInfoLastName'];?>
									/></td>
								</tr>
								<tr>
									<td><label for="phoneNumber">Phone Number*</label></td>
									<td><input name="phoneNumber" id="phoneNumber" type="tel" pattern="^\d{10}$|^(\(\d{3}\)\s*)?\d{3}[\s-]?\d{4}$"
										 placeholder="(nnn) nnn-nnnn" 
										value = <?php echo $row['PatientInfoPhone'];?>
										></td>
								</tr>
								<tr>
									<td><label for="birthDay">Birthday</label></td>
									<td><input name="birthDay" id="birthDay" type="date"
										value = <?php echo $row['PatientInfoBirthDay'];?>
									></td>
								</tr>
								<tr>
									<td><label for="streetBox">Street</label></td>
									<td><input name="streetBox" id="streetBox" type="text"
										value = <?php echo $row['PatientInfoStreet'];?>
									></td>
								</tr>
								<tr>
									<td><label for="cityName">City</label></td>
									<td><input name="cityName" id="cityName" type="text"
										value = <?php echo $row['PatientInfoCity'];?>
									></td>
								</tr>
								<tr>
									<td><label for="stateBox">State</label></td>
									<td><select name="stateBox" id="stateBox">
											<option value="AL"  <?php if( $row['PatientInfoState'] == "AL" ){echo ' selected';}?>>Alabama</option>
											<option value="AK"  <?php if(  $row['PatientInfoState'] == "AK" ){echo ' selected';}?>>Alaska</option>
											<option value="AZ"  <?php if(  $row['PatientInfoState'] == "AZ" ){echo ' selected';}?>>Arizona</option>
											<option value="AR"  <?php if(  $row['PatientInfoState'] == "AR" ){echo ' selected';}?>>Arkansas</option>
											<option value="CA"	<?php if(  $row['PatientInfoState'] == "CA" ){echo ' selected';}?>>California</option>
											<option value="CO"	<?php if(  $row['PatientInfoState'] == "CO" ){echo ' selected';}?>>Colorado</option>
											<option value="CT"	<?php if(  $row['PatientInfoState'] == "CT" ){echo ' selected';}?>>Connecticut</option>
											<option value="DE"	<?php if(  $row['PatientInfoState'] == "DE" ){echo ' selected';}?>>Delaware</option>
											<option value="DC"	<?php if( $row['PatientInfoState'] == "DC" ){echo ' selected';}?>>District Of Columbia</option>
											<option value="FL"  <?php if( $row['PatientInfoState'] == "FL" ){echo ' selected';}?>>Florida</option>
											<option value="GA"	<?php if( $row['PatientInfoState'] == "GA" ){echo ' selected';}?>>Georgia</option>
											<option value="HI"	<?php if( $row['PatientInfoState'] == "HI" ){echo ' selected';}?>>Hawaii</option>
											<option value="ID"	<?php if( $row['PatientInfoState'] == "ID" ){echo ' selected';}?>>Idaho</option>
											<option value="IL"	<?php if( $row['PatientInfoState'] == "IL" ){echo ' selected';}?>>Illinois</option>
											<option value="IN"	<?php if( $row['PatientInfoState'] == "IN" ){echo ' selected';}?>>Indiana</option>
											<option value="IA"	<?php if( $row['PatientInfoState'] == "IA" ){echo ' selected';}?>>Iowa</option>
											<option value="KS"	<?php if( $row['PatientInfoState'] == "KS" ){echo ' selected';}?>>Kansas</option>
											<option value="KY"	<?php if( $row['PatientInfoState'] == "KY" ){echo ' selected';}?>>Kentucky</option>
											<option value="LA"	<?php if( $row['PatientInfoState'] == "LA" ){echo ' selected';}?>>Louisiana</option>
											<option value="ME"	<?php if( $row['PatientInfoState'] == "ME" ){echo ' selected';}?>>Maine</option>
											<option value="MD"	<?php if( $row['PatientInfoState'] == "MD" ){echo ' selected';}?>>Maryland</option>
											<option value="MA"	<?php if( $row['PatientInfoState'] == "MA" ){echo ' selected';}?>>Massachusetts</option>
											<option value="MI"	<?php if( $row['PatientInfoState'] == "MI" ){echo ' selected';}?>>Michigan</option>
											<option value="MN"	<?php if( $row['PatientInfoState'] == "MN" ){echo ' selected';}?>>Minnesota</option>
											<option value="MS"	<?php if( $row['PatientInfoState'] == "MS" ){echo ' selected';}?>>Mississippi</option>
											<option value="MO"	<?php if( $row['PatientInfoState'] == "MO" ){echo ' selected';}?>>Missouri</option>
											<option value="MT"	<?php if( $row['PatientInfoState'] == "MT" ){echo ' selected';}?>>Montana</option>
											<option value="NE"	<?php if( $row['PatientInfoState'] == "NE" ){echo ' selected';}?>>Nebraska</option>
											<option value="NV"	<?php if( $row['PatientInfoState'] == "NV" ){echo ' selected';}?>>Nevada</option>
											<option value="NH"	<?php if( $row['PatientInfoState'] == "NH" ){echo ' selected';}?>>New Hampshire</option>
											<option value="NJ"	<?php if( $row['PatientInfoState'] == "NJ" ){echo ' selected';}?>>New Jersey</option>
											<option value="NM"	<?php if( $row['PatientInfoState'] == "NM" ){echo ' selected';}?>>New Mexico</option>
											<option value="NY"	<?php if(  $row['PatientInfoState']== "NY" ){echo ' selected';}?>>New York</option>
											<option value="NC"	<?php if( $row['PatientInfoState'] == "NC" ){echo ' selected';}?>>North Carolina</option>
											<option value="ND"	<?php if( $row['PatientInfoState'] == "ND" ){echo ' selected';}?>>North Dakota</option>
											<option value="OH"	<?php if( $row['PatientInfoState'] == "OH" ){echo ' selected';}?>>Ohio</option>
											<option value="OK"	<?php if( $row['PatientInfoState'] == "OK" ){echo ' selected';}?>>Oklahoma</option>
											<option value="OR"	<?php if( $row['PatientInfoState'] == "OR" ){echo ' selected';}?>>Oregon</option>
											<option value="PA"	<?php if( $row['PatientInfoState'] == "PA" ){echo ' selected';}?>>Pennsylvania</option>
											<option value="RI"	<?php if( $row['PatientInfoState'] == "RI" ){echo ' selected';}?>>Rhode Island</option>
											<option value="SC"	<?php if( $row['PatientInfoState'] == "SC" ){echo ' selected';}?>>South Carolina</option>
											<option value="SD"	<?php if( $row['PatientInfoState'] == "SD" ){echo ' selected';}?>>South Dakota</option>
											<option value="TN"	<?php if( $row['PatientInfoState'] == "TN" ){echo ' selected';}?>>Tennessee</option>
											<option value="TX"	<?php if( $row['PatientInfoState'] == "TX" ){echo ' selected';}?>>Texas</option>
											<option value="UT"	<?php if( $row['PatientInfoState'] == "UT" ){echo ' selected';}?>>Utah</option>
											<option value="VT"	<?php if( $row['PatientInfoState'] == "VT" ){echo ' selected';}?>>Vermont</option>
											<option value="VA"	<?php if( $row['PatientInfoState'] == "VA" ){echo ' selected';}?>>Virginia</option>
											<option value="WA"	<?php if( $row['PatientInfoState'] == "WA" ){echo ' selected';}?>>Washington</option>
											<option value="WV"	<?php if( $row['PatientInfoState'] == "WV" ){echo ' selected';}?>>West Virginia</option>
											<option value="WI"	<?php if( $row['PatientInfoState'] == "WI" ){echo ' selected';}?>>Wisconsin</option>
											<option value="WY"	<?php if( $row['PatientInfoState'] == "WY" ){echo ' selected';}?>>Wyoming</option>
										</select>
									</td>
								</tr>
								<tr>
									<td><label for="zipCode">Zip</label></td>
									<td><input name="zipCode" id="zipCode" type="text" pattern="^\d{5}"
											placeholder="NNNNN"
											value = <?php echo $row['PatientInfoZip'];?>>
									</td>
								</tr>
								<tr>
									<td><label for="mailingBox">Mailing List Option </label></td>
									<td><select id="mailingBox" name="mailingBox">
											<option value="Y" <?php if( isset($_POST['mailingBox']) && $formfield['ffmailingBox'] == "Y" ){echo ' selected';}?>>YES</option>
											<option value="N" <?php if( isset($_POST['mailingBox']) && $formfield['ffmailingBox'] == "N" ){echo ' selected';}?>>NO</option>
										</select>
									</td>
								</tr>
							</table>
					</fieldset>
			<fieldset id="submitButton">
				<input type="hidden" name = "patient_id" value=<?php echo $formfield['patient_id'] ?>>
				<input id="buttonSubmit" type="submit" name="buttonSubmit" value="Update Patient">
			</fieldset>
	</form>	
	<?php
		}
	else if ($showform == 2) {
	?>
	<form id="editForm" name="editForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
					<h1> Edit Patient Form</h1>
					<fieldset id="patientInfo">
							<table>
								<tr>
									<td>
										<label for="firstName">First Name*</label>
									</td>
									<td><input name="firstName" id="firstName" type="text" 
										value = <?php echo $formfield['fffirstName'];?>
									></td>
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
									<td><label for="mailingBox">Mailing List Option </label></td>
									<td><select id="mailingBox" name="mailingBox">
											<option value="Y" <?php if( isset($_POST['mailingBox']) && $formfield['ffmailingBox'] == "Y" ){echo ' selected';}?>>YES</option>
											<option value="N" <?php if( isset($_POST['mailingBox']) && $formfield['ffmailingBox'] == "N" ){echo ' selected';}?>>NO</option>
										</select>
									</td>
								</tr>
							</table>
					</fieldset>
			<fieldset id="submitButton">
				<input type="hidden" name = "patient_id" value=<?php echo $formfield['patient_id'] ?>>
				<input id="buttonSubmit" type="submit" name="buttonSubmit" value="Add Patient">
			</fieldset>

	</form>	
	<?php
		}
		else {
		echo "You do not have permission to update";
		}
	?>
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