<?php

class Payload{

	$alert;
	$badge;
	$sound;

	function __construct($alert, $badge, $sound){

		$this->alert = $alert;
		$this->badge = $badge;
		$this->sound = $sound;
	}

}

?>