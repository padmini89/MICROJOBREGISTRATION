<?php
include('database.inc.php');
$msg='';
if(isset($_POST['submit'])){
	$name=mysqli_real_escape_string($con,$_POST['name']);
	$occupation=mysqli_real_escape_string($con,$_POST['occupation']);
	$contact=mysqli_real_escape_string($con,$_POST['contact']);
	$state=mysqli_real_escape_string($con,$_POST['state']);
	$city=mysqli_real_escape_string($con,$_POST['city']);
	$pincode=mysqli_real_escape_string($con,$_POST['pincode']);
	

	mysqli_query($con,"insert into contactus(name,occupation,contact,state,city,pincode) values('$name','$occupation','$contact','$state','$city','$pincode')");
	$msg='thanks you';

	// sms code here//
}
if(isset($_POST['sendotp'])){
	
	
 	$username = "pad35mini@gmail.com";
 	$hash = "43f8fa0562859fff901f7a7c63e52e4fc7c236de44e245e91a2d854f9c7a925d";
 	$test = "0";
 	$sender = "TXTLCL-microjob"; // This is who the message appears to be from.
 	$numbers = $_POST['contact']; // A single number or a comma-seperated list of numbers
 	$otp = mt_rand(10000, 99999);
 	setcookie("otp",$otp);
 	$message = "Hello " . $_POST['name'] . " This is your OTP: " . $otp;

 	// 612 chars or less
 	// A single number or a comma-seperated list of numbers
 	$message = urlencode($message);
 	$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
 	$ch = curl_init('http://api.textlocal.in/send/?');
 	curl_setopt($ch, CURLOPT_POST, true);
 	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 	$result = curl_exec($ch); // This is the result from the API
 		echo("otp sent succefully");
 	curl_close($ch);
 }
if(isset($_POST['verifyotp'])){
	
 	$verotp=$_POST['otp'];
 	if($verotp==$_COOKIE['otp']){
 		echo("verified succesfully");

 	}else{
 		echo("otp is wrong ");
 	}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Get City State from Pincode</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script> 

</head>                   
<body>
<div class="container">
	<div><legend><h2>MICRO JOB REGISTRATION</h2></legend></div>
	<div>&nbsp;</div>
	<form  action='auto_otp.php' autocomplete="off" method="post" id="frmPinCode" style="text-align:center;">
		<div>
			<input type="text" class="textbox" name="pincode" id="pincode" placeholder="Enter Pincode"  autocomplete="new-password">
			<input type="button" class="btn" value="Get Details" onclick="get_details()">
		</div>
		<div>&nbsp;</div>
		<div>
			<input type="text" class="textbox" id="name" name="name"  placeholder="your name"><br/><br>
			<input type="text" class="textbox" id="occupation" name="occupation"  placeholder="your occupation"><br/><br>
			<input type="number"  id="contact" name="contact"  placeholder="your contact number"><br/><br>
			<input type="text" class="textbox" id="city" name="city"  placeholder="City"><br/><br/>
			<input type="text" class="textbox" id="state"name="state"  placeholder="State"><br/><br/>
			<input type="text" class="textbox" id="district" name="district"  placeholder="district"><br/><br>
		</div>
		<div>
			<button type="submit" name="sendopt" class="btn btn-lg btn-success btn-block">Send OTP</button><br></br>
			<input type="text" class="form-control" id="otp" name="otp" placeholder="Enter OTP" maxlength="5" required=""><br></br>
			<button type="submit" name="verifyotp" class="btn btn-lg btn-info btn-block">Verify</button><br></br>
		</div>
		<br>
		<div>
			<input type="submit" class="btn" value="SUBMIT" name="submit" >
			
		</div>
	</form>
</div>
<script>
function get_details(){
	var pincode=jQuery('#pincode').val();
	if(pincode==''){
		jQuery('#city').val('');
		jQuery('#state').val('');
		jQuery('#district').val('');
	}else{
		jQuery.ajax({
			url:'get.php',
			type:'POST',
			data:'pincode='+pincode,
			success:function(data){
				if(data=='no'){
					alert('Wrong Pincode');
					jQuery('#city').val('');
					jQuery('#state').val('');
					jQuery('#district').val('');
				}else{
					var getData=$.parseJSON(data);
					jQuery('#city').val(getData.city);
					jQuery('#state').val(getData.state);
					jQuery('#district').val(getData.district);
				}
			}
		});
	}
}
</script>
<script>
	function send_otp(){

	}
</script>

          

</body>
</html>
