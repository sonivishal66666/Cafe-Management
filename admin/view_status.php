<?php
include("../connection/connect.php");
error_reporting(0);
session_start();

if(isset($_POST['submit']))
{
    if(!empty($_POST['status']))
    {
       $UpdateSql = "UPDATE users_orders SET status='$_POST[status]' WHERE o_id=$_GET[o_id]";
       mysqli_query($db, $UpdateSql); 
       
       // Add a session message for feedback
       $_SESSION['status_update'] = "Order status updated successfully!";
       header('location:status.php');
       exit();
    }
}

include_once('header.php');
?>

<!DOCTYPE html>
<html lang="en">


<!-- Custom CSS for animations and styling -->
<style>
    .order-card {
        transition: all 0.3s ease;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        overflow: hidden;
        animation: fadeIn 0.6s ease-in-out;
    }
    
    .order-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    
    .card-header {
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        color: white;
        padding: 20px;
        border-radius: 10px 10px 0 0;
    }
    
    .status-badge {
        padding: 8px 15px;
        border-radius: 50px;
        font-weight: 600;
        display: inline-block;
        animation: pulseAnimation 2s infinite;
    }
    
    .info-row {
        padding: 15px;
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.3s ease;
    }
    
    .info-row:hover {
        background-color: #f9f9f9;
    }
    
    .info-label {
        font-weight: 600;
        color: #555;
    }
    
    .info-value {
        font-weight: 500;
        color: #333;
    }
    
    .btn-confirm {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        border: none;
        color: white;
        transition: all 0.3s ease;
    }
    
    .btn-confirm:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(56, 239, 125, 0.4);
    }
    
    .btn-reject {
        background: linear-gradient(135deg, #cb2d3e 0%, #ef473a 100%);
        border: none;
        color: white;
        transition: all 0.3s ease;
    }
    
    .btn-reject:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(239, 71, 58, 0.4);
    }
    
    .select-status {
        border-radius: 8px;
        padding: 12px;
        border: 2px solid #eaeaea;
        transition: all 0.3s ease;
    }
    
    .select-status:focus {
        border-color: #2575fc;
        box-shadow: 0 0 0 0.2rem rgba(37, 117, 252, 0.25);
    }
    
    .btn-submit {
        padding: 12px 25px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-submit:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes pulseAnimation {
        0% { box-shadow: 0 0 0 0 rgba(66, 133, 244, 0.4); }
        70% { box-shadow: 0 0 0 10px rgba(66, 133, 244, 0); }
        100% { box-shadow: 0 0 0 0 rgba(66, 133, 244, 0); }
    }
    select.form-control, 
select.select-status {
    height: auto !important;
    padding: 12px 10px !important;
    font-size: 14px;
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
}

/* Ensure the option text is fully visible */
select.form-control option,
select.select-status option {
    padding: 10px;
    font-size: 14px;
}

/* Additional style to make sure dropdown appears correctly */
.form-group {
    margin-bottom: 20px;
}

/* Fix for select dropdown on different browsers */
select {
    text-indent: 5px;
    text-overflow: '';
    appearance: menulist !important;
    -webkit-appearance: menulist !important;
    -moz-appearance: menulist !important;
}
</style>

<!-- Container fluid  -->
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Flash message for status update -->
            <?php if(isset($_SESSION['status_update'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="animation: fadeIn 0.5s ease-in-out;">
                    <strong><i class="fa fa-check-circle"></i> Success!</strong> <?php echo $_SESSION['status_update']; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php unset($_SESSION['status_update']); ?>
            <?php endif; ?>
            
            <div class="order-card">
                <div class="card-header text-center">
                    <h4><i class="fa fa-cutlery me-2"></i> Order Details</h4>
                </div>
                
                <?php
                $sql = "SELECT users.*, users_orders.* FROM users INNER JOIN users_orders ON users.u_id=users_orders.u_id WHERE o_id='".$_GET['o_id']."'";
                $query = mysqli_query($db, $sql);
                $order = mysqli_fetch_array($query);
                ?>
                
                <div class="card-body p-0">
                    <div class="info-row row align-items-center">
                        <div class="col-md-4 info-label">Student Name</div>
                        <div class="col-md-8 info-value"><?php echo $order['student_name']; ?></div>
                    </div>
                    
                    <div class="info-row row align-items-center">
                        <div class="col-md-4 info-label">Dish Name</div>
                        <div class="col-md-8 info-value"><?php echo $order['title']; ?></div>
                    </div>
                    
                    <div class="info-row row align-items-center">
                        <div class="col-md-4 info-label">Quantity</div>
                        <div class="col-md-8 info-value"><?php echo $order['quantity']; ?></div>
                    </div>
                    
                    <div class="info-row row align-items-center">
                        <div class="col-md-4 info-label">Price</div>
                        <div class="col-md-8 info-value">₹<?php echo $order['price']; ?></div>
                    </div>
                    
                    <div class="info-row row align-items-center">
                        <div class="col-md-4 info-label">Pickup Time</div>
                        <div class="col-md-8 info-value"><?php echo $order['pick_time']; ?></div>
                    </div>
                    
                    <div class="info-row row align-items-center">
                        <div class="col-md-4 info-label">Status</div>
                        <div class="col-md-8">
                            <?php
                            $status = $order['status'];
                            if($status == "" || $status == "NULL") {
                                echo '<span class="status-badge bg-primary"><i class="fa fa-spinner fa-spin me-1"></i> Pending</span>';
                            } elseif($status == "confirm") {
                                echo '<span class="status-badge bg-success"><i class="fa fa-check-circle me-1"></i> Confirmed</span>';
                            } elseif($status == "rejected") {
                                echo '<span class="status-badge bg-danger"><i class="fa fa-times-circle me-1"></i> Rejected</span>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer p-4 bg-light">
                    <form method="post" class="update-form">
                        <div class="form-group mb-3">
                            <label class="form-label"><i class="fa fa-check-square me-1"></i> Update Order Status</label>
                            <select name="status" class="form-control select-status">
                                <option value="">-- Select Status --</option>
                                <option value="confirm">Confirm Order</option>
                                <option value="rejected">Reject Order</option>
                            </select>
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" name="submit" class="btn btn-submit btn-primary">
                                <i class="fa fa-paper-plane me-1"></i> Update Status
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="mt-4 text-center">
                <a href="status.php" class="btn btn-outline-secondary">
                    <i class="fa fa-arrow-left me-1"></i> Back to All Orders
                </a>
            </div>
        </div>
    </div>
</div>
<!-- End Container fluid -->

<!-- Add some JS for animations -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animate elements on page load
    const orderCard = document.querySelector('.order-card');
    setTimeout(() => {
        orderCard.style.opacity = "1"; 
    }, 100);
    
    // Add smooth transition when selecting status
    const statusSelect = document.querySelector('.select-status');
    statusSelect.addEventListener('change', function() {
        if(this.value === 'confirm') {
            this.style.borderColor = '#11998e';
        } else if(this.value === 'rejected') {
            this.style.borderColor = '#cb2d3e';
        } else {
            this.style.borderColor = '#eaeaea';
        }
    });
    
    // Add alert auto-close
    const alertBox = document.querySelector('.alert');
    if(alertBox) {
        setTimeout(() => {
            alertBox.classList.remove('show');
            setTimeout(() => {
                alertBox.remove();
            }, 300);
        }, 3000);
    }
});
</script>

