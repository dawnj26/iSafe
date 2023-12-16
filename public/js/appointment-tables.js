let appointmentTable = $('#appointment-table')
let filters = $('input[type="radio"]')
let cancel = $('.cancel')
let tBody = $('tbody')
$(function () {

    let table = appointmentTable.DataTable({
        pageLength: 3,
        select: true
    })

    getAppointments()
    filters.on('change', function () {
        $.ajax({
            url: "../../src/appointment/get_appointments.php",
            method: "POST",
            data: {
                filter: $(this).val()
            },
            success: function (response) {
                if (response === "") {
                    $('tbody').html("")
                    return
                }
                tBody.html(response)
            }
        })
        table.draw();
    })

    $('.delete').click()
})

function getAppointments() {
    $.ajax({
        url: "../../src/appointment/get_appointments.php",
        method: "POST",
        data: {
            filter: 'all'
        },
        success: function (response) {
            if (response === "") {
                tBody.html("")
                return
            }
            tBody.html(response)
        }
    })
}

function deleteAppointment(id) {
    console.log("clik")
    if (!confirm("You want to cancel this appointment?")) {
        return
    }
    $.ajax({
        url: "../../src/appointment/delete_appointment.php",
        method: "POST",
        data: {
            id: id
        },
        success: function (response) {
            if (response === "SUCCESS") {
                getAppointments()
            } else {
                alert(response)
            }
        }
    })
}