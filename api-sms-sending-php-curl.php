<?php
// variables
$var = array();
$var['email'] = 'your_account_email@any.com';
$var['password'] = 'your_account_password';
$var['appkey'] = 'your_app_key';
$var['secretkey'] = 'your_app_secret_key';
// must be include country calling code example: 84973367
$var['phone'] = 'send_to_phone_number';
$var['content'] = 'message_content';
// get token
$curl = curl_init();
curl_setopt_array($curl, array(
	CURLOPT_URL => 'https://trustsms.net/api/login',
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 0,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_CUSTOMREQUEST => 'POST',
	CURLOPT_POSTFIELDS => array('email' => $var['email'], 'password' => $var['password']),
));
$response = curl_exec($curl);
curl_close($curl);
$response = json_decode($response, 1);
if(!isset($response['data']) && !isset($response['data']['access_token']))
{
	echo 'Can not get access token.';
	exit();
}
// send sms via trustsms api
$curl = curl_init();
curl_setopt_array($curl, array(
	CURLOPT_URL => 'https://trustsms.net/api/mtsend',
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 0,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_CUSTOMREQUEST => 'POST',
	CURLOPT_POSTFIELDS => array('appkey' => $var['appkey'], 'secretkey' => $var['secretkey'], 'phone' => $var['phone'], 'content' => $var['content']),
	CURLOPT_HTTPHEADER => array('Authorization: Bearer ' . $response['data']['access_token']),
));
$response = curl_exec($curl);
curl_close($curl);
echo $response;
?>