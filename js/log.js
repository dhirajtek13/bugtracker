

$(document).ready(function () {
    // Setup - add a text input to each footer cell
      $("#dataList tfoot th").each(function () {
        var title = $(this).text();
        $(this).html(
          '<input type="text" placeholder="' + title + '"  size="8"/>'
        );
      });

      //get ticketId 
      var ticketId = $("#ticketId").val();


      // Initialize DataTables API object and configure table
      var table = $("#dataList").DataTable({
        processing: true,
        serverSide: true,
        ajax: "db/log_list.php?ticket="+ticketId,
        columnDefs: [
          {
            orderable: true,
            targets: 6,
          },
        ],
        orderCellsTop: true,
      //   fixedHeader: true,
        initComplete: function () {
          // Apply the search
          this.api()
            .columns()
            .every(function () {
              var that = this;

              $("input", this.footer()).on("keyup change clear", function () {
                if (that.search() !== this.value) {
                  that.search(this.value).draw();
                }
              });
            });
        },
      });
});


//Modal CRUD operations 
function addData() {
  $(".frm-status").html("");
  $("#userModalLabel").html("Add New Ticket");

  $("#ticket_id").val("");
  $("#type_id").val(1);
  $("#c_status").val(1);
  $("#assignee_id").val(1);

  $("#assigned_date").val("");
  $("#plan_start_date").val("");
  $("#plan_end_date").val("");
  $("#actual_start_date").val("");
  $("#actual_end_date").val("");

  $("#planned_hrs").val("");
  $("#actual_hrs").val("");

  $("#userDataModal").modal("show");
}

function editData(user_data) {
    console.log(user_data);
    $(".frm-status").html("");
    $("#userModalLabel").html("Edit Ticket #" + user_data.ticket_id);

    $("#ticket_id").val(user_data.ticket_id);

    $("#type_id option").filter(function() {return this.text == user_data.ticket_type ;}).attr('selected', true);
    $("#c_status option").filter(function() {return this.text == user_data.c_type_name ;}).attr('selected', true);
    $("#assignee_id option").filter(function() {return this.text == user_data.assignee ;}).attr('selected', true);

    // $("#type_id").val(user_data.ticket_type);
    // $("#c_status").val(user_data.c_status);
    // $("#assignee_id").val(user_data.assignee_id);
  
    $("#assigned_date").val(user_data.assigned_date);
    $("#plan_start_date").val(user_data.plan_start_date);
    $("#plan_end_date").val(user_data.plan_end_date);
    $("#actual_start_date").val(user_data.actual_start_date);
    $("#actual_end_date").val(user_data.actual_end_date);
  
    $("#planned_hrs").val(user_data.planned_hrs);
    $("#actual_hrs").val(user_data.actual_hrs);

    $('#ticketID').val(user_data.id);
    $("#userDataModal").modal("show");
}

function submitUserData() {
  $(".frm-status").html("");
  let input_data_arr = [
    document.getElementById("ticket_id").value,
    
    document.querySelector('select[name="type_id"]').value,
    document.querySelector('select[name="c_status"]').value,
    document.querySelector('select[name="assignee_id"]').value,

    document.getElementById("assigned_date").value,
    document.getElementById("plan_start_date").value,
    document.getElementById("plan_end_date").value,
    document.getElementById("actual_start_date").value,
    document.getElementById("actual_end_date").value,

    document.getElementById("planned_hrs").value,
    document.getElementById("actual_hrs").value,
    document.getElementById('ticketID').value,
  ];

  fetch("controller/ticket_eventHandler.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      request_type: "addEditUser",
      user_data: input_data_arr,
    }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.status == 1) {
        Swal.fire({
          title: data.msg,
          icon: "success",
        }).then((result) => {
          // Redraw the table
          table.draw();

          $("#userDataModal").modal("hide");
          $("#userDataFrm")[0].reset();
        });
      } else {
        $(".frm-status").html(
          '<div class="alert alert-danger" role="alert">' +
            data.error +
            "</div>"
        );
      }
    })
    .catch(console.error);
}

//TODO 
function deleteData(user_id) {
  Swal.fire({
    title: "Are you sure to Delete?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!",
  }).then((result) => {
    if (result.isConfirmed) {
      // Delete event
      fetch("eventHandler.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          request_type: "deleteUser",
          user_id: user_id,
        }),
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.status == 1) {
            Swal.fire({
              title: data.msg,
              icon: "success",
            }).then((result) => {
              table.draw();
            });
          } else {
            Swal.fire(data.error, "", "error");
          }
        })
        .catch(console.error);
    } else {
      Swal.close();
    }
  });
}
