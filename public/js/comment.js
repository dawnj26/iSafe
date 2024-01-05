let commentForm = $('#send-comment')
let sendBtn = $('#send-comment-btn')
let postId = $('#post_id')

$(document).ready(function() {

  commentForm.on('submit', function(e) {
    e.preventDefault()

    let currentUser = $('#current_user')
    let comment = $('#comment')

    if (comment.val() === "" || postId.val() === "") {
      alert('Please enter a comment')
      return
    }

    $.ajax({
      url: "../../src/comment/send_comment.php",
      method: "POST",
      data: {
        user_id: currentUser.val(),
        comment: comment.val(),
        post_id: postId.val()
      },
      success: function(response) {
        if (response !== "SUCCESS") {
          alert(response)
          return
        }
        comment.val("")
        commentForm.trigger('reset')
        getComments()
      }
    })

  })

})

function getComments() {
  let postId = $('#post_id').val()
  $('#comments').html('')

  $.ajax({
    url: "../../src/comment/get_comment.php",
    method: "POST",
    data: {
      post_id: postId
    },
    success: function(response) {
      let data = JSON.parse(response)

      if (data.length === 0) {
        return
      }

      data.forEach((item) => {
        let fullName = item.first_name + " " + item.last_name
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
`
        $('#comments').prepend(commentComponent)
      })
    }
  })
}
