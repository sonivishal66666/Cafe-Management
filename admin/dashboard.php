<!DOCTYPE html>
<html lang="en">
<?php
include("../connection/connect.php");
error_reporting(0);
session_start();
if(empty($_SESSION["adm_id"]))
{
    header('location:index.php');
    exit();
}
?>
<?php include_once('header.php');?>

<!-- Modern Dashboard CSS -->
<style>
    :root {
        --primary-color: #4e73df;
        --primary-dark: #3a5bbf;
        --secondary-color: #1cc88a;
        --warning-color: #f6c23e;
        --danger-color: #e74a3b;
        --dark-color: #5a5c69;
        --light-color: #f8f9fc;
        --card-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        --card-hover-shadow: 0 0.5rem 2rem 0 rgba(58, 59, 69, 0.2);
    }
    
    .dashboard-card {
        border-radius: 10px;
        border: none;
        box-shadow: var(--card-shadow);
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
        z-index: 1;
    }
    
    .dashboard-card::before {
        content: '';
        position: absolute;
        z-index: -1;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--card-hover-shadow);
    }
    
    .dashboard-card:hover::before {
        opacity: 1;
    }
    
    .card-icon {
        width: 64px;
        height: 64px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 16px;
        font-size: 1.8rem;
        color: white;
        margin-right: 15px;
        position: relative;
        overflow: hidden;
    }
    
    .card-icon::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.15);
        top: -50%;
        left: -50%;
        transform: rotate(35deg);
        transition: all 0.5s ease;
    }
    
    .dashboard-card:hover .card-icon::after {
        top: 150%;
        left: 150%;
    }
    
    .card-icon-archive {
        background: linear-gradient(135deg, #f6c23e, #ffa500);
        box-shadow: 0 4px 20px rgba(246, 194, 62, 0.3);
    }
    
    .card-icon-dish {
        background: linear-gradient(135deg, #36b9cc, #0097e6);
        box-shadow: 0 4px 20px rgba(54, 185, 204, 0.3);
    }
    
    .card-icon-user {
        background: linear-gradient(135deg, #e74a3b, #d63031);
        box-shadow: 0 4px 20px rgba(231, 74, 59, 0.3);
    }
    
    .card-icon-order {
        background: linear-gradient(135deg, #4e73df, #2d3fa9);
        box-shadow: 0 4px 20px rgba(78, 115, 223, 0.3);
    }
    
    .dashboard-card .card-body {
        padding: 24px;
        display: flex;
        align-items: center;
    }
    
    .card-data h2 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 5px;
        color: #2c3e50;
        letter-spacing: -0.5px;
    }
    
    .card-data p {
        font-size: 14px;
        color: #7d8ba1;
        margin-bottom: 0;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    
    .dashboard-header {
        padding: 24px 0 28px;
        position: relative;
    }
    
    .dashboard-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100px;
        height: 4px;
        background: var(--primary-color);
        border-radius: 2px;
    }
    
    .breadcrumb-custom {
        background: transparent;
        padding: 0;
    }
    
    .breadcrumb-custom .breadcrumb-item a {
        color: var(--primary-color);
        font-weight: 600;
        transition: color 0.2s;
    }
    
    .breadcrumb-custom .breadcrumb-item a:hover {
        color: var(--primary-dark);
        text-decoration: none;
    }
    
    .breadcrumb-custom .breadcrumb-item.active {
        color: var(--dark-color);
        font-weight: 600;
    }
    
    .dashboard-container {
        padding: 28px 0;
    }
    
    .card-footer {
        border-top: 1px solid rgba(0, 0, 0, 0.05);
        transition: background-color 0.3s;
    }
    
    .card-footer:hover {
        background-color: #f1f5fe !important;
    }
    
    .card-footer a {
        transition: color 0.3s;
        font-weight: 600;
    }
    
    .card-footer a:hover {
        color: var(--primary-dark) !important;
        text-decoration: none;
    }
    
    .card-header {
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: 16px 24px;
    }
    
    .card-title {
        color: #2c3e50;
        font-weight: 700;
        margin-bottom: 0;
        display: flex;
        align-items: center;
    }
    
    .card-title i {
        margin-right: 10px;
        color: var(--primary-color);
    }
    
    .table {
        margin-bottom: 0;
    }
    
    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 0.7px;
        color: #5a6772;
        border-top: none;
        padding: 16px 24px;
    }
    
    .table td {
        vertical-align: middle;
        padding: 16px 24px;
        color: #2c3e50;
    }
    
    .badge {
        padding: 6px 12px;
        font-weight: 600;
        border-radius: 40px;
        font-size: 11px;
        letter-spacing: 0.5px;
    }
    
    .badge-warning {
        background-color: #fff8e6;
        color: #e5a100;
    }
    
    .badge-success {
        background-color: #e6fff2;
        color: #00b070;
    }
    
    .badge-danger {
        background-color: #ffe6e6;
        color: #d63031;
    }
    
    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        padding: 8px 20px;
        font-weight: 600;
        border-radius: 6px;
        box-shadow: 0 4px 15px rgba(78, 115, 223, 0.3);
        transition: all 0.3s;
    }
    
    .btn-primary:hover {
        background-color: var(--primary-dark);
        border-color: var(--primary-dark);
        transform: translateY(-2px);
    }
    
    /* Dashboard Stats Bar */
    .stats-summary {
        background: linear-gradient(135deg, #4e73df, #3a5bbf);
        border-radius: 10px;
        padding: 25px;
        margin-bottom: 30px;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(78, 115, 223, 0.3);
    }
    
    .stats-summary::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><path fill="rgba(255,255,255,0.05)" d="M0,0 L100,0 L100,5 C60,20 40,60 0,5 Z"></path></svg>');
        background-size: cover;
    }
    
    .stats-summary h3 {
        font-weight: 700;
        margin-bottom: 15px;
        font-size: 24px;
    }
    
    .stats-item {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }
    
    .stats-icon {
        background: rgba(255, 255, 255, 0.2);
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        backdrop-filter: blur(5px);
    }
    
    .stats-info h4 {
        font-size: 18px;
        margin-bottom: 0;
        font-weight: 600;
    }
    
    .stats-info p {
        margin-bottom: 0;
        font-size: 14px;
        opacity: 0.8;
    }
    
    /* Activity Timeline */
    .activity-timeline {
        position: relative;
        padding-left: 45px;
    }
    
    .timeline-item {
        position: relative;
        padding-bottom: 20px;
    }
    
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -30px;
        top: 5px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: var(--primary-color);
        z-index: 2;
    }
    
    .timeline-item::after {
        content: '';
        position: absolute;
        left: -25px;
        top: 12px;
        width: 2px;
        height: 100%;
        background: #e3e8ef;
    }
    
    .timeline-item:last-child::after {
        display: none;
    }
    
    .timeline-date {
        font-size: 12px;
        color: #7d8ba1;
        margin-bottom: 6px;
        display: block;
    }
    
    .timeline-title {
        font-weight: 600;
        margin-bottom: 5px;
        color: #2c3e50;
    }
    
    .timeline-desc {
        font-size: 14px;
        color: #5a6772;
        margin-bottom: 0;
    }
    
    /* Order Status Colors */
    .status-circle {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        margin-right: 6px;
    }
    
    .status-pending {
        background-color: #f6c23e;
    }
    
    .status-completed {
        background-color: #1cc88a;
    }
    
    .status-cancelled {
        background-color: #e74a3b;
    }
    
    /* Empty state styling */
    .empty-state {
        padding: 40px 20px;
        text-align: center;
    }
    
    .empty-state i {
        font-size: 48px;
        color: #e3e8ef;
        margin-bottom: 15px;
    }
    
    .empty-state h5 {
        color: #7d8ba1;
        font-weight: 600;
    }
    
    .empty-state p {
        color: #a7b4c8;
        max-width: 450px;
        margin: 0 auto;
    }
    
    /* System Overview */
    .system-overview {
        padding: 20px;
    }
    
    .overview-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #f1f5fe;
    }
    
    .overview-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    
    .overview-label {
        font-weight: 600;
        color: #5a6772;
    }
    
    .overview-value {
        font-weight: 700;
        color: #2c3e50;
    }
    
    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes countUp {
        from { transform: scale(0.8); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    
    @keyframes shimmer {
        0% { background-position: -1000px 0; }
        100% { background-position: 1000px 0; }
    }
    
    .animate-fade-in {
        animation: fadeIn 0.8s ease forwards;
        opacity: 0;
    }
    
    .animate-count-up {
        animation: countUp 0.6s ease forwards;
        opacity: 0;
    }
    
    .animate-pulse {
        animation: pulse 2s infinite;
    }
    
    .shimmer {
        background: linear-gradient(90deg, #f0f3f8 0%, #ffffff 50%, #f0f3f8 100%);
        background-size: 1000px 100%;
        animation: shimmer 2s infinite linear;
    }
    
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }
    .delay-4 { animation-delay: 0.4s; }
    .delay-5 { animation-delay: 0.5s; }
    
    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .dashboard-card .card-body {
            flex-direction: column;
            text-align: center;
        }
        
        .card-icon {
            margin-right: 0;
            margin-bottom: 15px;
        }
        
        .activity-timeline {
            padding-left: 30px;
        }
        
        .timeline-item::before {
            left: -20px;
        }
        
        .timeline-item::after {
            left: -15px;
        }
    }
</style>

<!-- Dashboard Header Section -->
<div class="container-fluid">
    <div class="row dashboard-header">
        <div class="col-md-6 align-self-center">
            <h2 class="text-primary mb-0 animate-fade-in">Admin Dashboard</h2>
            <p class="text-muted animate-fade-in delay-1">Welcome back, <?php echo isset($_SESSION["adm_name"]) ? $_SESSION["adm_name"] : "Administrator"; ?>!</p>
        </div>
        <div class="col-md-6 d-flex justify-content-end align-items-center">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-custom animate-fade-in delay-2">
                    <li class="breadcrumb-item"><a href="dashboard.php"><i class="fa fa-home mr-1"></i>Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
        </div>
    </div>
</div>


    <!-- Main Dashboard Content -->
    <div class="row">
        <!-- Food Category Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="dashboard-card animate-fade-in delay-1">
                <div class="card-body">
                    <div class="card-icon card-icon-archive">
                        <i class="fa fa-archive"></i>
                    </div>
                    <div class="card-data">
                        <h2 class="animate-count-up">
                            <?php 
                            $sql = "SELECT * FROM res_category";
                            $result = mysqli_query($db, $sql); 
                            $categories_count = mysqli_num_rows($result);
                            echo $categories_count;
                            ?>
                        </h2>
                        <p>Food Categories</p>
                    </div>
                </div>
                <div class="card-footer bg-light p-2 text-center">
                    <a href="add_category.php" class="text-primary">
                        <small><i class="fa fa-list mr-1"></i>Manage Categories <i class="fa fa-arrow-circle-right ml-1"></i></small>
                    </a>
                </div>
            </div>
        </div>

        <!-- Dishes Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="dashboard-card animate-fade-in delay-2">
                <div class="card-body">
                    <div class="card-icon card-icon-dish">
                        <i class="fa fa-cutlery"></i>
                    </div>
                    <div class="card-data">
                        <h2 class="animate-count-up">
                            <?php 
                            $sql = "SELECT * FROM dishes";
                            $result = mysqli_query($db, $sql); 
                            $dishes_count = mysqli_num_rows($result);
                            echo $dishes_count;
                            ?>
                        </h2>
                        <p>Total Dishes</p>
                    </div>
                </div>
                <div class="card-footer bg-light p-2 text-center">
                    <a href="all_menu.php" class="text-primary">
                        <small><i class="fa fa-cutlery mr-1"></i>Manage Menu <i class="fa fa-arrow-circle-right ml-1"></i></small>
                    </a>
                </div>
            </div>
        </div>

        <!-- Students Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="dashboard-card animate-fade-in delay-3">
                <div class="card-body">
                    <div class="card-icon card-icon-user">
                        <i class="fa fa-user"></i>
                    </div>
                    <div class="card-data">
                        <h2 class="animate-count-up">
                            <?php 
                            $sql = "SELECT * FROM users";
                            $result = mysqli_query($db, $sql); 
                            $users_count = mysqli_num_rows($result);
                            echo $users_count;
                            ?>
                        </h2>
                        <p>Registered Students</p>
                    </div>
                </div>
                <div class="card-footer bg-light p-2 text-center">
                    <a href="allusers.php" class="text-primary">
                        <small><i class="fa fa-users mr-1"></i>Manage Students <i class="fa fa-arrow-circle-right ml-1"></i></small>
                    </a>
                </div>
            </div>
        </div>

        <!-- Orders Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="dashboard-card animate-fade-in delay-4">
                <div class="card-body">
                    <div class="card-icon card-icon-order">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                    <div class="card-data">
                        <h2 class="animate-count-up">
                            <?php 
                            $sql = "SELECT * FROM users_orders";
                            $result = mysqli_query($db, $sql); 
                            $orders_count = mysqli_num_rows($result);
                            echo $orders_count;
                            ?>
                        </h2>
                        <p>Total Orders</p>
                    </div>
                </div>
                <div class="card-footer bg-light p-2 text-center">
                    <a href="all_orders.php" class="text-primary">
                        <small><i class="fa fa-shopping-cart mr-1"></i>Manage Orders <i class="fa fa-arrow-circle-right ml-1"></i></small>
                    </a>
                </div>
            </div>
        </div>
    </div>


