<?php
require_once("inc/functions.php");

$requests = $_GET;
$hmac = $_GET['hmac'];
$serializeArray = serialize($requests);
$requests = array_diff_key($requests, array('hmac' => ''));
ksort($requests);

$token = "YOUR_ACCESS_TOKEN"; // The access token you received after app installation
$shop = "https://7r4f3s-11.myshopify.com"; // Your Shopify store's subdomain (e.g., "your-store.myshopify.com")

// Make a call to Shopify API to retrieve customers
$customers = shopify_call($token, $shop, "/admin/api/2024-01/customers.json", array(), 'GET');
$customers = json_decode($customers['response'], JSON_PRETTY_PRINT);

// Display customer data (Name, Address, Phone, Email)
foreach ($customers['customers'] as $customer) {
    echo "Name: " . $customer['first_name'] . " " . $customer['last_name'] . "<br>";
    echo "Email: " . $customer['email'] . "<br>";
    echo "Phone: " . $customer['phone'] . "<br>";

    // Assuming address is available
    if (!empty($customer['addresses'])) {
        foreach ($customer['addresses'] as $address) {
            echo "Address: " . $address['address1'] . ", " . $address['city'] . ", " . $address['province'] . ", " . $address['country'] . "<br>";
        }
    }
    echo "<br>";
}
?>
