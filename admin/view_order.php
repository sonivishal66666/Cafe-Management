<?php
include("../connection/connect.php");
error_reporting(0);
session_start();
?>

<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Orders</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #1cc88a;
            --danger-color: #e74a3b;
            --warning-color: #f6c23e;
            --info-color: #36b9cc;
            --dark-color: #5a5c69;
        }
        
        body {
            background-color: #f8f9fc;
            font-family: 'Nunito', sans-serif;
        }
        
        .page-wrapper {
            min-height: 100vh;
            padding-top: 20px;
        }
        
        .card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 2rem 0 rgba(58, 59, 69, 0.2);
        }
        
        .card-header {
            background-color: white;
            border-bottom: 1px solid #e3e6f0;
        }
        
        .card-title {
            color: var(--dark-color);
            font-weight: 700;
            margin-bottom: 0;
        }
        
        .table {
            border-radius: 0.35rem;
            overflow: hidden;
        }
        
        .table th {
            background-color: #f8f9fc;
            color: var(--dark-color);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-size: 0.85rem;
            border: none;
        }
        
        .table td {
            vertical-align: middle;
            border-color: #e3e6f0;
        }
        
        .table tr:hover {
            background-color: #f8f9fc;
        }
        
        .btn {
            border-radius: 0.35rem;
            padding: 0.375rem 0.75rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #2653d4;
            border-color: #2653d4;
            transform: translateY(-2px);
        }
        
        .btn-warning {
            background-color: var(--warning-color);
            border-color: var(--warning-color);
            color: #fff;
        }
        
        .btn-success {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .btn-danger {
            background-color: var(--danger-color);
            border-color: var(--danger-color);
        }
        
        .btn-info {
            background-color: var(--info-color);
            border-color: var(--info-color);
            color: #fff;
        }
        
        .order-info-row {
            transition: background-color 0.3s ease;
        }
        
        .order-info-row:hover {
            background-color: #f1f3f9;
        }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 600;
            color: white;
        }
        
        .status-badge i {
            margin-right: 0.5rem;
        }
        
        .status-pending {
            background: linear-gradient(45deg, #007bff, #6610f2);
        }
        
        .status-process {
            background: linear-gradient(45deg, #fd7e14, #ffc107);
        }
        
        .status-delivered {
            background: linear-gradient(45deg, #28a745, #20c997);
        }
        
        .status-cancelled {
            background: linear-gradient(45deg, #dc3545, #e83e8c);
        }
        
        .status-accepted {
            background: linear-gradient(45deg, #17a2b8, #007bff);
        }
        
        .status-prepared {
            background: linear-gradient(45deg, #28a745, #1cc88a);
        }
        
        .price-tag {
            background-color: #f8f9fc;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-weight: 700;
            color: var(--dark-color);
        }
        
        .modal-content {
            border-radius: 0.5rem;
            border: none;
        }
        
        .modal-header {
            border-bottom: 1px solid #e3e6f0;
            background-color: #f8f9fc;
        }
        
        .modal-title {
            color: var(--dark-color);
            font-weight: 700;
        }
        
        .modal-footer {
            border-top: 1px solid #e3e6f0;
        }
        
        .info-label {
            font-weight: 600;
            color: var(--dark-color);
        }
        
        .info-value {
            font-weight: 400;
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
        
        .fade-in-up {
            animation: fadeInUp 0.5s ease forwards;
        }
        
        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
            100% {
                transform: scale(1);
            }
        }
        
        .pulse {
            animation: pulse 2s infinite;
        }
        
        .action-button-container {
            display: flex;
            justify-content: center;
            margin: 1.5rem 0;
        }
        
        .action-button {
            padding: 0.75rem 2rem;
            font-size: 1rem;
            box-shadow: 0 4px 6px rgba(50, 50, 93, 0.11), 0 1px 3px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }
        
        .action-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 7px 14px rgba(50, 50, 93, 0.1), 0 3px 6px rgba(0, 0, 0, 0.08);
        }
        
        .action-button:active {
            transform: translateY(1px);
        }
        
        .action-button i {
            margin-right: 0.5rem;
        }
    </style>
</head>

<body>
    <script>
        var popUpWin = 0;
        function popUpWindow(URLStr, left, top, width, height) {
            if (popUpWin) {
                if (!popUpWin.closed) popUpWin.close();
            }
            popUpWin = open(URLStr, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width=' + 600 + ',height=' + 600 + ',left=' + left + ',top=' + top + ',screenX=' + left + ',screenY=' + top + '');
        }
    </script>

    <?php include_once('header.php'); ?>

    <!-- Page wrapper -->
    <div class="page-wrapper">
        <!-- Container fluid -->
        <div class="container-fluid">
            <!-- Start Page Content -->
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4 animate__animated animate__fadeIn">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h4 class="card-title m-0 font-weight-bold">Order Details</h4>
                            <div class="dropdown no-arrow">
                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-print me-2"></i>Print</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-file-pdf me-2"></i>Export PDF</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php
                            $sql = "SELECT users.*, users_orders.* FROM users INNER JOIN users_orders ON users.u_id=users_orders.u_id where o_id='" . $_GET['user_upd'] . "'";
                            $query = mysqli_query($db, $sql);
                            $rows = mysqli_fetch_array($query);
                            ?>

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="d-flex align-items-center mb-3 animate__animated animate__fadeInLeft justify-content-center">
                                        <div class="me-3">
                                            <div class="icon-circle bg-primary text-white">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-primary">Student Information</h6>
                                            <span class="text-muted small">Order #<?php echo $rows['o_id']; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Centered Action Button -->
                            <div class="action-button-container animate__animated animate__fadeInUp">
                                <a href="javascript:void(0);" onClick="popUpWindow('order_update.php?form_id=<?php echo htmlentities($rows['o_id']); ?>');" class="btn btn-primary action-button pulse">
                                    <i class="fas fa-edit"></i>Take Action
                                </a>
                            </div>

                            <div class="row fade-in-up" style="animation-delay: 0.1s;">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <tbody>
                                                <tr class="order-info-row">
                                                    <td width="25%" class="bg-light"><strong class="info-label">Student Name:</strong></td>
                                                    <td class="info-value"><?php echo $rows['student_name']; ?></td>
                                                </tr>
                                                <tr class="order-info-row">
                                                    <td class="bg-light"><strong class="info-label">Dish Name:</strong></td>
                                                    <td class="info-value"><?php echo $rows['title']; ?></td>
                                                </tr>
                                                <tr class="order-info-row">
                                                    <td class="bg-light"><strong class="info-label">Quantity:</strong></td>
                                                    <td class="info-value"><?php echo $rows['quantity']; ?></td>
                                                </tr>
                                                <tr class="order-info-row">
                                                    <td class="bg-light"><strong class="info-label">Price:</strong></td>
                                                    <td class="info-value"><span class="price-tag">₹<?php echo $rows['price']; ?></span></td>
                                                </tr>
                                                <tr class="order-info-row">
                                                    <td class="bg-light"><strong class="info-label">Pickup Time:</strong></td>
                                                    <td class="info-value"><?php echo $rows['pick_time']; ?></td>
                                                </tr>
                                                <tr class="order-info-row">
                                                    <td class="bg-light"><strong class="info-label">Date:</strong></td>
                                                    <td class="info-value"><?php echo $rows['date']; ?></td>
                                                </tr>
                                                <tr class="order-info-row">
                                                    <td class="bg-light"><strong class="info-label">Status:</strong></td>
                                                    <td>
                                                        <?php
                                                        $status = $rows['status'];
                                                        if ($status == "" or $status == "NULL") {
                                                        ?>
                                                            <span class="status-badge status-pending pulse">
                                                                <i class="fas fa-spinner fa-spin"></i> Pending
                                                            </span>
                                                        <?php
                                                        }
                                                        if ($status == "in process") {
                                                        ?>
                                                            <span class="status-badge status-process">
                                                                <i class="fas fa-cog fa-spin"></i> Preparing!
                                                            </span>
                                                        <?php
                                                        }
                                                        if ($status == "closed") {
                                                        ?>
                                                            <span class="status-badge status-delivered">
                                                                <i class="fas fa-check-circle"></i> Delivered
                                                            </span>
                                                        <?php
                                                        }
                                                        if ($status == "rejected") {
                                                        ?>
                                                            <span class="status-badge status-cancelled">
                                                                <i class="fas fa-times-circle"></i> Cancelled
                                                            </span>
                                                        <?php
                                                        }
                                                        if ($status == "confirm") {
                                                        ?>
                                                            <span class="status-badge status-accepted">
                                                                <i class="fas fa-check"></i> Accepted
                                                            </span>
                                                        <?php
                                                        }
                                                        if ($status == "prepared") {
                                                        ?>
                                                            <span class="status-badge status-prepared">
                                                                <i class="fas fa-shopping-bag"></i> Prepared
                                                            </span>
                                                        <?php
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Page Content -->
        </div>
        <!-- End Container fluid -->
    </div>
    <!-- End Page wrapper -->

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#myTable').DataTable();
            
            // Add animation to rows when page loads
            let delay = 0;
            $('.order-info-row').each(function() {
                $(this).css('animation-delay', delay + 's');
                $(this).addClass('animate__animated animate__fadeInRight');
                delay += 0.1;
            });
            
            // Add hover effect to action buttons
            $('.btn').hover(
                function() {
                    $(this).addClass('animate__animated animate__pulse');
                },
                function() {
                    $(this).removeClass('animate__animated animate__pulse');
                }
            );
        });
        
        // Add smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>

    <style>
        .icon-circle {
            height: 2.5rem;
            width: 2.5rem;
            border-radius: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }
    </style>

</body>
</html>