let violenceEl = $('#violence')
let descEl = $('#description')
let dateEl = $('#date-of-event')
let timeEl = $('#time-of-event')
let counselorEl = $('#counselor')
let dateAppointment = $('#date-of-appointment')
let timeAppointment = $('#time-of-appointment')
let appointmentForm = $('#appointment')
let longitudeEl = $('#longitude')
let latitudeEl = $('#latitude')
$(function () {

    dateEl.datepicker({})
    dateAppointment.datepicker({})
    dateAppointment.prop('disabled', true)
    timeAppointment.prop('disabled', true)

    counselorEl.on('change', function () {
        if ($(this).val() === "") {
            dateAppointment.prop('disabled', true)
            timeAppointment.prop('disabled', true)
            return
        }

        $.ajax({
            type: 'POST',
            url: '../../src/appointment/get_counselor_sched.php',
            data: {
                'counselor_id': $(this).val()
            },
            success: function (response) {
                let result = JSON.parse(response)
                let day_of_week = {
                    'Sunday': 0,
                    'Monday': 1,
                    'Tuesday': 2,
                    'Wednesday': 3,
                    'Thursday': 4,
                    'Friday': 5,
                    'Saturday': 6
                }
                let availableDays = result.map(function (day) {
                    return day_of_week[day]
                })
                function disableDays(date) {
                    let day = date.getDay();
                    return [availableDays.indexOf(day) !== -1, ''];
                }
                dateAppointment.datepicker('option', 'beforeShowDay', disableDays)
                dateAppointment.datepicker('option', 'minDate', 0)
                dateAppointment.prop('disabled', false)
            }
        })
    })

    dateAppointment.on('change', function () {
        $.ajax({
            type: 'POST',
            url: '../../src/appointment/get_available_time.php',
            data: {
                date: dateAppointment.val(),
            },
            success: function (response) {
                timeAppointment.prop('disabled', false)
                timeAppointment.html("<option value=''>Select time</option>")
                let result = JSON.parse(response)
                result.forEach(function (time) {
                    let time12hr = convertTo12HourFormat(time)
                    timeAppointment.append(`<option value="${time}">${time12hr}</option>`)
                })
            }
        })
    })
    appointmentForm.on('submit', function (e) {
        e.preventDefault()
        let errors = 0


        $('.input').each(function () {

            if ($(this).val() === '') {
                $(this).parent().find('.error-msg').removeClass('hidden')
                $(this).removeClass('border-gray-400').addClass('border-error-600')
                errors++
            } else {
                $(this).parent().find('.error-msg').addClass('hidden')
                $(this).removeClass('border-error-600').addClass('border-gray-400')
                if (errors > 0) {
                    errors--
                }
            }

        })
        console.log(errors)

        if (errors !== 0) {
            return
        }
        let formData = {
            violence: violenceEl.val(),
            description: descEl.val(),
            dateOfEvent: dateEl.val(),
            timeOfEvent: timeEl.val(),
            counselor: counselorEl.val(),
            dateOfAppointment: dateAppointment.val(),
            timeOfAppointment: timeAppointment.val(),
            latitude: latitudeEl.val(),
            longitude: longitudeEl.val()
        }
        $.ajax({
            type: 'POST',
            url: '../../src/appointment/create_appointment.php',
            data: formData,
            success: function (response) {
                console.log(response)
                let msg = $('#msg')
                let success = msg.html()
                let err = `
                        Something went wrong
                        <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_296_882)">
                                <path d="M10.0002 6.0699L6.00016 10.0699M6.00016 6.0699L10.0002 10.0699M14.6668 8.0699C14.6668 11.7518 11.6821 14.7366 8.00016 14.7366C4.31826 14.7366 1.3335 11.7518 1.3335 8.0699C1.3335 4.388 4.31826 1.40323 8.00016 1.40323C11.6821 1.40323 14.6668 4.388 14.6668 8.0699Z" stroke="#D92D20" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </g>
                            <defs>
                                <clipPath id="clip0_296_882">
                                <rect width="16" height="16" fill="white" transform="translate(0 0.0698853)"/>
                                </clipPath>
                            </defs>
                        </svg>
                `
                msg.removeClass('opacity-0')

                if (response !== "SUCCESS") {
                    msg.text('Something went wrong')
                    msg.removeClass('text-success-600').addClass('text-error-600')
                    msg.html(err)
                    return
                }
                msg.html(success)
                resetForm()
            }
        })
    })
})

function resetForm() {
    appointmentForm.find('input, textarea').val('')
    appointmentForm.find('select').prop('selectedIndex', 0)
}

function convertTo12HourFormat(time24) {
    const [hours, minutes] = time24.split(':');
    const dateObj = new Date();
    dateObj.setHours(hours);
    dateObj.setMinutes(minutes);

    const formattedTime = dateObj.toLocaleTimeString('en-US', {
        hour: 'numeric',
        minute: 'numeric',
        hour12: true,
    });

    dateObj.setHours(dateObj.getHours() + 1);
    const nextHour = dateObj.toLocaleTimeString('en-US', {
        hour: 'numeric',
        minute: 'numeric',
        hour12: true,
    });

    return `${formattedTime} to ${nextHour}`;
}