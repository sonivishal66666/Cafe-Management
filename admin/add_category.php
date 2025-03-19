<!DOCTYPE html>
<html lang="en">
<?php
include("../connection/connect.php");
error_reporting(0);
session_start();

if(isset($_POST['submit']))           //if upload btn is pressed
{
    if(empty($_POST['food_name']))
    {	
        $error = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <strong>Error!</strong> All fields must be filled out.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';															
    }
    else
    {
        $check_cat = mysqli_query($db, "SELECT c_name FROM res_category where c_name = '".$_POST['food_name']."' ");
        
        if(mysqli_num_rows($check_cat) > 0)
        {
            $error = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <strong>Error!</strong> Category already exists!
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
                    $sql = "INSERT INTO res_category(c_name,image) VALUE('".$_POST['food_name']."','".$fnew."')";
                    mysqli_query($db, $sql); 
                    move_uploaded_file($temp, $store);			  
                    $success = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                  <i class="fas fa-check-circle me-2"></i>
                                  <strong>Success!</strong> New category added successfully.
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

<!-- Add these in your header.php file -->
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
    
    .btn-primary {
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        border: none;
        border-radius: 8px;
        padding: 12px 25px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(37, 117, 252, 0.4);
    }
    
    .btn-danger {
        background: linear-gradient(135deg, #ff4b1f 0%, #ff9068 100%);
        border: none;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255, 75, 31, 0.4);
    }
    
    .btn-info {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        border: none;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .btn-info:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(17, 153, 142, 0.4);
    }
    
    .table {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    
    .table thead th {
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        color: white;
        border: none;
        padding: 15px;
    }
    
    .table tbody tr {
        transition: all 0.3s ease;
    }
    
    .table tbody tr:hover {
        background-color: rgba(37, 117, 252, 0.05);
        transform: scale(1.01);
    }
    
    .category-img {
        border-radius: 10px;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        object-fit: cover;
    }
    
    .category-img:hover {
        transform: scale(1.05);
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
    
    .form-label {
        font-weight: 600;
        margin-bottom: 10px;
        color: #555;
    }
    
    .alert {
        border-radius: 10px;
        border: none;
        padding: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    
    .dataTables_wrapper .dataTables_filter input {
        border-radius: 8px;
        padding: 8px 12px;
        border: 1px solid #e0e0e0;
    }
    
    .dataTables_wrapper .dataTables_length select {
        border-radius: 8px;
        padding: 8px;
        border: 1px solid #e0e0e0;
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
</style>

<!-- Page content -->
<div class="container-fluid py-4">
    <!-- Page Title -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-title-wrapper" data-aos="fade-down">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="text-gradient m-0">Food Category Management</h3>
                        <p class="text-white-50 m-0">Manage your restaurant's food categories</p>
                    </div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent m-0">
                            <li class="breadcrumb-item"><a href="dashboard.php" class="text-white-50"><i class="fas fa-home me-1"></i>Home</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">Food Categories</li>
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
    
    <!-- Add Category Form -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card shimmer" data-aos="fade-up">
                <div class="card-header">
                    <h4 class="m-0 text-white"><i class="fas fa-plus-circle me-2"></i>Add New Food Category</h4>
                </div>
                <div class="card-body py-4">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="categoryName" class="form-label">
                                        <i class="fas fa-tag me-1"></i> Category Name
                                    </label>
                                    <input type="text" name="food_name" id="categoryName" class="form-control" 
                                           placeholder="Ex: Breakfast, Lunch, Dinner, Desserts..." required>
                                    <div class="form-text text-muted">Enter a unique category name</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="categoryImage" class="form-label">
                                        <i class="fas fa-image me-1"></i> Category Image
                                    </label>
                                    <div class="file-upload">
                                        <input type="file" name="file" id="categoryImage" class="form-control" accept="image/png, image/jpeg, image/gif">
                                        <div class="form-text text-muted">Supported formats: JPG, PNG, GIF (Max: 1MB)</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <a href="dashboard.php" class="btn btn-outline-secondary me-2">
                                <i class="fas fa-times me-1"></i> Cancel
                            </a>
                            <button type="submit" name="submit" class="btn btn-primary pulse-animation">
                                <i class="fas fa-save me-1"></i> Save Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Category List -->
    <div class="row">
        <div class="col-12">
            <div class="card" data-aos="fade-up" data-aos-delay="200">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="m-0 text-white"><i class="fas fa-list me-2"></i>Listed Categories</h4>
                        <span class="badge bg-white text-primary" id="category-count">0</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="categoryTable" class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="25%">Category Name</th>
                                    <th width="20%">Date Added</th>
                                    <th width="30%">Image</th>
                                    <th width="20%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sql = "SELECT * FROM res_category ORDER BY c_id DESC";
                                    $query = mysqli_query($db, $sql);
                                    
                                    if(!mysqli_num_rows($query) > 0) {
                                        echo '<tr><td colspan="5" class="text-center py-5">
                                                <div class="d-flex flex-column align-items-center">
                                                    <i class="fas fa-folder-open text-muted" style="font-size: 48px;"></i>
                                                    <p class="mt-3">No categories found!</p>
                                                    <p class="text-muted">Add your first category above</p>
                                                </div>
                                              </td></tr>';
                                    } else {
                                        $i = 1;
                                        while($rows = mysqli_fetch_array($query)) {
                                            echo '<tr data-aos="fade-up" data-aos-delay="'.($i * 50).'">
                                                <td>'.$i.'</td>
                                                <td>
                                                    <span class="fw-bold">'.$rows['c_name'].'</span>
                                                </td>
                                                <td>
                                                    <span class="text-muted">
                                                        <i class="far fa-calendar-alt me-1"></i>
                                                        '.date('M d, Y', strtotime($rows['date'])).'
                                                    </span>
                                                </td>
                                                <td>
                                                    <img src="Category_Image/'.$rows['image'].'" class="category-img" 
                                                         style="height:100px;width:150px;" alt="'.$rows['c_name'].'">
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="update_category.php?cat_upd='.$rows['c_id'].'" class="btn btn-info btn-sm">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                        <a href="javascript:void(0);" onclick="confirmDelete('.$rows['c_id'].')" 
                                                           class="btn btn-danger btn-sm ms-2">
                                                            <i class="fas fa-trash-alt"></i> Delete
                                                        </a>
                                                    </div>
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
    
    // Update category count badge
    document.addEventListener('DOMContentLoaded', function() {
        const tableRows = document.querySelectorAll('#categoryTable tbody tr');
        const categoryCount = document.getElementById('category-count');
        if (categoryCount) {
            categoryCount.textContent = tableRows.length;
        }
        
        // Initialize DataTables with enhanced options
        if (typeof $.fn.DataTable !== 'undefined') {
            $('#categoryTable').DataTable({
                responsive: true,
                language: {
                    search: "<i class='fas fa-search'></i> Search:",
                    searchPlaceholder: "Filter categories...",
                    paginate: {
                        first: "<i class='fas fa-angle-double-left'></i>",
                        last: "<i class='fas fa-angle-double-right'></i>",
                        next: "<i class='fas fa-angle-right'></i>",
                        previous: "<i class='fas fa-angle-left'></i>"
                    }
                },
                dom: '<"top"lf>rt<"bottom"ip><"clear">',
                pageLength: 5,
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
            });
        }
        
        // Show success message with animation if it exists
        <?php if(isset($success)): ?>
        Swal.fire({
            title: 'Success!',
            text: 'Category has been added successfully',
            icon: 'success',
            confirmButtonText: 'Continue',
            confirmButtonColor: '#2575fc'
        });
        <?php endif; ?>
    });
    
    // Preview image before upload
    document.getElementById('categoryImage').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const preview = document.createElement('div');
                preview.className = 'mt-3';
                preview.innerHTML = `
                    <p class="form-text">Image Preview:</p>
                    <img src="${event.target.result}" class="img-thumbnail category-img" style="height:100px;" />
                `;
                
                // Remove any existing preview
                const existingPreview = document.querySelector('.file-upload .mt-3');
                if (existingPreview) {
                    existingPreview.remove();
                }
                
                document.querySelector('.file-upload').appendChild(preview);
            };
            reader.readAsDataURL(file);
        }
    });
    
    // Confirm delete function
    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This category will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff4b1f',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'delete_category.php?cat_del=' + id;
            }
        });
    }
</script>

