let temp;
let isLoaded = false;
let offset = isLoaded;
$(function () {
  let messages_users = $("#messages");
  function load(id) {
    $.ajax({
      url: "../../src/chat/load_msg_user.php",
      success: function (response) {
        let msg_usrs = JSON.parse(response);

        let msg_usrs_html = "";
        let i = 0;
        console.log(msg_usrs);

        if (messages_users.data("receiver") && !isLoaded) {
          $.ajax({
            url: "../../src/chat/get_user.php",
            method: "POST",
            data: {
              id: messages_users.data("receiver"),
            },
            success: function (response) {
              let result = JSON.parse(response);

              let usr_template = `
                         <div class='msg-card cursor-pointer flex gap-2 items-center bg-gray-100 hover:bg-gray-100 rounded-lg px-4 py-2' data-id='${result.id}' data-index='${i++}'>
                            <div class='avatar rounded-full bg-gray-200 text-brand-600 font-medium w-max p-2'>
                                <p class='uppercase'>${result.first_name[0]}${
                result.last_name[0]
              }</p>
                            </div>
                            <div class='' id='receiver-usr'>
                                <p class='text-sm font-medium name'>${result.first_name} ${result.last_name}</p>
                            </div>
                        </div>
                    `;

              isLoaded = true;
              offset = isLoaded;

              msg_usrs.forEach((item) => {
                msg_usrs_html += `
                         <div class='msg-card cursor-pointer flex gap-2 items-center hover:bg-gray-100 rounded-lg px-4 py-2' data-id='${item.user_id}' data-index='${i++}'>
                          <div  CLASS='avatar rounded-full bg-gray-200 text-brand-600 font-medium w-max p-2'>
                                <p class=''>${item.initials}</p>
                            </div>
                            <div class='' id='receiver-usr'>
                                <p class='text-sm ${
                  item.is_read === "0" ? "font-medium" : ""
                } name'>${item.full_name}</p>
                                <p id='msg-content' class='text-xs text-gray-600'>${item.message}</p>
                            </div>
                        </div>
                        `;
              });
              messages_users.append(msg_usrs_html);
              let msg_card = $(".msg-card");
              let alreadyExist = false;

              msg_card.each(function () {
                let selected = $(this);
                if (selected.data("id") === messages_users.data("receiver")) {
                  selected.addClass("bg-gray-100");
                  load_messages(selected.data("id"), true);
                  alreadyExist = true;

                  if (temp !== undefined) {
                    clearInterval(temp);
                    temp = setInterval(
                      () => load_messages(selected.data("id"), false),
                      1000,
                    );
                  } else {
                    temp = setInterval(
                      () => load_messages(selected.data("id"), false),
                      1000,
                    );
                  }
                }
              });
              if (!alreadyExist) {
                messages_users.prepend(usr_template);
              }
              set_user_details(0, result);
              addClick(id, msg_usrs);
            },
          });
        } else {
          msg_usrs.forEach((item) => {
            msg_usrs_html += `
                         <div class='msg-card cursor-pointer flex gap-2 items-center hover:bg-gray-100 rounded-lg px-4 py-2' data-id='${item.user_id}' data-index='${i++}'>
                            <div  CLASS='avatar rounded-full bg-gray-200 text-brand-600 font-medium w-max p-2'>
                                <p class=''>${item.initials}</p>
                            </div>
                            <div class='' id='receiver-usr'>
                                <p class='text-sm ${
              item.is_read === "0" ? "font-medium" : ""
            } name'>${item.full_name}</p>
                                <p id='msg-content' class='text-xs text-gray-600'>${item.message}</p>
                            </div>
                        </div>
                        `;
          });
          messages_users.html(msg_usrs_html);
          addClick(id, msg_usrs);
        }

        // if there is a selected user remove the bg of the current and add to next user
        // if (id !== "") {
        //   $(".msg-card").removeClass("bg-gray-100");
        //   $("[data-id=" + id + "]").addClass("bg-gray-100");
        //   load_messages(id, true);
        //
        //   if (temp !== undefined) {
        //     clearInterval(temp);
        //     temp = setInterval(() => load_messages(id, false), 1000);
        //   } else {
        //     temp = setInterval(() => load_messages(id, false), 1000);
        //   }
        //
        //   set_user_details(+$("[data-id=" + id + "]").data("index"), msg_usrs);
        // }
        //
        // $(".msg-card").on("click", function () {
        //   $(".msg-card").removeClass("bg-gray-100");
        //   $(this).addClass("bg-gray-100");
        //   load_messages($(this).data("id"), true);
        //   $("#call-btn").removeAttr("disabled");
        //   if (temp !== undefined) {
        //     clearInterval(temp);
        //     temp = setInterval(
        //       () => load_messages($(this).data("id"), false),
        //       1000,
        //     );
        //   } else {
        //     temp = setInterval(
        //       () => load_messages($(this).data("id"), false),
        //       1000,
        //     );
        //   }
        //
        //   set_user_details(+$(this).data("index"), msg_usrs);
        // });
      },
    });
  }

  // load all messaged users
  load("");

  // Create new message
  $("#open-new-msg").on("click", function () {
    let users = $("#users");

    //get all current users
    $("#message-modal").removeClass("hidden").addClass("grid");
    let data;
    $.ajax({
      url: "../../src/chat/new_message.php",
      success: function (response) {
        data = JSON.parse(response);
      },
    });

    // search user to message
    $("#search").on("input", function () {
      let searchTxt = $(this).val().toLowerCase();

      if (searchTxt === "") {
        users.html("");
        return;
      }

      // get all matching names
      let result = data.filter((item) => {
        let name = item.full_name.toLowerCase();
        return name.includes(searchTxt);
      });
      let userList = "";
      let i = 0;
      result.forEach((item) => {
        userList +=
          `<div class='usr-card flex gap-2 items-center hover:bg-gray-100 rounded-lg px-4 py-2' data-id=${item.user_id} data-index='${i++}'>
                            <div CLASS='avatar rounded-full bg-gray-200 text-brand-600 font-medium w-max p-2'>
                                <p class=''>${item.initials}</p>
                            </div>
                            <div class='name'>
                                <p class='text-sm font-medium'>${item.full_name}</p>
                            </div>
                        </div>`;
      });

      // display the users
      users.html(userList);

      // create new message
      $(".usr-card").on("click", function (e) {
        let index = +$(this).data("index");
        let msg_card = $(".msg-card");
        let usr = `
                                <div class='msg-card flex gap-2 items-center bg-gray-100 rounded-lg px-4 py-2' data-id=''>
                                    <div  CLASS='avatar rounded-full bg-gray-200 text-brand-600 font-medium w-max p-2'>
                                        <p class=''>${
          result[index].initials
        }</p>
                                    </div>
                                    <div class=''>
                                    <p class='text-sm font-medium'>${
          result[index].full_name
        }</p>
                                    </div>
                                </div>
                                 `;

        msg_card.removeClass("bg-gray-100");

        // if messages already exists do not prepend
        msg_card.each(function () {
          let selected = $(this);
          let name = selected.find("#receiver-usr .name").text();
          if (result[index].full_name === name) {
            usr = "";
            selected.addClass("bg-gray-100");
            load_messages(selected.data("id"), true);

            if (temp !== undefined) {
              clearInterval(temp);
              temp = setInterval(
                () => load_messages($(this).data("id"), false),
                1000,
              );
            } else {
              temp = setInterval(
                () => load_messages($(this).data("id"), false),
                1000,
              );
            }
            return;
          }
          if (temp !== undefined) {
            clearInterval(temp);
          }
          $("#msg-list").html("");
        });

        $("#messages").prepend(usr);

        set_user_details(index, result);

        $("#message-modal").removeClass("grid").addClass("hidden");
      });
    });
  });

  // sending messages
  $("#send-message").on("submit", function (e) {
    e.preventDefault();
    if ($("#send-message input").val() === "") {
      return;
    }

    $.ajax({
      url: "../../src/chat/send_message.php",
      data: $(this).serialize(),
      method: "POST",
      success: function (response) {
        let user_id = $("#id");
        if (response !== "") {
          alert(response);
          return;
        }
        $("#message").val("");
        // load messages after sending
        load_messages(user_id.val(), true);

        // start live chat
        if (temp !== undefined) {
          clearInterval(temp);
          temp = setInterval(() => load_messages(user_id.val(), false), 1000);
        } else {
          temp = setInterval(() => load_messages(user_id.val(), false), 1000);
        }

        load(user_id.val());
      },
    });
  });

  // close new message modal
  $("#close-msg").on("click", function () {
    $("#message-modal").removeClass("grid").addClass("hidden");
  });
});

/*
 * this function loads messages if the user
 * clicks the chat
 */
function load_messages(receiver, click) {
  $.ajax({
    url: "../../src/chat/load_messages.php",
    method: "POST",
    data: {
      receiver: receiver,
    },
    success: function (response) {
      $("#msg-list").html(response);
      if (click) {
        const scroll = $("#scrollable");
        scroll.scrollTop(scroll.prop("scrollHeight"));
      }
    },
  });
}

/*
 * This function get the information about the user
 * and display it on the message user details
 */
function set_user_details(i, array) {
  let user_id = "";
  let user_role = "";

  if (Object.keys(array).length > 4) {
    $("#user").text(array.first_name + " " + array.last_name);
    $("#user-details").text(array.first_name + " " + array.last_name);
    $("#initials").text(array.first_name[0] + array.last_name[0]);
    $("#user-id").text(array.id);
    $("#id").val(array.id);
    user_id = array.id;
    user_role = array.role;
  } else {
    if (offset) {
      i--;
      offset = false;
    }
    $("#user").text(array[i].full_name);
    $("#user-details").text(array[i].full_name);
    $("#initials").text(array[i].initials);
    $("#user-id").text(array[i].user_id);
    $("#id").val(array[i].user_id);
    user_id = array[i].user_id;
    user_role = array[i].user_role;
  }

  $.ajax({
    url: "../../src/chat/get_user_info.php",
    method: "POST",
    data: {
      id: user_id,
      role: user_role,
    },
    success: function (response) {
      let result = JSON.parse(response);
      $("#user-gender").html(result.gender);
      $("#user-bday").html(result.birth_date);
    },
  });
}

function logout() {
  $.ajax({
    url: "../../src/login-reg/logout.php",
    success: function (response) {
      if (response === "SUCCESS") {
        location.reload();
      }
    },
  });
}

// start a video call
function call() {
  $.ajax({
    url: "../../src/chat/get_room.php",
    method: "POST",
    data: {
      receiver: $("#id").val(),
    },
    success: function (response) {
      console.log(response);
      let result = JSON.parse(response);
      load_messages($("#id").val(), true);
      if (temp !== undefined) {
        clearInterval(temp);
        temp = setInterval(
          () => load_messages($("#id").val(), false),
          1000,
        );
      } else {
        temp = setInterval(
          () => load_messages($("#id").val(), false),
          1000,
        );
      }
      let newTab = window.open(result[0], "_blank");
      newTab.focus();
    },
  });
}

function addClick(id, msg_usrs) {
  console.log(id);
  if (id !== "") {
    $(".msg-card").removeClass("bg-gray-100");
    $("[data-id=" + id + "]").addClass("bg-gray-100");
    load_messages(id, true);

    if (temp !== undefined) {
      clearInterval(temp);
      temp = setInterval(() => load_messages(id, false), 1000);
    } else {
      temp = setInterval(() => load_messages(id, false), 1000);
    }

    set_user_details(+$("[data-id=" + id + "]").data("index"), msg_usrs);
  }

  $(".msg-card").on("click", function () {
    $(".msg-card").removeClass("bg-gray-100");
    $(this).addClass("bg-gray-100");
    load_messages($(this).data("id"), true);
    $("#call-btn").removeAttr("disabled");
    if (temp !== undefined) {
      clearInterval(temp);
      temp = setInterval(
        () => load_messages($(this).data("id"), false),
        1000,
      );
    } else {
      temp = setInterval(
        () => load_messages($(this).data("id"), false),
        1000,
      );
    }

    set_user_details(+$(this).data("index"), msg_usrs);
  });
}
