<?php
include("../connection/connect.php");
error_reporting(0);
session_start();

if(isset($_POST['submit']))           //if upload btn is pressed
{
    if(empty($_POST['c_name']))
    {	
        $error = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <strong>Error!</strong> All fields must be filled out.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';															
    }
    elseif(empty($_FILES['file']['name']))
    {
        $sql = "UPDATE res_category SET c_name ='$_POST[c_name]' WHERE c_id='$_GET[cat_upd]'";
        mysqli_query($db, $sql); 
        $success = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <strong>Success!</strong> Category name updated successfully.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';    
    }
    else
    {
        $check_cat = mysqli_query($db, "SELECT c_name FROM res_category WHERE c_name = '".$_POST['c_name']."' AND c_id != '".$_GET['cat_upd']."'");
        
        if(mysqli_num_rows($check_cat) > 0)
        {
            $error = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <strong>Error!</strong> Category name already exists!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
            $store = "Category_Image/".basename($fnew);

            if($extension == 'jpg'||$extension == 'png'||$extension == 'gif')
            {        
                if($fsize >= 1000000)
                {			
                    $error = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <strong>Error!</strong> Max image size is 1024kb! Try a different image.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                              </div>';
                }		
                else
                {
                    $mql = "UPDATE res_category SET c_name ='$_POST[c_name]', image='$fnew' WHERE c_id='$_GET[cat_upd]'";
                    mysqli_query($db, $mql);
                    move_uploaded_file($temp, $store);			  
                    $success = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                  <i class="fas fa-check-circle me-2"></i>
                                  <strong>Success!</strong> Category updated successfully.
                                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>';                                 
                }
            }
            elseif($extension == '')
            {
                $error = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <strong>Error!</strong> Please select an image.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>';
            }
            else
            {					
                $error = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <strong>Error!</strong> Invalid extension! Only PNG, JPG, and GIF are accepted.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>';							   
            } 
        }                     	   
    }
}
?>   	

<?php include_once('header.php');?>

<!DOCTYPE html>
<html lang="en">


<!-- Add these in your header.php file if not already added -->
<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<!-- AOS Animation Library -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<!-- SweetAlert2 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
<!-- Custom Styles -->
<style>
    .page-title-wrapper {
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 30px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    
    .page-title-wrapper:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    
    .text-gradient {
        background: -webkit-linear-gradient(#fff, #e0e0e0);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    
    .card {
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        overflow: hidden;
        border: none;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    
    .card-header {
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        padding: 20px;
        border-radius: 15px 15px 0 0 !important;
    }
    
    .form-control {
        border-radius: 8px;
        padding: 12px;
        border: 1px solid #e0e0e0;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        box-shadow: 0 0 0 3px rgba(37, 117, 252, 0.2);
        border-color: #2575fc;
    }
    
    .btn-success {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        border: none;
        border-radius: 8px;
        padding: 12px 25px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(17, 153, 142, 0.4);
    }
    
    .btn-inverse {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 12px 25px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-inverse:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(108, 117, 125, 0.4);
        color: white;
    }
    
    .alert {
        border-radius: 10px;
        border: none;
        padding: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    
    .form-label {
        font-weight: 600;
        margin-bottom: 10px;
        color: #555;
    }
    
    .file-upload {
        position: relative;
        overflow: hidden;
        margin: 10px 0;
        cursor: pointer;
    }
    
    .file-upload .form-control {
        cursor: pointer;
    }
    
    .category-img {
        border-radius: 10px;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .category-img:hover {
        transform: scale(1.05);
    }
    
    /* Pulse animation for buttons */
    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(37, 117, 252, 0.7);
        }
        70% {
            box-shadow: 0 0 0 10px rgba(37, 117, 252, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(37, 117, 252, 0);
        }
    }
    
    .pulse-animation {
        animation: pulse 2s infinite;
    }
    
    /* Shimmer effect for cards */
    @keyframes shimmer {
        0% {
            background-position: -1000px 0;
        }
        100% {
            background-position: 1000px 0;
        }
    }
    
    .shimmer {
        animation: shimmer 2s infinite linear;
        background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.2) 50%, rgba(255,255,255,0) 100%);
        background-size: 1000px 100%;
    }
    
    /* Current image indicator */
    .current-image-container {
        position: relative;
        margin-top: 15px;
        padding: 15px;
        border-radius: 10px;
        background-color: rgba(0, 0, 0, 0.03);
        border: 1px dashed #ddd;
    }
    
    .current-image-label {
        position: absolute;
        top: -10px;
        left: 10px;
        background-color: white;
        padding: 0 10px;
        font-size: 12px;
        color: #6a11cb;
        border-radius: 15px;
    }
</style>

<!-- Page content -->
<div class="container-fluid py-4">
    <!-- Page Title -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-title-wrapper" data-aos="fade-down">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="text-gradient m-0">Update Food Category</h3>
                        <p class="text-white-50 m-0">Edit your existing food category details</p>
                    </div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent m-0">
                            <li class="breadcrumb-item"><a href="dashboard.php" class="text-white-50"><i class="fas fa-home me-1"></i>Home</a></li>
                            <li class="breadcrumb-item"><a href="add_category.php" class="text-white-50"><i class="fas fa-list me-1"></i>Categories</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">Update Category</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Alerts -->
    <?php 
        if(isset($error)) {
            echo $error;
        }
        if(isset($success)) {
            echo $success;
        }
    ?>
    
    <!-- Update Category Form -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shimmer" data-aos="fade-up">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="m-0 text-white"><i class="fas fa-edit me-2"></i>Edit Food Category</h4>
                        <a href="add_category.php" class="btn btn-sm btn-light rounded-pill">
                            <i class="fas fa-arrow-left me-1"></i> Back to Categories
                        </a>
                    </div>
                </div>
                <div class="card-body py-4">
                    <?php 
                        $ssql = "SELECT * FROM res_category WHERE c_id='$_GET[cat_upd]'";
                        $res = mysqli_query($db, $ssql); 
                        $row = mysqli_fetch_array($res);
                    ?>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6" data-aos="fade-right" data-aos-delay="100">
                                <div class="mb-3">
                                    <label for="categoryName" class="form-label">
                                        <i class="fas fa-tag me-1"></i> Category Name
                                    </label>
                                    <input type="text" name="c_name" id="categoryName" value="<?php echo $row['c_name']; ?>" 
                                           class="form-control" placeholder="Enter category name" required>
                                    <div class="form-text text-muted">Update the name of this food category</div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="categoryImage" class="form-label">
                                        <i class="fas fa-image me-1"></i> New Category Image <span class="text-muted">(Optional)</span>
                                    </label>
                                    <div class="file-upload">
                                        <input type="file" name="file" id="categoryImage" class="form-control" 
                                               accept="image/png, image/jpeg, image/gif">
                                        <div class="form-text text-muted">Leave empty to keep current image. Supported formats: JPG, PNG, GIF (Max: 1MB)</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6" data-aos="fade-left" data-aos-delay="200">
                                <div class="current-image-container">
                                    <span class="current-image-label">Current Image</span>
                                    <div class="text-center mb-3">
                                        <img src="Category_Image/<?php echo $row['image']; ?>" class="category-img img-fluid" 
                                             style="max-height: 200px;" alt="<?php echo $row['c_name']; ?>">
                                    </div>
                                    <div class="text-center text-muted">
                                        <small>
                                            <i class="fas fa-info-circle me-1"></i>
                                            This is the current image for "<?php echo $row['c_name']; ?>" category
                                        </small>
                                    </div>
                                </div>
                                
                                <div id="preview-container" class="mt-4 d-none">
                                    <div class="current-image-container">
                                        <span class="current-image-label">New Image Preview</span>
                                        <div class="text-center">
                                            <img id="image-preview" class="category-img img-fluid" style="max-height: 200px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end mt-4">
                            <a href="add_category.php" class="btn btn-inverse me-2">
                                <i class="fas fa-times me-1"></i> Cancel
                            </a>
                            <button type="submit" name="submit" class="btn btn-success pulse-animation">
                                <i class="fas fa-save me-1"></i> Update Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add these scripts at the end of your body tag -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>

<!-- Custom Scripts -->
<script>
    // Initialize AOS animations
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true
    });
    
    // Preview image before upload
    document.getElementById('categoryImage').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const previewContainer = document.getElementById('preview-container');
        const imagePreview = document.getElementById('image-preview');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                imagePreview.src = event.target.result;
                previewContainer.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        } else {
            previewContainer.classList.add('d-none');
        }
    });
    
    // Show success message with animation if it exists
    <?php if(isset($success)): ?>
    setTimeout(function() {
        Swal.fire({
            title: 'Success!',
            text: 'Category has been updated successfully',
            icon: 'success',
            confirmButtonText: 'Continue',
            confirmButtonColor: '#11998e'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'add_category.php';
            }
        });
    }, 1000);
    <?php endif; ?>
</script>

