<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
# This is a sample page to understand how to connect payment gateway

require_once(__DIR__ . "/lib/SslCommerzNotification.php");

include("db_connection.php");
include("OrderTransaction.php");
include("database_connect.php");
require("vendor/autoload.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use SslCommerz\SslCommerzNotification;

# Organize the submitted/inputted data
$post_data = array();

$post_data['total_amount'] = $_POST['amount'];
// $post_data['total_amount'] = 500;
$post_data['currency'] = "BDT";
$post_data['tran_id'] = "SSLCZ_TEST_" . uniqid();
$email = $_SESSION['email'];
$mobile = $_SESSION['phone'];
# CUSTOMER INFORMATION
// $post_data['cus_name'] = isset($_POST['customer_name']) ? $_POST['customer_name'] : "John Doe";
$post_data['cus_email'] = isset($email) ? $email : "john.doe@email.com";
$post_data['cus_add1'] = "Dhaka";
$post_data['cus_add2'] = "Dhaka";
$post_data['cus_city'] = "Dhaka";
$post_data['cus_state'] = "Dhaka";
$post_data['cus_postcode'] = "1000";
$post_data['cus_country'] = "Bangladesh";
$post_data['cus_phone'] = isset($mobile) ? $mobile : "01711111111";
$post_data['cus_fax'] = "01711111111";
$post_data['user_id'] = $_SESSION['user_id'];
$post_data['event_id'] = intval($_POST['event_id']);

# SHIPMENT INFORMATION
$post_data["shipping_method"] = "YES";
$post_data['ship_name'] = "Store Test";
$post_data['ship_add1'] = "Dhaka";
$post_data['ship_add2'] = "Dhaka";
$post_data['ship_city'] = "Dhaka";
$post_data['ship_state'] = "Dhaka";
$post_data['ship_postcode'] = "1000";
$post_data['ship_phone'] = "";
$post_data['ship_country'] = "Bangladesh";

$post_data['emi_option'] = "1";
$post_data["product_category"] = "Electronic";
$post_data["product_profile"] = "general";
$post_data["product_name"] = "Computer";
$post_data["num_of_item"] = "1";



# First, save the input data into local database table `orders`
$query = new OrderTransaction();
$sql = $query->saveTransactionQuery($post_data);

if ($conn_integration->query($sql) === TRUE) {
    $sslcomz = new SslCommerzNotification();
    $sslcomz->makePayment($post_data, 'hosted');
} else {
    echo "Error: " . $sql . "<br>" . $conn_integration->error;
}

