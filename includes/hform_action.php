<?php

if (isset($_POST['submit'])) {

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$street = $_POST['street'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip = $_POST['zip'];
$dob = $_POST['date_of_birth'];
$date_of_birth = Date('mdY',strtotime($dob));
$phone = str_replace('-', '', $_POST['phone']);
$email = $_POST['email'];
//$unit = $_POST['middle_name'];
//$unit = $_POST['unit'];
  
if(get_option( 'api_url_field' ) && get_option( 'auth_token_field' )){
	$apiUrl = get_option( 'api_url_field');
	$authToken = get_option( 'auth_token_field');
	$url = $apiUrl;
	$getData = '?auth_token='. $authToken.'&street='.$street.'&city='.$city.'&state='.$state.'&zip='.$zip .'&first_name='.$first_name.'&last_name='.$last_name.'&email='.$email.'&phone='.$phone.'&date_of_birth='.$date_of_birth;

	$response = wp_remote_get($url.$getData);

	$json = json_decode(wp_remote_retrieve_body($response));

		echo '<pre>';
		print_r($json);
		print_r('quote_premium = $'.$json->quote_premium);
		echo '</pre>';
	}
}

