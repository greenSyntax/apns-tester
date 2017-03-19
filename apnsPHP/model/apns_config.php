<?php

class ApnsConfig{

	private $hostName = "";
	private $certificatePath = "";
	private $hostPort = "";
	private $certificatePassword = "";
	private $apnsToken = "";

	function __construct($hostName, $certificatePath, $hostPort, $certificatePassword, $apnsToken){

		$this->hostName = $hostName;
		$this->certificatePath = $certificatePath;
		$this->hostPort = $hostPort;
		$this->certificatePassword = $certificatePassword;
		$this->apnsToken = $apnsToken;
	}

	function getHostName(){

		return $this->hostName;
	}

	function getCertificatePath(){

		return $this->certificatePath;
	}

	function getHostPort(){

		return $this->hostPort;
	}

	function getCertificatePassword(){

		return $this->certificatePassword;
	}

	function getApnsToken(){

		return $this->apnsToken;
	}

}

?>