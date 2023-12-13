const regForm = $('#reg-form')
const input_ID = $('#id')
const input_email = $('#email')
const input_pwd = $('#password')
const input_repwd = $('#retype-password')
let isValid = true;
$(function () {


    input_pwd.on('input', function () {
        // Get the entered password value
        let password = $(this).val();

        // Regular expressions to check for password requirements
        let regexUpperCase = /[A-Z]/;
        let regexLowerCase = /[a-z]/;
        let regexNumber = /[0-9]/;
        let regexSpecialChar = /[!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?]/;

        // Check if the password meets all the criteria
        let isLengthValid = password.length >= 8;
        let hasUpperCase = regexUpperCase.test(password);
        let hasLowerCase = regexLowerCase.test(password);
        let hasNumber = regexNumber.test(password);
        let hasSpecialChar = regexSpecialChar.test(password);

        // Display validation message based on criteria
        if (!(isLengthValid && hasUpperCase && hasLowerCase && hasNumber && hasSpecialChar)) {
            displayErr("8 characters including 1 uppercase, lowercase, number, and special character", "pwd")
            return;
        }
        valid("pwd")
    })

    input_repwd.on('input', function () {
        if(input_pwd.val() !== $(this).val()) {
            displayErr("Password does not match", "repwd");
            return;
        }
        valid("repws")
    })

    input_email.on('input', function () {
        let email = $(this).val();

        // Regular expression for basic email format validation
        let regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        // Check if the email matches the basic format
        let isValidEmail = regexEmail.test(email);

        // Display validation message based on criteria
        if (!isValidEmail) {
            displayErr("Invalid email address", "email");
            return
        }

        valid("email")
    })

    input_ID.on('input', function () {
        if ($(this).val().length !== 10) {
            displayErr('ID must be 10 characters long', 'id')
        } else {
            valid("id")
        }
    })

    regForm.on('submit', function (e) {
        e.preventDefault();

        if (input_ID.val() === "") {
            displayErr('ID must not be empty', 'id')
        } else {
            valid("id")
        }

        if (input_pwd.val() === "") {
            displayErr('Password must not be empty', 'pwd')
        } else {
            valid("pwd")
        }

        if (input_email.val() === "") {
            displayErr('Email must not be empty', 'email')
        } else {
            valid("email")
        }

        if (input_repwd.val() !== input_pwd.val()) {
            displayErr('Password does not match', 'repwd')
        } else {
            valid("repwd")
        }

        if(!isValid) return

        $.ajax({
            url: "../src/login-reg/registration.php",
            method: "POST",
            data: regForm.serialize(),
            success: function (response) {
                if (response === "SUCCESS") {
                    alert(response)
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

    if (type === 'email') {
        $('#email-msg').text(errMsg)
        input_email.removeClass('border-gray-300').addClass('border-error-600')
    }

    if (type === 'repwd') {
        $('#repwd-msg').text(errMsg)
        input_repwd.removeClass('border-gray-300').addClass('border-error-600')
    }

    isValid = false;
}

function valid(type) {
    if (type === 'id') {
        $('#id-msg').text('')
        input_ID.addClass('border-gray-300').removeClass('border-error-600')
    }
    if (type === 'pwd') {
        $('#pwd-msg').text('')
        input_pwd.addClass('border-gray-300').removeClass('border-error-600')
    }

    if (type === 'email') {
        $('#email-msg').text('')
        input_email.addClass('border-gray-300').removeClass('border-error-600')
    }

    if (type === 'repwd') {
        $('#repwd-msg').text('')
        input_repwd.addClass('border-gray-300').removeClass('border-error-600')
    }
    isValid = true;
}