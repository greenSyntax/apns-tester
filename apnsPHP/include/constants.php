<?php

define("AUTHOR", "Abhishek Kumar Ravi");
define("GITHUB_PATH", "https://github.com/greenSyntax");

define("APP_NAME", "xAPNS");
define("DESCRIPTION", "Test Your Apple Push Notification Service.");
define("VERSION", "1.0");

define("LABEL_TOKEN", " APNS Token");
define("TOOLTIP_TOKEN", "Unique Token which you'll get in your iPhone. (Refer to  #123)");
define("LABEL_MESSAGE", " Push Notification Message");
define("TOOLTIP_MESSAGE", "Message which you'll see in your Push Message.");
define("LABEL_CERTIFICATE", " APNS Certificate (*.pem)");
define("TOOLTIP_CERTFICATE", "APNS Certificate which your export from your Keychain and then convert into *.pem. (Refer to #123)");
define("LABEL_MADE_WITH", "Made with ");
define("TOOLTIP_MODE", "It depends upon the kind of Certificate you are using. Refer to #123");
define("LABEL_MODE_DEVELOPMENT", "Development");
define("LABEL_MODE_PRODUCTION", "Production");

define("UPLOAD_DIRECTORY_NAME", "uploads");
define("UPLOAD_FILE_SIZE", "500000");
define("FILE_TYPE", "pem");

define("ERROR_NO_TOKEN", "Sorry, You'vent given your APNS Token.");
define("ERROR_NO_MESSAGE", "Sorry, There is No Message for Push Notification.");
define("ERROR_INCORRECT_PATH", "Sorry, Your Saving Location is invalid. (or, no permission)");
define("ERROR_INVALID_SIZE", "Sorry, You may have choosen wrong file.");
define("ERROR_INVALID_FILE", "Sorry, This type of file is not allowed.");
define("ERROR_NO_CERTIFICATE", "Sorry, you haven't choose your APNS certificate.");
define("ERROR_NO_DEVELOPEMNT_MODE", "Sorry, you haven't choosen any mode yet.");

?>