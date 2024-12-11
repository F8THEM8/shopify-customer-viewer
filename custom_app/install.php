<?php
$shop = $_GET['shop'];
$api_key = "d634765af60561d695affc6d1d2f5981";
$scopes = "read_orders,write_products";
$redirect_uri = "http://github.COM/F8THEM8/shopify-customer-viewer/custom_app/generate_token.php";

$install_url = "https://" . $shop . "/admin/oauth/authorize?client_id=" . $api_key . "&scope=" . $scopes . "&redirect_uri=" . urlencode($redirect_uri);

header("Location: " . $install_url);
die();
?>
