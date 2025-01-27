<?php
// Paystack secret key
$paystackSecretKey = '';

// Get the reference from the URL
$reference = $_GET['reference'];

if (!$reference) {
    die('Transaction reference not found!');
}

// Verify the transaction
$url = "https://api.paystack.co/transaction/verify/$reference";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $paystackSecretKey",
    "Cache-Control: no-cache",
]);

$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);

if ($result['status'] && $result['data']['status'] === 'success') {
    // Payment was successful
    echo "Payment Successful! Transaction Reference: " . $reference;
    echo "<br>Amount Paid: " . ($result['data']['amount'] / 100) . " NGN";
} else {
    // Payment failed
    echo "Payment failed: " . $result['message'];
}
?>
