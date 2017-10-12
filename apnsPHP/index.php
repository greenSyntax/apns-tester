<?php

require_once 'manager/apns_manager.php';
require_once 'include/global_context.php';
require_once 'manager/upload_manager.php';
require_once 'include/resource.php';
require_once 'include/constants.php';

//Error Reporting
error_reporting(0);

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

		$error = ERROR_NO_TOKEN;
		array_push($errorLog, $error);

	}

	if(!empty($_POST['pushMessage'])){

		if($_POST['isJSON']== "true"){
				$isJSON = true;
		}
		else{
				$isJSON = false;
		}

			$message = $_POST['pushMessage'];
	}
	else{

		$error = ERROR_NO_MESSAGE;
		array_push($errorLog, $error);
	}

	if(!empty($_POST['certificate_mode'])){


		if($_POST['certificate_mode'] == "Development"){

			//DEVELOPMENT
			GlobalContext::$modeOfDeployment = "Development";
		}
		else{

			//PRODUCTION
			GlobalContext::$modeOfDeployment = "Production";
		}
	}
	else{

		$error = ERROR_NO_DEVELOPEMNT_MODE;
		array_push($errorLog, $error);
	}



	if(GlobalContext::$hasCertificateUploaded == true){

		$apnsManager = new ApnsManager();
		$apnsManager->sendPushNotification($token, $message, GlobalContext::$pathOfCertificate, false, $isJSON);

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
	<title>xAPNS</title>

	<!-- Style -->
	<link rel="stylesheet" href="style/style.css">

	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Francois+One|Questrial" rel="stylesheet">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Minified JavaScript -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body>

	<div class="container">
		<div class="col-sm-2"></div>
		<div class="col-sm-8">
			<p></p>
			<h1 class="headingFont"><span class="glyphicon glyphicon-apple"></span> <?php echo APP_NAME; ?> v<?php echo VERSION; ?></h1>
			<h4 class="secondaryFont"><?php echo DESCRIPTION; ?></h4>
			<!-- <a href="#" class="grayFont text-right"><kbd> Configure Payload </kbd></a> -->
			<hr>

			<form method="POST" enctype="multipart/form-data">

				<label class="control-label primaryFont"><span class="glyphicon glyphicon-tag"></span><?php echo LABEL_TOKEN; ?></label>
				<a href="#" data-toggle="tooltip" title="<?php echo TOOLTIP_TOKEN; ?>"><span class="glyphicon glyphicon-question-sign"></span></a>
				<input type="text" name="pushToken" value="" placeholder="Device APNS Token" class="form-control primaryFont"></input>
				<br>
				<label class="control-label primaryFont"><span class="glyphicon glyphicon-comment"></span><?php echo LABEL_MESSAGE; ?></label>
				<a href="#" data-toggle="tooltip" title="<?php echo TOOLTIP_MESSAGE; ?>"><span class="glyphicon glyphicon-question-sign"></span></a>

				<textarea rows="4" name="pushMessage" class="form-control primaryFont" placeholder="Payload for Push Notification"></textarea>
				<br>
				<label class="formJson">
    			<input class="form-check-input" name="isJSON" type="checkbox" value="true">
    			Payload is as JSON
  			</label>
				<p></p>
				<!--

				<div class="checkbox">
					<label class="primaryFont">
						<input type="checkbox" value="Configure APNS Payload JSON." onClick="unhide(this, 'payload_json')"> Configure APNS Payload JSON.
					</label>
				</div>

				<div class="hidden" id="payload_json">

					<label class="control-label primaryFont"><span class="glyphicon glyphicon-volume-down"></span><?php echo LABEL_SOUND_NAME; ?></label>
					<a href="#" data-toggle="tooltip" title="<?php echo TOOLTIP_MESSAGE; ?>"><span class="glyphicon glyphicon-question-sign"></span></a>
					<input type="text" name="pushMessage" class="form-control primaryFont" placeholder="Your Message for Push Notification"></input>
					<br>
					<label class="control-label primaryFont"><span class="glyphicon glyphicon-star"></span><?php echo LABEL_BADGE_NUMBER; ?></label>
					<a href="#" data-toggle="tooltip" title="<?php echo TOOLTIP_MESSAGE; ?>"><span class="glyphicon glyphicon-question-sign"></span></a>
					<input type="text" name="pushMessage" class="form-control primaryFont" placeholder="Your Message for Push Notification"></input>
					<br>
					<label class="control-label primaryFont"><span class="glyphicon glyphicon-volume-off"></span><?php echo LABEL_IS_SILENT_PUSH; ?></label>
					<a href="#" data-toggle="tooltip" title="<?php echo TOOLTIP_MESSAGE; ?>"><span class="glyphicon glyphicon-question-sign"></span></a>
					<input type="text" name="pushMessage" class="form-control primaryFont" placeholder="Your Message for Push Notification"></input>
					<br>
				</div>
			-->

				<p></p>
				<label class="control-label primaryFont"><span class="glyphicon glyphicon-bookmark"></span> Development Mode</label>
				<a href="#" data-toggle="tooltip" title="<?php echo TOOLTIP_MODE; ?> "><span class="glyphicon glyphicon-question-sign"></span></a>
				<select name="certificate_mode" id="certificate_mode" class="form-control">
					<option id="mode_development" value="Development"><?php echo LABEL_MODE_DEVELOPMENT; ?></option>
					<option ="mode_production" value="Production"><?php echo LABEL_MODE_PRODUCTION; ?></option>
				</select>
				<br>
				<label class="control-label primaryFont"><span class="glyphicon glyphicon-paperclip"></span><?php echo LABEL_CERTIFICATE; ?></label>
				<a href="#" data-toggle="tooltip" title="<?php echo TOOLTIP_CERTFICATE; ?>"><span class="glyphicon glyphicon-question-sign"></span></a>
				<input type="file" class="primaryFont" name="certificate_upload"><br>

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
			<footer>
				<hr>
				<p class="text-center secondaryFont"><?php echo LABEL_MADE_WITH; ?> <span class="glyphicon glyphicon-headphones"></span> <strong>Stackoverflow</strong> | <a href="<?php echo GITHUB_PATH; ?>"><?php echo AUTHOR; ?></a></p>
			</div>
		</footer>

	</div>
	<div class="col-sm-2"></div>
</div>

<script>
$(document).ready(function(){

	$('[data-toggle="tooltip"]').tooltip();
});

function unhide(clickedButton, divID) {

	var item = document.getElementById(divID);

	if (item) {

		if(item.className=='hidden'){

			item.className = 'unhidden' ;
			clickedButton.value = 'hide'
		}else{

			item.className = 'hidden';
			clickedButton.value = 'unhide'
		}
	}}

	</script>

</body>
</html>
