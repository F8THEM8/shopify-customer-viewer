<?php
// Load environment variables
require_once 'vendor/autoload.php'; // Composer's autoloader
Dotenv\Dotenv::createImmutable(__DIR__)->load(); // Load the .env file

// Set variables for our request
$api_key = getenv('API_KEY'); // Shopify API key from .env
$shared_secret = getenv('SECRET_KEY'); // Shopify secret key from .env

$params = $_GET; // Retrieve all request parameters
$hmac = $_GET['hmac']; // Retrieve HMAC request parameter

$params = array_diff_key($params, array('hmac' => '')); // Remove hmac from params
ksort($params); // Sort params lexicographically
$computed_hmac = hash_hmac('sha256', http_build_query($params), $shared_secret);

// Use hmac data to check that the response is from Shopify or not
if (hash_equals($hmac, $computed_hmac)) {
    // Set variables for our request
    $query = array(
        "client_id" => $api_key, // Your API key
        "client_secret" => $shared_secret, // Your app credentials (secret key)
        "code" => $params['code'] // Grab the access key from the URL
    );
    // Generate access token URL
    $access_token_url = "https://" . $params['shop'] . "/admin/oauth/access_token";
    // Configure curl client and execute request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $access_token_url);
    curl_setopt($ch, CURLOPT_POST, count($query));
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($query));
    $result = curl_exec($ch);
    curl_close($ch);
    // Store the access token
    $result = json_decode($result, true);
    $access_token = $result['access_token'];
    // Show the access token (don't do this in production!)
    // Here is the place where you can store the access token to the database
    echo $access_token;
} else {
    // Someone is trying to be shady!
    die('This request is NOT from Shopify!');
}
