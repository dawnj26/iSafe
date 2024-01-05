$(function() {
  getPosts()
  getAppointments()
})


function getPosts() {

  $.ajax({
    url: "../../src/post/get-posts.php",
    method: "POST",
    data: {
      current_user: $('#current_user').val()
    },
    success: function(response) {
      let data = JSON.parse(response)
      let postDiv = $('#posts')


      console.log(data)

      if (data.length === 0) {
        return
      }
      $('#posts').html('')

      const limit = 3
      let count = 0
      for (let i in data) {

        if (count === limit) break

        let fullName = data[i].first_name + ' ' + data[i].last_name

        let isAnonymous = data[i].is_anonymous
        let likeCounter = `
                  <div class='flex items-center gap-2 like-counter'>
                    <svg width='16' height='16' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'>
                      <path d='M23.3041 11.944C23.3041 11.6086 23.2241 11.294 23.0901 11.008C22.1961 8.12398 18.0107 8.33464 12.0574 8.19398C11.0621 8.17064 11.6314 6.99531 11.9807 4.41531C12.2081 2.73731 11.1261 0.160645 9.30741 0.160645C6.30874 0.160645 9.19341 2.52598 6.54207 8.37531C5.12541 11.5006 1.95874 9.74998 1.95874 12.8893V20.0353C1.95874 21.2573 2.07874 22.432 3.79741 22.6253C5.46341 22.8126 5.08874 24 7.49207 24H19.5214C20.1106 23.9993 20.6755 23.7648 21.0921 23.3482C21.5086 22.9315 21.7429 22.3665 21.7434 21.7773C21.7434 21.2693 21.5654 20.8066 21.2781 20.432C21.9581 20.0513 22.4247 19.3326 22.4247 18.4993C22.4247 17.9926 22.2474 17.53 21.9607 17.156C22.6427 16.776 23.1107 16.0566 23.1107 15.222C23.1107 14.616 22.8654 14.0666 22.4701 13.6646C22.7292 13.4587 22.9387 13.1972 23.0831 12.8993C23.2274 12.6015 23.303 12.275 23.3041 11.944Z' fill='#FFDB5E' />
                      <path d='M15.3468 14.1659H21.0828C21.8628 14.1659 22.5948 13.7486 22.9934 13.0773C23.0644 12.9446 23.0814 12.7896 23.0409 12.6446C23.0005 12.4997 22.9056 12.376 22.7761 12.2993C22.6466 12.2226 22.4925 12.1989 22.346 12.233C22.1994 12.2672 22.0717 12.3566 21.9894 12.4826C21.8957 12.6398 21.7629 12.77 21.6039 12.8606C21.4449 12.9511 21.2651 12.9989 21.0821 12.9993H15.2088C14.6268 12.9993 14.1534 12.5259 14.1534 11.9439C14.1534 11.3619 14.6268 10.8886 15.2088 10.8886H19.1334C19.2881 10.8886 19.4365 10.8271 19.5459 10.7177C19.6553 10.6083 19.7168 10.46 19.7168 10.3053C19.7168 10.1505 19.6553 10.0022 19.5459 9.89278C19.4365 9.78338 19.2881 9.72192 19.1334 9.72192H15.2081C14.619 9.72263 14.0542 9.95696 13.6377 10.3735C13.2211 10.7901 12.9868 11.3548 12.9861 11.9439C12.9861 12.6273 13.3028 13.2319 13.7894 13.6399C13.5788 13.846 13.4114 14.0922 13.2972 14.3638C13.1829 14.6355 13.1241 14.9272 13.1241 15.2219C13.1241 15.9073 13.4428 16.5139 13.9321 16.9213C13.701 17.1486 13.5226 17.424 13.4097 17.7279C13.2969 18.0319 13.2521 18.3569 13.2788 18.68C13.3054 19.0031 13.4028 19.3164 13.564 19.5977C13.7251 19.8791 13.9462 20.1215 14.2114 20.3079C13.8475 20.711 13.6452 21.2342 13.6434 21.7773C13.6441 22.3664 13.8785 22.9311 14.295 23.3477C14.7116 23.7642 15.2763 23.9986 15.8654 23.9993H19.5214C19.9068 23.9982 20.2854 23.8975 20.6203 23.7068C20.9552 23.5162 21.2351 23.2421 21.4327 22.9113C21.5081 22.7785 21.5284 22.6214 21.4893 22.4739C21.4501 22.3263 21.3547 22.2 21.2235 22.1219C21.0922 22.0439 20.9356 22.0205 20.7873 22.0566C20.639 22.0928 20.5107 22.1856 20.4301 22.3153C20.3361 22.4725 20.203 22.6028 20.0438 22.6934C19.8846 22.7841 19.7046 22.832 19.5214 22.8326H15.8654C15.2834 22.8326 14.8101 22.3593 14.8101 21.7773C14.8101 21.1953 15.2834 20.7219 15.8654 20.7219H20.2028C20.5882 20.7208 20.9668 20.62 21.3017 20.4292C21.6367 20.2384 21.9165 19.9642 22.1141 19.6333C22.1551 19.5674 22.1825 19.494 22.1948 19.4173C22.207 19.3407 22.2039 19.2624 22.1855 19.187C22.1671 19.1117 22.1339 19.0407 22.0878 18.9783C22.0416 18.9159 21.9835 18.8633 21.9168 18.8237C21.8501 18.7841 21.7762 18.7581 21.6993 18.7474C21.6225 18.7367 21.5443 18.7414 21.4693 18.7613C21.3943 18.7812 21.324 18.8158 21.2625 18.8632C21.2011 18.9106 21.1497 18.9698 21.1114 19.0373C21.0186 19.1956 20.8858 19.3268 20.7263 19.4177C20.5669 19.5086 20.3863 19.5561 20.2028 19.5553H15.4941C15.2221 19.5434 14.9651 19.427 14.7768 19.2303C14.5885 19.0337 14.4834 18.7719 14.4834 18.4996C14.4834 18.2273 14.5885 17.9655 14.7768 17.7688C14.9651 17.5722 15.2221 17.4558 15.4941 17.4439H20.8881C21.2735 17.4429 21.652 17.3422 21.987 17.1515C22.3219 16.9609 22.6018 16.6868 22.7994 16.3559C22.8748 16.2231 22.895 16.0661 22.8559 15.9185C22.8168 15.771 22.7214 15.6446 22.5901 15.5666C22.4589 15.4886 22.3023 15.4652 22.154 15.5013C22.0056 15.5374 21.8774 15.6303 21.7968 15.7599C21.7038 15.9181 21.5709 16.0491 21.4115 16.1399C21.252 16.2307 21.0716 16.2781 20.8881 16.2773H15.3468C15.0747 16.2654 14.8178 16.149 14.6295 15.9523C14.4412 15.7557 14.336 15.4939 14.336 15.2216C14.336 14.9493 14.4412 14.6875 14.6295 14.4908C14.8178 14.2942 15.0747 14.1778 15.3468 14.1659Z' fill='#EE9547' />
                    </svg>
                    <span class='text-sm num_likes'>${data[i].likes}</span>
                  </div>
`
        let commentCounter = `
                  <div class='flex items-center gap-2 comment-counter'>
                    <svg width='16' height='16' viewBox='0 0 24 24' fill='#475467' xmlns='http://www.w3.org/2000/svg'>
                      <path d='M21 11.5C21.0034 12.8199 20.6951 14.1219 20.1 15.3C19.3944 16.7118 18.3098 17.8992 16.9674 18.7293C15.6251 19.5594 14.0782 19.9994 12.5 20C11.1801 20.0035 9.87812 19.6951 8.7 19.1L3 21L4.9 15.3C4.30493 14.1219 3.99656 12.8199 4 11.5C4.00061 9.92179 4.44061 8.37488 5.27072 7.03258C6.10083 5.69028 7.28825 4.6056 8.7 3.90003C9.87812 3.30496 11.1801 2.99659 12.5 3.00003H13C15.0843 3.11502 17.053 3.99479 18.5291 5.47089C20.0052 6.94699 20.885 8.91568 21 11V11.5Z' stroke='#475467' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' />
                    </svg>
                    <span class='text-sm num_comments'>${data[i].comments}</span>
                  </div>
`
        let counter = `
                <div class='mt-2 flex justify-between items-center'>
                  <!-- Number of likes -->
                    ${data[i].likes === 0 ? '<div></div>' : likeCounter}
                    ${data[i].comments === 0 ? '<div></div>' : commentCounter}
                  <!-- Number of comments -->
                </div>
`
        let postWithoutImage = `
            <!-- Post -->
            <div class='bg-brand-200 rounded-lg w-full h-full px-4 pt-4 pb-0' data-id=''>
              <!-- Post header -->
              <div class='post-header flex items-center justify-between mb-6' data-id=''>
                <div class='profile flex items-center gap-2'>
                  <img src='https://ui-avatars.com/api/?name=${isAnonymous ? 'Anonymous' : data[i].first_name}+${isAnonymous ? 'user' : data[i].last_name}&size=48&rounded=true&color=7F56D9&background=F9F5FF' alt=''>
                  <div class='profile-details'>
                    <a class='' href='./profile.php?user_id=${data[i].poster_id}'><p class='text-sm font-medium hover:underline'>${isAnonymous ? 'Anonymous user' : fullName}</p></a>
                    <p class='text-sm text-gray-500'><span class='capitalize'>${isAnonymous ? 'Secret' : data[i].user_role}</span> | ${data[i].date_posted}</p>
                  </div>
                </div>
                <button type='button'>
                  <svg width='24' height='25' viewBox='0 0 24 25' fill='none' xmlns='http://www.w3.org/2000/svg'>
                    <path d='M18 6.5L6 18.5M6 6.5L18 18.5' stroke='#101828' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' />
                  </svg>
                </button>
              </div>

              <div class='post-content mb-2'>
                <p class='text-sm mb-4'>
                  ${data[i].post_text}
                </p>
                ${data[i].likes === 0 && data[i].comments === 0 ? '<div></div>' : counter}
              </div>
              <div class='react flex items-center justify-around border-t border-gray-400'>
                <button type='button' class='${data[i].liked ? 'checked' : ''} like-btn flex items-center justify-center px-4 py-2 hover:bg-gray-300 rounded-lg text-sm gap-2 font-medium' data-post-id='${data[i].post_id}' data-user-id='${data[i].poster_id}'>
                  <svg class='${data[i].liked ? 'fill-brand-500' : 'fill-brand-200'}' width='16' height='16' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'>
                    <path d='M7 22H4C3.46957 22 2.96086 21.7893 2.58579 21.4142C2.21071 21.0391 2 20.5304 2 20V13C2 12.4696 2.21071 11.9609 2.58579 11.5858C2.96086 11.2107 3.46957 11 4 11H7M14 9V5C14 4.20435 13.6839 3.44129 13.1213 2.87868C12.5587 2.31607 11.7956 2 11 2L7 11V22H18.28C18.7623 22.0055 19.2304 21.8364 19.5979 21.524C19.9654 21.2116 20.2077 20.7769 20.28 20.3L21.66 11.3C21.7035 11.0134 21.6842 10.7207 21.6033 10.4423C21.5225 10.1638 21.3821 9.90629 21.1919 9.68751C21.0016 9.46873 20.7661 9.29393 20.5016 9.17522C20.2371 9.0565 19.9499 8.99672 19.66 9H14Z' stroke='#475467' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' />
                  </svg>

                  Like
                </button>
                <button type='button' class='comment-btn flex items-center justify-center px-4 py-2 hover:bg-gray-300 rounded-lg text-sm gap-2 font-medium'>
                  <svg width='16' height='16' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'>
                    <path d='M21 11.5C21.0034 12.8199 20.6951 14.1219 20.1 15.3C19.3944 16.7118 18.3098 17.8992 16.9674 18.7293C15.6251 19.5594 14.0782 19.9994 12.5 20C11.1801 20.0035 9.87812 19.6951 8.7 19.1L3 21L4.9 15.3C4.30493 14.1219 3.99656 12.8199 4 11.5C4.00061 9.92179 4.44061 8.37488 5.27072 7.03258C6.10083 5.69028 7.28825 4.6056 8.7 3.90003C9.87812 3.30496 11.1801 2.99659 12.5 3.00003H13C15.0843 3.11502 17.053 3.99479 18.5291 5.47089C20.0052 6.94699 20.885 8.91568 21 11V11.5Z' stroke='#475467' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' />
                  </svg>

                  Comment
                </button>
              </div>

            </div>
          </div>
          `

        postDiv.prepend(postWithoutImage)
        count++
      }

      let reactBtn = $('.like-btn')
      let commentBtn = $('.comment-btn')
      let closeComment = $('#close-comment-modal')
      let commentModal = $('#comment-modal')
      let inputPostID = $('#post_id')

      commentBtn.on('click', function() {
        let postId = $(this).parent().children('.like-btn').data('post-id')
        commentModal.addClass('grid').removeClass('hidden')
        inputPostID.val(postId)

        $('#comments').html('')
        setTimeout(getComments, 50)
      })

      closeComment.on('click', function() {
        commentModal.addClass('hidden').removeClass('grid')
        inputPostID.val("")
      })

      reactBtn.on('click', function() {
        let btn = $(this)
        let postId = btn.data('post-id')
        let userId = $('#current_user').val()
        let icon = btn.find('svg')
        let isLiked = btn.hasClass('checked') ? 1 : 0

        console.log(postId, userId, isLiked)

        $.ajax({
          url: "../../src/post/react-post.php",
          method: "POST",
          data: {
            post_id: postId,
            user_id: userId,
            is_liked: isLiked
          },
          success: function(response) {
            if (response !== 'SUCCESS') {
              alert(response)
              return
            }
            isLiked = isLiked === 0 ? 1 : 0
            if (isLiked) {
              btn.addClass('checked')
              icon.addClass('fill-brand-500').removeClass('fill-brand-200')
            } else {
              btn.removeClass('checked')
              icon.addClass('fill-brand-200').removeClass('fill-brand-500')
            }
          }
        })
      })
    }
  })

}

function getAppointments() {
  $.ajax({
    url: "../../src/appointment/dashboard-appointment.php",
    success: function(response) {
      console.log(response)
      const data = JSON.parse(response)
      if (response.length === 0) {
        return
      }
      let appointmentsDiv = $('#appointments')

      for (let i in data) {
        let fullName = data[i].first_name + ' ' + data[i].last_name
        let date = formatDate(data[i].appointment_date)
        let time = formatTime(data[i].appointment_time)
        let component = `
                <div class='flex items-center justify-between bg-brand-100 px-2 py-4 rounded-lg' data-id=''>
                  <div class='profile flex items-center gap-2'>
                    <img src='https://ui-avatars.com/api/?name=${data[i].first_name}+${data[i].last_name}&size=48&rounded=true&color=7F56D9&background=F9F5FF' alt=''>
                    <div class='profile-details'>
                      <p class='text-sm font-medium'>${fullName}</p>
                      <p class='text-sm text-gray-500'><span class='capitalize'>${data[i].report_title}</span></p>
                    </div>
                  </div>
                  <div class="text-sm text-right">
                    <p class=''>${date}</p>
                    <p class='text-gray-500'>${time}</p>
                  </div>
                </div>
`
        appointmentsDiv.prepend(component)
      }

    }
  })

}
/*
 *
 [{"appointment_id":"5","creator_id":"21-UR-0001","counselor_id":"CLR-UR-001","report_title":"Bullying",
 "report_desc":"bully","time_of_event":"15:41:00","date_of_event":"2023-12-16","status":"unfinished",
 "map_longitude":"120.902864","map_latitude":"15.593939","appointment_time":"13:00:00","appointment_date":"2023-12-20",
 "user_id":"CLR-UR-001","first_name":"Ernico","last_name":"Uy","user_gender":"Male","email_address":"asd@asd.asd",
 "user_password":"$2y$10$N\/tuOf1vNrMFvn\/AnBEpAOMW3voArhY90gDLQMDUNc6PwpVSkoZjG","user_role":"counselor",
 "date_registered":"2023-12-11 23:48:15"},{"appointment_id":"6","creator_id":"21-UR-0001","counselor_id":"CLR-UR-001",
 "report_title":"Rape","report_desc":"ako ay nirape sa school","time_of_event":"23:37:00","date_of_event":"2024-01-01",
 "status":"unfinished","map_longitude":"120.357980","map_latitude":"16.008938","appointment_time":"10:00:00",
 "appointment_date":"2024-01-12","user_id":"CLR-UR-001","first_name":"Ernico","last_name":"Uy","user_gender":"Male",
 "email_address":"asd@asd.asd","user_password":"$2y$10$N\/tuOf1vNrMFvn\/AnBEpAOMW3voArhY90gDLQMDUNc6PwpVSkoZjG",
 "user_role":"counselor","date_registered":"2023-12-11 23:48:15"}]
dashboard.js:20 
 */

function formatDate(dateString) {
  const options = { year: 'numeric', month: 'long', day: 'numeric' };
  const [year, month, day] = dateString.split('-').map(Number);
  const formattedDate = new Date(year, month - 1, day).toLocaleDateString('en-US', options);
  return formattedDate;
}

function formatTime(timeString) {
  const [hours, minutes, seconds] = timeString.split(':').map(Number);

  let period = 'AM';
  let formattedHours = hours;

  if (hours >= 12) {
    period = 'PM';
    formattedHours = hours === 12 ? 12 : hours - 12;
  }

  if (formattedHours === 0) {
    formattedHours = 12;
  }

  const formattedTime = `${formattedHours}:${minutes < 10 ? '0' : ''}${minutes} ${period}`;
  return formattedTime;
}
