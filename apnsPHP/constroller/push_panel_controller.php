<?php

class PushPanelController{


	function setPushController($token, $messageText, $pathOfCertificate, $isSandbox){

		require_once 'model/user_input.php';

		//Instance of UserInput Model
		$userInput = new UserInput($token, $messageText, $pathOfCertificate, $isSandbox);

		//APNS Manager
		$apnsManager = new ApnsManager();

		//Upload Certificate


		$timeStamp;

		//Send Push Notfication
		$apnsManager->sendPushNotification($token, $messageText, $timeStamp, $isSandbox);

	}

}

?>