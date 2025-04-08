<?php
include("../connection/connect.php");
error_reporting(0);
session_start();

if(isset($_POST['submit']))
{
    if(empty($_POST['username'])||empty($_POST['role']))
    {	
        $error = '<div class="alert alert-danger alert-dismissible fade show animate__animated animate__shakeX">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong><i class="fa fa-exclamation-triangle mr-2"></i>All fields must be filled!</strong>
                  </div>';															
    }
    else
    {
        $check_cat = mysqli_query($db, "SELECT username FROM staff where username = '".$_POST['username']."' AND st_id != '".$_GET['staff_upd']."'");
        if(mysqli_num_rows($check_cat) > 0)
        {
            $error = '<div class="alert alert-warning alert-dismissible fade show animate__animated animate__shakeX">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong><i class="fa fa-exclamation-circle mr-2"></i>Username already exists!</strong>
                      </div>';
        }
        else
        {			           
            $mql = "UPDATE staff SET username ='$_POST[username]', role='$_POST[role]' WHERE st_id='$_GET[staff_upd]'";
            mysqli_query($db, $mql);	  
            $success = '<div class="alert alert-success alert-dismissible fade show animate__animated animate__bounceIn">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong><i class="fa fa-check-circle mr-2"></i>Updated successfully!</strong>
                        </div>';                                 	
        }                     	   
    }
}
?>   	
    
<?php include_once('header.php');?>


<!DOCTYPE html>
<html lang="en">


<!-- Include required CSS libraries -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/hover.css/2.3.1/css/hover-min.css" />

<style>
    /* Custom Styles */
    .card {
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        margin-bottom: 30px;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }
    
    .card-outline-primary {
        border-top: 5px solid #007bff;
    }
    
    .card-header {
        border-radius: 15px 15px 0 0 !important;
        padding: 1.5rem 1.5rem;
        background: linear-gradient(45deg, #007bff, #00c6ff);
    }
    
    .form-control {
        border-radius: 10px;
        padding: 12px 15px;
        border: 1px solid #e0e0e0;
        transition: all 0.3s;
    }
    
    .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        border-color: #007bff;
    }
    
    .btn {
        border-radius: 10px;
        padding: 10px 20px;
        font-weight: 600;
        transition: all 0.3s;
    }
    
    .btn-success {
        background: linear-gradient(45deg, #28a745, #5cb85c);
        border: none;
    }
    
    .btn-success:hover {
        background: linear-gradient(45deg, #218838, #4cae4c);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
    }
    
    .btn-inverse {
        background: linear-gradient(45deg, #6c757d, #495057);
        border: none;
        color: white;
    }
    
    .btn-inverse:hover {
        background: linear-gradient(45deg, #5a6268, #3d4246);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(108, 117, 125, 0.4);
    }
    
    .page-titles {
        padding: 15px 0;
        margin-bottom: 20px;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .text-white {
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
        animation: fadeInUp 0.5s ease-out;
    }
    
    .form-group label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 8px;
    }
    
    .form-body {
        padding: 20px 10px;
    }
    
    .form-actions {
        padding: 20px 0;
        margin-top: 20px;
        border-top: 1px solid #f0f0f0;
        display: flex;
        justify-content: flex-start;
    }
    
    .container-fluid {
        padding: 0 25px;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .card-body {
            padding: 1.25rem;
        }
        
        .form-control {
            padding: 10px;
        }
    }
</style>

<!-- Container fluid  -->
<div class="container-fluid">
    <div class="row page-titles animate__animated animate__fadeIn">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary"><i class="fas fa-user-edit mr-2"></i>Update Staff</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home mr-1"></i>Home</a></li>
                <li class="breadcrumb-item"><a href="staff.php">Staff Management</a></li>
                <li class="breadcrumb-item active">Update Staff</li>
            </ol>
        </div>
    </div>

    <!-- Start Page Content -->			
    <div class="row">      		
        <div class="container-fluid">
            <?php  
                echo $error;
                echo $success; 
            ?>
                                                                                                                                                                                                                                    
            <div class="col-lg-12">
                <div class="card card-outline-primary animate__animated animate__fadeInUp">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"><i class="fas fa-user-edit mr-2"></i>Update Staff Member</h4>
                    </div>
                    <div class="card-body">
                        <form action='' method='post' enctype="multipart/form-data" class="fade-in-up">
                            <div class="form-body">
                                <?php 
                                    $ssql = "SELECT * FROM staff WHERE st_id='$_GET[staff_upd]'";
                                    $res = mysqli_query($db, $ssql); 
                                    $row = mysqli_fetch_array($res);
                                ?>
                                <hr>
                                <div class="row p-t-20">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label"><i class="fas fa-user mr-2"></i>Username</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-primary text-white"><i class="fas fa-user"></i></span>
                                                </div>
                                                <input type="text" name="username" value="<?php echo $row['username']; ?>" class="form-control" placeholder="Enter username">
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label"><i class="fas fa-id-badge mr-2"></i>Role</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-primary text-white"><i class="fas fa-id-badge"></i></span>
                                                </div>
                                                <input type="text" name="role" value="<?php echo $row['role']; ?>" class="form-control" placeholder="e.g. Cook, Waiter, Manager...">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <button type="submit" name="submit" class="btn btn-success hvr-grow">
                                        <i class="fas fa-save mr-2"></i>Save Changes
                                    </button> 
                                    <a href="staff.php" class="btn btn-inverse ml-2 hvr-grow">
                                        <i class="fas fa-arrow-left mr-2"></i>Back to Staff List
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>					
        </div>																						
    </div>
    <!-- End Page Content -->
</div>
<!-- End Container fluid  -->

<!-- Additional JavaScript -->
<script>
    $(document).ready(function() {
        // Add animation to form fields
        $('.form-control').focus(function() {
            $(this).parent().addClass('animate__animated animate__pulse');
        }).blur(function() {
            $(this).parent().removeClass('animate__animated animate__pulse');
        });
        
        // Form validation enhancement
        $("form").submit(function(e) {
            var valid = true;
            $(this).find('.form-control').each(function() {
                if($(this).val() === '') {
                    $(this).addClass('is-invalid');
                    valid = false;
                } else {
                    $(this).removeClass('is-invalid').addClass('is-valid');
                }
            });
            
            if(!valid) {
                e.preventDefault();
                $(".card-outline-primary").addClass("animate__animated animate__shakeX");
                setTimeout(function() {
                    $(".card-outline-primary").removeClass("animate__animated animate__shakeX");
                }, 1000);
            } else {
                $(".card-outline-primary").addClass("animate__animated animate__pulse");
            }
        });
        
        // Show success message with animation
        if ($('.alert-success').length) {
            setTimeout(function() {
                $('.alert-success').addClass('animate__animated animate__fadeOutUp');
            }, 5000);
        }
    });
</script>
