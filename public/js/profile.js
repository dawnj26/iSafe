let userPosts = $("#user-posts");

/*
 * TODO:
 * enable comment
 * enable like
 * clickable user name to go to profile
 */

$(function () {
  let reactBtn = $(".like-btn");
  let commentBtn = $(".comment-btn");
  let closeComment = $("#close-comment-modal");
  let commentModal = $("#comment-modal");
  let input_post_id = $("#post_id");

  commentBtn.on("click", function () {
    let postId = $(this).parent().children(".like-btn").data("post-id");
    commentModal.addClass("grid").removeClass("hidden");
    input_post_id.val(postId);

    $("#comments").html("");
    setTimeout(() => getComments1($("#current_user").val()), 50);
  });

  closeComment.on("click", function () {
    commentModal.addClass("hidden").removeClass("grid");
    input_post_id.val("");
  });

  reactBtn.on("click", function () {
    let btn = $(this);
    let postId = btn.data("post-id");
    let userId = $("#current_user").val();
    let icon = btn.find("svg");
    let isLiked = btn.hasClass("checked") ? 1 : 0;

    console.log(postId, userId, isLiked);

    $.ajax({
      url: "../../src/post/react-post.php",
      method: "POST",
      data: {
        post_id: postId,
        user_id: userId,
        is_liked: isLiked,
      },
      success: function (response) {
        if (response !== "SUCCESS") {
          alert(response);
          return;
        }
        isLiked = isLiked === 0 ? 1 : 0;
        if (isLiked) {
          btn.addClass("checked");
          icon.addClass("fill-brand-500").removeClass("fill-brand-200");
        } else {
          btn.removeClass("checked");
          icon.addClass("fill-brand-200").removeClass("fill-brand-500");
        }
      },
    });
  });
});

function getComments1(current_user) {
  let postId = $("#post_id").val();

  $.ajax({
    url: "../../src/comment/get_comment.php",
    method: "POST",
    data: {
      post_id: postId,
    },
    success: function (response) {
      let data = JSON.parse(response);

      if (data.length === 0) {
        return;
      }

      data.forEach((item) => {
        let fullName = item.first_name + " " + item.last_name;
        console.log(current_user, item.user_id);
        if (current_user === item.user_id) {
          fullName = "You";
        }
        let commentComponent = `
            <div class='grid grid-cols-[auto_1fr] w-full gap-2'>
              <div class="avatar">
                <img src='https://ui-avatars.com/api/?name=${item.first_name}+${item.last_name}&size=40&rounded=true&color=7F56D9&background=F9F5FF' alt=''>
              </div>
              <div class='min-w-fit flex flex-col mr-4'>
                <div class='flex items-center justify-between mb-2'>
                  <p class='text-xs text-gray-700 font-medium mr-2'>${fullName}</p>
                  <p class='text-xs text-gray-700'>${item.date}</p>
                </div>
                <div class='bg-brand-500 text-white text-sm rounded-lg px-4 py-2 flex items-center gap-2'>
                  ${item.comment}
                </div>
              </div>
            </div>
`;
        $("#comments").prepend(commentComponent);
      });
    },
  });
}
