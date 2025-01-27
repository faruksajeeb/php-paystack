<?php
// Paystack secret key
$paystackSecretKey = 'sk_test_8ce098c48adc6bcffa0554275d49b179baf38953';

// Collect form data
$email = $_POST['email']; // Customer's email
$amount = $_POST['amount'] * 100; // Convert to kobo
$reference = $_POST['reference']; // Transaction reference

// Initialize a cURL session
$url = "https://api.paystack.co/transaction/initialize";
$fields = [
    'email' => $email,
    'amount' => $amount,
    'reference' => $reference,
    'callback_url' => 'https://php-paystack.test/verify_payment.php' // Callback URL
];
$fields_string = http_build_query($fields);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $paystackSecretKey",
    "Cache-Control: no-cache",
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);

if ($result['status']) {
    // Redirect to Paystack payment page
    header('Location: ' . $result['data']['authorization_url']);
    exit();
} else {
    echo "Error: " . $result['message'];
}
?>
