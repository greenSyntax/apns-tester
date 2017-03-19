<?php

require_once 'manager/apns_manager.php';
require_once 'include/global_context.php';
require_once 'manager/upload_manager.php';

//Error Array
$errorLog = array();

//onUpload
if(isset($_FILES['certificate_upload'])){

	$upload = new UploadManager();
	$uploadResponse = $upload->uploadFile($_FILES['certificate_upload']);

	if(GlobalContext::$hasCertificateUploaded == true){

		//File Destination Path
		GlobalContext::$pathOfCertificate = $uploadResponse; 		
	}
	else{

		// There is Some error in Uploading.
		array_push($errorLog, $uploadResponse);

	}
}

//onSendPushNotification
if(array_key_exists('apnsPush',$_POST)){


	# VALIDATION
	if(!empty($_POST['pushToken'])){

		$token = $_POST['pushToken'];	
	}
	else{

		$error = "There is No Token.";
		array_push($errorLog, $error);
		
	}
	
	if(!empty($_POST['pushMessage'])){

		$message = $_POST['pushMessage'];
	}
	else{

		$error = "There is No Push Message.";
		array_push($errorLog, $error);
	}

	if(GlobalContext::$hasCertificateUploaded == true){

		$apnsManager = new ApnsManager();
		$apnsManager->sendPushNotification($token, $message, GlobalContext::$pathOfCertificate, false); 

		//Successfully Sent
		echo '<div class="alert alert-success" role="success">
  							<span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span>
  							<span class="sr-only">Error:</span> Your Push Notification has successfully sent to Apple Push Notification Service.
						</div>';
	} 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-16">
	<title>APNS Panel</title>

	<!-- Style -->
	<link rel="stylesheet" href="style/style.css">

	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Francois+One|Questrial" rel="stylesheet">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

</head>
<body>
	
	<div class="container">
		<div class="col-sm-2"></div>
		<div class="col-sm-8">
			<p></p>
			<h1 class="headingFont"><span class="glyphicon glyphicon-apple"></span> xAPNS v1.0</h1>
			<h4 class="secondaryFont">Test Your Apple Push Notification Service. </h4>
			<hr>

			<form method="POST" enctype="multipart/form-data">
				<!-- 30BE50C4CC7CBE5F6E6411ECCE98968E6C147FBEEC78AEB894DDAC515EC2F220 -->
				
			<label class="control-label primaryFont"><span class="glyphicon glyphicon-tag"></span> APNS Token</label>
			<input type="text" name="pushToken" value="" placeholder="Device APNS Token" class="form-control primaryFont"></input>
			<br>
			<label class="control-label primaryFont"><span class="glyphicon glyphicon-comment"></span> Push Notification Message</label>
			<input type="text" name="pushMessage" class="form-control primaryFont" placeholder="Your Message for Push Notification"></input>
			<br>
			<label class="control-label primaryFont"><span class="glyphicon glyphicon-paperclip"></span> APNS Certificate (*.pem)</label>
			
			<input type="file" class="primaryFont" name="certificate_upload"><br>
			<!-- <input type="submit" class="btn btn-default" value="Upload"> -->

			<p></p>
			<input type="submit" class="btn btn-success primaryFont" name="apnsPush" id="apnsPush" value="Send Push Notification" /><br/>
			<br>
			<span name="error_lable" id="error_lable" class="text-warning primaryFont">
				<?php
				 if(isset($errorLog)){

				 	foreach ($errorLog as $error) {
				 		
				 		echo '<div class="alert alert-danger" role="alert">
  							<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
  							<span class="sr-only">Error:</span>'.
 						 	$error.'
						</div>';
				 	}
				 } 
				 ?>
				</span>
			</form>
			<footer class="footer">
			<hr>
			<p class="text-center secondaryFont">Made with <span class="glyphicon glyphicon-heart"></span> | <a href="https://github.com/greenSyntax">Abhishek Kumar Ravi</a></p>
			</div>	
			</footer>

		</div>
		<div class="col-sm-2"></div>
	</div>

</body>
</html>