

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
  $("#userModalLabel").html("Add New Log");

  // $("#ticket_id").val("");
  $("#dates").val("");
  $("#hrs").val("");
  $("#c_status").val(1);
  $("#what_is_done").val("");
  $("#what_is_pending").val("");
  $("#what_support_required").val("");

  $("#userDataModal").modal("show");
}

function editData(user_data) {
    $(".frm-status").html("");

    $("#userModalLabel").html("Edit Log ");

    // $("#ticket_id").val(user_data.ticket_id);

    $("#c_status option").filter(function() {return this.text == user_data.c_type_name ;}).attr('selected', true);
    $("#dates").val(user_data.dates);
    $("#hrs").val(user_data.hrs);
    $("#what_is_done").val(user_data.what_is_done);
    $("#what_is_pending").val(user_data.what_is_pending);
    $("#what_support_required").val(user_data.what_support_required);

    $('#editID').val(user_data.id);
    $("#userDataModal").modal("show");
}

function submitUserData() {
  $(".frm-status").html("");
  let input_data_arr = [
    document.getElementById("ticket_id").value,
    document.getElementById("ticket").value,

    document.getElementById("dates").value,
    document.getElementById("hrs").value,
    document.querySelector('select[name="c_status"]').value,
    
    document.getElementById("what_is_done").value,
    document.getElementById("what_is_pending").value,
    document.getElementById("what_support_required").value,

    document.getElementById('editID').value,
  ];

  fetch("controller/log_eventHandler.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      request_type: "addEdit",
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
