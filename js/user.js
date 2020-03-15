function service_submit() {

	var f = document.getElementById('form_submit'); 
	var fd = new FormData(f);

	if (window.XMLHttpRequest) {
		   // code for modern browsers
		   xhttp = new XMLHttpRequest();
		 } else {
		   // code for old IE browsers
		   xhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("q_res").innerHTML = this.responseText;
    }
  };
  var url = "service/user_update_db.php";
  alert(url);
  
  xhttp.open("POST",url , true);
  xhttp.send(fd);
}
//action="service/user_update_db.php" 