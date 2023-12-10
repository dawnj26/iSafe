let temp;
$(function () {

    // load all messaged users
    $.ajax({
        url: "../../src/load_msg_user.php",
        success: function (response) {
            let msg_usrs = JSON.parse(response);

            let msg_usrs_html = ""
            let i = 0
            msg_usrs.forEach((item) => {
                msg_usrs_html += `
                         <div class='msg-card flex gap-2 items-center hover:bg-gray-100 rounded-lg px-4 py-2' data-id='${item.user_id}' data-index='${i++}'>
                            <div  CLASS='avatar rounded-full bg-gray-200 text-brand-600 font-medium w-max p-2'>
                                <p class=''>${item.initials}</p>
                            </div>
                            <div class='' id='receiver-usr'>
                                <p class='text-sm font-medium name'>${item.full_name}</p>
                                <p id='msg-content' class='text-xs text-gray-600'>${item.message}</p>
                            </div>
                        </div>
                        `
            })
            $('#messages').html(msg_usrs_html)

            $('.msg-card').on('click', function () {
                $('.msg-card').removeClass('bg-gray-100')
                $(this).addClass('bg-gray-100')
                load_messages($(this).data('id'), true)

                if(temp !== undefined) {
                    clearInterval(temp)
                    temp = setInterval(() => load_messages($(this).data('id'), false), 1000)
                } else {
                    temp = setInterval(() => load_messages($(this).data('id'), false), 1000)
                }


                set_user_details(+$(this).data('index'), msg_usrs)
            })
        }
    })




    // Create new message
    $('#open-msg').on('click', function () {
        let users = $('#users')

        //get all current users
        $('#message-modal').removeClass('hidden').addClass('grid')
        let data;
        $.ajax({
            url: "../../src/new_message.php",
            success: function (response) {
                data = JSON.parse(response);
            }
        })

        // search user
        $('#search').on('input', function () {
            let searchTxt = $(this).val().toLowerCase();

            if (searchTxt === "") {
                users.html("");
                return;
            }

            let result = data.filter((item) => {
                let name = item.full_name.toLowerCase()
                return name.includes(searchTxt)
            })
            let userList = "";
            let i = 0;
            result.forEach((item) => {
                userList += `<div class='usr-card flex gap-2 items-center hover:bg-gray-100 rounded-lg px-4 py-2' data-id=${item.user_id} data-index='${i++}'>
                            <div CLASS='avatar rounded-full bg-gray-200 text-brand-600 font-medium w-max p-2'>
                                <p class=''>${item.initials}</p>
                            </div>
                            <div class='name'>
                                <p class='text-sm font-medium'>${item.full_name}</p>
                            </div>
                        </div>`
            })

            users.html(userList);

            // create new message
            $('.usr-card').on('click', function (e) {
                let index = +$(this).data('index')
                let usr = `
                                <div class='msg-card flex gap-2 items-center bg-gray-100 rounded-lg px-4 py-2' data-id=''>
                                    <div  CLASS='avatar rounded-full bg-gray-200 text-brand-600 font-medium w-max p-2'>
                                        <p class=''>${result[index].initials}</p>
                                    </div>
                                    <div class=''>
                                    <p class='text-sm font-medium'>${result[index].full_name}</p>
                                    </div>
                                </div>
                                 `
                $('.msg-card').each(function () {
                    let name = $(this).find('#receiver-usr .name').text()
                    if (result[index].full_name === name) {
                        let selected = $(this)
                        usr = "";
                        selected.addClass('bg-gray-100')
                        load_messages(selected.data('id'), true)
                        
                        if(temp !== undefined) {
                            clearInterval(temp)
                            temp = setInterval(() => load_messages($(this).data('id'), false), 1000)
                        } else {
                            temp = setInterval(() => load_messages($(this).data('id'), false), 1000)
                        }

                    }

                })

                $('#messages').prepend(usr)


                set_user_details(index, result)



                $('#message-modal').removeClass('grid').addClass('hidden')
            })
        })
    })

    // sending messages
    $('#send-message').on('submit', function (e) {
        e.preventDefault();
        if($('#send-message input').val() === "") {
            return;
        }
        
        $.ajax({
            url: '../../src/send_message.php',
            data: $(this).serialize(),
            method: 'POST',
            success: function (response) {
                // load messages after sending
                $('#message').val("")
                load_messages($('#id').val(),true)
            }
        })
    })

    // close msg modal
    $('#close-msg').on('click', function () {
        $('#message-modal').removeClass('grid').addClass('hidden')
    })

})

function load_messages(receiver, click) {
    console.log(receiver)
    $.ajax({
        url: "../../src/load_messages.php",
        method: "POST",
        data: {
            receiver: receiver
        },
        success: function (response) {
            $('#msg-list').html(response)
            if (click) {
                const scroll = $('#scrollable')
                scroll.scrollTop(scroll.prop('scrollHeight'))
            }
        }
    })

}

function set_user_details(i, array) {

    $('#user').text(array[i].full_name)
    $('#user-details').text(array[i].full_name)
    $('#initials').text(array[i].initials)
    $('#user-id').text(array[i].user_id)
    $('#id').val(array[i].user_id)

    $.ajax({
        url: "../../src/get_user_info.php",
        method: "POST",
        data: {
            id: array[i].user_id,
            role: array[i].user_role,
        },
        success: function (response) {
            let result = JSON.parse(response)
            $('#user-gender').html(result.gender)
            $('#user-bday').html(result.birth_date)
        }
    })
}