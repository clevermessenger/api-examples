<?php
$apiKey = "YOU API KEY";

// MAKE actual signup actions happen, like saving to ur database

// Make API call to clever messenger perform actions

function getUserIP()
{
    // Get real visitor IP behind CloudFlare network
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
        $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    }
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}


$ip = getUserIP();

$query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
if($query && $query['status'] == 'success') {
   $country = $query['country'];
   $city = $query['city'];
} else {
die();
}

$profileId = $_GET["id"];
$registrationId = rand();
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://app.clevermessenger.com/api/?api_key=$apiKey");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);

curl_setopt($ch, CURLOPT_POST, TRUE);

curl_setopt($ch, CURLOPT_POSTFIELDS, "{
  \"profile_id\": \"$profileId\",
  \"actions\": [
    {
      \"action\": \"attach_tag\",
      \"tag\": \"signup_finished\"
    },
    {
      \"action\": \"set_custom_field\",
      \"custom_field\": \"registration_id\",
      \"value\": \"$registrationId\"
    },
    {
      \"action\": \"send_flow\",
      \"flow_id\": \"8964\"
    }
  ],
  \"air_variables\": [
    {
      \"country\": \"$country\",
      \"city\": \"$city\"
    }
  ]
}");

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Content-Type: application/json"
));

$response = curl_exec($ch);
curl_close($ch);
