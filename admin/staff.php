<!DOCTYPE html>
<html lang="en">
<?php
include("../connection/connect.php");
error_reporting(0);
session_start();

// Staff deletion handler
if(!empty($_GET['staff_del']))
{
    mysqli_query($db,"DELETE FROM staff WHERE st_id = '".$_GET['staff_del']."'");
    $error = '<div class="alert alert-danger alert-dismissible fade show animate__animated animate__fadeIn">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong><i class="fa fa-trash-o mr-2"></i>Record Deleted Successfully</strong>
              </div>';
}

// Staff addition handler
if(isset($_POST['submit']))          
{										  				
    if(empty($_POST['username']) || empty($_POST['role']) || empty($_POST['password']))
    {	
        $error = '<div class="alert alert-danger alert-dismissible fade show animate__animated animate__shakeX">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong><i class="fa fa-exclamation-triangle mr-2"></i>All fields must be filled!</strong>
                  </div>';															
    }
    else
    {
        $check_cat = mysqli_query($db, "SELECT username FROM staff where username = '".$_POST['username']."' ");
       
        if(mysqli_num_rows($check_cat) > 0)
        {
            $error = '<div class="alert alert-warning alert-dismissible fade show animate__animated animate__shakeX">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong><i class="fa fa-exclamation-circle mr-2"></i>Username already exists!</strong>
                      </div>';
        }
        else
        {			           				
            $sql = "INSERT INTO staff(username,role,password) VALUE('".$_POST['username']."','".$_POST['role']."','".md5($_POST['password'])."')";
            mysqli_query($db, $sql); 	  
            $success = '<div class="alert alert-success alert-dismissible fade show animate__animated animate__bounceIn" style="color: black;">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong><i class="fa fa-check-circle mr-2"></i>Congratulations!</strong> New Staff Member Added Successfully.
        </div>';  
              
        }                     	   
    }
}
?>
<?php include_once('header.php');?>

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
    
    .btn-danger {
        background: linear-gradient(45deg, #dc3545, #f86b7d);
        border: none;
    }
    
    .btn-danger:hover {
        background: linear-gradient(45deg, #c82333, #e74c3c);
    }
    
    .btn-info {
        background: linear-gradient(45deg, #17a2b8, #5bc0de);
        border: none;
    }
    
    .btn-info:hover {
        background: linear-gradient(45deg, #138496, #4bacc6);
    }
    
    .btn-inverse {
        background: linear-gradient(45deg, #6c757d, #495057);
        border: none;
        color: white;
    }
    
    .btn-inverse:hover {
        background: linear-gradient(45deg, #5a6268, #3d4246);
        color: white;
    }
    
    .breadcrumb {
        background: transparent;
        padding: 0.75rem 0;
    }
    
    .breadcrumb-item a {
        color: #007bff;
        transition: all 0.3s;
    }
    
    .breadcrumb-item a:hover {
        color: #0056b3;
        text-decoration: none;
    }
    
    .page-titles {
        padding: 15px 0;
        margin-bottom: 20px;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .text-primary {
        background: linear-gradient(45deg, #007bff, #00c6ff);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        font-weight: 700;
    }
    
    table {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    
    table thead th {
        background: linear-gradient(45deg, #f8f9fa, #e9ecef);
        border: none !important;
        padding: 15px !important;
        font-weight: 600;
    }
    
    table tbody td {
        padding: 15px !important;
        vertical-align: middle !important;
        border: none !important;
        border-bottom: 1px solid #f0f0f0 !important;
        transition: all 0.3s;
    }
    
    table tbody tr:hover td {
        background-color: #f8f9fa;
    }
    
    .role-badge {
        padding: 5px 10px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }
    
    .action-btn {
        border-radius: 50%;
        width: 35px;
        height: 35px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin: 0 5px;
        padding: 0;
    }
    
    .tooltip-inner {
        border-radius: 10px;
        padding: 10px 15px;
    }
    
    .animate-hover:hover {
        animation: pulse 1s;
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

<div class="row page-titles animate__animated animate__fadeIn">
    <div class="col-md-5 align-self-center">
        <h3 class="text-primary"><i class="fas fa-users mr-2"></i>Staff Management</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard.php"><i class="fas fa-home mr-1"></i>Home</a></li>
            <li class="breadcrumb-item active">Staff Management</li>
        </ol>
    </div>
</div>

<!-- Container fluid -->
<div class="container-fluid"> 
    <!-- Start Page Content -->                 							
    <?php 
        echo $error;
        echo $success;
    ?>											
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-outline-primary animate__animated animate__fadeInUp">
                <div class="card-header">
                    <h4 class="m-b-0 text-white"><i class="fas fa-user-plus mr-2"></i>Add New Staff Member</h4>
                </div>
                <div class="card-body">
                    <form action='' method='post' enctype="multipart/form-data" class="fade-in-up">
                        <div class="form-body">                                     
                            <hr>                                     
                            <div class="row p-t-20">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label"><i class="fas fa-user mr-2"></i>Username</label>
                                        <input type="text" name="username" class="form-control" placeholder="Enter username">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label"><i class="fas fa-id-badge mr-2"></i>Role</label>
                                        <input type="text" name="role" class="form-control" placeholder="e.g. Cook, Waiter, Manager...">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label"><i class="fas fa-lock mr-2"></i>Password</label>
                                        <input type="password" name="password" class="form-control" placeholder="Enter password">
                                    </div>
                                </div>
                            </div>    
                        </div>
                        <div class="form-actions text-center mt-4">
                            <button type="submit" name="submit" class="btn btn-success hvr-grow">
                                <i class="fas fa-save mr-2"></i>Save
                            </button>
                            <a href="dashboard.php" class="btn btn-inverse ml-2 hvr-grow">
                                <i class="fas fa-times mr-2"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>		

        <div class="col-12"> 
            <div class="card animate__animated animate__fadeInUp" style="animation-delay: 0.3s;">
                <div class="card-body">
                    <h4 class="card-title"><i class="fas fa-list mr-2"></i>Staff Directory</h4>
                    <div class="table-responsive m-t-40">
                        <table id="myTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Username</th>
                                    <th>Role</th> 
                                    <th>Registration Date</th> 
                                    <th>Actions</th>	 
                                </tr>
                            </thead>
                            <tbody>	                                           											
                            <?php
                                $sql = "SELECT * FROM staff ORDER BY st_id DESC";
                                $query = mysqli_query($db, $sql);
                                    
                                if(!mysqli_num_rows($query) > 0)
                                {
                                    echo '<tr><td colspan="5" class="text-center">No Staff Records Found</td></tr>';
                                }
                                else
                                {	
                                    $i = 1;			
                                    while($rows = mysqli_fetch_array($query))
                                    {
                                        // Define role colors
                                        $roleClass = "";
                                        $role = strtolower($rows['role']);
                                        
                                        if(strpos($role, 'admin') !== false || strpos($role, 'manager') !== false) {
                                            $roleClass = "bg-danger text-white";
                                        } elseif(strpos($role, 'cook') !== false || strpos($role, 'chef') !== false) {
                                            $roleClass = "bg-success text-white";
                                        } elseif(strpos($role, 'waiter') !== false || strpos($role, 'server') !== false) {
                                            $roleClass = "bg-info text-white";
                                        } else {
                                            $roleClass = "bg-secondary text-white";
                                        }
                                        
                                        echo '<tr class="animate-hover">
                                                <td>'.$i.'</td>
                                                <td><i class="fas fa-user-circle mr-2"></i>'.$rows['username'].'</td>
                                                <td><span class="role-badge '.$roleClass.'">'.$rows['role'].'</span></td>
                                                <td><i class="far fa-calendar-alt mr-2"></i>'.date('M d, Y', strtotime($rows['date'])).'</td>
                                                <td>
                                                    <a href="staff.php?staff_del='.$rows['st_id'].'" 
                                                       onclick="return confirm(\'Are you sure you want to delete this staff member?\');" 
                                                       class="btn btn-danger action-btn" 
                                                       data-toggle="tooltip" 
                                                       title="Delete">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a> 																									 
                                                    <a href="update_staff.php?staff_upd='.$rows['st_id'].'" 
                                                       class="btn btn-info action-btn" 
                                                       data-toggle="tooltip" 
                                                       title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>																									
                                                </td>
                                              </tr>';
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
    </div>
    <!-- End Page Content -->
</div>
<!-- End Container fluid -->

<!-- Additional JavaScript -->
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
    // Initialize tooltips
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
        
        // Add animation to table rows
        $("#myTable tbody tr").each(function(index) {
            $(this).css("animation-delay", (index * 0.1) + "s");
            $(this).addClass("animate__animated animate__fadeInUp");
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
            }
        });
        
        // Input field animation
        $('.form-control').focus(function() {
            $(this).parent().addClass('animate__animated animate__pulse');
        }).blur(function() {
            $(this).parent().removeClass('animate__animated animate__pulse');
        });
    });
</script>
