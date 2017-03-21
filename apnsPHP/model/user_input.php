<?php

class UserInput{

	$token;
	$message;
	$pemPath;
	$isSandbox;

	function __construct($token, $message, $pemPath, $isSandbox){

		//Intialize
		$this->token = $token;
		$this->message = $message;
		$this->pemPath = $pemPath;
		$thos->isSandbox = $isSandbox;


	}

}

?>