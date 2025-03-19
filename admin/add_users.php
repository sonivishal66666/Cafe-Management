<?php
session_start();
error_reporting(0);
include("../connection/connect.php");

if(isset($_POST['submit']))
{
    if(empty($_POST['studentName']) ||
       empty($_POST['rollNo'])|| 
       empty($_POST['email'])||
       empty($_POST['password'])||
       empty($_POST['phone']))
    {
        $error = '<div class="alert alert-danger alert-dismissible fade show animate__animated animate__shakeX">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong><i class="fas fa-exclamation-circle me-2"></i>All fields are required!</strong>
                </div>';
    }
    else
    {
        $check_username = mysqli_query($db, "SELECT roll_no FROM users where roll_no = '".$_POST['rollNo']."' ");
        $check_email = mysqli_query($db, "SELECT email FROM users where email = '".$_POST['email']."' ");
        
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        {
            $error = '<div class="alert alert-danger alert-dismissible fade show animate__animated animate__shakeX">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <strong><i class="fas fa-exclamation-circle me-2"></i>Invalid email format!</strong>
                    </div>';
        }
        elseif(strlen($_POST['password']) < 6)
        {
            $error = '<div class="alert alert-danger alert-dismissible fade show animate__animated animate__shakeX">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <strong><i class="fas fa-exclamation-circle me-2"></i>Password must be at least 6 characters!</strong>
                    </div>';
        }
        elseif(strlen($_POST['phone']) < 10)
        {
            $error = '<div class="alert alert-danger alert-dismissible fade show animate__animated animate__shakeX">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <strong><i class="fas fa-exclamation-circle me-2"></i>Invalid phone number!</strong>
                    </div>';
        }
        elseif(mysqli_num_rows($check_username) > 0)
        {
            $error = '<div class="alert alert-danger alert-dismissible fade show animate__animated animate__shakeX">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <strong><i class="fas fa-exclamation-circle me-2"></i>Username already exists!</strong>
                    </div>';
        }
        elseif(mysqli_num_rows($check_email) > 0)
        {
            $error = '<div class="alert alert-danger alert-dismissible fade show animate__animated animate__shakeX">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <strong><i class="fas fa-exclamation-circle me-2"></i>Email already exists!</strong>
                    </div>';
        }
        else{
            $mql = "INSERT INTO users(student_name,roll_no,email,phone,password) VALUES('".$_POST['studentName']."','".$_POST['rollNo']."','".$_POST['email']."','".$_POST['phone']."','".md5($_POST['password'])."')";
            mysqli_query($db, $mql);
            $success = '<div class="alert alert-success alert-dismissible fade show animate__animated animate__bounceIn">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <strong><i class="fas fa-check-circle me-2"></i>Congratulations!</strong> New user added successfully.
                        </div>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #1cc88a;
            --background-color: #f8f9fc;
            --card-bg: #ffffff;
            --text-primary: #5a5c69;
        }
        
        body {
            background: var(--background-color);
            font-family: 'Nunito', sans-serif;
            transition: all 0.3s ease;
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 2rem 0 rgba(58, 59, 69, 0.2);
        }
        
        .card-outline-primary {
            border-left: 0.25rem solid var(--primary-color);
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, #224abe 100%);
            color: white;
            border-radius: 15px 15px 0 0;
        }
        
        .breadcrumb {
            background: transparent;
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
            border-radius: 0.25rem;
        }
        
        .form-control {
            border-radius: 10px;
            padding: 12px;
            transition: all 0.3s ease;
            border: 1px solid #d1d3e2;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }
        
        .btn {
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-success {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .btn-success:hover {
            background-color: #13a673;
            border-color: #13a673;
            transform: translateY(-2px);
        }
        
        .btn-inverse {
            background-color: #858796;
            border-color: #858796;
            color: white;
        }
        
        .btn-inverse:hover {
            background-color: #717384;
            border-color: #717384;
            color: white;
            transform: translateY(-2px);
        }
        
        label {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 8px;
        }
        
        .page-title {
            color: var(--primary-color);
            font-weight: 700;
        }
        
        .input-icon-container {
            position: relative;
        }
        
        .input-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #b7b9cc;
        }
        
        /* Progress indicator animation */
        .progress-bar-container {
            height: 5px;
            width: 100%;
            background-color: #e9ecef;
            margin-bottom: 20px;
            border-radius: 5px;
            overflow: hidden;
        }
        
        .progress-bar {
            height: 100%;
            width: 0;
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            border-radius: 5px;
            transition: width 0.5s ease;
        }
        
        /* Floating label animation */
        .form-floating {
            position: relative;
        }
        
        .form-floating > label {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            padding: 1rem 0.75rem;
            pointer-events: none;
            border: 1px solid transparent;
            transform-origin: 0 0;
            transition: opacity .1s ease-in-out, transform .1s ease-in-out;
        }
        
        .form-floating > .form-control:focus ~ label,
        .form-floating > .form-control:not(:placeholder-shown) ~ label {
            opacity: .65;
            transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
        }
    </style>
</head>

<body>
    <?php include_once('header.php');?>
    
    <div class="container py-4 animate__animated animate__fadeIn">
        <div class="row page-titles mb-4">
            <div class="col-md-5 align-self-center">
                <h2 class="page-title animate__animated animate__fadeInLeft"><i class="fas fa-user-plus me-2"></i>Add Users</h2>
            </div>
            <div class="col-md-7 align-self-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-end animate__animated animate__fadeInRight">
                        <li class="breadcrumb-item"><a href="javascript:void(0)"><i class="fas fa-home me-1"></i>Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add Users</li>
                    </ol>
                </nav>
            </div>
        </div>
        
        <div class="progress-bar-container animate__animated animate__fadeInDown">
            <div class="progress-bar" id="progressBar"></div>
        </div>
        
        <?php 
            echo $error;
            echo $success; 
        ?>
        
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-outline-primary animate__animated animate__fadeInUp">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white"><i class="fas fa-user-plus me-2"></i>Add New User</h4>
                    </div>
                    <div class="card-body">
                        <form action='' method='post' enctype="multipart/form-data" id="registrationForm">
                            <div class="form-body">
                                <div class="row p-t-20">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating animate__animated animate__fadeInLeft" style="animation-delay: 0.1s">
                                            <input type="text" name="studentName" class="form-control" id="studentName" placeholder="John Doe">
                                            <label for="studentName"><i class="fas fa-user me-2"></i>Student Name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating animate__animated animate__fadeInRight" style="animation-delay: 0.2s">
                                            <input type="text" name="rollNo" class="form-control" id="rollNo" placeholder="IU1754100016">
                                            <label for="rollNo"><i class="fas fa-id-card me-2"></i>Roll No</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating animate__animated animate__fadeInLeft" style="animation-delay: 0.3s">
                                            <input type="email" name="email" class="form-control" id="email" placeholder="example@gmail.com">
                                            <label for="email"><i class="fas fa-envelope me-2"></i>Email</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating animate__animated animate__fadeInRight" style="animation-delay: 0.4s">
                                            <input type="tel" name="phone" class="form-control" id="phone" placeholder="1234567890">
                                            <label for="phone"><i class="fas fa-phone me-2"></i>Phone</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-floating animate__animated animate__fadeInLeft" style="animation-delay: 0.5s">
                                            <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                                            <label for="password"><i class="fas fa-lock me-2"></i>Password</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-actions mt-4">
                                <button type="submit" name="submit" class="btn btn-success animate__animated animate__fadeInUp" style="animation-delay: 0.6s">
                                    <i class="fas fa-save me-2"></i>Save
                                </button>
                                <a href="dashboard.php" class="btn btn-inverse ms-2 animate__animated animate__fadeInUp" style="animation-delay: 0.7s">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    
    <script>
        // Progress bar animation
        function updateProgressBar() {
            const inputs = document.querySelectorAll('input');
            let filledInputs = 0;
            
            inputs.forEach(input => {
                if (input.value.trim() !== '') {
                    filledInputs++;
                }
            });
            
            const percentage = (filledInputs / inputs.length) * 100;
            document.getElementById('progressBar').style.width = percentage + '%';
        }
        
        // Input field animations
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('animate__animated', 'animate__pulse');
                setTimeout(() => {
                    this.parentElement.classList.remove('animate__animated', 'animate__pulse');
                }, 1000);
            });
            
            input.addEventListener('input', updateProgressBar);
        });
        
        // Form submission animation
        document.getElementById('registrationForm').addEventListener('submit', function(e) {
            const requiredFields = ['studentName', 'rollNo', 'email', 'password', 'phone'];
            let valid = true;
            
            requiredFields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    valid = false;
                } else {
                    field.classList.remove('is-invalid');
                    field.classList.add('is-valid');
                }
            });
            
            if (!valid) {
                e.preventDefault();
                document.querySelector('.card').classList.add('animate__animated', 'animate__shakeX');
                setTimeout(() => {
                    document.querySelector('.card').classList.remove('animate__animated', 'animate__shakeX');
                }, 1000);
            } else {
                document.querySelector('.card').classList.add('animate__animated', 'animate__fadeOutUp');
                setTimeout(() => {
                    return true;
                }, 1000);
            }
        });
        
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
        
        // Initialize the progress bar
        updateProgressBar();
    </script>
    
</body>
</html>