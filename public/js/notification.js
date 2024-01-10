$(function () {
  let notifContainer = $("#notification-container");
  $.get("../../src/notification/get_notif.php", function (data, status) {
    if (status !== "success") {
      console.log("Something went wrong");
      return;
    }

    let notif = JSON.parse(data);
    console.log(notif);

    if (notif.length === 0) {
      return;
    }
    let count = 0;

    for (let i in notif) {
      if (notif[i].is_read !== "0") {
        continue;
      }

      let msgNotif = `
          <div class="flex items-center justify-between bg-brand-100 p-4 rounded-xl">
            <div class="flex gap-4 items-center">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M21 15C21 15.5304 20.7893 16.0391 20.4142 16.4142C20.0391 16.7893 19.5304 17 19 17H7L3 21V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H19C19.5304 3 20.0391 3.21071 20.4142 3.58579C20.7893 3.96086 21 4.46957 21 5V15Z" stroke="#344054" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
              <div>
                <p class="text-sm font-semibold">${
        notif[i].full_name
      } messaged you</p>
                <p class="text-xs text-gray-600">${notif[i].date} | ${
        notif[i].time
      }</p>
              </div>
            </div>
            <a href='chat.php?id=${notif[i].user_id}'>
              <button type="button" class="p-2 rounded-lg bg-brand-600">

                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M10 8.5V4.5L3 11.5L10 18.5V14.4C15 14.4 18.5 16 21 19.5C20 14.5 17 9.5 10 8.5Z" fill="white"/>
                </svg>
              </button>
            </a>
          </div>
`;
      if (notif[i].call) {
        let callNotif = `
              <div class="flex justify-between bg-brand-100 p-4 rounded-xl">
                <div class="flex gap-4 items-center">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16 2V6M8 2V6M3 10H21M5 4H19C20.1046 4 21 4.89543 21 6V20C21 21.1046 20.1046 22 19 22H5C3.89543 22 3 21.1046 3 20V6C3 4.89543 3.89543 4 5 4Z" stroke="#344054" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  <div>
                    <p class="text-sm font-semibold">${notif[i].full_name} started a meeting</p>
                    <p class="text-xs text-gray-600">${notif[i].date} | ${notif[i].time}</p>
                  </div>
                </div>
                <a href='${notif[i].call}'>
                  <button type="button" class="text-white text-sm font-medium bg-brand-600 h-min py-2 px-4 rounded-xl hover:bg-brand-700">
                    Join
                  </button>
                </a>
              </div>
`;
        notifContainer.prepend(callNotif);
      }
      notifContainer.append(msgNotif);
      count++;
    }
    if (count === 0) {
      notifContainer.html(
        "<p class='text-center text-gray-600'>No new notification</p>",
      );
    }
  });
});
