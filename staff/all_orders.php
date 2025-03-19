<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Orders</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #1cc88a;
            --accent-color: #f6c23e;
            --danger-color: #e74a3b;
            --dark-color: #5a5c69;
            --light-color: #f8f9fc;
        }
        
        body {
            background-color: #f8f9fc;
            font-family: 'Nunito', 'Segoe UI', Roboto, sans-serif;
        }
        
        .page-header {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            margin-bottom: 1.5rem;
            padding: 1.5rem;
        }
        
        .page-header h3 {
            color: var(--primary-color);
            font-weight: 700;
            margin: 0;
        }
        
        .breadcrumb {
            background: transparent;
            margin: 0;
        }
        
        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            margin-bottom: 2rem;
        }
        
        .card-header {
            background-color: white;
            border-bottom: 1px solid #e3e6f0;
            padding: 1.25rem 1.5rem;
        }
        
        .card-title {
            color: var(--dark-color);
            font-weight: 700;
            margin-bottom: 0;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .table-container {
            border-radius: 8px;
            overflow: hidden;
        }
        
        .table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
        }
        
        .table thead th {
            background-color: var(--primary-color);
            color: black;
            font-weight: 600;
            padding: 0.75rem;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            border: none;
        }
        
        .table td {
            border-top: 1px solid #e3e6f0;
            padding: 0.75rem;
            vertical-align: middle;
        }
        
        .table tbody tr:hover {
            background-color: rgba(78, 115, 223, 0.05);
        }
        
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f8f9fc;
        }
        
        .status-badge {
            border-radius: 30px;
            color: white;
            display: inline-flex;
            align-items: center;
            font-size: 0.85rem;
            font-weight: 600;
            padding: 0.35rem 0.75rem;
        }
        
        .status-pending {
            background-color: #4e73df;
        }
        
        .status-preparing {
            background-color: #f6c23e;
        }
        
        .status-delivered {
            background-color: #1cc88a;
        }
        
        .status-cancelled {
            background-color: #e74a3b;
        }
        
        .status-accepted {
            background-color: #36b9cc;
        }
        
        .status-prepared {
            background-color: #2e9d4d;
        }
        
        .btn-action {
            border-radius: 50%;
            color: white;
            height: 32px;
            margin-right: 0.5rem;
            padding: 0;
            width: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(50, 50, 93, 0.11), 0 1px 3px rgba(0, 0, 0, 0.08);
        }
        
        .btn-view {
            background-color: #4e73df;
        }
        
        .btn-delete {
            background-color: #e74a3b;
        }
        
        .price-column {
            font-weight: 600;
            color: #2e9d4d;
        }
        
        .pagination {
            margin-top: 1rem;
        }
        
        .icon-space {
            margin-right: 0.5rem;
        }
        
        .table-responsive {
            border-radius: 8px;
            overflow: visible; /* Changed from hidden to visible */
        }
        
        /* Added to ensure action buttons are visible */
        .action-column {
            min-width: 90px; /* Ensure minimum width for action buttons */
            white-space: nowrap; /* Prevent wrapping */
        }
        
        /* Make sure the table doesn't get cut off */
        .dataTables_wrapper {
            overflow-x: visible;
        }
        
        /* Make sure that horizontal scrolling works properly */
        .card-body {
            overflow: visible;
        }
        
        /* Fix for DataTables responsive behavior */
        .dataTable {
            width: 100% !important;
        }
    </style>
</head>
<body>
    <?php
    include("../connection/connect.php");
    error_reporting(0);
    session_start();
    ?>
    <?php include_once('header.php');?>
    
    <div class="container-fluid py-4">
        <div class="page-header d-flex justify-content-between align-items-center">
            <div>
                <h3 class="mb-1">All Orders</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">All Orders</li>
                    </ol>
                </nav>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">All User Orders</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Student Name</th>
                                <th>Dish Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Pickup Time</th>
                                <th>Order Date</th>
                                <th class="action-column">Action</th> <!-- Added class -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql="SELECT users.*, users_orders.* FROM users INNER JOIN users_orders ON users.u_id=users_orders.u_id order by o_id desc ";
                            $query=mysqli_query($db,$sql);
                            
                            if(!mysqli_num_rows($query) > 0 ) {
                                echo '<tr><td colspan="9" class="text-center">No Orders-Data!</td></tr>';
                            } else {
                                $i=1;
                                while($rows=mysqli_fetch_array($query)) {
                            ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $rows['student_name']; ?></td>
                                    <td><?php echo $rows['title']; ?></td>
                                    <td><?php echo $rows['quantity']; ?></td>
                                    <td class="price-column">₹<?php echo $rows['price']; ?></td>
                                    <td>
                                        <?php 
                                        $status=$rows['status'];
                                        if($status=="" or $status=="NULL") { ?>
                                            <span class="status-badge status-pending">
                                                <i class="fas fa-spinner fa-spin icon-space"></i>Pending
                                            </span>
                                        <?php } 
                                        if($status=="in process") { ?>
                                            <span class="status-badge status-preparing">
                                                <i class="fas fa-cog fa-spin icon-space"></i>Preparing
                                            </span>
                                        <?php }
                                        if($status=="closed") { ?>
                                            <span class="status-badge status-delivered">
                                                <i class="fas fa-check-circle icon-space"></i>Delivered
                                            </span>
                                        <?php } 
                                        if($status=="rejected") { ?>
                                            <span class="status-badge status-cancelled">
                                                <i class="fas fa-times-circle icon-space"></i>Cancelled
                                            </span>
                                        <?php } 
                                        if($status=="confirm") { ?>
                                            <span class="status-badge status-accepted">
                                                <i class="fas fa-check icon-space"></i>Accepted
                                            </span>
                                        <?php }
                                        if($status=="prepared") { ?>
                                            <span class="status-badge status-prepared">
                                                <i class="fas fa-shopping-bag icon-space"></i>Prepared
                                            </span>
                                        <?php } ?>
                                    </td>
                                    <td><?php echo $rows['pick_time']; ?></td>
                                    <td><?php echo $rows['date']; ?></td>
                                    <td class="action-column"> <!-- Added class -->
                                        <div class="d-flex">
                                            <a href="delete_orders.php?order_del=<?php echo $rows['o_id'];?>" onclick="return confirm('Are you sure?');" class="btn btn-action btn-delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                            <a href="view_order.php?user_upd=<?php echo $rows['o_id'];?>" class="btn btn-action btn-view">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                                    $i++;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="js/lib/datatables/datatables.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="js/lib/datatables/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <script src="js/lib/datatables/datatables-init.js"></script>
    <script>
       $(document).ready(function() {
    // Check if the table is already initialized as a DataTable
    if (!$.fn.DataTable.isDataTable('#myTable')) {
        $('#myTable').DataTable({
            "order": [[ 0, "desc" ]],
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "scrollX": true, // Enable horizontal scrolling
            "responsive": true,
            "autoWidth": false // Disable auto-width calculation
        });
        });
    </script>
    
</body>
</html>