<?php
// Start session
session_start();
include("connection/connect.php");
include('phpqrcode/qrlib.php');
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
ini_set('display_errors', 0);



$user_id = null;

// Try getting user_id from session
if (!empty($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
}

// If not in session, try to retrieve from the order_id in GET/POST
if (empty($user_id)) {
    $order_id = $_GET['order_id'] ?? $_POST['orderId'] ?? null;

    if ($order_id) {
        // Try to get user_id from database using order_id
        $result = mysqli_query($db, "SELECT u_id FROM users_orders WHERE o_id = '$order_id' LIMIT 1");
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $user_id = $row['u_id'];
            $_SESSION["user_id"] = $user_id; // Re-store into session
        } else {
            // Order not found, redirect to login
            header('location:login.php');
            exit();
        }
    } else {
        // No session and no order_id → redirect
        header('location:login.php');
        exit();
    }
}


// Set timezone
date_default_timezone_set("asia/kolkata");

// Include the PHP QR Code library

// Initialize variables
$user_id = $_SESSION["user_id"];
$order_details = [];
$order_items = [];
$payment_details = [];
$payment_status = "";
$order_id = "";

// Get order ID from URL parameter or from the payment response
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
} elseif (isset($_POST['orderId'])) {
    $order_id = $_POST['orderId'];
} else {
    // If no order ID, get the latest order for this user
    $latest_order_query = "SELECT o_id FROM users_orders WHERE u_id = '$user_id' ORDER BY o_id DESC LIMIT 1";
    $latest_order_result = mysqli_query($db, $latest_order_query);
    if (mysqli_num_rows($latest_order_result) > 0) {
        $latest_order = mysqli_fetch_assoc($latest_order_result);
        $order_id = $latest_order['o_id'];
    }
}

// Get payment status from URL or POST data
if (isset($_GET['status'])) {
    $payment_status = $_GET['status'];
} elseif (isset($_POST['txnStatus'])) {
    $payment_status = ($_POST['txnStatus'] == 'SUCCESS') ? 'Paid' : 'Failed';
} 

// If we have an order ID, get the details
if (!empty($order_id)) {
    // Get all items from this order
    $items_query = "SELECT * FROM users_orders WHERE u_id = '$user_id' AND o_id = '$order_id'";
    $items_result = mysqli_query($db, $items_query);
    
    while ($item = mysqli_fetch_assoc($items_result)) {
        $order_items[] = $item;
        // Save the first item's details as the order details
        if (empty($order_details)) {
            $order_details = $item;
        }
    }
    
    // Get payment details
    $payment_query = "SELECT * FROM payments WHERE order_id = '$order_id' AND user_id = '$user_id'";
    $payment_result = mysqli_query($db, $payment_query);
    
    if (mysqli_num_rows($payment_result) > 0) {
        $payment_details = mysqli_fetch_assoc($payment_result);
        // If we didn't get payment status from URL/POST, use the database value
        if (empty($payment_status)) {
            $payment_status = $payment_details['payment_status'];
        } else {
            // Update payment status in the database if it came from the URL or POST
            if ($payment_status != $payment_details['payment_status']) {
                $updateSQL = "UPDATE payments SET payment_status = '$payment_status' WHERE order_id = '$order_id'";
                mysqli_query($db, $updateSQL);
            }
        }
    }
    
    // Generate QR code for this order
    $qr_data = json_encode([
        'order_id' => $order_id,
        'user_id' => $user_id,
        'timestamp' => time()
    ]);
    
    // Create directory for QR codes if it doesn't exist
    $qr_dir = 'uploads/qrcodes/';
    if (!file_exists($qr_dir)) {
        mkdir($qr_dir, 0777, true);
    }
    
    // QR code filename
    $qr_filename = $qr_dir . 'order_' . $order_id . '.png';
    
    // Generate QR code
    QRcode::png($qr_data, $qr_filename, QR_ECLEVEL_L, 10);
    
    // QR code URL for display
    $qr_code_url = $qr_filename;
}

// Get user details
$user_query = "SELECT * FROM users WHERE u_id = '$user_id'";
$user_result = mysqli_query($db, $user_query);
$user_data = mysqli_fetch_assoc($user_result);

// Calculate total
$order_total = 0;
foreach ($order_items as $item) {
    $order_total += ($item['price'] * $item['quantity']);
}

// Determine if success or failure
$is_success = ($payment_status == 'Paid' || $payment_status == 'COD');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Order Confirmation</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style-starter.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fa;
            color: #333;
        }

        .confirmation-container {
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            margin: 50px auto;
            max-width: 900px;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .confirmation-header {
            color: white;
            padding: 30px 20px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .confirmation-header::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.1)" fill-opacity="1" d="M0,160L48,154.7C96,149,192,139,288,149.3C384,160,480,192,576,186.7C672,181,768,139,864,138.7C960,139,1056,181,1152,186.7C1248,192,1344,160,1392,144L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') bottom no-repeat;
            background-size: cover;
            z-index: 0;
        }
        
        .confirmation-header h2 {
            font-weight: 700;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }
        
        .confirmation-header p {
            font-weight: 300;
            opacity: 0.9;
            margin-bottom: 0;
            position: relative;
            z-index: 1;
        }
        
        .success-header {
            background: linear-gradient(135deg, #38b2ac, #0d9488);
        }
        
        .failure-header {
            background: linear-gradient(135deg, #ef4444, #b91c1c);
        }
        
        .confirmation-body {
            padding: 40px 30px;
        }
        
        .order-item {
            border-bottom: 1px solid #e9ecef;
            padding: 15px 0;
        }
        
        .order-summary {
            background-color: #f9fafb;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            margin-top: 30px;
            padding: 25px;
            transition: box-shadow 0.3s ease;
        }
        
        .order-summary:hover {
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
        }
        
        .order-info {
            margin-bottom: 30px;
            background-color: #f9fafb;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        }
        
        .status-badge {
            border-radius: 30px;
            display: inline-block;
            font-size: 0.85rem;
            font-weight: 500;
            padding: 6px 16px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        .status-paid {
            background-color: #d1fae5;
            color: #047857;
        }
        
        .status-cod {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .status-failed {
            background-color: #fee2e2;
            color: #b91c1c;
        }
        
        .btn-action {
            border: none;
            border-radius: 30px;
            color: white;
            font-weight: 600;
            margin-top: 20px;
            padding: 12px 24px;
            text-transform: uppercase;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        
        .btn-success {
            background: linear-gradient(135deg, #38b2ac, #0d9488);
        }
        
        .btn-success:hover {
            box-shadow: 0 8px 15px rgba(13, 148, 136, 0.4);
            transform: translateY(-3px);
        }
        
        .btn-danger {
            background: linear-gradient(135deg, #ef4444, #b91c1c);
        }
        
        .btn-danger:hover {
            box-shadow: 0 8px 15px rgba(185, 28, 28, 0.4);
            transform: translateY(-3px);
        }
        
        .btn-secondary {
            background: linear-gradient(135deg, #6b7280, #4b5563);
            color: white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: none;
            border-radius: 30px;
            font-weight: 600;
            padding: 12px 24px;
        }
        
        .btn-secondary:hover {
            box-shadow: 0 8px 15px rgba(75, 85, 99, 0.4);
            transform: translateY(-3px);
            color: white;
        }
        
        .icon-large {
            font-size: 70px;
            margin-bottom: 25px;
            opacity: 0.9;
            text-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .icon-success {
            color: #0d9488;
        }
        
        .icon-failure {
            color: #b91c1c;
        }
        
        /* QR Code Container Styles */
        .qr-code-container {
            background-color: white;
            border-radius: 16px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.05);
            margin: 30px auto;
            max-width: 320px;
            padding: 30px 20px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
        }
        
        .qr-code-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
        }
        
        .qr-code-container::before {
            content: '';
            position: absolute;
            top: 10px;
            left: 10px;
            right: 10px;
            bottom: 10px;
            border: 2px dashed #e5e7eb;
            border-radius: 12px;
            z-index: 0;
            pointer-events: none;
        }
        
        .qr-code-img {
            display: block;
            margin: 0 auto 20px;
            max-width: 200px;
            padding: 10px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            position: relative;
            z-index: 1;
        }
        
        .qr-instructions {
            color: #64748b;
            font-size: 0.9rem;
            margin-top: 20px;
            line-height: 1.5;
            position: relative;
            z-index: 1;
        }
        
        .qr-code-container h4 {
            color: #0f172a;
            font-weight: 600;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }
        
        .qr-code-container p {
            position: relative;
            z-index: 1;
        }
        
        .table {
            margin-bottom: 0;
        }
        
        .table thead th {
            border-top: none;
            border-bottom: 2px solid #e5e7eb;
            color: #64748b;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .table tbody tr:last-child td {
            border-bottom: none;
        }
        
        .table td, .table th {
            border-top: 1px solid #e5e7eb;
            padding: 16px 12px;
            vertical-align: middle;
        }
        
        .table tbody tr:hover {
            background-color: #f1f5f9;
        }
        
        .table-total {
            background-color: #f1f5f9;
            font-weight: 600;
        }
        
        .table-grand-total {
            background-color: #e5e7eb;
            font-weight: 700;
            color: #0f172a;
        }
        
        .section-title {
            color: #0f172a;
            font-weight: 600;
            margin-bottom: 20px;
            position: relative;
            display: inline-block;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            width: 50%;
            height: 3px;
            bottom: -8px;
            left: 0;
            background-color: #38b2ac;
            border-radius: 2px;
        }
        
        .info-label {
            color: #64748b;
            font-weight: 500;
            margin-right: 5px;
        }
        
        .info-value {
            color: #0f172a;
            font-weight: 400;
        }
        
        .breadcrumb-section {
            background-color: #f1f5f9;
            padding: 15px 0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }
        
        .breadcrumb-custom-path {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
            align-items: center;
            font-size: 0.9rem;
        }
        
        .breadcrumb-custom-path li {
            display: inline-flex;
            align-items: center;
        }
        
        .breadcrumb-custom-path li a {
            color: #64748b;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .breadcrumb-custom-path li a:hover {
            color: #38b2ac;
        }
        
        .breadcrumb-custom-path li.active {
            color: #0f172a;
            font-weight: 500;
        }
        
        .fa-arrow-right {
            font-size: 0.7rem;
            color: #94a3b8;
        }
        
        @media print {
            .no-print {
                display: none;
            }
            
            .confirmation-container {
                box-shadow: none;
                margin: 0;
                max-width: 100%;
            }
            
            .confirmation-body {
                padding: 20px 0;
            }
            
            .order-info, .order-summary, .qr-code-container {
                box-shadow: none;
                border: 1px solid #e5e7eb;
            }
        }
        
        @media (max-width: 767px) {
            .confirmation-container {
                margin: 20px 10px;
                border-radius: 12px;
            }
            
            .confirmation-body {
                padding: 25px 15px;
            }
            
            .order-info, .order-summary {
                padding: 15px;
            }
        }
        
        /* Animation for success/failure icon */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        
        .icon-large {
            animation: pulse 2s infinite ease-in-out;
        }
    </style>
</head>
<body>
    <?php include_once('header.php'); ?>
    
    <section class="breadcrumb-section">
        <div class="container">
            <ul class="breadcrumb-custom-path">
                <li><a href="index.php">Home</a></li>
                <li><span class="fa fa-arrow-right mx-2" aria-hidden="true"></span></li>
                <li><a href="your_orders.php">Orders</a></li>
                <li><span class="fa fa-arrow-right mx-2" aria-hidden="true"></span></li>
                <li class="active">Order Confirmation</li>
            </ul>
        </div>
    </section>
    
    <div class="container">
        <div class="confirmation-container">
            <div class="confirmation-header <?php echo $is_success ? 'success-header' : 'failure-header'; ?>">
                <h2>
                    <i class="fa <?php echo $is_success ? 'fa-check-circle' : 'fa-times-circle'; ?>"></i> 
                    <?php echo $is_success ? 'Order Confirmed' : 'Order Processing Failed'; ?>
                </h2>
                <p><?php echo $is_success ? 'Thank you for your order! Your food will be ready soon.' : 'We encountered an issue with your order processing.'; ?></p>
            </div>
            
            <div class="confirmation-body">
                <div class="text-center mb-5">
                    <i class="fa <?php echo $is_success ? 'fa-check-circle icon-success' : 'fa-times-circle icon-failure'; ?> icon-large"></i>
                    <h3><?php echo $is_success ? 'Your order has been received' : 'Your payment was not processed'; ?></h3>
                    <?php if ($is_success): ?>
                        <p>A confirmation has been sent to your email address. Please check your inbox.</p>
                    <?php else: ?>
                        <p>Please try again or choose a different payment method to complete your order.</p>
                    <?php endif; ?>
                </div>
                
                <?php if (!empty($order_details) && $is_success): ?>
                    <!-- QR Code Section -->
                    <div class="qr-code-container">
                        <h4>Your Pickup QR Code</h4>
                        <img src="<?php echo $qr_code_url; ?>" alt="Order QR Code" class="qr-code-img">
                        <p><strong>Order #<?php echo $order_details['o_id']; ?></strong></p>
                        <p class="qr-instructions">
                            <i class="fa fa-info-circle"></i> Show this QR code at the pickup counter to collect your order.
                        </p>
                        <a href="<?php echo $qr_code_url; ?>" download="order_<?php echo $order_details['o_id']; ?>_qr.png" class="btn btn-sm btn-primary mt-2 no-print">
                            <i class="fa fa-download"></i> Download QR Code
                        </a>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($order_details)): ?>
                    <div class="order-info">
                        <div class="row">
                            <div class="col-md-6 mb-4 mb-md-0">
                                <h4 class="section-title">Order Information</h4>
                                <p>
                                    <span class="info-label">Order Number:</span>
                                    <span class="info-value">#<?php echo $order_details['o_id']; ?></span>
                                </p>
                                <p>
                                    <span class="info-label">Order Date:</span>
                                    <span class="info-value"><?php echo date('d M Y h:i A', strtotime($order_details['date'])); ?></span>
                                </p>
                                <p>
                                    <span class="info-label">Pickup Time:</span>
                                    <span class="info-value"><?php echo date('h:i A', strtotime($order_details['pick_time'])); ?></span>
                                </p>
                                <p>
                                    <span class="info-label">Payment Status:</span>
                                    <?php if($payment_status == 'Paid'): ?>
                                        <span class="status-badge status-paid"><i class="fa fa-check-circle"></i> Paid</span>
                                    <?php elseif($payment_status == 'COD'): ?>
                                        <span class="status-badge status-cod"><i class="fa fa-money"></i> Cash on Delivery</span>
                                    <?php else: ?>
                                        <span class="status-badge status-failed"><i class="fa fa-times-circle"></i> Failed</span>
                                    <?php endif; ?>
                                </p>
                                <?php if(isset($payment_details['payment_method'])): ?>
                                    <p>
                                        <span class="info-label">Payment Method:</span>
                                        <span class="info-value"><?php echo $payment_details['payment_method']; ?></span>
                                    </p>
                                <?php endif; ?>
                                <?php if(isset($payment_details['transaction_id']) && !empty($payment_details['transaction_id'])): ?>
                                    <p>
                                        <span class="info-label">Transaction ID:</span>
                                        <span class="info-value"><?php echo $payment_details['transaction_id']; ?></span>
                                    </p>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <h4 class="section-title">Customer Information</h4>
                             
                                <p>
                                    <span class="info-label">Email:</span>
                                    <span class="info-value"><?php echo $user_data['email']; ?></span>
                                </p>
                                <?php if(!empty($user_data['phone'])): ?>
                                    <p>
                                        <span class="info-label">Phone:</span>
                                        <span class="info-value"><?php echo $user_data['phone']; ?></span>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="order-summary">
                        <h4 class="section-title">Order Summary</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-right">Price</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($order_items as $item): ?>
                                        <tr>
                                            <td><strong><?php echo $item['title']; ?></strong></td>
                                            <td class="text-center"><?php echo $item['quantity']; ?></td>
                                            <td class="text-right">₹<?php echo number_format($item['price'], 2); ?></td>
                                            <td class="text-right">₹<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    
                                    <tr class="table-total">
                                        <td colspan="3" class="text-right"><strong>Subtotal</strong></td>
                                        <td class="text-right">₹<?php echo number_format($order_total, 2); ?></td>
                                    </tr>
                                    <tr class="table-total">
                                        <td colspan="3" class="text-right"><strong>Tax (5%)</strong></td>
                                        <td class="text-right">₹<?php echo number_format($order_total * 0.05, 2); ?></td>
                                    </tr>
                                    <tr class="table-grand-total">
                                        <td colspan="3" class="text-right"><strong>Grand Total</strong></td>
                                        <td class="text-right"><strong>₹<?php echo number_format($order_total * 1.05, 2); ?></strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning">
                        <i class="fa fa-exclamation-triangle"></i> No order information found. Please check your order history.
                    </div>
                <?php endif; ?>
                
                <div class="text-center mt-5 no-print">
                    <?php if($is_success): ?>
                        <button onclick="window.print()" class="btn btn-secondary mr-3">
                            <i class="fa fa-print"></i> Print Receipt
                        </button>
                        <a href="your_orders.php" class="btn btn-action btn-success">
                            <i class="fa fa-list"></i> View All Orders
                        </a>
                    <?php else: ?>
                        <a href="checkout.php" class="btn btn-action btn-danger mr-3">
                            <i class="fa fa-refresh"></i> Try Again
                        </a>
                        <a href="your_orders.php" class="btn btn-secondary">
                            <i class="fa fa-list"></i> View All Orders
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    
    <script src="js/jquery.min.js"></script>
    <script src="js/tether.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/animsition.min.js"></script>
    <script src="js/bootstrap-slider.min.js"></script>
    <script src="js/jquery.isotope.min.js"></script>
    <script src="js/headroom.js"></script>
    <script src="js/foodpicky.min.js"></script>
</body>
</html>