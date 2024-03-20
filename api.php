<?php
header("Content-Type: application/json");
require 'api_functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $handler =  'handleGet';
    $input =  null;

    $response = call_user_func($handler, $input);
    echo $response;
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);

    $handler = 'handlePost';
    $response = call_user_func($handler, $data);
    echo $response;
} else {
    http_response_code(405);
    header('Allow: GET, POST');
    echo 'Only GET and POST requests are allowed.';
}
