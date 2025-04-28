<?php
include 'config.php';
require 'vendor/autoload.php';
use Razorpay\Api\Api;

$keyId = "rzp_test_5ibSUgMDlbF8SS";
$keySecret = "QBWC2BUAnMAVNDP3Y4XeaV7d";
$api = new Api($keyId, $keySecret);

if (isset($_GET['payment_id']) && isset($_GET['order_id']) && isset($_GET['signature'])) {
    $payment_id = $_GET['payment_id'];
    $order_id = $_GET['order_id'];
    $signature = $_GET['signature'];

    // Verify Payment Signature (Optional but recommended)
    try {
        $attributes = [
            'razorpay_order_id' => $order_id,
            'razorpay_payment_id' => $payment_id,
            'razorpay_signature' => $signature
        ];
        $api->utility->verifyPaymentSignature($attributes);

        // Update order status in the database
        mysqli_query($conn, "UPDATE `orders` SET payment_status = 'Completed', transaction_id = '$payment_id' WHERE razorpay_order_id = '$order_id'") 
        or die('Query failed');

        // Redirect to order confirmation page
        header("Location: order_confirmation.php?order_id=$order_id");
        exit;
    } catch (Exception $e) {
        echo "Payment verification failed: " . $e->getMessage();
    }
} else {
    echo "Invalid request!";
}
?>
