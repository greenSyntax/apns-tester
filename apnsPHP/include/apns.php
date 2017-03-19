
<?php

$apnsHost = 'gateway.sandbox.push.apple.com';
$apnsCert = $_SERVER['DOCUMENT_ROOT'].'/apple_push.pem';
$apnsPort = 2195;
$apnsPass = '<PASSWORD_GOES_HERE>';
$token = '30BE50C4CC7CBE5F6E6411ECCE98968E6C147FBEEC78AEB894DDAC515EC2F220';

$payload['aps'] = array('alert' => 'Oh hai!', 'badge' => 1, 'sound' => 'default');
$output = json_encode($payload);
$token = pack('H*', str_replace(' ', '', $token));
$apnsMessage = chr(0).chr(0).chr(32).$token.chr(0).chr(strlen($output)).$output;

$streamContext = stream_context_create();
stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);
//stream_context_set_option($streamContext, 'ssl', 'passphrase', $apnsPass);

$apns = stream_socket_client('ssl://'.$apnsHost.':'.$apnsPort, $error, $errorString, 2, STREAM_CLIENT_CONNECT, $streamContext);
fwrite($apns, $apnsMessage);
fclose($apns);

?>

