<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
include("connection/connect.php");
if (!$db) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Start session
session_start();

// Redirect if user is not logged in
if (empty($_SESSION["user_id"])) {
    header('location:login.php');
    exit();
}

// Set timezone
date_default_timezone_set("asia/kolkata");

// Initialize variables
$item_total = 0;
$success = "";
$error = "";

// Handle Payment Response from Cashfree
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['txnId']) && isset($_POST['txnStatus'])) {
    // Log payment response
    error_log("Payment Gateway Response: " . print_r($_POST, true));

    // Extract payment details
    $order_id = $_POST['orderId'];
    $transaction_id = $_POST['txnId'];
    $payment_status = ($_POST['txnStatus'] == 'SUCCESS') ? 'Paid' : 'Failed';

    // Update payment_status in payments table
    $updateSQL = "UPDATE payments SET payment_status = '$payment_status', transaction_id = '$transaction_id' WHERE order_id = '$order_id'";
    mysqli_query($db, $updateSQL);

    // Redirect based on payment success or failure
    if ($payment_status == 'Paid') {
        header('Location: success.php');
    } else {
        header('Location: failure.php');
    }
    exit(); // Stop further execution
}

// Calculate total cart value
foreach ($_SESSION["cart_item"] as $item) {
    $item_total += ($item["price"] * $item["quantity"]);
}

// Handle Form Submission for Checkout
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    if (!empty($_POST['pickTime'])) {
        if (substr($_POST['pickTime'], 0, 2) < date("G")) {
            $error = "Pick-Up Time Not Valid!";
        } elseif (substr($_POST['pickTime'], 0, 2) == date("G")) {
            if (substr($_POST['pickTime'], 3, 2) < date("i") + 10) {
                $error = "Please Select Time After 10 Minutes";
            } else {
                $payment_method = $_POST['mod'];
                if ($payment_method == 'COD') {
                    $SQL = "INSERT INTO users_orders(u_id, title, quantity, price, pick_time, payment_status) VALUES('" . $_SESSION["user_id"] . "','" . $item["title"] . "','" . $item["quantity"] . "','" . $item["price"] . "','" . $_POST['pickTime'] . "', 'COD')";
                    if (mysqli_query($db, $SQL)) {
                        $order_id = mysqli_insert_id($db);

                        // Insert payment info for COD
                        $SQL = "INSERT INTO payments (order_id, user_id, payment_amount, payment_status, payment_method) 
                                VALUES ('" . $order_id . "', '" . $_SESSION["user_id"] . "', '" . $item_total . "', 'COD', 'COD')";
                        if (mysqli_query($db, $SQL)) {
                            unset($_SESSION["cart_item"]);
                            $success = "Thankyou! Your Order Placed successfully! <p>You will be redirected to Order Page in <span id='counter'>5</span> second(s).</p>
                            <script>
                            function countdown() {
                                var i = document.getElementById('counter');
                                if (parseInt(i.innerHTML)<=0) {
                                    location.href = 'your_orders.php';
                                }
                                i.innerHTML = parseInt(i.innerHTML)-1;
                            }
                            setInterval(countdown, 1000);
                            </script>";
                        } else {
                            $error = "Database error: " . mysqli_error($db);
                        }
                    } else {
                        $error = "Database error: " . mysqli_error($db);
                    }
                } elseif ($payment_method == 'UPI') {
                    // First, insert the order into users_orders
                    $SQL = "INSERT INTO users_orders (u_id, title, quantity, price, pick_time, payment_status) 
                            VALUES ('" . $_SESSION["user_id"] . "', '" . $item["title"] . "', '" . $item["quantity"] . "', '" . $item["price"] . "', '" . $_POST['pickTime'] . "', 'PAID')";
                
                    if (mysqli_query($db, $SQL)) {
                        $order_id = mysqli_insert_id($db); // Get the newly created order ID
                
                        // Insert into payments table with PENDING status
                        $SQL = "INSERT INTO payments (order_id, user_id, payment_amount, payment_status, payment_method) 
                                VALUES ('" . $order_id . "', '" . $_SESSION["user_id"] . "', '" . $item_total . "', 'PAID', 'UPI')";
                        
                        if (mysqli_query($db, $SQL)) {
                            // Redirect to Cashfree with correct order_id
                            $cashfree_url = "https://test.cashfree.com/billpay/checkout/post/submit";
                            $app_id = "TEST10323353dd615588a92764db9a9335332301";
                            $secret_key = "cfsk_ma_test_0a60a66d37c1ab96dcd3d4056cf57e04_f7f25b7b";
                            $order_amount = $item_total;
                            $customer_name = "vishal";
                            $customer_email = "vishal@cashfree.com";
                            $customer_phone = "9999999999";
                            $return_url = "http://localhost:3000/Canteen_Management/your_orders.php";
                
                            $postData = array(
                                "appId" => $app_id,
                                "orderId" => $order_id, // Ensure correct order_id is passed
                                "orderAmount" => $order_amount,
                                "orderCurrency" => "INR",
                                "orderNote" => "Order Payment",
                                "customerName" => $customer_name,
                                "customerEmail" => $customer_email,
                                "customerPhone" => $customer_phone,
                                "returnUrl" => $return_url,
                                "notifyUrl" => $return_url
                            );
                
                            ksort($postData);
                            $signatureData = "";
                            foreach ($postData as $key => $value) {
                                $signatureData .= $key . $value;
                            }
                            $signature = hash_hmac('sha256', $signatureData, $secret_key, true);
                            $signature = base64_encode($signature);
                
                            $postData['signature'] = $signature;
                
                            echo '<form id="cashfreeForm" action="' . $cashfree_url . '" method="post">';
                            foreach ($postData as $key => $value) {
                                echo '<input type="hidden" name="' . $key . '" value="' . $value . '">';
                            }
                            echo '</form>';
                            echo '<script>document.getElementById("cashfreeForm").submit();</script>';
                            exit();
                        } else {
                            $error = "Database error: " . mysqli_error($db);
                        }
                    } else {
                        $error = "Database error: " . mysqli_error($db);
                    }
                }
                
            }
        } else {
            $error = "Pick-Up Time Must be Fillup!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Checkout</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style-starter.css">
</head>
<body>
    <?php include_once('header.php'); ?>
    <section class="w3l-breadcrumb">
        <div class="container">
            <ul class="breadcrumbs-custom-path">
                <li><a href="index.php">Home</a></li>
                <li class="active"><span class="fa fa-arrow-right mx-2" aria-hidden="true"></span> Checkout</li>
            </ul>
        </div>
    </section>
    <div class="container">
        <span style="color:green;"> <?php echo $success; ?></span>
        <span style="color:red;"> <?php echo $error; ?></span>
    </div>
    <div class="container m-t-30">
        <form action="" method="post">
            <div class="widget clearfix">
                <div class="widget-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="cart-totals margin-b-20">
                                <div class="cart-totals-title">
                                    <h4>Cart Summary</h4>
                                </div>
                                <div class="cart-totals-fields">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>Cart Subtotal</td>
                                                <td> <?php echo "₹" . $item_total; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Pick-Up Time</td>
                                                <td><input type="time" id="pickTime" name="pickTime" required></td>
                                            </tr>
                                            <tr>
                                                <td class="text-color"><strong>Total</strong></td>
                                                <td class="text-color"><strong> <?php echo "₹" . $item_total; ?></strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="payment-option">
                                <ul class=" list-unstyled">
                                    <li>
                                        <label class="custom-control custom-radio  m-b-20">
                                            <input name="mod" id="radioStacked1" checked value="COD" type="radio" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">Payment on delivery</span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="custom-control custom-radio  m-b-10">
                                            <input name="mod" type="radio" value="UPI" class="custom-control-input"> <span class="custom-control-indicator"></span> <span class="custom-control-description">UPI Payment</span>
                                        </label>
                                    </li>
                                </ul>
                                <p class="text-xs-center"> <input type="submit" onclick="return confirm('Are you sure?');" name="submit" class="btn btn-outline-success btn-block" value="Order now"> </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php include_once('footer.php'); ?>
    <script src="js/jquery.min.js"></script>
    <script src="js/tether.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/animsition.min.js"></script>
    <script src="js/bootstrap-slider.min.js"></script>
    <script src="js/jquery.isotope.min.js"></script>
    <script src="js/headroom.js"></script>
    <script src="js/foodpicky.min.js"></script>
    <script src="js/jquery.toaster.js"></script>
</body>
</html>