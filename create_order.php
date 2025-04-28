<?php
require('razorpay-php-master/Razorpay.php'); 

use Razorpay\Api\Api;

session_start();
include 'config.php'; 

$api_key = "rzp_test_d";
$api_secret = "SlIcM2Xx90nqZ6dBld9D7Eft";

$api = new Api($api_key, $api_secret);

$amount = 50000; 
$orderData = [
    'receipt'         => uniqid(),
    'amount'          => $amount,
    'currency'        => 'INR',
    'payment_capture' => 1
];

$order = $api->order->create($orderData);
$order_id = $order['id'];


$_SESSION['razorpay_order_id'] = $order_id;


echo json_encode(['order_id' => $order_id]);
?>
