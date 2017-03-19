
<?php

$name = "Rsvi";

if(isset($_FILES['file_upload'])){

	$file = $_FILES['file_upload'];
	
	//Properties
	$file_name = $file['name'];
	$file_path = $file['tmp_name'];
	$file_size = $file['size'];
	$file_error = $file['error'];
	
	$file_name_array = explode('.', $file_name);
	$file_extension = strtolower(end($file_name_array));

	$allowed = array('png','jpg','txt');
	if(in_array($file_extension, $allowed)){

		if($file_error === 0){

			if($file_size <= 2000000){

				$file_new_name = uniqid('',true).'.'.$file_extension;

				$file_destination = 'uploads/'.$file_new_name;

				if(move_uploaded_file($file_path, $file_destination)){

					echo "Successfully Uploaded  ".$file_destination. " :)";
}
else{

	echo "Error while Saving.";
}
}
else{

	echo "File Size Error";
}
}
else{

	echo "File Error";
}
}
else{

	echo "Files Format are not allowed";
}
}

?>

<?php

class UploadManager{

	function __construct(){

		require_once 'include/global_context.php';
	}

	function uploadFile($file){

		if(isset($file)){

			//File Information
			$file_name = $file['name'];
			$file_path = $file['tmp_name'];
			$file_size = $file['size'];
			$file_error = $file['error'];

			$file_name_array = explode('.', $file_name);
			$file_extension = strtolower(end($file_name_array));

			//Only *.PEM files are allowed
			$allowedExtension = array('pem', 'jpg');

			if(in_array($file_extension, $allowedExtension)){

				if($file_error == null){

					if($file_size < 500000){

						//Everything is file, Upload to Destination
						$file_new_name = uniqid('',true).'.'.$file_extension;

						$file_destination = 'uploads/'.$file_new_name;

						if(move_uploaded_file($file_path, $file_destination)){

							//echo "Successfully Uploaded  ".$file_destination. " :)";

							GlobalContext::$hasCertificateUploaded = true;
							
							return $file_destination;
						}
						else{

							GlobalContext::$hasCertificateUploaded = false;
							return "Error while Saving to passed location.";
						}
					}
					else{

						GlobalContext::$hasCertificateUploaded = false;
						return "Your Certificate Size is greater than the limit.";
					}
				}
				else{

					GlobalContext::$hasCertificateUploaded = false;
					return "There is Errror : $file_error";
				}
			}
			else{

				GlobalContext::$hasCertificateUploaded = false;
				if($file_extension != null){

					return "Sorry, this file extension ( *.$file_extension ) is Not Allowed.";
				}
				else{
					return "Please, Add your APNS Certficate (*.pem)";
				}
			}
		}
		else{

			echo "Hell";
		}
	}
}

?>