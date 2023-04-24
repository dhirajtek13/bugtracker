<?php 
if(!isset($_GET['ticket'])) { //redirect if no ticket id given to list its log
    header("Location: /");
} else {
    echo "<input type='hidden' name='ticketId' id='ticketId' value='".$_GET['ticket']."'>";
}

?>
<h2>Timing</h2>

    <!-- Add button -->
    <!-- <div class="top-panel">
        <a href="javascript:void(0);" class="btn btn-primary my-2" onclick="addData()">Add New Log</a>
    </div> -->
    <!-- Data list table -->
    <table id="dataList" class="display" style="width:100%">
        <thead>
            <tr>
                <!-- <th>S.N</th> -->
                <th>Ticket</th>
                <th>User</th>
                <th>Status</th>
                <th>Activity</th>
                <th>Date</th>
                <th></th>
            </tr>
        </thead>
        <tfoot style="display:table-header-group">
            <tr>
                <th>Ticket</th>
                <th>User</th>
                <th>Status</th>
                <th>Activity</th>
                <th>Date</th>
                <th></th>
            </tr>
        </tfoot>
        <tbody>
            
        </tbody>
    </table>

    