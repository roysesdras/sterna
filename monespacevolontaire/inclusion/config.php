<?php
require_once './vendor/autoload.php';

$client = new Google_Client();
$client->setClientId('643673376458-ma2mf1coq3htbuo44spmm1vddofq1sk8.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('https://monespacevolontaire.sternaafrica.org/oauth_callback.php');
$client->addScope("email");
$client->addScope("profile");
?>
