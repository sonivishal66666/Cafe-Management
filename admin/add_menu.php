<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Restaurant Admin - Add Menu</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
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
      font-family: 'Nunito', 'Segoe UI', Roboto, sans-serif;
    }
    
    .page-header {
      background: linear-gradient(to right, var(--primary-color), #2e59d9);
      padding: 1.5rem 0;
      border-radius: 0.5rem;
      margin-bottom: 2rem;
      box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }
    
    .page-header h3 {
      color: white;
      font-weight: 700;
      margin: 0;
    }
    
    .breadcrumb {
      background: transparent;
      margin: 0;
    }
    
    .breadcrumb-item a {
      color: rgba(255, 255, 255, 0.8);
      text-decoration: none;
    }
    
    .breadcrumb-item.active {
      color: white;
    }
    
    .card {
      border: none;
      box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
      border-radius: 0.5rem;
      margin-bottom: 2rem;
    }
    
    .card-header {
      background: linear-gradient(to right, var(--primary-color), #2e59d9);
      color: white;
      font-weight: 700;
      padding: 1rem 1.5rem;
      border-top-left-radius: 0.5rem !important;
      border-top-right-radius: 0.5rem !important;
    }
    
    .form-label {
      font-weight: 600;
      color: var(--dark-color);
    }
    
    .form-control {
      padding: 0.75rem 1rem;
      border-radius: 0.5rem;
      border: 1px solid #d1d3e2;
    }
    
    .form-control:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
    }
    
    .btn-success {
      background-color: var(--secondary-color);
      border-color: var(--secondary-color);
      padding: 0.75rem 1.5rem;
      font-weight: 600;
      border-radius: 0.5rem;
    }
    
    .btn-success:hover {
      background-color: #169b6b;
    }
    
    .btn-secondary {
      background-color: #858796;
      border-color: #858796;
      padding: 0.75rem 1.5rem;
      font-weight: 600;
      border-radius: 0.5rem;
    }
    
    .file-upload-wrapper {
      position: relative;
      width: 100%;
    }
    
    .file-upload-wrapper:after {
      content: attr(data-text);
      position: absolute;
      top: 0;
      left: 0;
      background: #fff;
      padding: 0.75rem 1rem;
      display: block;
      width: calc(100% - 40px);
      pointer-events: none;
      z-index: 20;
      color: #999;
      border-radius: 0.5rem 0 0 0.5rem;
      border: 1px solid #d1d3e2;
      border-right: none;
    }
    
    .file-upload-wrapper:before {
      content: 'Upload';
      position: absolute;
      top: 0;
      right: 0;
      display: inline-block;
      height: 100%;
      background: var(--primary-color);
      color: #fff;
      font-weight: 600;
      z-index: 25;
      padding: 0.75rem 1rem;
      text-transform: uppercase;
      pointer-events: none;
      border-radius: 0 0.5rem 0.5rem 0;
    }
    
    .file-upload-wrapper input {
      opacity: 0;
      position: relative;
      z-index: 99;
      height: 50px;
      width: 100%;
      cursor: pointer;
    }
    
    .alert {
      border-radius: 0.5rem;
    }
    
    .form-group {
      margin-bottom: 1.5rem;
    }
    
    .custom-select {
      height: 50px;
    }

    .form-section {
      background-color: white;
      padding: 2rem;
      border-radius: 0.5rem;
    }

    .form-divider {
      height: 1px;
      background-color: #e3e6f0;
      margin: 1.5rem 0;
    }
  </style>
</head>

<body>
<?php
include("../connection/connect.php");
error_reporting(0); // Hides all PHP errors
ini_set('display_errors', 0);
session_start();

$error = "";
$success = "";

if (isset($_POST['submit'])) {  
    if (empty($_POST['d_name']) || empty($_POST['about']) || empty($_POST['price']) || empty($_POST['dish_name'])) {
        $error = '<div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <strong><i class="fas fa-exclamation-circle me-2"></i>All fields must be filled!</strong>
                  </div>';
    } else {
        $fname = $_FILES['file']['name'];
        $temp = $_FILES['file']['tmp_name'];
        $fsize = $_FILES['file']['size'];
        $extension = strtolower(pathinfo($fname, PATHINFO_EXTENSION));
        $fnew = uniqid() . '.' . $extension; 
        $store = "Category_Image/dishes/" . basename($fnew);

        if ($extension == 'jpg' || $extension == 'png' || $extension == 'gif') {
            if ($fsize >= 1000000) {
                $error = '<div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            <strong><i class="fas fa-exclamation-circle me-2"></i>Max Image Size is 1024kb!</strong> Try a smaller image.
                          </div>';
            } else {
                if (isset($db)) {
                    $rs_id = isset($_POST['rs_id']) ? $_POST['rs_id'] : 1;
                    $in_today_menu = isset($_POST['in_today_menu']) ? $_POST['in_today_menu'] : 0;

                    $stmt = $db->prepare("INSERT INTO dishes (title, slogan, price, img, status, c_id, rs_id, in_today_menu) 
                                          VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("ssdsiiii", $_POST['d_name'], $_POST['about'], $_POST['price'], $fnew, $_POST['status'], $_POST['dish_name'], $rs_id, $in_today_menu);

                    if ($stmt->execute()) {
                        if (@move_uploaded_file($temp, $store)) {
                            $success = '<div class="alert alert-success alert-dismissible fade show">
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                            <strong><i class="fas fa-check-circle me-2"></i>Success!</strong> New Dish Added Successfully.
                                        </div>';
                        } else {
                            $error = '<div class="alert alert-warning alert-dismissible fade show">
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                        <strong><i class="fas fa-exclamation-triangle me-2"></i>File upload failed, but data was saved.</strong>
                                      </div>';
                        }
                    } else {
                        $error = '<div class="alert alert-danger alert-dismissible fade show">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    <strong><i class="fas fa-exclamation-circle me-2"></i>Error!</strong> Could not insert into database.
                                  </div>';
                    }
                }
            }
        } elseif (empty($fname)) {
            $error = '<div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        <strong><i class="fas fa-exclamation-circle me-2"></i>Please select an image.</strong>
                      </div>';
        } else {
            $error = '<div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        <strong><i class="fas fa-exclamation-circle me-2"></i>Invalid extension!</strong> Only jpg, png, and gif are allowed.
                      </div>';
        }
    }
}
?>
<?php include_once('header.php'); ?>

<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h3 class="text-white"><i class="fas fa-utensils me-2"></i>Add Menu Item</h3>
                </div>
                <div class="col-md-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-md-end mb-0">
                            <li class="breadcrumb-item"><a href="index.php"><i class="fas fa-home me-1"></i>Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add Menu</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <?php echo $error; echo $success; ?>
        
        <div class="card">
            <div class="card-header">
                <h4 class="m-0"><i class="fas fa-plus-circle me-2"></i>Add New Menu Item</h4>
            </div>
            <div class="card-body">
                <form action='' method='post' enctype="multipart/form-data">
                    <div class="form-section">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Dish Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-hamburger"></i></span>
                                        <input type="text" name="d_name" class="form-control" placeholder="Enter dish name">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">About</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-info-circle"></i></span>
                                        <input type="text" name="about" class="form-control" placeholder="Enter dish description">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-divider"></div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Price</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                                        <input type="text" name="price" class="form-control" placeholder="Enter price">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Image</label>
                                    <div class="file-upload-wrapper" data-text="Select dish image">
                                        <input type="file" name="file" class="form-control">
                                    </div>
                                    <small class="text-muted">Accepted formats: JPG, PNG, GIF (Max: 1MB)</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-divider"></div>

                        <div class="row">    
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Category</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-tags"></i></span>
                                        <select name="dish_name" class="form-select">
                                            <option value="">--Select Food Category--</option>
                                            <?php
                                                $ssql ="SELECT * FROM res_category";
                                                $res=mysqli_query($db, $ssql);
                                                while($row=mysqli_fetch_array($res)) {
                                                    echo '<option value="'.$row['c_id'].'">'.$row['c_name'].'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>    
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Status</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-toggle-on"></i></span>
                                        <select name="status" class="form-select">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>                                        
                        </div>
                    </div>
                    
                    <div class="text-end mt-4">
                        <a href="all_menu.php" class="btn btn-secondary me-2">
                            <i class="fas fa-times me-1"></i> Cancel
                        </a>
                        <button type="submit" name="submit" class="btn btn-success">
                            <i class="fas fa-save me-1"></i> Save Menu Item
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>                                        
</div>

<?php include_once('footer.php'); ?>

<!-- Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<!-- Custom Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // File upload custom text
    const fileInput = document.querySelector('input[type="file"]');
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name || 'Select dish image';
            const fileWrapper = e.target.closest('.file-upload-wrapper');
            fileWrapper.setAttribute('data-text', fileName);
        });
    }
    
    // Alert auto-dismiss after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            const closeButton = alert.querySelector('.btn-close');
            if (closeButton) {
                closeButton.click();
            }
        }, 5000);
    });
});
</script>
</body>
</html>