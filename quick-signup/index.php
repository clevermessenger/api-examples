<?php
$profileId = $_GET["id"];
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://app.clevermessenger.com/api/match/?api_key=gkaf0cial0pdh4sc4564q6cydslg664m&profile_id=$profileId");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Accept: text/plain"
));

$response = curl_exec($ch);
$profileData = json_decode($response)->data->profile;
foreach ($profileData->custom_fields as $custom_field){
    if ($custom_field->name === "email")
        $email = $custom_field->value;
    else if ($custom_field->name === "phone")
        $phone = $custom_field->value;
}
curl_close($ch);


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Continue Signup</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-t-85 p-b-20">
				<form class="login100-form validate-form">

					<span class="login100-form-avatar">
						<img src="<?php echo $profileData->profile_picture ?>" alt="AVATAR">
					</span>

					<div class="wrap-input100 validate-input m-t-85 m-b-35" data-validate = "Full Name">
						<input class="input100" autocomplete="off" value="<?php echo "$profileData->first_name $profileData->last_name"  ?>" type="text" name="full_name">
						<span class="focus-input100" ></span>
					</div>


					<div class="wrap-input100 validate-input m-t-85 m-b-35" data-validate = "Email">
						<input class="input100" autocomplete="off_85z" value="<?php echo $email ?>" type="text" name="email" id="email">
						<span class="focus-input100" ></span>
					</div>


					<div class="wrap-input100 validate-input m-t-85 m-b-35"data-validate = "Phone">
						<input class="input100" autocomplete="off" type="text" value="<?php echo $phone ?>" name="phone" id="phone">
						<span class="focus-input100" ></span>
					</div>

					<div class="wrap-input100 validate-input m-t-85 m-b-35" data-validate = "password">
						<input class="input100" autocomplete="off_855" type="password" name="pss" id="pss">
						<span class="focus-input100" data-placeholder="Password"></span>
					</div>

					<div class="wrap-input100 validate-input m-t-85 m-b-35" data-validate = "Confirm password">
						<input class="input100" autocomplete="off_852" type="password" name="confirm_pss" id="confirm_pss">
						<span class="focus-input100" data-placeholder="Confirm Password"></span>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn" id="signup">
							Continue Signup
						</button>
					</div>

				</form>
			</div>
		</div>
	</div>


	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

    <script>
        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/messenger.Extensions.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'Messenger'));

    </script>

<script>

	$(document).ready(function(){
	    $("#signup").click(function(){
            $.get( "process.php?id=<?php echo $profileId ?>", function( data ) {
                MessengerExtensions.requestCloseBrowser(function success() {
                    // webview closed
                }, function error(err) {
                    // an error occurred
                });
            });
        })

	});

</script>

</body>
</html>