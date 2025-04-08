<?php
// Enable error reporting

// Include database connection
include("../connection/connect.php");
if (!$db) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Start session
session_start();

// Process QR code data if submitted
$scan_result = '';
$order_info = null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['qr_data'])) {
    // Decode the QR data
    $qr_data = json_decode($_POST['qr_data'], true);
    
    if (isset($qr_data['order_id']) && isset($qr_data['user_id'])) {
        $order_id = $qr_data['order_id'];
        $user_id = $qr_data['user_id'];
        
        // Check if order exists and belongs to this user
        $check_query = "SELECT uo.*, u.roll_no, u.email 
                        FROM users_orders uo 
                        JOIN users u ON uo.u_id = u.u_id 
                        WHERE uo.o_id = '$order_id' AND uo.u_id = '$user_id'
                        LIMIT 1";
        $check_result = mysqli_query($db, $check_query);
        
        if (mysqli_num_rows($check_result) > 0) {
            $order_info = mysqli_fetch_assoc($check_result);
            
            // Check if order is already delivered
            if ($order_info['status'] == 'closed') {
                $scan_result = 'error';
                $message = 'This order has already been delivered!';
            } else {
                // Update order status to "closed" instead of "Delivered"
                $update_query = "UPDATE users_orders SET status = 'closed', pick_time = NOW() WHERE o_id = '$order_id'";
                if (mysqli_query($db, $update_query)) {
                    $scan_result = 'success';
                    $message = 'Order verified and marked as delivered!';
                    
                    // Refresh order info
                    $refresh_query = "SELECT uo.*, u.roll_no, u.email 
                                    FROM users_orders uo 
                                    JOIN users u ON uo.u_id = u.u_id 
                                    WHERE uo.o_id = '$order_id' AND uo.u_id = '$user_id'
                                    LIMIT 1";
                    $refresh_result = mysqli_query($db, $refresh_query);
                    $order_info = mysqli_fetch_assoc($refresh_result);
                } else {
                    $scan_result = 'error';
                    $message = 'Database error: ' . mysqli_error($db);
                }
            }
        } else {
            $scan_result = 'error';
            $message = 'Invalid order or user information!';
        }
    } else {
        $scan_result = 'error';
        $message = 'Invalid QR code data!';
    }
}

// Process manual order verification
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];
    
    // Check if order exists
    $check_query = "SELECT uo.*, u.roll_no, u.email 
                    FROM users_orders uo 
                    JOIN users u ON uo.u_id = u.u_id 
                    WHERE uo.o_id = '$order_id'
                    LIMIT 1";
    $check_result = mysqli_query($db, $check_query);
    
    if (mysqli_num_rows($check_result) > 0) {
        $order_info = mysqli_fetch_assoc($check_result);
        $user_id = $order_info['u_id'];
        
        // Check if order is already delivered
        if ($order_info['status'] == 'closed') {
            $scan_result = 'error';
            $message = 'This order has already been delivered!';
        } else {
            // Update order status to "closed" instead of "Delivered"
            $update_query = "UPDATE users_orders SET status = 'closed', pick_time = NOW() WHERE o_id = '$order_id'";
            if (mysqli_query($db, $update_query)) {
                $scan_result = 'success';
                $message = 'Order verified and marked as delivered!';
                
                // Refresh order info
                $refresh_query = "SELECT uo.*, u.roll_no, u.email 
                                FROM users_orders uo 
                                JOIN users u ON uo.u_id = u.u_id 
                                WHERE uo.o_id = '$order_id'
                                LIMIT 1";
                $refresh_result = mysqli_query($db, $refresh_query);
                $order_info = mysqli_fetch_assoc($refresh_result);
            } else {
                $scan_result = 'error';
                $message = 'Database error: ' . mysqli_error($db);
            }
        }
    } else {
        $scan_result = 'error';
        $message = 'Invalid order ID!';
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>QR Code Scanner - Order Delivery</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style-starter.css">
    <style>
        .scanner-container {
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            margin: 40px auto;
            max-width: 800px;
            overflow: hidden;
            padding: 30px;
        }
        
        #reader {
            width: 100%;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 20px;
        }
        
        .result-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            margin-top: 20px;
            padding: 20px;
        }
        
        .success-message {
            background-color: #d4edda;
            border-color: #c3e6cb;
            border-radius: 5px;
            color: #155724;
            padding: 15px;
        }
        
        .error-message {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            border-radius: 5px;
            color: #721c24;
            padding: 15px;
        }
        
        .order-details {
            background-color: #f8f9fa;
            border-radius: 5px;
            margin-top: 20px;
            padding: 15px;
        }
        
        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: bold;
        }
        
        .status-delivered {
            background-color: #28a745;
            color: white;
        }
        
        .icon-space {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <?php include_once('header.php'); ?>
    
    <section class="w3l-breadcrumb">
        <div class="container">
            <ul class="breadcrumbs-custom-path">
                <li><a href="index.php">Home</a></li>
                <li class="active"><span class="fa fa-arrow-right mx-2" aria-hidden="true"></span> QR Scanner</li>
            </ul>
        </div>
    </section>
    
    <div class="container">
        <div class="scanner-container">
            <h2 class="text-center mb-4">Order Delivery QR Scanner</h2>
            
            <div class="row">
                <div class="col-md-12">
                    <div id="reader"></div>
                    
                    <div class="text-center mb-4">
                        <p>Position the QR code within the scanner frame.</p>
                        <button id="startButton" class="btn btn-primary">
                            <i class="fa fa-camera"></i> Start Scanner
                        </button>
                        <button id="resetButton" class="btn btn-secondary" style="display: none;">
                            <i class="fa fa-refresh"></i> Scan Another
                        </button>
                    </div>
                    
                    <?php if ($scan_result): ?>
                        <div class="<?php echo $scan_result == 'success' ? 'success-message' : 'error-message'; ?>">
                            <?php echo $message; ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($order_info): ?>
                        <div class="order-details">
                            <h4>Order Information</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Order ID:</strong> #<?php echo $order_info['o_id']; ?></p>
                                    <p><strong>Title:</strong> <?php echo $order_info['title']; ?></p>
                                    <p><strong>Status:</strong> 
                                        <?php if($order_info['status'] == 'Delivered'): ?>
                                            <span class="status-badge status-delivered">
                                                <i class="fas fa-check-circle icon-space"></i>Delivered
                                            </span>
                                        <?php else: ?>
                                            <?php echo $order_info['status']; ?>
                                        <?php endif; ?>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Customer:</strong> <?php echo $order_info['student']; ?></p>
                                    <p><strong>Email:</strong> <?php echo $order_info['email']; ?></p>
                                    <?php if (isset($order_info['pick_time']) && $order_info['pick_time']): ?>
                                        <p><strong>Delivered:</strong> <?php echo date('d M Y h:i A', strtotime($order_info['pick_time'])); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="text-center mt-3">
                                <a href="order_details.php?order_id=<?php echo $order_info['o_id']; ?>" class="btn btn-info">
                                    <i class="fa fa-eye"></i> View Full Order
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Manual Entry Form -->
            <div class="mt-5">
                <hr>
                <h4 class="text-center">Manual Order Verification</h4>
                <form method="post" action="">
                    <div class="form-group">
                        <label for="order_id_input">Order ID:</label>
                        <input type="text" class="form-control" id="order_id_input" name="order_id" placeholder="Enter Order ID">
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Verify Order</button>
                    </div>
                </form>
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
    
    <!-- Include the HTML5-QRCode library -->
    <script src="https://unpkg.com/html5-qrcode@2.0.9/dist/html5-qrcode.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Create QR Code Scanner
            const html5QrCode = new Html5Qrcode("reader");
            const qrCodeSuccessCallback = (decodedText, decodedResult) => {
                try {
                    // Parse the JSON data from the QR code
                    const qrData = JSON.parse(decodedText);
                    
                    // Create a hidden form and submit the data
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.style.display = 'none';
                    
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'qr_data';
                    input.value = decodedText;
                    
                    form.appendChild(input);
                    document.body.appendChild(form);
                    
                    // Stop the scanner
                    html5QrCode.stop().then(() => {
                        console.log("QR Code scanning stopped.");
                        $("#startButton").hide();
                        $("#resetButton").show();
                    });
                    
                    // Submit the form
                    form.submit();
                } catch (error) {
                    alert("Invalid QR Code format. Please try again.");
                }
            };
            
            const config = { fps: 90, qrbox: 250 };
            
            $("#startButton").click(function() {
                html5QrCode.start(
                    { facingMode: "environment" },
                    config,
                    qrCodeSuccessCallback,
                    (errorMessage) => {
                        console.log(`QR Code scanning failed: ${errorMessage}`);
                    }
                ).catch((err) => {
                    console.log(`Unable to start scanning: ${err}`);
                    alert("Unable to start camera. Please check camera permissions.");
                });
            });

            $("#resetButton").click(function() {
                location.reload();
            });
        });
    </script>
</body>
</html>