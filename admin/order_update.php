<?php
include("../connection/connect.php");
error_reporting(0); // Changed from E_ALL for production
ini_set('display_errors', 0); // Changed from 1 for production
session_start();

// Check if user is logged in
if(strlen($_SESSION['adm_id']) == 0) { 
    header('location:login.php');
    exit();
} else {
    // Process form submission
    if(isset($_POST['update'])) {
        $form_id = mysqli_real_escape_string($db, $_GET['form_id']); // Added security
        $status = mysqli_real_escape_string($db, $_POST['status']);
        $remark = mysqli_real_escape_string($db, $_POST['remark']);
        
        // Insert remark
        $query = mysqli_query($db, "INSERT INTO remark(frm_id, status, remark) VALUES('$form_id', '$status', '$remark')");
        
        // Update order status
        $sql = mysqli_query($db, "UPDATE users_orders SET status='$status' WHERE o_id='$form_id'");

        if($query && $sql) {
            $success_message = "Order status updated successfully!";
        } else {
            $error_message = "Something went wrong. Please try again.";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Admin Dashboard - Order Status Update">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <title>Order Status Update - Admin Dashboard</title>
    
    <!-- Bootstrap Core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #4e73df;
            --success-color: #1cc88a;
            --info-color: #36b9cc;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
            --dark-color: #5a5c69;
            --light-color: #f8f9fc;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fc;
            color: #444;
            padding: 0;
            margin: 0;
        }
        
        .card {
            border: none;
            border-radius: 0.35rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        
        .card-header {
            background-color: var(--primary-color);
            color: white;
            padding: 1rem 1.5rem;
            border-top-left-radius: 0.35rem;
            border-top-right-radius: 0.35rem;
            font-weight: 600;
        }
        
        .card-body {
            padding: 1.5rem;
            background: white;
        }
        
        .form-label {
            font-weight: 600;
            color: var(--dark-color);
        }
        
        .form-control, .form-select {
            border-radius: 0.35rem;
            border: 1px solid #d1d3e2;
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #bac8f3;
            box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #4262c7;
            border-color: #4262c7;
        }
        
        .btn-danger {
            background-color: var(--danger-color);
            border-color: var(--danger-color);
        }
        
        .alert {
            border-radius: 0.35rem;
            border-left: 0.25rem solid;
        }
        
        .alert-success {
            background-color: rgba(28, 200, 138, 0.1);
            border-left-color: var(--success-color);
            color: #14a074;
        }
        
        .alert-danger {
            background-color: rgba(231, 74, 59, 0.1);
            border-left-color: var(--danger-color);
            color: #d52a1a;
        }
        
        .order-info {
            background-color: var(--light-color);
            padding: 1rem;
            border-radius: 0.35rem;
            margin-bottom: 1.5rem;
        }
        
        .order-number {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--primary-color);
        }
        
        .btn {
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 0.35rem;
        }
        
        .btn-icon {
            margin-right: 0.5rem;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="m-0"><i class="fas fa-clipboard-list me-2"></i>Update Order Status</h5>
                        <div>
                            <button type="button" class="btn btn-sm btn-light" onclick="window.print()">
                                <i class="fas fa-print btn-icon"></i>Print
                            </button>
                            <button type="button" class="btn btn-sm btn-light ms-2" onclick="window.close()">
                                <i class="fas fa-times btn-icon"></i>Close
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if(isset($success_message)): ?>
                            <div class="alert alert-success" role="alert">
                                <i class="fas fa-check-circle me-2"></i><?php echo $success_message; ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if(isset($error_message)): ?>
                            <div class="alert alert-danger" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i><?php echo $error_message; ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="order-info mb-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Order #</strong></p>
                                    <p class="order-number"><?php echo htmlentities($_GET['form_id']); ?></p>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <p class="mb-1"><strong>Date</strong></p>
                                    <p><?php echo date('F d, Y'); ?></p>
                                </div>
                            </div>
                        </div>
                        
                        <form name="updateticket" id="updatecomplaint" method="post">
                            <div class="mb-4">
                                <label for="status" class="form-label">Update Status</label>
                                <select name="status" id="status" class="form-select" required>
                                    <option value="">Select Status</option>
                                    <option value="in process">In Process</option>
                                    <option value="prepared">Prepared</option> 
                                    <option value="closed">Closed</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                            </div>
                            
                            <div class="mb-4">
                                <label for="remark" class="form-label">Remarks</label>
                                <textarea name="remark" id="remark" class="form-control" rows="5" placeholder="Enter your remarks here..."></textarea>
                            </div>
                            
                            <div class="d-flex">
                                <button type="submit" name="update" class="btn btn-primary">
                                    <i class="fas fa-save btn-icon"></i>Update Status
                                </button>
                                <button type="button" class="btn btn-danger ms-2" onclick="window.close()">
                                    <i class="fas fa-times btn-icon"></i>Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap core JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Auto-close alert messages after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    alert.style.opacity = '0';
                    alert.style.transition = 'opacity 1s';
                    setTimeout(function() {
                        alert.style.display = 'none';
                    }, 1000);
                });
            }, 5000);
        });
    </script>
</body>
</html>
<?php } ?>