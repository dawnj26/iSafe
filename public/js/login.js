let loginForm = $('#login-form')
let input_ID = $('#id')
let input_pwd = $('#password')
$(function () {
    let isValid = true;

    input_ID.on('input', function () {
        if ($(this).val().length !== 10) {
            displayErr('ID must be 10 characters long', 'id')
            isValid = false
        } else {
            input_ID.addClass('border-gray-300').removeClass('border-error-600')
            $('#id-msg').text('')
            isValid = true
        }
    })

    loginForm.on('submit', function (e) {
        e.preventDefault();

        if (input_ID.val() === "") {
            displayErr('ID must not be empty', 'id')
            isValid = false
        } else {
            $('#id-msg').text('')
            isValid = true
        }

        if (input_pwd.val() === "") {
            displayErr('ID must not be empty', 'pwd')
            isValid = false
        } else {
            $('#pwd-msg').text('')
            isValid = true
        }

        if(!isValid) return

        $.ajax({
            url: "../src/login-reg/auth.php",
            method: "POST",
            data: {
                id: input_ID.val(),
                password: input_pwd.val()
            },
            success: function (response) {
                let client = ["student", "employee"]
                let counselor = "counselor"
                let admin = "admin"

                if (client.includes(response)) {
                    location.href = "client/dashboard-new.php"
                    return
                }

                if (response === counselor) {
                    location.href = "counselor/chat.php"
                    return
                }

                if (response === admin) {
                    return
                }

                if(response.includes("password")) {
                    displayErr(response, "pwd")
                    return
                }
                displayErr(response, "id")
            }
        })
    })
})

function displayErr(errMsg, type) {
    if (type === 'id') {
        $('#id-msg').text(errMsg)
        input_ID.removeClass('border-gray-300').addClass('border-error-600')
    }
    if (type === 'pwd') {
        $('#pwd-msg').text(errMsg)
        input_pwd.removeClass('border-gray-300').addClass('border-error-600')
    }
}