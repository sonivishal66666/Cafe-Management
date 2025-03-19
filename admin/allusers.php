<!DOCTYPE html>
<html lang="en">
<?php
include("../connection/connect.php");
error_reporting(0);
session_start();
?>
<?php include_once('header.php');?>

<!-- Page Title with Animation -->
<div class="row page-titles animated fadeInDown">
    <div class="col-md-5 align-self-center">
        <h3 class="text-primary">All Users</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item active">All Users</li>
        </ol>
    </div>
</div>

<!-- Main Content Container -->
<div class="container-fluid">
    <!-- Start Page Content -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg animated fadeIn">
                <div class="card-header bg-gradient-primary text-white">
                    <h4 class="card-title mb-0">All Registered Users</h4>
                </div>
                <div class="card-body">
                    <!-- Search and Export Controls -->
                    <div class="d-flex justify-content-between mb-4">
                        <div class="input-group w-50">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-primary text-white">
                                    <i class="fa fa-search"></i>
                                </span>
                            </div>
                            <input type="text" id="tableSearch" class="form-control" placeholder="Search users...">
                        </div>
                        <div class="export-buttons">
                            <button class="btn btn-outline-primary btn-sm" data-toggle="tooltip" title="Export to Excel">
                                <i class="fa fa-file-excel-o"></i> Excel
                            </button>
                            <button class="btn btn-outline-danger btn-sm" data-toggle="tooltip" title="Export to PDF">
                                <i class="fa fa-file-pdf-o"></i> PDF
                            </button>
                        </div>
                    </div>
                    
                    <!-- Responsive Table -->
                    <div class="table-responsive">
                        <table id="userTable" class="table table-hover table-striped table-bordered">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Student Name</th>                                        
                                    <th>Roll No</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Registration Date</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT * FROM users order by u_id desc";
                                $query = mysqli_query($db, $sql);
                                
                                if(!mysqli_num_rows($query) > 0) {
                                    echo '<tr><td colspan="7"><div class="alert alert-info text-center">No User Data Available!</div></td></tr>';
                                } else {
                                    $i = 1;    
                                    while($rows = mysqli_fetch_array($query)) {
                                        echo '<tr class="animated fadeIn">
                                            <td class="text-center">'.$i.'</td>
                                            <td><span class="user-name">'.$rows['student_name'].'</span></td>
                                            <td>'.$rows['roll_no'].'</td>
                                            <td><a href="mailto:'.$rows['email'].'">'.$rows['email'].'</a></td>
                                            <td><a href="tel:'.$rows['phone'].'">'.$rows['phone'].'</a></td>
                                            <td>'.date('d M Y', strtotime($rows['date'])).'</td>
                                            <td class="text-center">
                                                <a href="update_users.php?user_upd='.$rows['u_id'].'" class="btn btn-info btn-sm m-1" data-toggle="tooltip" title="Edit User">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <a href="delete_users.php?user_del='.$rows['u_id'].'" class="btn btn-danger btn-sm m-1" onclick="return confirm(\'Are you sure you want to delete this user?\');" data-toggle="tooltip" title="Delete User">
                                                    <i class="fa fa-trash"></i>
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
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-between mt-4">
                        <div class="dataTables_info">
                            Showing <span id="showing-entries">1-10</span> of <span id="total-entries">0</span> entries
                        </div>
                        <nav aria-label="Page navigation">
                            <ul class="pagination pagination-sm" id="table-pagination">
                                <!-- Pagination will be generated by JavaScript -->
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Content -->
</div>
<!-- End Container fluid -->

<!-- footer -->
<?php include_once('footer.php');?>

<!-- Required Scripts -->
<script src="js/lib/jquery/jquery.min.js"></script>
<script src="js/lib/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="js/lib/datatables/datatables.min.js"></script>
<script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
<script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
<script src="js/lib/datatables/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script src="js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
<script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>

<!-- Custom Script for Enhanced Features -->
<script>
$(document).ready(function() {
    // Initialize DataTable with enhanced features
    var table = $('#userTable').DataTable({
        responsive: true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "pageLength": 10,
        "order": [[0, "asc"]],
        "columnDefs": [
            { "orderable": false, "targets": 6 }
        ],
        "initComplete": function() {
            // Apply animation to table rows on page change
            $('#userTable').on('draw.dt', function() {
                $('tbody tr').addClass('animated fadeIn');
            });
            
            // Update the showing entries text
            updateShowingEntries();
        }
    });
    
    // Search functionality
    $('#tableSearch').on('keyup', function() {
        table.search(this.value).draw();
        updateShowingEntries();
    });
    
    // Update showing entries helper function
    function updateShowingEntries() {
        var info = table.page.info();
        $('#showing-entries').text((info.start + 1) + '-' + info.end);
        $('#total-entries').text(info.recordsDisplay);
    }
    
    // Enable tooltips
    $('[data-toggle="tooltip"]').tooltip();
    
    // Add hover effect to table rows
    $(document).on('mouseenter', 'tbody tr', function() {
        $(this).addClass('bg-light-hover');
    }).on('mouseleave', 'tbody tr', function() {
        $(this).removeClass('bg-light-hover');
    });
    
    // Add animation to export buttons
    $('.export-buttons button').on('mouseenter', function() {
        $(this).addClass('animated pulse');
    }).on('mouseleave', function() {
        $(this).removeClass('animated pulse');
    });
});
</script>

<!-- Custom CSS for Enhanced UI -->
<style>
    /* General Enhancements */
    .card {
        border-radius: 10px;
        overflow: hidden;
        border: none;
        margin-bottom: 30px;
        transition: all 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 25px rgba(0,0,0,0.1);
    }
    
    .card-header {
        border-bottom: none;
        padding: 15px 20px;
    }
    
    .bg-gradient-primary {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    }
    
    /* Table Enhancements */
    #userTable {
        border-collapse: separate;
        border-spacing: 0;
        border-radius: 5px;
        overflow: hidden;
    }
    
    #userTable thead th {
        font-weight: 600;
        position: relative;
        padding: 15px 10px;
        color: #495057;
        border-bottom: 2px solid #dee2e6;
    }
    
    #userTable tbody td {
        vertical-align: middle;
        padding: 12px 10px;
        border-top: 1px solid #f0f0f0;
    }
    
    .user-name {
        font-weight: 600;
        color: #333;
    }
    
    /* Button Enhancements */
    .btn {
        border-radius: 4px;
        font-size: 0.875rem;
        padding: 0.375rem 0.75rem;
        transition: all 0.2s;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem;
    }
    
    .btn-info {
        background-color: #36b9cc;
        border-color: #36b9cc;
    }
    
    .btn-danger {
        background-color: #e74a3b;
        border-color: #e74a3b;
    }
    
    /* Animation Classes */
    .animated {
        animation-duration: 0.8s;
        animation-fill-mode: both;
    }
    
    .fadeIn {
        animation-name: fadeIn;
    }
    
    .fadeInDown {
        animation-name: fadeInDown;
    }
    
    .pulse {
        animation-name: pulse;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translate3d(0, -20px, 0);
        }
        to {
            opacity: 1;
            transform: translate3d(0, 0, 0);
        }
    }
    
    @keyframes pulse {
        from {
            transform: scale3d(1, 1, 1);
        }
        50% {
            transform: scale3d(1.05, 1.05, 1.05);
        }
        to {
            transform: scale3d(1, 1, 1);
        }
    }
    
    /* Hover Effects */
    .bg-light-hover {
        background-color: rgba(0, 123, 255, 0.05) !important;
        transition: all 0.3s ease;
    }
    
    a {
        color: #4e73df;
        transition: all 0.3s ease;
    }
    
    a:hover {
        color: #224abe;
        text-decoration: none;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .input-group.w-50 {
            width: 100% !important;
        }
        
        .d-flex {
            flex-direction: column;
        }
        
        .export-buttons {
            margin-top: 10px;
            text-align: right;
        }
    }
</style>