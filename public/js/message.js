$(function () {
    $('#open-msg').on('click', function () {
        $('#message-modal').removeClass('hidden').addClass('grid')
        let data;
        $.ajax({
            url: "../../src/new_message.php",
            success: function (response) {
                data = JSON.parse(response);
            }
        })

        $('#search').on('input', function () {
            let searchTxt = $(this).val().toLowerCase();

            if (searchTxt === "") {
                $('#users').html("");
                return;
            }

            let result = data.filter((item) => {
                let name = item.full_name.toLowerCase()
                return name.includes(searchTxt)
            })
            let users = "";

            result.forEach((item) => {
                users += `<div class='msg-card flex gap-2 items-center hover:bg-gray-100 rounded-lg px-4 py-2' data-id=${item.user_id}>
                            <div CLASS='avatar rounded-full bg-gray-200 text-brand-600 font-medium w-max p-2'>
                                <p class=''>${item.initials}</p>
                            </div>
                            <div class='name'>
                                <p class='text-sm font-medium'>${item.full_name}</p>
                            </div>
                        </div>`
            })

            $('#users').html(users);
        })
    })
    $('#close-msg').on('click', function () {
        $('#message-modal').removeClass('grid').addClass('hidden')
    })
})