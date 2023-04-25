<?php 
if(!isset($_GET['ticket'])) { //redirect if no ticket id given to list its log
    header("Location: /");
} else {
    echo "<input type='hidden' name='ticketId' id='ticketId' value='".$_GET['ticket']."'>";
}

?>
<!-- <h2>Logs</h2> -->

    <!-- Add button -->
    <!-- <div class="top-panel">
        
    </div> -->
    <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-6">
                    <h2>Manage <b>Log</b></h2>
                </div>
                <div class="col-sm-6">
                    <a href="javascript:void(0);" class="btn btn-success " onclick="addData()"><i class="material-icons">&#xE147;</i> <span> Add New Log</a>
                    <?php if($_GET['ticket']) echo '<a href="/timing.php?ticket='.$_GET['ticket'].'" class="btn btn-secondary">View Timing</a>'; ?>
                    
                    <!-- <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal">Add New Employee</span></a> -->
                    <!-- <a href="#deleteEmployeeModal" class="btn btn-danger" data-toggle="modal"><i class="material-icons">&#xE15C;</i> <span>Delete</span></a>						 -->
                </div>
            </div>
        </div>

        <!-- Data list table -->
        <table id="dataList" class="display" style="width:100%">
            <thead>
                <tr>
                    <!-- <th>S.N</th> -->
                    <th>Date</th>
                    <th>Hours</th>
                    <th>Status</th>
                    <th>What Is Done</th>
                    <th>What is pending</th>
                    <th>What support is required</th>
                    <th></th>
                </tr>
            </thead>
            <tfoot style="display:table-header-group">
                <tr>
                    <th>Date</th>
                    <th>Hours</th>
                    <th>Status</th>
                    <th>What Is Done</th>
                    <th>What is pending</th>
                    <th>What support is required</th>
                    <th></th>
                </tr>
            </tfoot>
            <tbody>
                
            </tbody>
        </table>

    </div>

    