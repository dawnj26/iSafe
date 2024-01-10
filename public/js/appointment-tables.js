let appointmentTable = $("#appointment-table");
let filters = $('input[type="radio"]');
let cancel = $(".cancel");
let tBody = $("tbody");
$(function () {
  $.get("../../src/appointment/check_appointment.php", function (data, status) {
    if (status !== "success") {
      console.log(response);
      return;
    }
    console.log(status);

    let table = appointmentTable.DataTable({
      pageLength: 3,
      select: true,
    });

    getAppointments();
    filters.on("change", function () {
      table.draw();
      $.ajax({
        url: "../../src/appointment/get_appointments.php",
        method: "POST",
        data: {
          filter: $(this).val(),
        },
        success: function (response) {
          if (response === "") {
            $("tbody").html("");
            return;
          }
          tBody.html(response);
        },
      });
    });
  });
});

function getAppointments() {
  let url = "../../src/appointment/get_appointments.php";

  $.ajax({
    url: url,
    method: "POST",
    data: {
      filter: "all",
    },
    success: function (response) {
      if (response === "") {
        tBody.html("");
        return;
      }
      tBody.html(response);
    },
  });
}

function deleteAppointment(id) {
  if (!confirm("You want to cancel this appointment?")) {
    return;
  }
  $.ajax({
    url: "../../src/appointment/delete_appointment.php",
    method: "POST",
    data: {
      id: id,
    },
    success: function (response) {
      if (response === "SUCCESS") {
        getAppointments();
      } else {
        alert(response);
      }
    },
  });
}
