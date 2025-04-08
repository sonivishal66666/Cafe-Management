<?php
session_start();
error_reporting(0);
include("../connection/connect.php");

// Form validation and processing
if(isset($_POST['submit'])) {
    if(empty($_POST['studentName']) || empty($_POST['rollNo']) || empty($_POST['email']) || empty($_POST['phone'])) {
        $error = '<div class="alert alert-danger alert-dismissible fade show animated shake">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong><i class="fas fa-exclamation-circle"></i> All fields are required!</strong>
                </div>';
    } else {
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $error = '<div class="alert alert-danger alert-dismissible fade show animated shake">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong><i class="fas fa-exclamation-circle"></i> Invalid email format!</strong>
                    </div>';
        } elseif(strlen($_POST['phone']) < 10) {
            $error = '<div class="alert alert-danger alert-dismissible fade show animated shake">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong><i class="fas fa-exclamation-circle"></i> Invalid phone number!</strong>
                    </div>';
        } else {
            // Prepare statement to prevent SQL injection
            $stmt = $db->prepare("UPDATE users SET student_name=?, roll_no=?, email=?, phone=? WHERE u_id=?");
            $stmt->bind_param("ssssi", $_POST['studentName'], $_POST['rollNo'], $_POST['email'], $_POST['phone'], $_GET['user_upd']);
            $stmt->execute();
            
            if($stmt->affected_rows > 0) {
                $success = '<div class="alert alert-success alert-dismissible fade show animated bounceIn">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong><i class="fas fa-check-circle"></i> User updated successfully!</strong>
                        </div>';
            } else {
                $info = '<div class="alert alert-info alert-dismissible fade show animated fadeIn">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong><i class="fas fa-info-circle"></i> No changes detected!</strong>
                    </div>';
            }
            $stmt->close();
        }
    }
}

// Get user data
$user_id = isset($_GET['user_upd']) ? intval($_GET['user_upd']) : 0;
$stmt = $db->prepare("SELECT * FROM users WHERE u_id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Redirect if user not found
if(!$user) {
    header("Location: dashboard.php");
    exit;
}

// Include header
include_once('header.php');
?>

<!DOCTYPE html>
<html lang="en">


<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #1cc88a;
            --dark-color: #5a5c69;
            --light-color: #f8f9fc;
        }
        
        body {
            background-color: #f8f9fc;
            font-family: 'Nunito', sans-serif;
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 2rem 0 rgba(58, 59, 69, 0.2);
        }
        
        .card-header {
            background: linear-gradient(45deg, var(--primary-color), #224abe);
            border-radius: 10px 10px 0 0 !important;
            padding: 1.5rem 1.5rem;
        }
        
        .card-header h4 {
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        
        .form-control {
            border-radius: 8px;
            padding: 12px 15px;
            border: 1px solid #e3e6f0;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }
        
        .btn {
            border-radius: 8px;
            padding: 10px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-success {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .btn-success:hover {
            background-color: #17a673;
            border-color: #17a673;
            transform: translateY(-2px);
        }
        
        .btn-inverse {
            background-color: var(--dark-color);
            border-color: var(--dark-color);
            color: white;
        }
        
        .btn-inverse:hover {
            background-color: #484a56;
            border-color: #484a56;
            color: white;
            transform: translateY(-2px);
        }
        
        .form-group label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }
        
        .input-group-addon {
            background-color: var(--primary-color);
            color: white;
            border: none;
        }
        
        .form-section {
            opacity: 0;
            transform: translateY(20px);
            animation: slideUp 0.5s ease forwards;
        }
        
        @keyframes slideUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .alert {
            border-radius: 8px;
            border: none;
        }
        
        .alert-success {
            background-color: rgba(28, 200, 138, 0.15);
            border-left: 4px solid var(--secondary-color);
            color: #0f6848;
        }
        
        .alert-danger {
            background-color: rgba(231, 74, 59, 0.15);
            border-left: 4px solid #e74a3b;
            color: #86261d;
        }
        
        .alert-info {
            background-color: rgba(54, 185, 204, 0.15);
            border-left: 4px solid #36b9cc;
            color: #1a6f7c;
        }
        
        .floating-label {
            position: relative;
            margin-bottom: 20px;
        }
        
        .floating-label input {
            font-size: 16px;
            padding: 20px 15px 10px;
            display: block;
            width: 100%;
            height: 60px;
        }
        
        .floating-label label {
            position: absolute;
            top: 0;
            left: 15px;
            font-size: 14px;
            opacity: 0.6;
            transition: all 0.2s ease;
            pointer-events: none;
        }
        
        .floating-label input:focus ~ label,
        .floating-label input:not(:placeholder-shown) ~ label {
            top: 8px;
            font-size: 11px;
            opacity: 0.8;
        }
        
        .shake {
            animation: shake 0.82s cubic-bezier(.36,.07,.19,.97) both;
        }
        
        @keyframes shake {
            10%, 90% { transform: translate3d(-1px, 0, 0); }
            20%, 80% { transform: translate3d(2px, 0, 0); }
            30%, 50%, 70% { transform: translate3d(-4px, 0, 0); }
            40%, 60% { transform: translate3d(4px, 0, 0); }
        }
        
        .page-title {
            margin-bottom: 1.5rem;
            font-weight: 700;
            position: relative;
            padding-bottom: 10px;
        }
        
        .page-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            height: 4px;
            width: 50px;
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            border-radius: 2px;
        }
        
        .card-body {
            padding: 2rem;
        }
        
        .form-row {
            margin-bottom: 1rem;
        }
        
        .input-icon {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            color: var(--primary-color);
            opacity: 0.5;
        }
        
        .input-container {
            position: relative;
        }
    </style>
</head>

<body>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <h2 class="page-title text-dark animate__animated animate__fadeIn">User Management</h2>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-12">
                <?php  
                    if(isset($error)) echo $error;
                    if(isset($success)) echo $success;
                    if(isset($info)) echo $info;
                ?>
                
                <div class="card animate__animated animate__fadeIn">
                    <div class="card-header">
                        <h4 class="m-0 text-white"><i class="fas fa-user-edit mr-2"></i>Update User Profile</h4>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" class="user-form">
                            <div class="form-row">
                                <div class="col-md-6 form-section" style="animation-delay: 0.1s;">
                                    <div class="floating-label">
                                        <div class="input-container">
                                            <input type="text" name="studentName" class="form-control" id="studentName" placeholder=" " value="<?php echo htmlspecialchars($user['student_name']); ?>">
                                            <label for="studentName">Student Name</label>
                                            <i class="fas fa-user input-icon"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 form-section" style="animation-delay: 0.2s;">
                                    <div class="floating-label">
                                        <div class="input-container">
                                            <input type="text" name="rollNo" class="form-control" id="rollNo" placeholder=" " value="<?php echo htmlspecialchars($user['roll_no']); ?>">
                                            <label for="rollNo">Roll Number</label>
                                            <i class="fas fa-id-card input-icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="col-md-6 form-section" style="animation-delay: 0.3s;">
                                    <div class="floating-label">
                                        <div class="input-container">
                                            <input type="email" name="email" class="form-control" id="email" placeholder=" " value="<?php echo htmlspecialchars($user['email']); ?>">
                                            <label for="email">Email Address</label>
                                            <i class="fas fa-envelope input-icon"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 form-section" style="animation-delay: 0.4s;">
                                    <div class="floating-label">
                                        <div class="input-container">
                                            <input type="text" name="phone" class="form-control" id="phone" placeholder=" " value="<?php echo htmlspecialchars($user['phone']); ?>">
                                            <label for="phone">Phone Number</label>
                                            <i class="fas fa-phone input-icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-row mt-4 form-section" style="animation-delay: 0.5s;">
                                <div class="col-12 text-center">
                                    <button type="submit" name="submit" class="btn btn-success mr-2 animate__animated animate__pulse animate__infinite animate__slow">
                                        <i class="fas fa-save mr-2"></i>Save Changes
                                    </button>
                                    <a href="dashboard.php" class="btn btn-inverse">
                                        <i class="fas fa-arrow-left mr-2"></i>Cancel
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Fancy form interactions
            $('.form-control').on('focus', function() {
                $(this).parent().addClass('focused');
            }).on('blur', function() {
                $(this).parent().removeClass('focused');
            });
            
            // Remove alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
            
            // Form validation
            $('.user-form').on('submit', function(e) {
                let isValid = true;
                
                $('.form-control').each(function() {
                    if ($(this).val().trim() === '') {
                        $(this).addClass('is-invalid').removeClass('is-valid');
                        isValid = false;
                    } else {
                        $(this).removeClass('is-invalid').addClass('is-valid');
                    }
                });
                
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test($('#email').val())) {
                    $('#email').addClass('is-invalid').removeClass('is-valid');
                    isValid = false;
                }
                
                if ($('#phone').val().length < 10) {
                    $('#phone').addClass('is-invalid').removeClass('is-valid');
                    isValid = false;
                }
                
                if (!isValid) {
                    e.preventDefault();
                    
                    // Shake the form on validation error
                    $('.card').addClass('shake');
                    setTimeout(function() {
                        $('.card').removeClass('shake');
                    }, 1000);
                } else {
                    // Show loading state
                    $(this).find('button[type="submit"]').html('<i class="fas fa-spinner fa-spin mr-2"></i>Processing...');
                }
            });
            
            // Tooltips
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</body>

</html>