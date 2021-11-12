<?php
include_once(__DIR__ . '/vendor/autoload.php');
include_once('config.php');

use GuzzleHttp\Client;


session_start();

$state = $_SESSION['state'];
$code_verifier = $_SESSION['code_verifier'];


$data = [
    'grant_type' => 'authorization_code',
    'client_id' => $config['client_id'],
    'redirect_uri' => $config['redirect_uri'],
    'code_verifier' => $code_verifier,
    'code' => $_REQUEST['code'],

];


$response = (new Client)->post('https://mark.guncritic.com/oauth/token', [
    'form_params' => $data,
]);

echo json_decode((string) $response->getBody(), true);
