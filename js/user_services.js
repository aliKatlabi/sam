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
			
			document.getElementById("q_res").style.height  = "150px";
			document.getElementById("q_res").style.padding = "8px 8px 8px 8px";
			
			logger(this,37,"q_res");
		}
  };

  xhttp.open("POST","service/user_update_db.php" , true);
  xhttp.send(fd);
}


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
			
			
			logger(this,37,"q_res");
		}
  };


  xhttp.open("POST","service/user_query_grade.php" , true);
  xhttp.send(fd);
}


function update_info(){
	
	if (window.XMLHttpRequest) {
		   xhttp = new XMLHttpRequest();
		 } else {
		   xhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		
	xhttp.onreadystatechange = function() {
	if (this.readyState == 4 && this.status == 200)
		{
			
			 logger(this,37,"text_area");
		}
  };

   xhttp.open("POST","service/user_query_info.php" , true);
   xhttp.send("");
}

var pos = 0;

function logger(response,speed,elementid)
{
		
	var elem = document.getElementById(elementid);
	var str  = response.responseText;
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
	
} 

