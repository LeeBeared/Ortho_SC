<!DOCTYPE html>
<html lang="en">
<head>
<!--
	New Patient page for Ortho SC company
	This page works in conjuction with NewPatient.css, NewPatient.js
	
	Name: LeeWayne Barrineau
	Date: 11/7/2019
	File Name: New_Patient.html
--->
	<title>New Patient Portal</title>
	<meta charset="utf-8" />
	<link href="New_Patient_Styles.css" rel="stylesheet"  />
	<script src="New_Patient_Validate.js" async></script>
	<script src="https://kit.fontawesome.com/a076d05399.js"></script>
	<script src=""></script>
	</head>
	<center>
	<body>
		<header>
	
		<div id="socialMedia">
			<a href="https://www.youtube.com/channel/UCB6jNq5D8rTwszbIF2Cvuyg"><img src="media/yt_icon.png" alt="Youtube" />  </a>
			<a href="https://twitter.com/OrthoSC1"><img src="media/tw_icon.png" alt="Twitter" />  </a>
			<a href="https://www.facebook.com/orthosc1/"><img src="media/fb_icon.png" alt="Facebook" /> </a>
		
			
		
		</div>
	
	
		<div id="compImg">
			<img src="media/OrthoSc.png" alt="OrthoSC Logo" />   
			
			<div id="choose">
			<br><br>
			<li><img src="media/choose.png"></li>
			<li><p><i>Find the right provider for your specific<br>orthopedic needs now!</i></p></li><br>
			<li><a href="https://www.orthosc.org/doctors/mychoice?field_specialty_reference_target_id=All&field_location_reference_target_id=8446" >CHOOSE YOUR SPECIALIST</a></li>
			<br><br>
			</div>
		</div>
		
		<div id="navBar" >
			<nav>
				<ul>
					<li ><a href="https://www.orthosc.org/">HOME</a></li>
					<li ><a href="https://www.orthosc.org/about-us">ABOUT US</a></li>
					<li ><a href="https://www.orthosc.org/doctors">DOCTORS</a></li>
					<li ><a href="https://www.orthosc.org/specialties">SPECIALTIES</a></li>
					<li ><a href="https://www.orthosc.org/locations">LOCATION</a></li>
					<li ><a href="https://www.orthosc.org/services">SERVICES</a></li>
					<li ><a href="https://www.orthosc.org/patient-resources">PATIENT RESOURCES</a></li>
				</ul>                
			</nav>
		</div>
		
	</header>
		<div id="main">
	
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
			if(empty($formfield['fffirstName'])){$errormsg .= "<p>First name is empty.</p>";}
			if(empty($formfield['fflastName'])){$errormsg .= "<p>Last name is empty.</p>";}
			if(empty($formfield['ffphoneNumber'])){$errormsg .= "<p>Phone number is empty.</p>";}
			if(empty($formfield['ffmailingBox'])){$errormsg .= "<p>Your mailing option is empty.</p>";}

			/*  ****************************************************************************
			DISPLAY ERRORS
			**************************************************************************** */
			if($errormsg != "")
			{
				echo "<div class='error'><p>Please fix these errors!</p>";
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
					
					echo "<p id='ThankMess' name='ThankMess'><br><br>Your information was added to our system</p>";
				}//try
				catch(PDOException $e)
				{
					echo 'ERROR!!!' .$e->getMessage();
					exit();
				}
			}//else statement end
			
		}//if isset submit
	?>
		
			<form id="patientForm" name="patientForm" method="post" action="">
				<div id="formBox">
					<h1> New Patient Form</h1>
						<p>* Required<p>
	
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
									<td><label for="mailingBox">Would you like to join our mailing list? </label></td>
									<td><input type="radio" name="mailingBox" id="mailingBox"value="Y"
											<?php if( isset($_POST['mailingBox']) && $formfield['ffmailingBox'] == "Y" ){echo ' selected';}?>>Yes
										<input type="radio" name="mailingBox" id="mailingBox"value="N" checked
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
				<input id="buttonSubmit" type="submit" name="buttonSubmit" value="Submit Information">
			</fieldset>
				</div>
			</form>
			
			<br>
	
		<h3>After-Hours Information</h3>

		<p>At OrthoSC, our doctors are available 24 hours a day, 7 days a week. If you need to reach one of the OrthoSC doctors on the weekend or after regular office hours, please feel free to call one of our locations: 
		<a href="https://www.orthosc.org/locations/carolina-forest">Carolina Forest</a>, 
		<a href="https://www.orthosc.org/locations/carolina-forest-pain">Carolina Forest Pain
		</a>,&nbsp;<a href="https://www.orthosc.org/locations/conway">Conway</a>, or&nbsp;
		<a href="https://www.orthosc.org/locations/murrells-inlet">Murrells Inlet</a>.</p>
		<p>Our answering service will contact the on-call doctor, and he or she will return your call.</p>
		<p>Please note, calls after office hours and on weekends should be reserved only for real emergencies 
			and not for routine questions or medication prescription refills.</p>
	</div>
	
	
	
	<div id="contentRight">
	<div id="links">
		<h2>Patient Resources</h2>
	
		<ul>
			<li><a href="https://www.orthosc.org/appointments" >Appointments</a></li>
			<li><a href="https://www.orthosc.org/patient-resources/billing-insurance" >Billing &amp; Insurance</a></li>
			<li><a href="https://www.orthosc.org/patient-resources/faq" >Frequently Asked Questions</a></li>
			<li><a href="https://www.orthosc.org/patient-resources/joint-replacement-preoperative-q-and-a" >Joint Replacement Preoperative Q&amp;A</a></li>
			<li><a href="https://www.orthosc.org/patient-resources/medical-records-request" >Medical Records Request</a></li>
			<li><a href="https://www.orthosc.org/sports-medicine-guide" >Online Guide to Sports Medicine</a></li>
			<li><a href="https://www.orthosc.org/patient-resources/education" >Patient Education</a></li>
			<li><a href="https://www.orthosc.org/patient-resources/preparing-appointment" >Preparing for My Appointment</a></li>
			<li><a href="https://www.orthosc.org/patient-resources/preparing-surgery" >Preparing for My Surgery</a></li>
			<li><a href="https://www.orthosc.org/patient-resources/tips-healthy-joints" >Tips for Healthy Joints</a></li>
			<li><a href="https://www.orthosc.org/patient-resources/videos" >Video Library</a></li>
		</ul>
	</div>

		<div id="navButtons2">
			<br>
			<li><a href="patientForm.html">APPOINTMENT REQUEST</a></li><br>
			<li><a href="https://www.orthosc.org/online-bill-pay">ONLINE BILL PAY</a></li><br>
			<li><a href="https://17161.portal.athenahealth.com/">PATIENT PORTAL</a></li><br>
			<li><a href="https://www.orthosc.org/patient-resources/e-newsletter">E-NEWSLETTER SIGN-UP</a></li><br>
			<li><a href="https://www.orthosc.org/about-us/patient-reviews">PATIENT REVIEWS</a></li><br>
				
			<br>
		</div>
	</div>
	
	<br>
	
	</div>
	<br><br><br>
	
	<div id="ccu">
	
	<p>The Official Orthopedic Providers of &emsp;<img src="media/ccu_logo.png"><strong>&emsp;Coastal Carolina University Athletics</strong>&emsp;&emsp;&emsp;&emsp;&emsp;<a href="https://www.orthosc.org/specialties/sports-medicine-doctor"><small>LEARN MORE</small></a></p>
	
	</div>
	<div id="footer">
			<div id="fLinks1">
				<li><a href="https://www.orthosc.org/about-us" >About Us</a></li>
				<li ><a href="https://www.orthosc.org/doctors">Doctors</a></li>
				<li><a href="https://www.orthosc.org/specialties" >Specialties</a></li>
				<li ><a href="https://www.orthosc.org/locations">Locations</a></li>
				<li ><a href="https://www.orthosc.org/services">Services</a></li>
			</div>
			<div id="fLinks2">
				
				<li ><a href="https://www.orthosc.org/patient-resources">Patient Resources</a></li>
				<li><a href="https://www.orthosc.org/about-us/careers" >Employment Opportunities</a></li>
				<li ><a href="https://www.orthosc.org/news">News &amp; Events</a></li>
				<li><a href="https://17161.portal.athenahealth.com/" >Patient Portal</a></li>
			</div>
			<div id="fLinks3">
				<li ><a href="https://www.orthosc.org/online-bill-pay">Online Bill Pay</a></li>
				<li ><a href="https://www.orthosc.org/about-us/contact-us">Contact Us</a></li>
				<li ><a href="https://www.orthosc.org/about-us/privacy-policy">Privacy Policy</a></li>
				<li ><a href="https://www.orthosc.org/about-us/notice-non-discrimination">Notice of Non-Discrimination</a></li>
				
			</div>
			
		  <p><strong><br><br><br><br>Copyrighted by OrthoSC&copy;,&ensp;2019</strong></p>
	
	</div>
		<footer>
			<div id="navArea">
				<nav id="navFootBar">
					<ul>
						<li><a href="https://www.orthosc.org"><i class="fas fa-home"></i></a></li>
						<li><a href="https://www.orthosc.org/about-us">ABOUT US</a></li>
						<li><a href="https://www.orthosc.org/doctors">DOCTORS</a></li>
						<li><a href="https://www.orthosc.org/specialties">SPECIALTIES</a></li>
						<li><a href="https://www.orthosc.org/locations">LOCATIONS</a></li>
						<li><a href="https://www.orthosc.org/services">SERVICES</a></li>
						<li><a href="https://www.orthosc.org/patient-resources">PATIENT RESOURCES</a></li>
					</ul>
				</nav>
			</div>
		</footer>
	</body>
	</center>
</html>


