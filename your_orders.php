<?php
include("connection/connect.php");
error_reporting(0);
session_start();

if(empty($_SESSION['user_id']))  //if usser is not login redirected baack to login page
{
	header('location:login.php');
}
else
{
		if(!empty($_GET['o_id']))
		{
			// print_r($_GET['o_id']);die;
			$UpdateSql="update users_orders set status='rejected' where o_id=$_GET[o_id]";
			mysqli_query($db, $UpdateSql); 
		
			header('location:your_orders.php');
		}	
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="#">
    <title></title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    <style type="text/css" rel="stylesheet">
        /* Enhanced card styling */
.card {
  border-radius: 12px;
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
  transition: transform 0.3s, box-shadow 0.3s;
  overflow: hidden;
  border: none;
}
/* Toast notifications */
.toast-container {
  position: fixed;
  top: 20px;
  right: 20px;
  z-index: 9999;
}

.toast {
  display: flex;
  align-items: center;
  padding: 15px 20px;
  border-radius: 10px;
  margin-bottom: 10px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.2);
  transform: translateX(120%);
  opacity: 0;
  transition: all 0.3s ease;
  max-width: 350px;
  overflow: hidden;
}

.toast-icon {
  margin-right: 15px;
  font-size: 20px;
}

.toast-message {
  font-weight: 500;
}

.toast-info {
  background-color: #4a6bff;
  color: white;
}

.toast-success {
  background-color: #28a745;
  color: white;
}

.toast-error {
  background-color: #dc3545;
  color: white;
}
.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 12px 25px rgba(0, 0, 0, 0.12);
}

.card-header {
  background: linear-gradient(135deg, #4a6bff 0%, #2541b8 100%);
  color: white;
  border-bottom: none;
  padding: 1rem 1.5rem;
}

/* Statistics boxes animation and style */
.stat-box {
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
  position: relative;
  transition: all 0.3s;
}

.stat-box:hover {
  transform: scale(1.05);
}

.stat-box h3 {
  font-size: 2rem;
  font-weight: 700;
  margin-bottom: 5px;
  transition: all 0.3s;
}

.stat-box:hover h3 {
  transform: scale(1.1);
}

.stat-box::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 100%);
  z-index: 1;
}

/* Table styling */
.table {
  border-collapse: separate;
  border-spacing: 0 10px;
  margin-top: -10px;
}

.table thead th {
  border: none;
  background-color: #f4f7fc;
  color: #495057;
  font-weight: 600;
  padding: 15px;
  text-transform: uppercase;
  font-size: 0.85rem;
}

.table tbody tr {
  box-shadow: 0 2px 10px rgba(0,0,0,0.05);
  border-radius: 10px;
  transition: all 0.3s;
  transform: scale(1);
  background: white;
}

.table tbody tr:hover {
  transform: scale(1.01);
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
  z-index: 10;
  position: relative;
}

.table tbody td {
  border: none;
  padding: 15px;
  vertical-align: middle;
}

.table tbody tr td:first-child {
  border-top-left-radius: 10px;
  border-bottom-left-radius: 10px;
}

.table tbody tr td:last-child {
  border-top-right-radius: 10px;
  border-bottom-right-radius: 10px;
}

/* Search box */
.search-box {
  position: relative;
}

.search-box input {
  padding-left: 40px;
  border-radius: 20px;
  transition: all 0.3s;
  border: 1px solid #e0e0e0;
}

.search-box::before {
  content: '\f002';
  font-family: 'FontAwesome';
  position: absolute;
  left: 15px;
  top: 10px;
  color: #aaa;
  z-index: 1;
}

.search-box input:focus {
  box-shadow: 0 0 15px rgba(74, 107, 255, 0.2);
  border-color: #4a6bff;
}

/* Status buttons with enhanced styling */
.btn-sm {
  border-radius: 20px;
  padding: 5px 15px;
  text-transform: uppercase;
  font-size: 0.75rem;
  font-weight: 600;
  letter-spacing: 0.5px;
  transition: all 0.3s;
}

.btn-sm i {
  margin-right: 5px;
}

.btn-sm:hover {
  transform: translateY(-2px);
}

/* Pagination styling */
.pagination {
  margin-top: 2rem;
}

.pagination .page-item.active .page-link {
  background-color: #4a6bff;
  border-color: #4a6bff;
}

.pagination .page-link {
  border-radius: 5px;
  margin: 0 5px;
  color: #4a6bff;
  transition: all 0.3s;
}

.pagination .page-link:hover {
  transform: translateY(-2px);
  box-shadow: 0 5px 10px rgba(0,0,0,0.1);
}
@keyframes pulse {
  0% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.02);
    background-color: rgba(74, 107, 255, 0.1);
  }
  100% {
    transform: scale(1);
  }
}

@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes shimmer {
  0% {
    background-position: -200% 0;
  }
  100% {
    background-position: 200% 0;
  }
}
/* Status badges */
.status-badge {
  display: flex;
  align-items: center;
  border-radius: 20px;
  padding: 8px 15px;
  font-weight: 600;
  font-size: 0.85rem;
  box-shadow: 0 3px 8px rgba(0,0,0,0.1);
  transition: all 0.3s;
  animation: fadeInUp 0.5s;
}

.status-badge:hover {
  transform: translateY(-3px);
  box-shadow: 0 5px 15px rgba(0,0,0,0.15);
}

.status-badge .badge-dot {
  height: 10px;
  width: 10px;
  border-radius: 50%;
  margin-right: 8px;
  position: relative;
}

.status-badge .badge-dot::after {
  content: '';
  position: absolute;
  top: -2px;
  left: -2px;
  right: -2px;
  bottom: -2px;
  border-radius: 50%;
  animation: pulse 1.5s infinite;
  opacity: 0.6;
}

.status-badge.pending {
  background-color: rgba(128, 0, 128, 0.1);
  color: purple;
}

.status-badge.pending .badge-dot {
  background-color: purple;
}

.status-badge.pending .badge-dot::after {
  border: 2px solid purple;
}

.status-badge.processing {
  background-color: rgba(255, 193, 7, 0.1);
  color: #ffc107;
}

.status-badge.processing .badge-dot {
  background-color: #ffc107;
}

.status-badge.processing .badge-dot::after {
  border: 2px solid #ffc107;
}

.status-badge.delivered {
  background-color: rgba(40, 167, 69, 0.1);
  color: #28a745;
}

.status-badge.delivered .badge-dot {
  background-color: #28a745;
}

.status-badge.delivered .badge-dot::after {
  border: 2px solid #28a745;
}

.status-badge.cancelled {
  background-color: rgba(220, 53, 69, 0.1);
  color: #dc3545;
}

.status-badge.cancelled .badge-dot {
  background-color: #dc3545;
}

.status-badge.cancelled .badge-dot::after {
  border: 2px solid #dc3545;
}

.status-badge.confirmed {
  background-color: rgba(23, 162, 184, 0.1);
  color: #17a2b8;
}

.status-badge.confirmed .badge-dot {
  background-color: #17a2b8;
}

.status-badge.confirmed .badge-dot::after {
  border: 2px solid #17a2b8;
}

.status-badge.ready {
  background-color: rgba(40, 167, 69, 0.1);
  color: #28a745;
}

.status-badge.ready .badge-dot {
  background-color: #28a745;
}

.status-badge.ready .badge-dot::after {
  border: 2px solid #28a745;
}
/* Skeleton loading */
.skeleton-loader {
  height: 20px;
  background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
  background-size: 200% 100%;
  border-radius: 4px;
  animation: shimmer 1.5s infinite;
}

.skeleton-row td {
  padding: 15px;
}

</style>
	</head>

<body>
<?php include_once('header.php'); ?>
<link rel="stylesheet" href="assets/css/style-starter.css">
<section class="w3l-breadcrumb">
    <div class="container">
        <ul class="breadcrumbs-custom-path">
            <li><a href="index.php">Home</a></li>
            <li class="active"><span class="fa fa-arrow-right mx-2" aria-hidden="true"></span> Orders</li>
        </ul>
    </div>
</section>

    
<div class="page-wrapper">
    <div class="inner-page-hero bg-image" data-image-src="images/img/1.png">
        <div class="container"> </div>
    </div>
    
    <!-- Order Statistics Section -->
    <div class="statistics-section py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Order Statistics</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <?php
                                    // Get order statistics
                                    $user_id = $_SESSION['user_id'];
                                    
                                    // Total Orders
                                    $total_orders = mysqli_query($db, "SELECT COUNT(*) as total FROM users_orders WHERE u_id = '$user_id'");
                                    $total = mysqli_fetch_assoc($total_orders)['total'];
                                    
                                    // Pending Orders
                                    $pending_orders = mysqli_query($db, "SELECT COUNT(*) as pending FROM users_orders WHERE u_id = '$user_id' AND (status = '' OR status IS NULL OR status = 'in process' OR status = 'confirm')");
                                    $pending = mysqli_fetch_assoc($pending_orders)['pending'];
                                    
                                    // Completed Orders
                                    $completed_orders = mysqli_query($db, "SELECT COUNT(*) as completed FROM users_orders WHERE u_id = '$user_id' AND status = 'closed'");
                                    $completed = mysqli_fetch_assoc($completed_orders)['completed'];
                                    
                                    // Cancelled Orders
                                    $cancelled_orders = mysqli_query($db, "SELECT COUNT(*) as cancelled FROM users_orders WHERE u_id = '$user_id' AND status = 'rejected'");
                                    $cancelled = mysqli_fetch_assoc($cancelled_orders)['cancelled'];
                                    
                                    // Total Spent
                                    $total_spent = mysqli_query($db, "SELECT SUM(price) as total_spent FROM users_orders WHERE u_id = '$user_id'");
                                    $spent = mysqli_fetch_assoc($total_spent)['total_spent'];
                                ?>
                                <div class="col-md-3 col-sm-6">
                                    <div class="stat-box bg-primary text-white p-3 text-center rounded">
                                        <h3><?php echo $total; ?></h3>
                                        <p>Total Orders</p>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="stat-box bg-warning text-white p-3 text-center rounded">
                                        <h3><?php echo $pending; ?></h3>
                                        <p>Pending Orders</p>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="stat-box bg-success text-white p-3 text-center rounded">
                                        <h3><?php echo $completed; ?></h3>
                                        <p>Completed Orders</p>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="stat-box bg-danger text-white p-3 text-center rounded">
                                        <h3>₹<?php echo number_format($spent, 2); ?></h3>
                                        <p>Total Spent</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Order Filters and Sorting -->
    <div class="result-show">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4>Filter & Sort Orders</h4>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="" class="filter-form row">
                                <!-- Status Filter -->
                                <div class="col-md-3 mb-3">
                                    <label for="statusFilter">Filter by Status</label>
                                    <select name="status" id="statusFilter" class="form-control">
                                        <option value="">All Statuses</option>
                                        <option value="NULL" <?php if(isset($_GET['status']) && $_GET['status'] == 'NULL') echo 'selected'; ?>>Pending</option>
                                        <option value="in process" <?php if(isset($_GET['status']) && $_GET['status'] == 'in process') echo 'selected'; ?>>Preparing</option>
                                        <option value="confirm" <?php if(isset($_GET['status']) && $_GET['status'] == 'confirm') echo 'selected'; ?>>Accepted</option>
                                        <option value="prepared" <?php if(isset($_GET['status']) && $_GET['status'] == 'prepared') echo 'selected'; ?>>Ready to Pick</option>
                                        <option value="closed" <?php if(isset($_GET['status']) && $_GET['status'] == 'closed') echo 'selected'; ?>>Delivered</option>
                                        <option value="rejected" <?php if(isset($_GET['status']) && $_GET['status'] == 'rejected') echo 'selected'; ?>>Cancelled</option>
                                    </select>
                                </div>
                                
                                <!-- Date Range Filter -->
                                <div class="col-md-4 mb-3">
                                    <label>Date Range</label>
                                    <div class="input-group">
                                        <input type="date" name="start_date" class="form-control" value="<?php echo isset($_GET['start_date']) ? $_GET['start_date'] : ''; ?>">
                                        <div class="input-group-append input-group-prepend">
                                            <span class="input-group-text">to</span>
                                        </div>
                                        <input type="date" name="end_date" class="form-control" value="<?php echo isset($_GET['end_date']) ? $_GET['end_date'] : ''; ?>">
                                    </div>
                                </div>
                                
                                <!-- Payment Status Filter -->
                                <div class="col-md-2 mb-3">
                                    <label for="paymentFilter">Payment Status</label>
                                    <select name="payment" id="paymentFilter" class="form-control">
                                        <option value="">All</option>
                                        <option value="Paid" <?php if(isset($_GET['payment']) && $_GET['payment'] == 'Paid') echo 'selected'; ?>>Paid</option>
                                        <option value="Pending" <?php if(isset($_GET['payment']) && $_GET['payment'] == 'Pending') echo 'selected'; ?>>Pending</option>
                                    </select>
                                </div>
                                
                                <!-- Sort Order -->
                                <div class="col-md-2 mb-3">
                                    <label for="sortOrder">Sort By</label>
                                    <select name="sort" id="sortOrder" class="form-control">
                                        <option value="date_desc" <?php if(isset($_GET['sort']) && $_GET['sort'] == 'date_desc') echo 'selected'; ?>>Date (Newest)</option>
                                        <option value="date_asc" <?php if(isset($_GET['sort']) && $_GET['sort'] == 'date_asc') echo 'selected'; ?>>Date (Oldest)</option>
                                        <option value="price_desc" <?php if(isset($_GET['sort']) && $_GET['sort'] == 'price_desc') echo 'selected'; ?>>Price (High-Low)</option>
                                        <option value="price_asc" <?php if(isset($_GET['sort']) && $_GET['sort'] == 'price_asc') echo 'selected'; ?>>Price (Low-High)</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-1 mb-3 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary">Apply</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Orders Section -->
    <section class="restaurants-page">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="bg-gray restaurant-entry">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Search and quick filters -->
                                <div class="mb-3 d-flex justify-content-between">
                                    <div>
                                        <span class="badge badge-primary p-2 mr-1"><?php echo $total; ?> Total Orders</span>
                                        <a href="?status=NULL" class="badge badge-warning p-2 mr-1"><?php echo $pending; ?> Pending</a>
                                        <a href="?status=prepared" class="badge badge-success p-2 mr-1"><?php echo mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(*) as ready FROM users_orders WHERE u_id = '$user_id' AND status = 'prepared'"))['ready']; ?> Ready</a>
                                    </div>
                                    <div class="search-box">
                                        <input type="text" id="searchInput" class="form-control" placeholder="Search orders...">
                                    </div>
                                </div>
                                
                                <!-- Orders Table -->
                                <div class="table-responsive">
                                    <table class="table table-striped" id="ordersTable">
                                        <thead>
                                            <tr>    
                                                <th>Order ID</th>
                                                <th>Item</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                                <th>Status</th>
                                                <th>Payment Status</th>
                                                <th>Date</th>
                                                <th>Pick Time</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                // Build the query with filters and sorting
                                                $query = "SELECT uo.*, p.payment_status 
                                                        FROM users_orders uo
                                                        LEFT JOIN payments p ON uo.o_id = p.order_id
                                                        WHERE uo.u_id = '".$_SESSION['user_id']."'";
                                                
                                                // Apply status filter
                                                if(isset($_GET['status']) && $_GET['status'] != '') {
                                                    if($_GET['status'] == 'NULL') {
                                                        $query .= " AND (uo.status = '' OR uo.status IS NULL)";
                                                    } else {
                                                        $query .= " AND uo.status = '".mysqli_real_escape_string($db, $_GET['status'])."'";
                                                    }
                                                }
                                                
                                                // Apply date range filter
                                                if(isset($_GET['start_date']) && $_GET['start_date'] != '') {
                                                    $query .= " AND DATE(uo.date) >= '".mysqli_real_escape_string($db, $_GET['start_date'])."'";
                                                }
                                                if(isset($_GET['end_date']) && $_GET['end_date'] != '') {
                                                    $query .= " AND DATE(uo.date) <= '".mysqli_real_escape_string($db, $_GET['end_date'])."'";
                                                }
                                                
                                                // Apply payment status filter
                                                if(isset($_GET['payment']) && $_GET['payment'] != '') {
                                                    $query .= " AND p.payment_status = '".mysqli_real_escape_string($db, $_GET['payment'])."'";
                                                }
                                                
                                                // Apply sorting
                                                if(isset($_GET['sort'])) {
                                                    switch($_GET['sort']) {
                                                        case 'date_asc':
                                                            $query .= " ORDER BY uo.date ASC";
                                                            break;
                                                        case 'price_desc':
                                                            $query .= " ORDER BY uo.price DESC";
                                                            break;
                                                        case 'price_asc':
                                                            $query .= " ORDER BY uo.price ASC";
                                                            break;
                                                        case 'date_desc':
                                                        default:
                                                            $query .= " ORDER BY uo.o_id DESC";
                                                            break;
                                                    }
                                                } else {
                                                    $query .= " ORDER BY uo.o_id DESC";
                                                }
                                                
                                                $query_res = mysqli_query($db, $query);

                                                if (!mysqli_num_rows($query_res) > 0) {
                                                    echo '<tr><td colspan="9"><center>No orders found matching your criteria.</center></td></tr>';
                                                } else {                  
                                                    while ($row = mysqli_fetch_array($query_res)) {
                                            ?>
                                            <tr>  
                                                <td data-column="Order ID">#<?php echo $row['o_id']; ?></td>  
                                                <td data-column="Item"><?php echo $row['title']; ?></td>
                                                <td data-column="Quantity"><?php echo $row['quantity']; ?></td>
                                                <td data-column="Price">₹<?php echo $row['price']; ?></td>
                                                <td data-column="Status">
                                                    <?php 
                                                       // Replace the existing status display code with this
$status = $row['status'];
if ($status == "" || $status == "NULL") {
    echo '<div class="status-badge pending">
            <span class="badge-dot"></span>
            <span class="badge-label"><i class="fa fa-spinner fa-pulse"></i> Pending</span>
          </div>';
} elseif ($status == "in process") {
    echo '<div class="status-badge processing">
            <span class="badge-dot"></span>
            <span class="badge-label"><i class="fa fa-cog fa-spin"></i> Preparing</span>
          </div>';
} elseif ($status == "closed") {
    echo '<div class="status-badge delivered">
            <span class="badge-dot"></span>
            <span class="badge-label"><i class="fa fa-check-circle"></i> Delivered</span>
          </div>';
} elseif ($status == "rejected") {
    echo '<div class="status-badge cancelled">
            <span class="badge-dot"></span>
            <span class="badge-label"><i class="fa fa-times-circle"></i> Cancelled</span>
          </div>';
} elseif ($status == "confirm") {
    echo '<div class="status-badge confirmed">
            <span class="badge-dot"></span>
            <span class="badge-label"><i class="fa fa-check"></i> Accepted</span>
          </div>';
} elseif ($status == "prepared") {
    echo '<div class="status-badge ready">
            <span class="badge-dot"></span>
            <span class="badge-label"><i class="fa fa-shopping-bag"></i> Ready to Pick</span>
          </div>';
}
                                                    ?>
                                                </td>
                                                
                                                <!-- Payment Status Column -->
                                                <td data-column="Payment Status">
                                                    <?php 
                                                        if ($row['payment_status']) {
                                                            if ($row['payment_status'] == 'Paid') {
                                                                echo '<span class="badge badge-success">Paid</span>';
                                                            } else {
                                                                echo '<span class="badge badge-warning">Pending</span>';
                                                            }
                                                        } else {
                                                            echo '<span class="badge badge-warning">Pending</span>'; // Default if no payment found
                                                        }
                                                    ?>
                                                </td>

                                                <td data-column="Date"><?php echo date('d M Y', strtotime($row['date'])); ?></td>
                                                <td data-column="PickTime"><?php echo $row['pick_time']; ?></td>
                                                <td class="action-column">
                                                    <?php
                                                        // View order details button
                                                        echo '<a href="order_details.php?o_id='.$row['o_id'].'" class="btn btn-info btn-sm mb-1">
                                                                <i class="fa fa-eye"></i>
                                                            </a> ';
                                                        
                                                        // Cancel button for pending orders
                                                        if ($status == "" || $status == "NULL") { 
                                                            echo '<a href="your_orders.php?o_id='.$row['o_id'].'" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to cancel the order?\');">
                                                                <i class="fa fa-times"></i>
                                                            </a>';
                                                        } elseif ($status == "prepared") {
                                                            // Picked up button for ready orders
                                                            echo '<a href="confirm_pickup.php?o_id='.$row['o_id'].'" class="btn btn-success btn-sm">
                                                                <i class="fa fa-check"></i> ORDERED
                                                            </a>';
                                                        } elseif ($status == "closed" && !isset($row['review_added'])) {
                                                            // Add review button for delivered orders without reviews
                                                            echo '<a href="add_review.php?o_id='.$row['o_id'].'" class="btn btn-primary btn-sm">
                                                                <i class="fa fa-star"></i> Review
                                                            </a>';
                                                        }   
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php }} ?>    
                                        </tbody>
                                    </table>
                                </div>
                                
                                <!-- Pagination -->
                                <nav aria-label="Page navigation">
                                    <ul class="pagination justify-content-center">
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#" tabindex="-1">Previous</a>
                                        </li>
                                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">Next</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- JavaScript for search functionality -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Existing search functionality
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const searchValue = this.value.toLowerCase();
        const table = document.getElementById('ordersTable');
        const rows = table.getElementsByTagName('tr');
        
        for (let i = 1; i < rows.length; i++) {
            let found = false;
            const cells = rows[i].getElementsByTagName('td');
            
            for (let j = 0; j < cells.length; j++) {
                const cellText = cells[j].textContent.toLowerCase();
                if (cellText.indexOf(searchValue) > -1) {
                    found = true;
                    break;
                }
            }
            
            if (found) {
                rows[i].style.display = '';
                // Highlight animation for found rows
                rows[i].style.animation = 'pulse 1s';
                setTimeout(() => {
                    rows[i].style.animation = '';
                }, 1000);
            } else {
                rows[i].style.display = 'none';
            }
        }
    });
    
    // Animate statistics on page load
    const statBoxes = document.querySelectorAll('.stat-box');
    statBoxes.forEach((box, index) => {
        box.style.opacity = '0';
        box.style.transform = 'translateY(20px)';
        setTimeout(() => {
            box.style.transition = 'all 0.5s ease';
            box.style.opacity = '1';
            box.style.transform = 'translateY(0)';
        }, 100 * (index + 1));
    });
    
    // Animate counter for statistics
    function animateCounter(element, target, duration = 1500) {
        const start = 0;
        const increment = target / (duration / 16);
        let current = start;
        
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                clearInterval(timer);
                element.textContent = target;
            } else {
                if (element.textContent.includes('₹')) {
                    element.textContent = '₹' + Math.floor(current).toLocaleString();
                } else {
                    element.textContent = Math.floor(current);
                }
            }
        }, 16);
    }
    
    // Apply counter animation to stat boxes
    document.querySelectorAll('.stat-box h3').forEach(statElement => {
        let targetValue;
        if (statElement.textContent.includes('₹')) {
            targetValue = parseFloat(statElement.textContent.replace(/[₹,]/g, ''));
            statElement.textContent = '₹0';
        } else {
            targetValue = parseInt(statElement.textContent);
            statElement.textContent = '0';
        }
        
        animateCounter(statElement, targetValue);
    });
    
    // Animate table rows on page load
    const tableRows = document.querySelectorAll('#ordersTable tbody tr');
    tableRows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateX(-20px)';
        setTimeout(() => {
            row.style.transition = 'all 0.3s ease';
            row.style.opacity = '1';
            row.style.transform = 'translateX(0)';
        }, 50 * (index + 1));
    });
    
    // Add filter animation
    const filterForm = document.querySelector('.filter-form');
    filterForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Add loading animation
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Applying...';
        
        // Simulate loading for demo purposes
        setTimeout(() => {
            this.submit();
        }, 500);
    });
});

// Create skeleton loading effect
function showSkeletonLoading() {
    const tableBody = document.querySelector('#ordersTable tbody');
    const rowCount = tableBody.querySelectorAll('tr').length || 5;
    tableBody.innerHTML = '';
    
    for (let i = 0; i < rowCount; i++) {
        const skelRow = document.createElement('tr');
        skelRow.className = 'skeleton-row';
        
        for (let j = 0; j < 9; j++) { // 9 columns
            const skelCell = document.createElement('td');
            skelCell.innerHTML = '<div class="skeleton-loader"></div>';
            skelRow.appendChild(skelCell);
        }
        
        tableBody.appendChild(skelRow);
    }
}

// Add this to your filter form submission
document.querySelector('.filter-form').addEventListener('submit', function(e) {
    e.preventDefault();
    showSkeletonLoading();
    
    setTimeout(() => {
        this.submit();
    }, 800);
});
// Toast notification system
function showToast(message, type = 'info') {
    const toastContainer = document.getElementById('toast-container');
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `
        <div class="toast-icon">
            <i class="fa fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
        </div>
        <div class="toast-message">${message}</div>
    `;
    
    toastContainer.appendChild(toast);
    
    // Animate in
    setTimeout(() => {
        toast.style.transform = 'translateX(0)';
        toast.style.opacity = '1';
    }, 10);
    
    // Automatically remove after 5 seconds
    setTimeout(() => {
        toast.style.transform = 'translateX(120%)';
        toast.style.opacity = '0';
        setTimeout(() => {
            toast.remove();
        }, 300);
    }, 5000);
}

// Show a welcome toast when page loads
setTimeout(() => {
    showToast('Welcome to your order dashboard!', 'info');
}, 1000);

// Show toast when applying filters
document.querySelector('.filter-form').addEventListener('submit', function() {
    showToast('Applying filters...', 'info');
});

</script>
            
            
            <!-- start: FOOTER -->
            <?php include_once('footer.php');?>

            <!-- end:Footer -->
        </div>
  
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <script src="js/jquery.min.js"></script>
    <script src="js/tether.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/animsition.min.js"></script>
    <script src="js/bootstrap-slider.min.js"></script>
    <script src="js/jquery.isotope.min.js"></script>
    <script src="js/headroom.js"></script>
    <script src="js/foodpicky.min.js"></script>

    <!-- move top -->
  <button onclick="topFunction()" id="movetop" title="Go to top">
  	&#10548;
  </button>
  <script>
  	// When the user scrolls down 20px from the top of the document, show the button
  	window.onscroll = function () {
  		scrollFunction()
  	};

  	function scrollFunction() {
  		if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
  			document.getElementById("movetop").style.display = "block";
  		} else {
  			document.getElementById("movetop").style.display = "none";
  		}
  	}

  	// When the user clicks on the button, scroll to the top of the document
  	function topFunction() {
  		document.body.scrollTop = 0;
  		document.documentElement.scrollTop = 0;
  	}
  </script>
  <!-- /move top -->
  </section>

  <!-- jQuery and Bootstrap JS -->
  <!-- <script src="assets/js/jquery-3.3.1.min.js"></script> -->

  <!-- libhtbox -->
  <!-- <script src="assets/js/lightbox-plus-jquery.min.js"></script> -->


  <script src="assets/js/jquery.magnific-popup.min.js"></script>

  <script src="assets/js/counter.js"></script>
  <script>
  	$(document).ready(function () {
  		$('.popup-with-zoom-anim').magnificPopup({
  			type: 'inline',

  			fixedContentPos: false,
  			fixedBgPos: true,

  			overflowY: 'auto',

  			closeBtnInside: true,
  			preloader: false,

  			midClick: true,
  			removalDelay: 300,
  			mainClass: 'my-mfp-zoom-in'
  		});

  		$('.popup-with-move-anim').magnificPopup({
  			type: 'inline',

  			fixedContentPos: false,
  			fixedBgPos: true,

  			overflowY: 'auto',

  			closeBtnInside: true,
  			preloader: false,

  			midClick: true,
  			removalDelay: 300,
  			mainClass: 'my-mfp-slide-bottom'
  		});
  	});
  </script>

  <!-- testimonials owlcarousel -->
  <script src="assets/js/owl.carousel.js"></script>
  <script>
  	$(document).ready(function () {
  		$('.owl-two').owlCarousel({
  			loop: true,
  			margin: 30,
  			nav: false,
  			responsiveClass: true,
  			autoplay: false,
  			autoplayTimeout: 5000,
  			autoplaySpeed: 1000,
  			autoplayHoverPause: false,
  			responsive: {
  				0: {
  					items: 1,
  					nav: false
  				},
  				480: {
  					items: 1,
  					nav: false
  				},
  				667: {
  					items: 1,
  					nav: false
  				},
  				1000: {
  					items: 1,
  					nav: false
  				}
  			}
  		})
  	})
  </script>
  <!-- //script for Testimonials-->

  <!-- script for food-->
  <script>
  	$(document).ready(function () {
  		$('.owl-carousel').owlCarousel({
  			loop: true,
  			margin: 0,
  			responsiveClass: true,
  			responsive: {
  				0: {
  					items: 1,
  					nav: true
  				},
  				480: {
  					items: 2,
  					nav: true,
  					margin: 20
  				},
  				769: {
  					items: 3,
  					nav: true,
  					margin: 20
  				},
  				1280: {
  					items: 4,
  					nav: true,
  					loop: true,
  					margin: 25
  				}
  			}
  		})
  	})
  </script>
  <!-- //script for food-->

  <!-- disable body scroll which navbar is in active -->
  <script>
  	$(function () {
  		$('.navbar-toggler').click(function () {
  			$('body').toggleClass('noscroll');
  		})
  	});
  </script>
  <!-- disable body scroll which navbar is in active -->
  <!--/MENU-JS-->
  <script>
  	$(window).on("scroll", function () {
  		var scroll = $(window).scrollTop();

  		if (scroll >= 80) {
  			$("#site-header").addClass("nav-fixed");
  		} else {
  			$("#site-header").removeClass("nav-fixed");
  		}
  	});

  	//Main navigation Active Class Add Remove
  	$(".navbar-toggler").on("click", function () {
  		$("header").toggleClass("active");
  	});
  	$(document).on("ready", function () {
  		if ($(window).width() > 991) {
  			$("header").removeClass("active");
  		}
  		$(window).on("resize", function () {
  			if ($(window).width() > 991) {
  				$("header").removeClass("active");
  			}
  		});
  	});
  </script>
  <!--//MENU-JS-->
  <script src="assets/js/bootstrap.min.js"></script>

<?php
}
?>

 
  