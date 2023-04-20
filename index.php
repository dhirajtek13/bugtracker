<?php include "db/config.php"; ?>
<?php include "db/fetch_dropdown_data.php"; ?>

<?php include "layout/header.php"; ?>

<div class="container my-5">
    <h2>Tickets</h2>

    <!-- Add button -->
    <div class="top-panel">
        <a href="javascript:void(0);" class="btn btn-primary my-2" onclick="addData()">Add New Ticket</a>
    </div>
    <!-- Data list table -->
    <table id="dataList" class="display" style="width:100%">
        <thead>
            <tr>
                <!-- <th>S.N</th> -->
                <th>Ticket Id</th>
                <th>Type</th>
                <th>C.Status</th>
                <th>Assignee</th>
                <th>Assigned Date</th>
                <th>P.Start Date</th>
                <th>P.End Date</th>
                <th>A.Start Date</th>
                <th>A.End Date</th>
                <th>Planned Hours</th>
                <th>A . Hours</th>
                <th>Variance </th>
                <th></th>
            </tr>
        </thead>
        <tfoot>
                <tr>
                    <th>Ticket Id</th>
                    <th>Type</th>
                    <th>C.Status</th>
                    <th>Assignee</th>
                    <th>Assigned Date</th>
                    <th>P.Start Date</th>
                    <th>P.End Date</th>
                    <th>A.Start Date</th>
                    <th>A.End Date</th>
                    <th>Planned Hours</th>
                    <th>A . Hours</th>
                    <th>Variance </th>
                    <th></th>
                </tr>
        </tfoot>
    </table>

</div>


<div class="modal fade" id="userDataModal" tabindex="-1" aria-labelledby="userAddEditModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="userModalLabel">Add New Ticket</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form name="userDataFrm" id="userDataFrm">
                <div class="modal-body">
                    <div class="frm-status"></div>

                    <div class="container">
                        <div class="row">
                            <div class="col-sm">
                                <div class="mb-3">
                                    <label for="userFirstName" class="form-label">Ticket Id</label>
                                    <input type="text" class="form-control" id="ticket_id" placeholder="Enter Ticket Id">
                                </div>
                                <div class="mb-3">
                                    <label for="type_id" class="form-label">Type</label>
                                    <?php print_r($ticket_types_row); ?>
                                </div>
                                <div class="mb-3">
                                    <label for="c_status" class="form-label">C.Status</label>
                                    <?php  print_r($c_status_types_row); ?>
                                </div>
                                <div class="mb-3">
                                    <label for="assignee_id" class="form-label">Assignee</label>
                                    <?php  print_r($assignees_row); ?>
                                </div>
                            </div>


                            <div class="col-sm">
                                <div class="mb-3">
                                    <label for="assigned_date" class="form-label">Assigned Date</label>
                                   <input type="datetime-local" name="assigned_date" id="assigned_date" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="plan_start_date" class="form-label">Plan Start Date</label>
                                    <input type="datetime-local" name="plan_start_date" id="plan_start_date" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="plan_end_date" class="form-label">Plan End Date</label>
                                    <input type="datetime-local" name="plan_end_date" id="plan_end_date" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="actual_start_date" class="form-label">Actual Start Date</label>
                                    <input type="datetime-local" name="actual_start_date" id="actual_start_date" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="mb-3">
                                    <label for="actual_end_date" class="form-label">Actual End Date</label>
                                    <input type="datetime-local" name="actual_end_date" id="actual_end_date" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="planned_hrs" class="form-label">Planned Hours</label>
                                    <input type="number" class="form-control" id="planned_hrs" placeholder="00.0">
                                </div>
                                <div class="mb-3">
                                    <label for="actual_hrs" class="form-label">Actual Date</label>
                                    <input type="number" class="form-control" id="actual_hrs" placeholder="00.0">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <input type="hidden" id="userID" value="0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submitUserData()">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>



<script>
    // Initialize DataTables API object and configure table
    var table = $('#dataList').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": "fetchData.php",
                    "columnDefs": [{
                        "orderable": true,
                        "targets": 12
                    }],
                    orderCellsTop: true,
                    fixedHeader: true,
                    initComplete: function () {
                        // Apply the search
                        this.api()
                            .columns()
                            .every(function () {
                                var that = this;
            
                                $('input', this.footer()).on('keyup change clear', function () {
                                    if (that.search() !== this.value) {
                                        that.search(this.value).draw();
                                    }
                                });
                            });
                    },
                });

    $(document).ready(function() {

                // Setup - add a text input to each footer cell
                // $('#dataList thead tr')
                //     .clone(true)
                //     .addClass('filters')
                //     .appendTo('#dataList thead');

                // Setup - add a text input to each footer cell
                $('#dataList tfoot th').each(function () {
                    var title = $(this).text();
                    $(this).html('<input type="text" placeholder="Search ' + title + '"  size="10"/>');
                });
                // DataTable
                // var table = $('#dataList').DataTable({
                //     initComplete: function () {
                //         // Apply the search
                //         this.api()
                //             .columns()
                //             .every(function () {
                //                 var that = this;
            
                //                 $('input', this.footer()).on('keyup change clear', function () {
                //                     if (that.search() !== this.value) {
                //                         that.search(this.value).draw();
                //                     }
                //                 });
                //             });
                //     },
                // });

        // Draw the table
        //table.draw();
    });


    function addData() {
        $('.frm-status').html('');
        $('#userModalLabel').html('Add New Ticket');

        $('#userGender_1').prop('checked', true);
        $('#userGender_2').prop('checked', false);
        $('#userStatus_1').prop('checked', true);
        $('#userStatus_2').prop('checked', false);
        $('#userFirstName').val('');
        $('#userLastName').val('');
        $('#userEmail').val('');
        $('#userCountry').val('');
        $('#userID').val(0);
        $('#userDataModal').modal('show');
    }

    function editData(user_data) {
        $('.frm-status').html('');
        $('#userModalLabel').html('Edit User #' + user_data.id);

        if (user_data.gender == 'Female') {
            $('#userGender_1').prop('checked', false);
            $('#userGender_2').prop('checked', true);
        } else {
            $('#userGender_2').prop('checked', false);
            $('#userGender_1').prop('checked', true);
        }

        if (user_data.status == 1) {
            $('#userStatus_2').prop('checked', false);
            $('#userStatus_1').prop('checked', true);
        } else {
            $('#userStatus_1').prop('checked', false);
            $('#userStatus_2').prop('checked', true);
        }

        $('#userFirstName').val(user_data.first_name);
        $('#userLastName').val(user_data.last_name);
        $('#userEmail').val(user_data.email);
        $('#userCountry').val(user_data.country);
        $('#userID').val(user_data.id);
        $('#userDataModal').modal('show');
    }

    function submitUserData() {
        $('.frm-status').html('');
        let input_data_arr = [
            document.getElementById('userFirstName').value,
            document.getElementById('userLastName').value,
            document.getElementById('userEmail').value,
            document.querySelector('input[name="userGender"]:checked').value,
            document.getElementById('userCountry').value,
            document.querySelector('input[name="userStatus"]:checked').value,
            document.getElementById('userID').value,
        ];

        fetch("eventHandler.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    request_type: 'addEditUser',
                    user_data: input_data_arr
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.status == 1) {
                    Swal.fire({
                        title: data.msg,
                        icon: 'success',
                    }).then((result) => {
                        // Redraw the table
                        table.draw();

                        $('#userDataModal').modal('hide');
                        $("#userDataFrm")[0].reset();
                    });
                } else {
                    $('.frm-status').html('<div class="alert alert-danger" role="alert">' + data.error + '</div>');
                }
            })
            .catch(console.error);
    }

    function deleteData(user_id) {
        Swal.fire({
            title: 'Are you sure to Delete?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Delete event
                fetch("eventHandler.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({
                            request_type: 'deleteUser',
                            user_id: user_id
                        }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status == 1) {
                            Swal.fire({
                                title: data.msg,
                                icon: 'success',
                            }).then((result) => {
                                table.draw();
                            });
                        } else {
                            Swal.fire(data.error, '', 'error');
                        }
                    })
                    .catch(console.error);
            } else {
                Swal.close();
            }
        });
    }
</script>
<?php include "layout/footer.php"; ?>