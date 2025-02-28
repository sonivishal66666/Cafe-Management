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
if (isset($_SESSION["cart_item"]) && is_array($_SESSION["cart_item"])) {
    foreach ($_SESSION["cart_item"] as $item) {
        $item_total += ($item["price"] * $item["quantity"]);
    }
}

// Fetch user details for pre-filling form
$user_id = $_SESSION["user_id"];
$user_query = "SELECT * FROM users WHERE u_id = '$user_id'";
$user_result = mysqli_query($db, $user_query);
$user_data = mysqli_fetch_assoc($user_result);

// Handle Form Submission for Checkout
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    if (!empty($_POST['pickTime'])) {
        // Current time + 30 minutes (minimum pickup time)
        $minimum_pickup_time = date("H:i", strtotime("+30 minutes"));
        $selected_time = $_POST['pickTime'];
        
        if ($selected_time < $minimum_pickup_time) {
            $error = "<div class='alert alert-danger fade show'>Please select a pickup time at least 30 minutes from now.</div>";
        } else {
            $payment_method = $_POST['mod'];
            
            // Begin transaction
            mysqli_begin_transaction($db);
            try {
                // Insert order for each cart item
                foreach ($_SESSION["cart_item"] as $item) {
                    $item_title = mysqli_real_escape_string($db, $item["title"]);
                    $item_quantity = intval($item["quantity"]);
                    $item_price = floatval($item["price"]);
                    $pickup_time = mysqli_real_escape_string($db, $_POST['pickTime']);
                    $payment_status = ($payment_method == 'COD') ? 'COD' : 'PENDING';
                    
                    $SQL = "INSERT INTO users_orders(u_id, title, quantity, price, pick_time, payment_status) 
                            VALUES(?, ?, ?, ?, ?, ?)";
                    
                    $stmt = mysqli_prepare($db, $SQL);
                    mysqli_stmt_bind_param($stmt, "isidss", $user_id, $item_title, $item_quantity, $item_price, $pickup_time, $payment_status);
                    mysqli_stmt_execute($stmt);
                    
                    if ($payment_method == 'COD') {
                        $order_id = mysqli_insert_id($db);
                        
                        // Insert payment info for COD
                        $payment_SQL = "INSERT INTO payments (order_id, user_id, payment_amount, payment_status, payment_method) 
                                VALUES (?, ?, ?, 'COD', 'COD')";
                        
                        $payment_stmt = mysqli_prepare($db, $payment_SQL);
                        mysqli_stmt_bind_param($payment_stmt, "iid", $order_id, $user_id, $item_total);
                        mysqli_stmt_execute($payment_stmt);
                    }
                }
                
                // If payment method is COD, process is complete
                if ($payment_method == 'COD') {
                    mysqli_commit($db);
                    unset($_SESSION["cart_item"]);
                    $success = "<div class='alert alert-success alert-dismissible fade show'>
                                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                    <strong>Success!</strong> Your order has been placed successfully!
                                    <p>You will be redirected to Order Page in <span id='counter'>5</span> second(s).</p>
                                </div>
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
                } elseif ($payment_method == 'UPI') {
                    // For UPI, get the last inserted order ID
                    $order_id = mysqli_insert_id($db);
                    
                    // Insert into payments table with PENDING status
                    $payment_SQL = "INSERT INTO payments (order_id, user_id, payment_amount, payment_status, payment_method) 
                            VALUES (?, ?, ?, 'PENDING', 'UPI')";
                    
                    $payment_stmt = mysqli_prepare($db, $payment_SQL);
                    mysqli_stmt_bind_param($payment_stmt, "iid", $order_id, $user_id, $item_total);
                    mysqli_stmt_execute($payment_stmt);
                    
                    mysqli_commit($db);
                    
                    // Redirect to Cashfree with correct order_id
                    $cashfree_url = "https://test.cashfree.com/billpay/checkout/post/submit";
                    $app_id = "TEST10323353dd615588a92764db9a9335332301";
                    $secret_key = "cfsk_ma_test_0a60a66d37c1ab96dcd3d4056cf57e04_f7f25b7b";
                    $order_amount = $item_total;
                    $customer_name = isset($user_data['username']) ? $user_data['username'] : "Customer";
                    $customer_email = isset($user_data['email']) ? $user_data['email'] : "customer@example.com";
                    $customer_phone = isset($user_data['phone']) ? $user_data['phone'] : "9999999999";
                    $return_url = "http://localhost:3000/Canteen_Management/your_orders.php";
            
                    $postData = array(
                        "appId" => $app_id,
                        "orderId" => $order_id,
                        "orderAmount" => $order_amount,
                        "orderCurrency" => "INR",
                        "orderNote" => "Food Order Payment",
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
                }
            } catch (Exception $e) {
                mysqli_rollback($db);
                $error = "<div class='alert alert-danger'>Error processing your order: " . $e->getMessage() . "</div>";
            }
        }
    } else {
        $error = "<div class='alert alert-danger'>Please select a pickup time!</div>";
    }
}

// Get current time + 30 minutes for minimum pickup time
$min_pickup_time = date("H:i", strtotime("+30 minutes"));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Checkout | Complete Your Order</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style-starter.css">
    <!-- Add AOS library for scrolling animations -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Add custom styles -->
    <style>
        .checkout-container {
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            overflow: hidden;
            margin-bottom: 40px;
        }
        
        .checkout-header {
            background: linear-gradient(135deg, #4CAF50, #2E7D32);
            color: white;
            padding: 20px;
            text-align: center;
        }
        
        .checkout-body {
            padding: 30px;
        }
        
        .cart-item {
            border-bottom: 1px solid #e9ecef;
            padding: 15px 0;
            transition: all 0.3s ease;
        }
        
        .cart-item:hover {
            background-color: #f1f1f1;
            transform: translateY(-2px);
        }
        
        .cart-totals {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            padding: 20px;
        }
        
        .cart-totals-title {
            border-bottom: 2px solid #4CAF50;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }
        
        .payment-option {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            margin-top: 30px;
            padding: 20px;
        }
        
        .payment-option h4 {
            border-bottom: 2px solid #4CAF50;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }
        
        .payment-method {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            cursor: pointer;
            margin-bottom: 15px;
            padding: 15px;
            transition: all 0.3s ease;
        }
        
        .payment-method:hover {
            border-color: #4CAF50;
            transform: translateY(-2px);
        }
        
        .payment-method.active {
            border-color: #4CAF50;
            background-color: rgba(76, 175, 80, 0.1);
        }
        
        .payment-method img {
            height: 30px;
            margin-right: 10px;
            width: auto;
        }
        
        .btn-checkout {
            background: linear-gradient(135deg, #4CAF50, #2E7D32);
            border: none;
            border-radius: 30px;
            color: white;
            font-weight: bold;
            margin-top: 20px;
            padding: 12px 30px;
            text-transform: uppercase;
            transition: all 0.3s ease;
        }
        
        .btn-checkout:hover {
            box-shadow: 0 5px 15px rgba(46, 125, 50, 0.4);
            transform: translateY(-2px);
        }
        
        .time-picker-container {
            position: relative;
        }
        
        .pickup-info {
            background-color: #e8f5e9;
            border-left: 4px solid #4CAF50;
            border-radius: 4px;
            margin-bottom: 20px;
            padding: 10px 15px;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }
        
        /* Loading animation for payment processing */
        .loading-overlay {
            align-items: center;
            background-color: rgba(255, 255, 255, 0.9);
            display: none;
            height: 100%;
            justify-content: center;
            left: 0;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 9999;
        }
        
        .spinner {
            animation: rotate 2s linear infinite;
            height: 50px;
            width: 50px;
        }
        
        .spinner .path {
            animation: dash 1.5s ease-in-out infinite;
            stroke: #4CAF50;
            stroke-linecap: round;
        }
        
        @keyframes rotate {
            100% { transform: rotate(360deg); }
        }
        
        @keyframes dash {
            0% {
                stroke-dasharray: 1, 150;
                stroke-dashoffset: 0;
            }
            50% {
                stroke-dasharray: 90, 150;
                stroke-dashoffset: -35;
            }
            100% {
                stroke-dasharray: 90, 150;
                stroke-dashoffset: -124;
            }
        }
    </style>
</head>
<body>
    <!-- Loading animation overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <svg class="spinner" viewBox="0 0 50 50">
            <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
        </svg>
        <p class="mt-3">Processing your order...</p>
    </div>

    <?php include_once('header.php'); ?>
    
    <section class="w3l-breadcrumb">
        <div class="container">
            <ul class="breadcrumbs-custom-path">
                <li><a href="index.php">Home</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li class="active"><span class="fa fa-arrow-right mx-2" aria-hidden="true"></span> Checkout</li>
            </ul>
        </div>
    </section>
    
    <div class="container">
        <?php echo $success; ?>
        <?php echo $error; ?>
    </div>
    
    <div class="container m-t-30">
        <div class="row">
            <div class="col-md-8" data-aos="fade-right" data-aos-duration="1000">
                <div class="checkout-container">
                    <div class="checkout-header">
                        <h3><i class="fa fa-shopping-cart"></i> Complete Your Order</h3>
                    </div>
                    <div class="checkout-body">
                        <h4 class="mb-4">Order Summary</h4>
                        
                        <?php if(empty($_SESSION["cart_item"])): ?>
                            <div class="alert alert-info">
                                Your cart is empty. <a href="menu.php">Continue shopping</a>
                            </div>
                        <?php else: ?>
                            <div class="cart-items">
                                <?php foreach($_SESSION["cart_item"] as $item): ?>
                                    <div class="cart-item row align-items-center fade-in">
                                        <div class="col-md-2">
                                            <?php if(isset($item["image_path"]) && !empty($item["image_path"])): ?>
                                                <img src="<?php echo $item["image_path"]; ?>" alt="<?php echo $item["title"]; ?>" class="img-fluid rounded">
                                            <?php else: ?>
                                                <div class="text-center p-3 bg-light rounded">
                                                    <i class="fa fa-cutlery fa-2x text-muted"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-5">
                                            <h5><?php echo $item["title"]; ?></h5>
                                            <p class="text-muted small"><?php echo isset($item["description"]) ? $item["description"] : ""; ?></p>
                                        </div>
                                        <div class="col-md-2 text-center">
                                            <span class="badge badge-pill badge-success"><?php echo $item["quantity"]; ?></span>
                                        </div>
                                        <div class="col-md-3 text-right">
                                            <p class="mb-0">₹<?php echo number_format($item["price"] * $item["quantity"], 2); ?></p>
                                            <small class="text-muted">₹<?php echo number_format($item["price"], 2); ?> each</small>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                <?php if(!empty($_SESSION["cart_item"])): ?>
                    <form action="" method="post" id="checkoutForm">
                        <div class="cart-totals">
                            <div class="cart-totals-title">
                                <h4>Order Total</h4>
                            </div>
                            <div class="cart-totals-fields">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>Subtotal</td>
                                            <td class="text-right">₹<?php echo number_format($item_total, 2); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Tax (5%)</td>
                                            <td class="text-right">₹<?php echo number_format($item_total * 0.05, 2); ?></td>
                                        </tr>
                                        <tr>
                                            <td class="text-color"><strong>Grand Total</strong></td>
                                            <td class="text-color text-right"><strong>₹<?php echo number_format($item_total * 1.05, 2); ?></strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="pickup-info">
                                <i class="fa fa-info-circle"></i> Please select a pickup time at least 30 minutes from now.
                            </div>
                            
                            <div class="form-group">
                                <label for="pickTime"><i class="fa fa-clock-o"></i> Pick-Up Time</label>
                                <div class="time-picker-container">
                                    <input type="time" id="pickTime" name="pickTime" class="form-control" min="<?php echo $min_pickup_time; ?>" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="payment-option mt-4">
                            <h4><i class="fa fa-credit-card"></i> Payment Method</h4>
                            <div class="payment-methods">
                                <div class="payment-method active" onclick="selectPayment('COD')">
                                    <input type="radio" name="mod" id="radioStacked1" checked value="COD" class="custom-control-input">
                                    <label for="radioStacked1">
                                        <i class="fa fa-money fa-2x text-success mr-2"></i>
                                        <span>Cash on Delivery</span>
                                    </label>
                                </div>
                                
                                <div class="payment-method" onclick="selectPayment('UPI')">
                                    <input type="radio" name="mod" id="radioStacked2" value="UPI" class="custom-control-input">
                                    <label for="radioStacked2">
                                        <i class="fa fa-mobile fa-2x text-primary mr-2"></i>
                                        <span>UPI Payment</span>
                                    </label>
                                </div>
                            </div>
                            
                            <button type="submit" name="submit" class="btn btn-checkout btn-block" id="orderButton">
                                <i class="fa fa-check-circle"></i> Place Order Now
                            </button>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
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
    <!-- AOS Library for scrolling animations -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        // Initialize AOS
        AOS.init();
        
        // Set minimum pickup time
        document.addEventListener('DOMContentLoaded', function() {
            // Set minimum pickup time (current time + 30 minutes)
            var now = new Date();
            now.setMinutes(now.getMinutes() + 30);
            var hours = now.getHours().toString().padStart(2, '0');
            var minutes = now.getMinutes().toString().padStart(2, '0');
            document.getElementById('pickTime').min = hours + ':' + minutes;
            
            // Show initial value
            if (!document.getElementById('pickTime').value) {
                document.getElementById('pickTime').value = hours + ':' + minutes;
            }
        });
        
        // Payment method selection
        function selectPayment(method) {
            document.querySelectorAll('.payment-method').forEach(function(el) {
                el.classList.remove('active');
            });
            
            document.querySelector('.payment-method input[value="' + method + '"]').checked = true;
            document.querySelector('.payment-method input[value="' + method + '"]').closest('.payment-method').classList.add('active');
        }
        
        // Form validation
        document.getElementById('checkoutForm').addEventListener('submit', function(e) {
            var pickupTime = document.getElementById('pickTime').value;
            
            if (!pickupTime) {
                e.preventDefault();
                $.toaster({ priority : 'danger', title : 'Error', message : 'Please select a pickup time'});
                return false;
            }
            
            // Show loading overlay
            document.getElementById('loadingOverlay').style.display = 'flex';
            return true;
        });
        
        // Animate cart items on load
        document.addEventListener('DOMContentLoaded', function() {
            var items = document.querySelectorAll('.cart-item');
            items.forEach(function(item, index) {
                setTimeout(function() {
                    item.classList.add('fade-in');
                }, index * 150);
            });
        });
    </script>
</body>
</html>