<?php

require_once 'include/global_context.php';

class Deployment{

	static $target_development = "Development";
	static $target_production = "Production";
}

//APNS Gateway
if(GlobalContext::$modeOfDeployment == Deployment::$target_production){

	define("APNS_GATEWAY", "$gateway = 'gateway.push.apple.com");	
}
else if(GlobalContext::$modeOfDeployment == Deployment::$target_development){

	define("APNS_GATEWAY", "gateway.sandbox.push.apple.com");
}

define("DEVELOPMENT_PORT", "2195");
define("SOUND_NAME", "default");

?>