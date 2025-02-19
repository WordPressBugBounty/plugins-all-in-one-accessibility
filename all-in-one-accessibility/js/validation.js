function validate_data(){
	var business_id=document.getElementById("showhorse_business_id").value;
	if(business_id==''){
		document.getElementById("error_business_id").style.display = "block";  
		document.getElementById("showhorse_business_id").focus()
		return false;
	}
	
}