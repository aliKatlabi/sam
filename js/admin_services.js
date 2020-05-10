function service_query() {
	
		var f  = document.getElementById("panel_form2"); 
		var fd = new FormData(f);
		var q  = document.getElementById("queries").value;
		//alert(q);
		if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
				let str = this.responseText;
			
				document.getElementById("db_table_").innerHTML = str;
				//let logtext = str.split(/[<td>]+ \w*\s* \w* [</td>]+/g)+"\n";
				//logger(logtext);
			}
        };
		
        xmlhttp.open("GET","service/admin_query.php/?queries="+q,true);
        xmlhttp.send();
}

/* function service_query_settings(){
	
	if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
				 document.getElementById("db_table_").innerHTML = this.responseText;
				   }
        };
		
        xmlhttp.open("GET","service/admin_query.php",true);
        xmlhttp.send();
	
	
} */
function service_reset_table() {
	//	user the authenticate function
	//  request delete sql query for the Grade table 
	//(later)if exist delete the file table 
	

	
}
function authenticate(){
	// ask for process key
	// confirm the request
}

function service_submit_info() {
	
	if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
	
	var idcode = "";
	var grade  = "";
		
	idcode = document.getElementById("idcode_input").value;
	grade  = document.getElementById("grade_input").value;
	
	var confirmmsg = "comfirm "+grade+" for "+idcode+" ?\n\n"+
					 "  Take into consideration that :\n"+
					 "- You wont be able to modify afterward!\n"+
					 "- The grade will be sent automatically to the submitter's email";
				
	// CAN BE DONE : more checking on idcode or grade 
	
	if(confirm(confirmmsg)){

		var form_ = document.getElementById('panel_form1'); 
		var fd = new FormData(form_);
		
		xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
			logger(this.responseText);
		
			  //document.getElementById("logger_").innerHTML = this.responseText;
			  //alert(this.responseText);
            }
        };
		
		xmlhttp.open("POST","service/admin_submit.php",true);
        xmlhttp.send(fd);
		
	}else{
		logger("<span> <span id='pep'>+</span> review and submit again<span> <br> ");
	
	}

		
}

function service_save_settings() {
	

		if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
	
	
	
		var form_ = document.getElementById('setting_form_'); 
		var fd = new FormData(form_);
		
	
		xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
				
				logger(this.responseText);
				
            }
        };
		
		xmlhttp.open("POST","service/admin_settings.php",true);
        xmlhttp.send(fd);
	
	
}


function logger(responseText) {
		var today = new Date();
		today.setHours(0);
		document.getElementById("logger_").innerHTML += responseText;
		document.getElementById("logger_").innerHTML += "<span style='color:white; font-size:9px'>" + today +"<br><span>";
		
}

