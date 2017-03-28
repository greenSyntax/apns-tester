
<?php

$apnsHost = 'gateway.push.apple.com';
$apnsCert = $_SERVER['DOCUMENT_ROOT'].'/apnsPHP/include/apns-prologic-pem.pem';
$apnsPort = 2195;
$apnsPass = '<PASSWORD_GOES_HERE>';
$token = '5b23f18a4778e3f61b72ac2cd7a158fd3db2b9aa981fb5257a4578a45883b4dd';
//'fc34a30c68edf50e9e33648e4dbe55e8c85e82de3e433c0db8a24d0e36234495';
//'10bbe69ad31dff33c59f4f62b56fa5996545f3775cea0e1246b82cf02e08ab91';
//'910c836eff02bb5ce062b1656cb1fb096188ab9fdebf5be82d2d4b28bddc5a6b';
//'10bbe69ad31dff33c59f4f62b56fa5996545f3775cea0e1246b82cf02e08ab91';

print_r($apnsCert);

$payload['aps'] = array('alert' => 'Hello Prologic Live!', 'badge' => 1, 'sound' => 'default');
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

