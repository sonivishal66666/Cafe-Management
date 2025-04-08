<?php
include("../connection/connect.php");
error_reporting(0);
session_start();
?>
<?php include_once('header.php');?>

<!DOCTYPE html>
<html lang="en">


<!-- Styled breadcrumb with gradient background -->
<div class="row page-header-wrapper mb-4">
    <div class="container-fluid">
        <div class="row align-items-center px-3 py-4 bg-gradient-primary text-white rounded shadow-sm">
            <div class="col-md-6">
                <h3 class="m-0 font-weight-bold">Order Status</h3>
            </div>
            <div class="col-md-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 p-0 justify-content-md-end">
                        <li class="breadcrumb-item"><a href="javascript:void(0)" class="text-white opacity-75">Home</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Status</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <!-- Start Page Content -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-lg rounded-lg">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title font-weight-bold text-primary mb-0">Students Orders</h4>
                        <div class="status-legend d-flex align-items-center">
                            <div class="legend-item d-flex align-items-center mr-3">
                                <span class="status-indicator bg-warning rounded-circle mr-2" style="width: 12px; height: 12px; display: inline-block;"></span>
                                <span class="text-muted">Pending</span>
                            </div>
                            <div class="legend-item d-flex align-items-center mr-3">
                                <span class="status-indicator bg-success rounded-circle mr-2" style="width: 12px; height: 12px; display: inline-block;"></span>
                                <span class="text-muted">Completed</span>
                            </div>
                            <div class="legend-item d-flex align-items-center">
                                <span class="status-indicator bg-danger rounded-circle mr-2" style="width: 12px; height: 12px; display: inline-block;"></span>
                                <span class="text-muted">Cancelled</span>
                            </div>
                        </div>
                    </div>
                    <hr class="mt-3">
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="myTable" class="table table-hover border-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="font-weight-bold">#</th>
                                    <th class="font-weight-bold">Student</th>
                                    <th class="font-weight-bold">Dish</th>
                                    <th class="font-weight-bold">Qty</th>
                                    <th class="font-weight-bold">Price</th>
                                    <th class="font-weight-bold" style="min-width: 120px;">Status</th>
                                    <th class="font-weight-bold">Pickup Time</th>
                                    <th class="font-weight-bold">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql="SELECT users.*, users_orders.* FROM users INNER JOIN users_orders ON users.u_id=users_orders.u_id order by o_id desc";
                                $query=mysqli_query($db,$sql);
                                
                                if(!mysqli_num_rows($query) > 0)
                                {
                                    echo '<tr><td colspan="8"><div class="alert alert-info text-center my-3">No Orders Found</div></td></tr>';
                                }
                                else
                                {
                                    $i=1;
                                    while($rows=mysqli_fetch_array($query))
                                    {
                                        $status=$rows['status'];
                                        if($status=="" or $status=="NULL")
                                        {
                                ?>
                                            <tr class="border-bottom">
                                                <td class="align-middle"><?php echo $i; ?></td>
                                                <td class="align-middle">
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-circle bg-primary text-white mr-3">
                                                            <?php echo substr($rows['student_name'], 0, 1); ?>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0"><?php echo $rows['student_name']; ?></h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="align-middle font-weight-medium"><?php echo $rows['title']; ?></td>
                                                <td class="align-middle"><?php echo $rows['quantity']; ?></td>
                                                <td class="align-middle">₹<?php echo number_format($rows['price'], 2); ?></td>
                                                <td class="align-middle">
                                                    <?php if($status=="" or $status=="NULL") { ?>
                                                        <div class="status-badge-wrapper text-center">
                                                            <div class="status-badge">
                                                                <span class="status-text">PENDING</span>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                </td>
                                                <td class="align-middle">
                                                    <div class="d-flex align-items-center">
                                                        <i class="far fa-clock text-muted mr-2"></i>
                                                        <?php echo $rows['pick_time']; ?>
                                                    </div>
                                                </td>
                                                <td class="align-middle">
                                                    <a href="view_status.php?o_id=<?php echo $rows['o_id']; ?>" class="btn btn-primary btn-sm rounded-pill px-3">
                                                        <i class="ti-settings mr-1"></i>Update
                                                    </a>
                                                </td>
                                            </tr>
                                <?php
                                            $i++;
                                        }
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white border-0">
                    <div class="d-flex justify-content-between">
                        <small class="text-muted">Last updated: Today</small>
                        <small class="text-primary">Showing all pending orders</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Content -->
</div>

<!-- Custom styles -->
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    }
    
    .card {
        transition: all 0.2s ease-in-out;
    }
    
    .avatar-circle {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }
    
    .opacity-75 {
        opacity: 0.75;
    }
    
    .table th, .table td {
        padding: 1rem;
    }
    
    /* Fixed Status Badge Styling */
    .status-badge-wrapper {
        display: table;
        width: 100%;
        height: 100%;
    }
    
    .status-badge {
        display: inline-block;
        background-color: #ffc107;
        color: #000;
        border-radius: 20px;
        padding: 8px 4px;
        width: 100px;
        height: 36px;
        position: relative;
        font-weight: bold;
        font-size: 14px;
        text-align: center;
        line-height: 20px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    
    .status-text {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        width: 100%;
        text-align: center;
    }
    
    /* Status legend styling */
    .status-legend {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
    }
    
    .legend-item {
        margin-bottom: 5px;
    }
    
    /* Make sure FA icons are visible */
    .fa, .fas, .far, .ti-settings {
        display: inline-block !important;
        font-style: normal !important;
    }
</style>

<!-- Scripts -->
<script src="js/lib/datatables/datatables.min.js"></script>
<script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
<script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
<script src="js/lib/datatables/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script src="js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
<script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>

<!-- Initialize DataTable with custom options -->
<script>
$(document).ready(function() {
    // Check if the table is already initialized as a DataTable
    if (!$.fn.DataTable.isDataTable('#myTable')) {
        $('#myTable').DataTable({
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
            "pageLength": 10,
            "ordering": true,
            "info": true,
            "searching": true,
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "language": {
                "emptyTable": "No orders available",
                "info": "Showing _START_ to _END_ of _TOTAL_ orders",
                "infoEmpty": "Showing 0 to 0 of 0 orders",
                "search": "Search orders:",
                "paginate": {
                    "first": "First",
                    "last": "Last",
                    "next": "Next",
                    "previous": "Previous"
                }
            }
        });
    }
});
</script>

