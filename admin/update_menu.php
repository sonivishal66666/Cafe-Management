<?php
include("../connection/connect.php");
error_reporting(0);
session_start();

if(isset($_POST['submit']))           //if upload btn is press
{				
    if(empty($_POST['d_name'])||empty($_POST['about'])||$_POST['price']==''||$_POST['dish_name']=='')
    {	
        $error = '<div class="alert alert-danger alert-dismissible fade show animate__animated animate__shakeX">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>All fields Must be Fillup!</strong>
                  </div>';																
    }
    elseif(empty($_FILES['file']['name']))
    {
        $sql = "update dishes set c_id='$_POST[dish_name]',title='$_POST[d_name]',slogan='$_POST[about]',price='$_POST[price]',status=$_POST[status],in_today_menu=$_POST[inToday] where d_id='$_GET[menu_upd]'"; 
        mysqli_query($db, $sql); 
        $success = '<div class="alert alert-success alert-dismissible fade show animate__animated animate__fadeIn">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Record</strong> Updated Successfully!
                  </div>';    
    }
    else
    {		
        $fname = $_FILES['file']['name'];
        $temp = $_FILES['file']['tmp_name'];
        $fsize = $_FILES['file']['size'];
        $extension = explode('.',$fname);
        $extension = strtolower(end($extension));  
        $fnew = uniqid().'.'.$extension;
        
        $store = "Category_Image/dishes/".basename($fnew);                      // the path to store the upload image
        
        if($extension == 'jpg'||$extension == 'png'||$extension == 'gif')
        {        
            if($fsize>=1000000)
            {		
                $error = '<div class="alert alert-danger alert-dismissible fade show animate__animated animate__shakeX">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Max Image Size is 1024kb!</strong> Try different Image.
                          </div>';
            }
            else
            {				                                 
                $sql = "update dishes set c_id='$_POST[dish_name]',title='$_POST[d_name]',slogan='$_POST[about]',price='$_POST[price]',img='$fnew',status=$_POST[status],in_today_menu=$_POST[in_Today] where d_id='$_GET[menu_upd]'";  
                mysqli_query($db, $sql); 
                move_uploaded_file($temp, $store);
      
                $success = '<div class="alert alert-success alert-dismissible fade show animate__animated animate__fadeIn">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Record</strong> Updated Successfully!
                          </div>';           	
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Add required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Add Animate.css for animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    <!-- Add custom styles -->
    <style>
        .card {
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }
        
        .card-header {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            padding: 20px;
            border-radius: 10px 10px 0 0;
        }
        
        .form-control {
            border-radius: 5px;
            padding: 10px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(37, 117, 252, 0.2);
            border-color: #2575fc;
        }
        
        .btn-success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            border: none;
            box-shadow: 0 4px 6px rgba(50, 50, 93, 0.11), 0 1px 3px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }
        
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 7px 14px rgba(50, 50, 93, 0.1), 0 3px 6px rgba(0, 0, 0, 0.08);
        }
        
        .btn-inverse {
            background: linear-gradient(135deg, #8e9eab 0%, #eef2f3 100%);
            border: none;
            color: #333;
            box-shadow: 0 4px 6px rgba(50, 50, 93, 0.11), 0 1px 3px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }
        
        .btn-inverse:hover {
            transform: translateY(-2px);
            box-shadow: 0 7px 14px rgba(50, 50, 93, 0.1), 0 3px 6px rgba(0, 0, 0, 0.08);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            display: block;
        }
        
        .custom-select {
            height: 45px;
            cursor: pointer;
        }
        
        .input-file-container {
            position: relative;
            overflow: hidden;
        }
        
        .input-file-trigger {
            display: block;
            padding: 10px 15px;
            background: #f1f1f1;
            color: #333;
            font-size: 14px;
            text-align: center;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .input-file-trigger:hover {
            background: #e0e0e0;
        }
        
        .input-file {
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }
        
        .file-return {
            margin-top: 5px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>

<?php include_once('header.php');?>  

<div class="container-fluid animate__animated animate__fadeIn">
    <!-- Start Page Content -->                								
    <?php  
        echo $error;
        echo $success; 
    ?>					
    <div class="col-lg-12">
        <div class="card card-outline-primary animate__animated animate__fadeInUp">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Update Menu Item</h4>
            </div>
            <div class="card-body">
                <form action='' method='post' enctype="multipart/form-data" class="form">
                    <div class="form-body">
                        <?php
                            $qml = "select * from dishes where d_id='$_GET[menu_upd]'";
                            $rest = mysqli_query($db, $qml); 
                            $rows = mysqli_fetch_array($rest);                                                     
                        ?>
                        <hr>
                        <div class="row p-t-20">
                            <div class="col-md-6">
                                <div class="form-group animate__animated animate__fadeInLeft" style="animation-delay: 0.1s">
                                    <label class="control-label">Dish Name</label>
                                    <input type="text" name="d_name" value="<?php echo $rows['title'];?>" class="form-control" placeholder="Morzirella">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group has-danger animate__animated animate__fadeInRight" style="animation-delay: 0.2s">
                                    <label class="control-label">About</label>
                                    <input type="text" name="about" value="<?php echo $rows['slogan'];?>" class="form-control form-control-danger" placeholder="slogan">
                                </div>
                            </div>
                        </div>
                        <div class="row p-t-20">
                            <div class="col-md-6">
                                <div class="form-group animate__animated animate__fadeInLeft" style="animation-delay: 0.3s">
                                    <label class="control-label">Price</label>
                                    <input type="text" name="price" value="<?php echo $rows['price'];?>" class="form-control" placeholder="₹">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group has-danger animate__animated animate__fadeInRight" style="animation-delay: 0.4s">
                                    <label class="control-label">Image</label>
                                    <div class="input-file-container">
                                        <label for="file" class="input-file-trigger">Select a file...</label>
                                        <input type="file" name="file" id="file" class="input-file">
                                        <p class="file-return">No file selected</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">	
                            <div class="col-md-4">
                                <div class="form-group animate__animated animate__fadeInUp" style="animation-delay: 0.5s">
                                    <label class="control-label">Select Food Category</label>
                                    <select name="dish_name" class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1">
                                        <?php
                                            $ssql = "select * from res_category";
                                            $res = mysqli_query($db, $ssql); 
                                            while($row = mysqli_fetch_array($res))  
                                            {
                                        ?>      
                                            <option value="<?=$row['c_id']?>" <?=$rows['c_id'] == $row['c_id'] ? 'selected="selected"' : ''?>><?=$row['c_name']?></option>;
                                        <?php
                                            }                                                 
                                        ?> 
                                    </select>
                                </div>
                            </div>			
                            <div class="col-md-4">
                                <div class="form-group animate__animated animate__fadeInUp" style="animation-delay: 0.6s">
                                    <label class="control-label">Status</label>
                                    <select name="status" class="form-control custom-select" data-placeholder="Select Status" tabindex="1">
                                        <option value="1" <?=$rows['status']==1 ? 'selected="selected"' : ''?>>Active</option>
                                        <option value="0" <?=$rows['status']==0 ? 'selected="selected"' : ''?>>InActive</option>
                                    </select>
                                </div>
                            </div>	
                            <div class="col-md-4">
                                <div class="form-group animate__animated animate__fadeInUp" style="animation-delay: 0.7s">
                                    <label class="control-label">Today's Menu</label>
                                    <select name="inToday" class="form-control custom-select" data-placeholder="Select Status" tabindex="1">
                                        <option value="1" <?=$rows['in_today_menu']==1 ? 'selected="selected"' : ''?>>Active</option>
                                        <option value="0" <?=$rows['in_today_menu']==0 ? 'selected="selected"' : ''?>>InActive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions mt-4 animate__animated animate__fadeInUp" style="animation-delay: 0.8s">
                        <input type="submit" name="submit" class="btn btn-success" value="Save"> 
                        <a href="all_menu.php" class="btn btn-inverse">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>				
</div>
<!-- End PAge Content -->

<!-- Add custom JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Show file name when selected
    document.querySelector('.input-file').addEventListener('change', function() {
        let fileName = this.value.split('\\').pop();
        document.querySelector('.file-return').innerHTML = fileName ? fileName : 'No file selected';
    });
    
    // Add ripple effect to buttons
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            let x = e.clientX - e.target.offsetLeft;
            let y = e.clientY - e.target.offsetTop;
            
            let ripple = document.createElement('span');
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
    
    // Add form validation animation
    const inputs = document.querySelectorAll('.form-control');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('animate__animated', 'animate__pulse');
            setTimeout(() => {
                this.parentElement.classList.remove('animate__animated', 'animate__pulse');
            }, 1000);
        });
    });
});
</script>

