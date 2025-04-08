<?php
include("../connection/connect.php");
error_reporting(0);
session_start();
?>
<?php include_once('header.php');?>

<!DOCTYPE html>
<html lang="en">


<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-primary"><i class="fa fa-table me-2"></i>All Menus</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item active">All Menus</li>
        </ol>
    </div>
</div>
<!-- Container fluid  -->
<div class="container-fluid">
    <!-- Start Page Content -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">All Menu data</h4>
                    <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>
                    <div class="table-responsive m-t-40">
                        <table id="menuTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>SR.No</th>
                                    <th>Food Category</th>
                                    <th>Dish-Name</th>
                                    <th>Slogan</th>
                                    <th>Price</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>Today's Menu</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql="SELECT * FROM dishes order by d_id desc";
                                $query=mysqli_query($db,$sql);
                                
                                if(!mysqli_num_rows($query) > 0 )
                                {
                                    echo '<td colspan="11"><center>No Dish-Data!</center></td>';
                                }
                                else
                                {   
                                    $i=1;            
                                    while($rows=mysqli_fetch_array($query))
                                    {
                                        $mql="select * from res_category where c_id='".$rows['c_id']."'";
                                        $newquery=mysqli_query($db,$mql);
                                        $fetch=mysqli_fetch_array($newquery);                                      
                                        echo '<tr>
                                            <td>'.$i.'</td>
                                            <td>'.$fetch['c_name'].'</td>                                     
                                            <td>'.$rows['title'].'</td>
                                            <td>'.$rows['slogan'].'</td>
                                            <td class="fw-bold">₹'.$rows['price'].'</td>
                                                                                                    
                                            <td><div class="col-md-3 col-lg-8 m-b-10">
                                                <center><img src="Category_Image/dishes/'.$rows['img'].'" class="img-dish" /></center></div>
                                            </td>';  
                                            if($rows['status']==1)
                                            {
                                                echo '<td><button type="button" class="btn btn-success btn-status"><span class="fa fa-unlock" aria-hidden="true"></span> Active</button></td>';   
                                            }   
                                            else
                                            {
                                                echo '<td><button type="button" class="btn btn-danger btn-status"><span class="fa fa-lock" aria-hidden="true"></span> InActive</button></td>';
                                            }       
                                            if($rows['in_today_menu']==1)
                                            {
                                                echo '<td><button type="button" class="btn btn-success btn-status"><span class="fa fa-unlock" aria-hidden="true"></span> Active</button></td>';    
                                            }   
                                            else
                                            {
                                                echo '<td><button type="button" class="btn btn-danger btn-status"><span class="fa fa-lock" aria-hidden="true"></span> InActive</button></td>';
                                            }                                                                                                                                         
                                        echo '<td class="action-column">
                                            <a href="delete_menu.php?menu_del='.$rows['d_id'].'" onclick="return confirm(\'Are sure to delete !\');" class="btn btn-danger btn-action"><i class="fa fa-trash-o" style="font-size:16px; color:#ffffff;"></i></a> 
                                            <a href="update_menu.php?menu_upd='.$rows['d_id'].'" class="btn btn-info btn-action"><i class="ti-settings" style="color:#ffffff;"></i></a>
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
<!-- End Container fluid  -->

<!-- Required CSS and JS for enhancements -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

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
$(document).ready(function() {
    // Initialize DataTable with enhanced options
    $('#menuTable').DataTable({
        dom: '<"top"Bf>rt<"bottom"lip>',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        "pageLength": 10,
        "ordering": true,
        "responsive": true,
        "columnDefs": [
            { "orderable": false, "targets": [5, 6, 7, 8] }
        ]
    });
    
    // Add row hover effect
    $("#menuTable tbody tr").hover(
        function() { $(this).addClass('table-hover-effect'); },
        function() { $(this).removeClass('table-hover-effect'); }
    );
    
    // Add image hover effect
    $(".img-dish").hover(
        function() { $(this).addClass('img-hover-effect'); },
        function() { $(this).removeClass('img-hover-effect'); }
    );
    
    // Ensure action buttons are visible
    $(".btn-action").hover(
        function() { $(this).addClass('btn-hover-effect'); },
        function() { $(this).removeClass('btn-hover-effect'); }
    );
});
</script>

<style>
/* Enhanced styles for better visibility */
#menuTable {
    border-collapse: separate;
    border-spacing: 0;
    width: 100% !important;
}

#menuTable th {
    background-color: #f8f9fa;
    font-weight: bold;
    color: #333;
    padding: 12px 8px;
    white-space: nowrap;
    border: 1px solid #dee2e6;
}

#menuTable td {
    padding: 10px 8px;
    border: 1px solid #dee2e6;
    vertical-align: middle;
}

/* Status buttons styling */
.btn-status {
    width: 100%;
    font-weight: bold;
    font-size: 14px;
    padding: 6px 8px;
    white-space: nowrap;
    text-align: center;
    transition: all 0.3s;
}

.btn-success {
    background-color: #28a745;
    border-color: #28a745;
}

.btn-danger {
    background-color: #dc3545;
    border-color: #dc3545;
}

.btn-info {
    background-color: #17a2b8;
    border-color: #17a2b8;
}

/* Action buttons styling - FIXED */
.action-column {
    width: 120px;
    text-align: center;
    white-space: nowrap;
}

.btn-action {
    display: inline-block;
    margin: 2px;
    padding: 8px 12px;
    transition: transform 0.2s;
    min-width: 40px;
}

.btn-action i {
    display: inline-block;
    font-weight: bold;
}

.btn-hover-effect {
    transform: scale(1.15);
}

/* Image styling */
.img-dish {
    max-height: 65px;
    max-width: 120px;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    transition: all 0.3s;
}

.img-hover-effect {
    transform: scale(1.3);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    z-index: 10;
}

/* Table hover effect */
.table-hover-effect {
    background-color: #f8f9fa !important;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}

/* DataTables custom styling */
.dataTables_wrapper .dataTables_filter {
    margin-bottom: 15px;
}

.dataTables_wrapper .dataTables_filter input {
    border: 1px solid #ced4da;
    border-radius: 4px;
    padding: 6px 12px;
    width: 250px;
}

/* Button styling */
div.dt-buttons {
    margin-bottom: 15px;
}

div.dt-buttons .dt-button {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 6px 15px;
    margin-right: 5px;
    border-radius: 4px;
    transition: background-color 0.3s;
}

div.dt-buttons .dt-button:hover {
    background-color: #0069d9;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    #menuTable {
        display: block;
        width: 100%;
        overflow-x: auto;
    }
    
    .btn-status {
        font-size: 12px;
        padding: 4px 6px;
    }
    
    .img-dish {
        max-height: 50px;
        max-width: 80px;
    }
    
    .action-column {
        width: 100px;
    }
    
    .btn-action {
        padding: 6px 10px;
        min-width: 36px;
    }
}
</style>

