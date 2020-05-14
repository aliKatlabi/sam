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
			
			document.getElementById("res").style.height  = "150px";
			document.getElementById("res").style.padding = "8px 8px 8px 8px";
			
			logger(this.responseText,37,"res");
			/* 
			ifHasChanged("index.html", function (nModif, nVisit) {
			 logger("The page '" + this.filepath + "' has been changed on " + (new Date(nModif)).toLocaleString() + "!",37,"q_res");
		
			}); */
		}
  };
  
	xhttp.addEventListener("progress", updateProgress);
	xhttp.addEventListener("load", transferComplete);
	xhttp.addEventListener("error", transferFailed);
	xhttp.addEventListener("abort", transferCanceled);

	xhttp.open("POST","service/user_update_db.php" , true);
	xhttp.send(fd);
}

function updateProgress (oEvent) {
  if (oEvent.lengthComputable) {
    var percentComplete = oEvent.loaded / oEvent.total * 100;
	
	document.getElementById("q_res").innerHTML+= percentComplete+"<br>";

    // ...
  } else {
	  document.getElementById("q_res").innerHTML+="... ";

    // Unable to compute progress information since the total size is unknown
  }
}

function transferComplete(evt) {
	  document.getElementById("q_res").innerHTML+="The transfer is complete."+"<br>";

	
}

function transferFailed(evt) {
		  document.getElementById("q_res").innerHTML+="An error occurred while transferring the file."+"<br>";

	}

function transferCanceled(evt) {
	 document.getElementById("q_res").innerHTML+="The transfer has been canceled by the user."+"<br>";

}



//////////////




function service_query() {
		
	var f  = document.getElementById("form_query"); 
	var fd = new FormData(f);

	if (window.XMLHttpRequest) {
		   // code for modern browsers
		   xhttp = new XMLHttpRequest();
		 } else {
		   // code for old IE browsers
		   xhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		
	xhttp.onreadystatechange = function() {
	if (this.readyState == 4 && this.status == 200)
		{
			
			document.getElementById("q_res").style.height = "100%";
			document.getElementById("q_res").style.padding ="8px 8px 8px 8px";
			//document.getElementById("q_res").style.borderBottomWidth = "20px";
			
			
			logger(this.responseText,37,"res");
		}
  };


  xhttp.open("POST","service/user_query_grade.php" , true);
  xhttp.send(fd);
}


function update_info(){
	
	let welocme = "All information will be secured and your identitiy will be hidden,for unbised grading ... enjoy!";
	
	if(logger(welocme,1,"text_area")){
		
		if (window.XMLHttpRequest) {
		   xhttp = new XMLHttpRequest();
		 } else {
		   xhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		
	xhttp.onreadystatechange = function() {
	if (this.readyState == 4 && this.status == 200)
		{
			
			 logger(this.responseText,37,"text_area");
		
		}
  };

  
}
	 xhttp.open("POST","service/user_query_info.php" , true);
   xhttp.send("");
}

////////////////////// testing last modified date changes
/* 
function getHeaderTime () {
  var nLastVisit = parseFloat(window.localStorage.getItem('lm_' + this.filepath));
  var nLastModif = Date.parse(this.getResponseHeader("Last-Modified"));

  if (isNaN(nLastVisit) || nLastModif > nLastVisit) {
    window.localStorage.setItem('lm_' + this.filepath, Date.now());
    isFinite(nLastVisit) && this.callback(nLastModif, nLastVisit);
  }
}

function ifHasChanged(sURL, fCallback) {
  var oReq = new XMLHttpRequest();
  oReq.open("HEAD"  , sURL);
  oReq.callback = fCallback;
  oReq.filepath = sURL;
  oReq.onload = getHeaderTime;
  oReq.send();
}
 */
//////////////////////////////
var pos = 0;

function logger(responsetext,speed,elementid)
{
		
	var elem = document.getElementById(elementid);
	var str  = responsetext;
	if(pos ==0)
	{
		var id = setInterval(frame, speed);
		function frame() 
		{
			if (pos >= str.length ) 
			{
				pos=0;
				 clearInterval(id);
					  
			} else 
			{
					
				if(str.charAt(pos)=='<')
				{
					pos+=4;
					elem.innerHTML += "<br>";
				}
				
				elem.innerHTML += str.charAt(pos++); 
					  
					
			}
		}
	}
	return true;
} 
