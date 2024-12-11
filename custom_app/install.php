<?php
// Load environment variables
require_once 'vendor/autoload.php'; // Ensure Composer's autoloader is included
Dotenv\Dotenv::createImmutable(__DIR__)->load(); // Load .env file

$shop = $_GET['shop'];
$api_key = getenv('API_KEY'); // Retrieve the API key from the .env file
$scopes = "read_customers";
$redirect_uri = "https://shopify-customer-viewer.vercel.app/custom_app/generate_token.php";

// Build the installation URL
$install_url = "https://" . $shop . "/admin/oauth/authorize?client_id=" . $api_key . "&scope=" . $scopes . "&redirect_uri=" . urlencode($redirect_uri);

// Redirect to the install URL
header("Location: " . $install_url);
die();
?>
