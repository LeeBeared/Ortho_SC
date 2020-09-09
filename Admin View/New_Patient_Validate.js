"use strict";
/*
	Java script for the New Patient page for Ortho Sc
	This java script will validate the new patient form
	and finally display thanking the patient for their time
	
	Name: LeeWayne Barrineau
	Date: 11/7/2019
	File Name: New_Patient_Validate.js
	
	formTest()
      
	setMessage()
		Will make a thank you message to display while the user is 
		typing into the form.
*/

window.addEventListener("load", function() {
	 document.getElementById("buttonSubmit").onclick = formTest(); 
	document.getElementById("firstName").onblur = setMessage();
	document.getElementById("lastName").onblur = setMessage();	
	
})
function formTest() {


	//Custom Zip Vailadtion 

	//Test for sex if reuirqed
   }
 /* set Message will use the first and last name fields from the patientForm
	to create a personal thank you message
 */
function setMessage(){
	sessionStorage.patientName= document.forms.patientForm.elements.firstName.value + " " 
								+ document.forms.patientForm.elements.lastName.value;
	var sexManners="";
	
	if(document.forms.patientForm.elements.sexMBox.checked){
		sexManners="Mr. ";
	}
	else if(document.forms.patientForm.elements.sexFBox.checked){
		sexManners="Ms. ";
	}
	
	
	document.getElementById("completionMessage").textContent = 
			"Thank you "+sexManners+sessionStorage.patientName+
			" for consdering Ortho SC as your next"+
			" place of care.";
	
}


