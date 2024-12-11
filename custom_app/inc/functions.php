<?php
function shopify_call($token, $shop, $api_endpoint, $array = array(), $method = 'GET') {
    $url = "https://" . $shop . ".myshopify.com" . $api_endpoint;
    
    // Initialize cURL session
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    // Set the headers for the request
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "X-Shopify-Access-Token: " . $token
    ));

    // Set the request method and parameters
    if ($method == 'POST') {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($array));
    }

    // Execute the cURL request and capture the response
    $response = curl_exec($ch);
    curl_close($ch);

    // Return the response
    return json_decode($response, true);
}
?>
