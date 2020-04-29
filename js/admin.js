
function openNav() {
  document.getElementById("settings_").style.width = "280px";
}


/* Set the width of the side navigation to 0 */
function closeNav() {
	  document.getElementById("settings_").style.width = "0";
	  document.getElementById("subjectcode_").value = "";
	  document.getElementById("subjectname_").value = "";
	  document.getElementById("maxgrade_").value = "";
	  document.getElementById("mingrade_").value = "";
	  document.getElementById("deadline_").value = "";
	  document.getElementById("loggertxt_").innerHTML = "";
	 
}