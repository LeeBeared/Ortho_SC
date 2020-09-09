"use strict";
/*
	Java script for the Admin Portal page for Ortho Sc
	
	
	Name: LeeWayne Barrineau
	Date: 11/8/2019
	File Name: Admin_Options.js
	
*/
findSearch();


function findSearch(){
	
	var patientDataArrays = new_Patients.directory.forEach(patientArray);
	patientDataArrays.forEach(buildPatientRow);
}

function buildPatientRow(record){
	var newRow = document.createElement("tr");
      
      var firstNameCell = document.createElement("td");
      firstNameCell.textContent = record.firstName;
	  newRow.appendChild(firstNameCell);
	 
	  var lastNameCell =document.createElement("td");
	  lastNameCell.textContent=record.lastName;
	  newRow.appendChild(lastNameCell);
      
	  var phoneCell = document.createElement("td");
      var phoneLink = document.createElement("a");
      phoneLink.setAttribute("href", "tel:" + record.phone);
      phoneLink.textContent = record.phone;
      phoneCell.appendChild(phoneLink);
      newRow.appendChild(phoneCell);  
	  
      var birthCell = document.createElement("td");
	  birthCell.textContent = record.birthDay;
      newRow.appendChild(birthCell);
	  
	  var streetCell = document.createElement("td");
	  streetCell.textContent = record.street;
      newRow.appendChild(streetCell);
	  
      var cityCell = document.createElement("td");
	  cityCell.textContent = record.city;
      newRow.appendChild(cityCell);
	  
	  var stateCell = document.createElement("td");
	  stateCell.textContent = record.state;
      newRow.appendChild(stateCell);
	  
	  var zipCell = document.createElement("td");
	  zipCell.textContent = record.zipcode;
      newRow.appendChild(zipCell);
	  
	  var sexCell = document.createElement("td");
	  sexCell.textContent = record.sex;
      newRow.appendChild(sexCell);
	  
	  var mailingCell = document.createElement("td");
	  mailingCell.textContent = record.mailing;
      newRow.appendChild(mailingCell);
	  
      tableBody.appendChild(newRow);   
}
function patientArray(id, firstName, lastName, phoneNumber, birthDay, street, city, state,
						zipcode,sex,mailing) {
   this.id = id;
   this.firstName = firstName;
   this.lastName = lastName;
   this.phone = phoneNumber;
   this.birthDay = birthDay;
   this.street = street;
   this.city = city;
   this.state = state;
   this.zipcode = zipcode;
   this.sex= sex;
   this.mailing = mailing;
}













