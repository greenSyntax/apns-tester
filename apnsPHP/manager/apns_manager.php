<?php

class ApnsManager{

	function __construct(){

		//Constant
		require_once 'include/config.php';

		//Model
		require_once 'model/apns_config.php';
	}

	# PRIVATE METHODS

	private function getToken($token){

		return pack('H*', str_replace(' ', '', $token));
	}

	private function getAPNSConfigration($hostName, $hostPort, $certificatePassword, $apnsToken, $certificatePath){

		$fullPathOfCertificate = $certificatePath;
		//$_SERVER['DOCUMENT_ROOT'].'/apnsPHP/uploads/apple_push.pem';

		//SSL Certifcate
		$apnsConfiggration = new ApnsConfig($hostName, $fullPathOfCertificate, $hostPort, $certificatePassword, $apnsToken );
		return $apnsConfiggration;
		
	}

	private function preparePayload($messageText){

		//JSON which we'll send to Apple.
		$payload = array('alert' => $messageText, 'badge' => 0, 'sound' => SOUND_NAME);

		return $payload;
	}

	private function prepareStreamContext($apnsCert ,$passwordOfCertificate = null){

		$streamContext = stream_context_create();
		stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);
		
		if($passwordOfCertificate != null){

			//When There is password for SSL Certficate.
			stream_context_set_option($streamContext, 'ssl', 'passphrase', $apnsPass);	
		}

		return $streamContext;
		
	}

	# Public Methods

	function sendPushNotification($token, $message, $certificatePath, $isSandbox){


		//Configration
		$configration = $this->getAPNSConfigration(DEVELOPMENT_GATEWAY, (int)DEVELOPMENT_PORT, null, $token, $certificatePath);

		$apnsHost = $configration->getHostName();
		$apnsCert = $configration->getCertificatePath(); 
		$apnsPort = $configration->getHostPort(); 
		$apnsPass = $configration->getCertificatePassword(); 
		$token = $configration->getApnsToken();

		//Prepare Payload
		$payloadArray = $this->preparePayload($message);
		$payload['aps'] =  $payloadArray;

		//Parse into JSON
		$output = json_encode($payload);

		//Split Token in Numeral.
		$token = $this->getToken($token);

		//Format APNS
		$apnsMessage = chr(0).chr(0).chr(32).$token.chr(0).chr(strlen($output)).$output;

		//Stram Text
		$streamContext = $this->prepareStreamContext($apnsCert ,$apnsPass);

		//Request for Push Notification
		$apns = stream_socket_client('ssl://'.$apnsHost.':'.$apnsPort, $error, $errorString, 2, STREAM_CLIENT_CONNECT, $streamContext);
		fwrite($apns, $apnsMessage);
		fclose($apns);

	}

}

?>
