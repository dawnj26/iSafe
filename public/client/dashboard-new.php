<?php
session_start();
if (! isset($_SESSION['id']) || ! isset($_SESSION['role'])) {
    session_destroy();
    header('Location: ../login.php');
    exit();
}
$client = ['student', 'employee'];
if (! in_array($_SESSION['role'], $client)) {
    session_destroy();
    header('Location: ../login.php');
    exit();
}
require '../../config/config.php';
$id = $_SESSION['id'];
$name = $mainConn->query("SELECT first_name, last_name FROM user WHERE user_id = '$id'")->fetch_assoc();

$fullname = $name['first_name'].' '.$name['last_name'];
$counselors = get_counselors()
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!--google font-->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  <!--tailwindcss file-->
  <link rel="stylesheet" href="../css/style.css">
  <!--Leaflet-->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
  <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
  <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
  <!--jquery-->
  <link rel="stylesheet" href="../js/jquery-ui-1.13.2.custom/jquery-ui.min.css">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="../js/jquery-ui-1.13.2.custom/jquery-ui.min.js"></script>
  <title>Document</title>
</head>

<body class="h-screen flex flex-col font-inter relative">
  <header class="py-4 px-6 flex w-full items-center justify-between shadow">
    <div class="logo flex items-center gap-2">
      <svg width="32" height="32" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect width="40" height="40" rx="8" fill="#7F56D9" />
        <path fill-rule="evenodd" clip-rule="evenodd" d="M19.064 6.92666C19.5902 6.7298 20.1651 6.70413 20.7067 6.85333L20.936 6.92666L30.2693 10.4267C30.7426 10.6041 31.1556 10.9124 31.4604 11.3156C31.7652 11.7188 31.9491 12.2003 31.9907 12.704L32 12.924V20.0747C31.9999 22.2352 31.4166 24.3557 30.3115 26.2122C29.2064 28.0688 27.6205 29.5926 25.7213 30.6227L25.3667 30.808L20.8947 33.044C20.6484 33.1669 20.3795 33.2377 20.1046 33.252C19.8298 33.2662 19.5549 33.2235 19.2973 33.1267L19.1053 33.044L14.6333 30.808C12.7008 29.8417 11.065 28.3716 9.89867 26.5528C8.73231 24.734 8.07864 22.6341 8.00667 20.4747L8 20.0747V12.924C8.00001 12.4188 8.1435 11.9241 8.41378 11.4973C8.68405 11.0705 9.06999 10.7293 9.52667 10.5133L9.73067 10.4267L19.064 6.92666ZM20 9.42399L10.6667 12.924V20.0747C10.6667 21.748 11.1166 23.3906 11.9693 24.8304C12.8219 26.2702 14.046 27.4543 15.5133 28.2587L15.8267 28.4227L20 30.5093L24.1733 28.4227C25.6703 27.6743 26.9385 26.5372 27.8452 25.1305C28.7518 23.7237 29.2635 22.0991 29.3267 20.4267L29.3333 20.0747V12.924L20 9.42399ZM19.344 14.0213C19.7051 13.8862 20.0991 13.8662 20.472 13.964L20.656 14.0213L24.3893 15.4213C24.7168 15.5442 25.0032 15.7565 25.2158 16.0342C25.4285 16.3119 25.5588 16.6438 25.592 16.992L25.6 17.1693V20.0293C25.6 21.0204 25.337 21.9937 24.8378 22.8499C24.3386 23.7061 23.6211 24.4144 22.7587 24.9027L22.5053 25.0387L20.716 25.932C20.5222 26.029 20.3107 26.0857 20.0943 26.0985C19.878 26.1114 19.6613 26.0801 19.4573 26.0067L19.284 25.9333L17.496 25.0387C16.6097 24.5955 15.8569 23.9251 15.3144 23.0958C14.7719 22.2666 14.4591 21.3083 14.408 20.3187L14.4 20.0293V17.1693C14.4 16.8196 14.4983 16.477 14.6836 16.1805C14.8689 15.8839 15.1337 15.6454 15.448 15.492L15.6107 15.4213L19.344 14.0213ZM20 16.624L17.0667 17.724V20.0307C17.0668 20.5376 17.1983 21.0358 17.4483 21.4767C17.6984 21.9177 18.0584 22.2863 18.4933 22.5467L18.688 22.6533L20 23.3093L21.312 22.6533C21.7657 22.4265 22.1528 22.0859 22.4356 21.6648C22.7184 21.2437 22.8871 20.7565 22.9253 20.2507L22.9333 20.0293V17.724L20 16.624Z" fill="white" />
      </svg>
      <h3 class="text-lg text-brand-600 font-inter font-medium">iSafe</h3>
    </div>

    <!--	Ito yung nasa left side-->
    <div class="flex items-center gap-10">
      <!--		create an appointment button-->
      <button type="button" id="open-appointment" class="font-inter text-xs bg-brand-600 text-white font-semibold flex gap-2 items-center py-2 px-4 rounded-lg hover:bg-brand-700 h-min">
        Create an appointment
        <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M9.99984 4.16666V15.8333M4.1665 9.99999H15.8332" stroke="white" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </button>
      <div class="flex gap-6">
        <!--			notification button-->
        <label for="checkbox-modal" class="rounded-full hover:bg-slate-100 p-2" id="open-notification">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M13.73 21C13.5542 21.3031 13.3018 21.5547 12.9982 21.7295C12.6946 21.9044 12.3504 21.9965 12 21.9965C11.6496 21.9965 11.3054 21.9044 11.0018 21.7295C10.6982 21.5547 10.4458 21.3031 10.27 21M18 8C18 6.4087 17.3679 4.88258 16.2426 3.75736C15.1174 2.63214 13.5913 2 12 2C10.4087 2 8.88258 2.63214 7.75736 3.75736C6.63214 4.88258 6 6.4087 6 8C6 15 3 17 3 17H21C21 17 18 15 18 8Z" stroke="#667085" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </label>
        <input type="checkbox" name="checkbox-modal" id="checkbox-modal" class="hidden">
        <!--			profile-->
        <div class="flex items-center gap-4">
          <svg width="32" height="32" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect width="48" height="48" rx="24" fill="#F9F5FF" />
            <path d="M34.6668 36V33.3333C34.6668 31.9188 34.1049 30.5623 33.1047 29.5621C32.1045 28.5619 30.748 28 29.3335 28H18.6668C17.2523 28 15.8958 28.5619 14.8956 29.5621C13.8954 30.5623 13.3335 31.9188 13.3335 33.3333V36M29.3335 17.3333C29.3335 20.2789 26.9457 22.6667 24.0002 22.6667C21.0546 22.6667 18.6668 20.2789 18.6668 17.3333C18.6668 14.3878 21.0546 12 24.0002 12C26.9457 12 29.3335 14.3878 29.3335 17.3333Z" stroke="#7F56D9" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
          <p class="text-sm"><?php echo $fullname ?></p>
        </div>

      </div>
    </div>

  </header>

  <!-- Navigation -->
  <div class="grid grid-cols-[12rem_1fr] h-full">
    <!-- Wrap in anchor tag to navigate through pages, yung li element-->
    <aside class="h-full pt-2 shadow-[rgba(0,0,0,0.1)_2px_0_0_0]">
      <ul>
        <li class="w-full">
          <a href="dashboard-new.php">
            <div class="p-4 active-tab text-brand-600 w-full f-full border-r-4 border-brand-600 hover:bg-slate-100 cursor-pointer flex items-center gap-2">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9 22V12H15V22M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z" stroke="#7F56D9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
              Dashboard
            </div>
          </a>
        </li>
        <li class="w-full">

          <a href="appointments.php">
            <div class="p-4 flex items-center gap-2 w-full h-full hover:bg-slate-100 cursor-pointer">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M16 2V6M8 2V6M3 10H21M5 4H19C20.1046 4 21 4.89543 21 6V20C21 21.1046 20.1046 22 19 22H5C3.89543 22 3 21.1046 3 20V6C3 4.89543 3.89543 4 5 4Z" stroke="#344054" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              </svg>

              Appointments
            </div>
          </a>
        </li>
        <li class="w-full">
          <a href="chat.php">
            <div class="p-4 flex items-center gap-2 w-full h-full hover:bg-slate-100 cursor-pointer">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M21 15C21 15.5304 20.7893 16.0391 20.4142 16.4142C20.0391 16.7893 19.5304 17 19 17H7L3 21V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H19C19.5304 3 20.0391 3.21071 20.4142 3.58579C20.7893 3.96086 21 4.46957 21 5V15Z" stroke="#344054" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              </svg>

              Chat
            </div>
          </a>
        </li>
        <li class="w-full">
          <a href="news-feed.php">

            <div class="p-4 flex items-center gap-2 w-full h-full hover:bg-slate-100 cursor-pointer">

              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M19 3H5C3.89543 3 3 3.89543 3 5V19C3 20.1046 3.89543 21 5 21H19C20.1046 21 21 20.1046 21 19V5C21 3.89543 20.1046 3 19 3Z" stroke="#344054" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M10 7H7V16H10V7Z" stroke="#344054" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M17 7H14V12H17V7Z" stroke="#344054" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              </svg>

              News Feed
            </div>
          </a>
        </li>
        <li class="flex items-center p-4 gap-2 w-full hover:bg-slate-100 cursor-pointer">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0_280_734)">
              <path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z" stroke="#344054" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              <path d="M19.4 15C19.2669 15.3016 19.2272 15.6362 19.286 15.9606C19.3448 16.285 19.4995 16.5843 19.73 16.82L19.79 16.88C19.976 17.0657 20.1235 17.2863 20.2241 17.5291C20.3248 17.7719 20.3766 18.0322 20.3766 18.295C20.3766 18.5578 20.3248 18.8181 20.2241 19.0609C20.1235 19.3037 19.976 19.5243 19.79 19.71C19.6043 19.896 19.3837 20.0435 19.1409 20.1441C18.8981 20.2448 18.6378 20.2966 18.375 20.2966C18.1122 20.2966 17.8519 20.2448 17.6091 20.1441C17.3663 20.0435 17.1457 19.896 16.96 19.71L16.9 19.65C16.6643 19.4195 16.365 19.2648 16.0406 19.206C15.7162 19.1472 15.3816 19.1869 15.08 19.32C14.7842 19.4468 14.532 19.6572 14.3543 19.9255C14.1766 20.1938 14.0813 20.5082 14.08 20.83V21C14.08 21.5304 13.8693 22.0391 13.4942 22.4142C13.1191 22.7893 12.6104 23 12.08 23C11.5496 23 11.0409 22.7893 10.6658 22.4142C10.2907 22.0391 10.08 21.5304 10.08 21V20.91C10.0723 20.579 9.96512 20.258 9.77251 19.9887C9.5799 19.7194 9.31074 19.5143 9 19.4C8.69838 19.2669 8.36381 19.2272 8.03941 19.286C7.71502 19.3448 7.41568 19.4995 7.18 19.73L7.12 19.79C6.93425 19.976 6.71368 20.1235 6.47088 20.2241C6.22808 20.3248 5.96783 20.3766 5.705 20.3766C5.44217 20.3766 5.18192 20.3248 4.93912 20.2241C4.69632 20.1235 4.47575 19.976 4.29 19.79C4.10405 19.6043 3.95653 19.3837 3.85588 19.1409C3.75523 18.8981 3.70343 18.6378 3.70343 18.375C3.70343 18.1122 3.75523 17.8519 3.85588 17.6091C3.95653 17.3663 4.10405 17.1457 4.29 16.96L4.35 16.9C4.58054 16.6643 4.73519 16.365 4.794 16.0406C4.85282 15.7162 4.81312 15.3816 4.68 15.08C4.55324 14.7842 4.34276 14.532 4.07447 14.3543C3.80618 14.1766 3.49179 14.0813 3.17 14.08H3C2.46957 14.08 1.96086 13.8693 1.58579 13.4942C1.21071 13.1191 1 12.6104 1 12.08C1 11.5496 1.21071 11.0409 1.58579 10.6658C1.96086 10.2907 2.46957 10.08 3 10.08H3.09C3.42099 10.0723 3.742 9.96512 4.0113 9.77251C4.28059 9.5799 4.48572 9.31074 4.6 9C4.73312 8.69838 4.77282 8.36381 4.714 8.03941C4.65519 7.71502 4.50054 7.41568 4.27 7.18L4.21 7.12C4.02405 6.93425 3.87653 6.71368 3.77588 6.47088C3.67523 6.22808 3.62343 5.96783 3.62343 5.705C3.62343 5.44217 3.67523 5.18192 3.77588 4.93912C3.87653 4.69632 4.02405 4.47575 4.21 4.29C4.39575 4.10405 4.61632 3.95653 4.85912 3.85588C5.10192 3.75523 5.36217 3.70343 5.625 3.70343C5.88783 3.70343 6.14808 3.75523 6.39088 3.85588C6.63368 3.95653 6.85425 4.10405 7.04 4.29L7.1 4.35C7.33568 4.58054 7.63502 4.73519 7.95941 4.794C8.28381 4.85282 8.61838 4.81312 8.92 4.68H9C9.29577 4.55324 9.54802 4.34276 9.72569 4.07447C9.90337 3.80618 9.99872 3.49179 10 3.17V3C10 2.46957 10.2107 1.96086 10.5858 1.58579C10.9609 1.21071 11.4696 1 12 1C12.5304 1 13.0391 1.21071 13.4142 1.58579C13.7893 1.96086 14 2.46957 14 3V3.09C14.0013 3.41179 14.0966 3.72618 14.2743 3.99447C14.452 4.26276 14.7042 4.47324 15 4.6C15.3016 4.73312 15.6362 4.77282 15.9606 4.714C16.285 4.65519 16.5843 4.50054 16.82 4.27L16.88 4.21C17.0657 4.02405 17.2863 3.87653 17.5291 3.77588C17.7719 3.67523 18.0322 3.62343 18.295 3.62343C18.5578 3.62343 18.8181 3.67523 19.0609 3.77588C19.3037 3.87653 19.5243 4.02405 19.71 4.21C19.896 4.39575 20.0435 4.61632 20.1441 4.85912C20.2448 5.10192 20.2966 5.36217 20.2966 5.625C20.2966 5.88783 20.2448 6.14808 20.1441 6.39088C20.0435 6.63368 19.896 6.85425 19.71 7.04L19.65 7.1C19.4195 7.33568 19.2648 7.63502 19.206 7.95941C19.1472 8.28381 19.1869 8.61838 19.32 8.92V9C19.4468 9.29577 19.6572 9.54802 19.9255 9.72569C20.1938 9.90337 20.5082 9.99872 20.83 10H21C21.5304 10 22.0391 10.2107 22.4142 10.5858C22.7893 10.9609 23 11.4696 23 12C23 12.5304 22.7893 13.0391 22.4142 13.4142C22.0391 13.7893 21.5304 14 21 14H20.91C20.5882 14.0013 20.2738 14.0966 20.0055 14.2743C19.7372 14.452 19.5268 14.7042 19.4 15Z" stroke="#344054" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </g>
            <defs>
              <clipPath id="clip0_280_734">
                <rect width="24" height="24" fill="white" />
              </clipPath>
            </defs>
          </svg>

          Settings
        </li>
        <li class="w-full flex justify-center mt-4">
          <button type="button" class="px-4 py-2 bg-error-600 rounded-lg text-white" onclick="logout()">
            Logout
          </button>
        </li>
      </ul>
    </aside>


    <div class="flex items-center justify-center bg-gray-100 h-full w-full">
      <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Your main content goes here -->
        <div class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200 ">
          <!-- Page Content -->

          <div class="m-4 border-black bg-white rounded-md p-4 flex items-center">
            <div class="flex-1 ml-5">
              <div class="font-extralight mb-8">
                <p>Friday, 24 November 2023</p>
              </div>
              <div class="text-3xl mb-8">
                <p>Good Evening, <?php echo $fullname ?></p>
              </div>
              <div class="font-light mb-8">
                <p>"The purpose of our life is to be <span style="color: #7F56D9;" class="">happy</span>" -
                  <span class="italic">Dalai Lama</span>
                </p>
              </div>
            </div>
            <div class="flex-shrink-0 mr-14">
              <img src="../assets/icons/undraw_mindfulness_8gqa 1.svg" alt="Image description" class="rounded-md" width="300">
            </div>
          </div>
          <div class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200 ">
            <!-- Page Content -->

            <div class="m-4 border-black bg-white rounded-md p-4 flex items-center">
              <div class="flex-1">
                <div class="font-bold mb-8 text-2xl mt-4 ml-4">
                  <p>Latest Posts</p>
                </div>

                <div class="flex justify-evenly">
                  <div class="p-5 inline-block rounded-lg" style="background-color: #F4EBFF; color: black; width: 400px;">

                    <div class="flex items-center justify-between mb-4">
                      <div class="flex items-center">
                        <div class="inline-block">
                          <img src="../assets/icons/olivia.svg" alt="Avatar" class="rounded-full" style="width: 50px; height: 50px;">
                        </div>
                        <div class="inline-block ml-4">
                          <p class="font-bold">Olivia Rhye</p>
                          <p class="text-sm">Student</p>
                        </div>
                      </div>
                      <p class="text-sm text-gray-500">9:00 PM</p>
                    </div>

                    <!-- Adjust max-width for the message box and remove fixed width -->
                    <div class="mt-5 mb-5 overflow-y-auto max-h-40">
                      <p>
                        <!-- Add more text or user information as needed -->
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua.
                      </p>
                    </div>

                    <hr>

                    <div class="flex justify-between mt-4">
                      <a href="#" class="text-blue-500">
                        <svg class="inline-block relative right-1" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M6 21H3C2.46957 21 1.96086 20.7893 1.58579 20.4142C1.21071 20.0391 1 19.5304 1 19V12C1 11.4696 1.21071 10.9609 1.58579 10.5858C1.96086 10.2107 2.46957 10 3 10H6M13 8V4C13 3.20435 12.6839 2.44129 12.1213 1.87868C11.5587 1.31607 10.7956 1 10 1L6 10V21H17.28C17.7623 21.0055 18.2304 20.8364 18.5979 20.524C18.9654 20.2116 19.2077 19.7769 19.28 19.3L20.66 10.3C20.7035 10.0134 20.6842 9.72068 20.6033 9.44225C20.5225 9.16382 20.3821 8.90629 20.1919 8.68751C20.0016 8.46873 19.7661 8.29393 19.5016 8.17522C19.2371 8.0565 18.9499 7.99672 18.66 8H13Z" stroke="#475467" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="inline-block">Like</div>
                      </a>
                      <a href="#" class="text-blue-500">
                        <svg class="inline-block relative right-1" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M19 9.5C19.0034 10.8199 18.6951 12.1219 18.1 13.3C17.3944 14.7117 16.3098 15.8992 14.9674 16.7293C13.6251 17.5594 12.0782 17.9994 10.5 18C9.18013
														18.0034 7.87812 17.6951 6.7 17.1L1 19L2.9 13.3C2.30493 12.1219 1.99656 10.8199 2 9.5C2.00061 7.92176 2.44061 6.37485 3.27072 5.03255C4.10083 3.69025 5.28825 2.60557 6.7 1.9C7.87812 1.30493 9.18013 0.996557 10.5 0.999998H11C13.0843 1.11499 15.053 1.99476 16.5291 3.47086C18.0052 4.94695 18.885 6.91565 19 9V9.5Z" stroke="#475467" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="inline-block">Comment</div>
                      </a>
                    </div>

                  </div>

                  <div class="p-5 inline-block rounded-lg" style="background-color: #F4EBFF; color: black; width: 400px;">

                    <div class="flex items-center justify-between mb-4">
                      <div class="flex items-center">
                        <div class="inline-block">
                          <img src="../assets/icons/olivia.svg" alt="Avatar" class="rounded-full" style="width: 50px; height: 50px;">
                        </div>
                        <div class="inline-block ml-4">
                          <p class="font-bold">Olivia Rhye</p>
                          <p class="text-sm">Student</p>
                        </div>
                      </div>
                      <p class="text-sm text-gray-500">9:00 PM</p>
                    </div>
                    <div class="mt-5 mb-5 overflow-y-auto max-h-40">
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>

                    <hr>

                    <div class="flex justify-between mt-4">
                      <a href="#" class="text-blue-500">
                        <svg class="inline-block relative right-1" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M6 21H3C2.46957 21 1.96086 20.7893 1.58579 20.4142C1.21071 20.0391 1 19.5304 1 19V12C1 11.4696 1.21071 10.9609 1.58579 10.5858C1.96086 10.2107 2.46957 10 3 10H6M13 8V4C13 3.20435 12.6839 2.44129 12.1213 1.87868C11.5587 1.31607 10.7956 1 10 1L6 10V21H17.28C17.7623 21.0055 18.2304 20.8364 18.5979 20.524C18.9654 20.2116 19.2077 19.7769 19.28 19.3L20.66 10.3C20.7035 10.0134 20.6842 9.72068 20.6033 9.44225C20.5225 9.16382 20.3821 8.90629 20.1919 8.68751C20.0016 8.46873 19.7661 8.29393 19.5016 8.17522C19.2371 8.0565 18.9499 7.99672 18.66 8H13Z" stroke="#475467" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="inline-block">Like</div>
                      </a>
                      <a href="#" class="text-blue-500">
                        <svg class="inline-block relative right-1" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M19 9.5C19.0034 10.8199 18.6951 12.1219 18.1 13.3C17.3944 14.7117 16.3098 15.8992 14.9674 16.7293C13.6251 17.5594 12.0782 17.9994 10.5 18C9.18013
														18.0034 7.87812 17.6951 6.7 17.1L1 19L2.9 13.3C2.30493 12.1219 1.99656 10.8199 2 9.5C2.00061 7.92176 2.44061 6.37485 3.27072 5.03255C4.10083 3.69025 5.28825 2.60557 6.7 1.9C7.87812 1.30493 9.18013 0.996557 10.5 0.999998H11C13.0843 1.11499 15.053 1.99476 16.5291 3.47086C18.0052 4.94695 18.885 6.91565 19 9V9.5Z" stroke="#475467" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="inline-block">Comment</div>
                      </a>
                    </div>


                  </div>

                  <div class="p-5 inline-block rounded-lg" style="background-color: #F4EBFF; color: black; width: 400px;">

                    <div class="flex items-center justify-between mb-4">
                      <div class="flex items-center">
                        <div class="inline-block">
                          <img src="../assets/icons/olivia.svg" alt="Avatar" class="rounded-full" style="width: 50px; height: 50px;">
                        </div>
                        <div class="inline-block ml-4">
                          <p class="font-bold">Olivia Rhye</p>
                          <p class="text-sm">Student</p>
                        </div>
                      </div>
                      <p class="text-sm text-gray-500">9:00 PM</p>
                    </div>
                    <div class="mt-5 mb-5 overflow-y-auto max-h-40">
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>

                    <hr>

                    <div class="flex justify-between mt-4">
                      <a href="#" class="text-blue-500">
                        <svg class="inline-block relative right-1" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M6 21H3C2.46957 21 1.96086 20.7893 1.58579 20.4142C1.21071 20.0391 1 19.5304 1 19V12C1 11.4696 1.21071 10.9609 1.58579 10.5858C1.96086 10.2107 2.46957 10 3 10H6M13 8V4C13 3.20435 12.6839 2.44129 12.1213 1.87868C11.5587 1.31607 10.7956 1 10 1L6 10V21H17.28C17.7623 21.0055 18.2304 20.8364 18.5979 20.524C18.9654 20.2116 19.2077 19.7769 19.28 19.3L20.66 10.3C20.7035 10.0134 20.6842 9.72068 20.6033 9.44225C20.5225 9.16382 20.3821 8.90629 20.1919 8.68751C20.0016 8.46873 19.7661 8.29393 19.5016 8.17522C19.2371 8.0565 18.9499 7.99672 18.66 8H13Z" stroke="#475467" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="inline-block">Like</div>
                      </a>
                      <a href="#" class="text-blue-500">
                        <svg class="inline-block relative right-1" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M19 9.5C19.0034 10.8199 18.6951 12.1219 18.1 13.3C17.3944 14.7117 16.3098 15.8992 14.9674 16.7293C13.6251 17.5594 12.0782 17.9994 10.5 18C9.18013
															18.0034 7.87812 17.6951 6.7 17.1L1 19L2.9 13.3C2.30493 12.1219 1.99656 10.8199 2 9.5C2.00061 7.92176 2.44061 6.37485 3.27072 5.03255C4.10083 3.69025 5.28825 2.60557 6.7 1.9C7.87812 1.30493 9.18013 0.996557 10.5 0.999998H11C13.0843 1.11499 15.053 1.99476 16.5291 3.47086C18.0052 4.94695 18.885 6.91565 19 9V9.5Z" stroke="#475467" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="inline-block">Comment</div>
                      </a>
                    </div>

                  </div>
                </div>
              </div>
            </div>

            <div class="flex items-center w-full">

              <!-- Appointments Container -->
              <div class="m-4 bg-white rounded-md p-4 items-center w-1/2 inline-block">
                <div class="flex-1 ml-5">
                  <div class="font-bold mb-5 text-2xl">
                    <p>Appointments</p>
                  </div>

                  <!-- First Appointment -->
                  <a href="#" class="block mb-2 hover:bg-purple-100 rounded-2xl">
                    <div class="p-5 block rounded-lg text-black w-full">
                      <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                          <div class="inline-block">
                            <img src="../assets/icons/olivia.svg" alt="Avatar" class="rounded-full w-12 h-12">
                          </div>
                          <div class="inline-block ml-4">
                            <p class="font-bold">Olivia Rhye</p>
                            <p class="text-sm">First Visit | Age: 18</p>
                          </div>
                        </div>
                        <p class="text-sm text-gray-500">9:00 PM</p>
                      </div>
                    </div>
                  </a>

                  <!-- Second Appointment -->
                  <a href="#" class="block mb-2 hover:bg-purple-100 rounded-2xl">
                    <div class="p-5 block rounded-lg text-black w-full">
                      <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                          <div class="inline-block">
                            <img src="../assets/icons/olivia.svg" alt="Avatar" class="rounded-full w-12 h-12">
                          </div>
                          <div class="inline-block ml-4">
                            <p class="font-bold">hotdog ni kap</p>
                            <p class="text-sm">Second Visit | Age: 25</p>
                          </div>
                        </div>
                        <p class="text-sm text-gray-500">10:30 AM</p>
                      </div>
                    </div>
                  </a>

                  <!-- Third Appointment -->
                  <a href="#" class="block mb-2 hover:bg-purple-100 rounded-2xl">
                    <div class="p-5 block rounded-lg text-black w-full">
                      <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                          <div class="inline-block">
                            <img src="../assets/icons/olivia.svg" alt="Avatar" class="rounded-full w-12 h-12">
                          </div>
                          <div class="inline-block ml-4">
                            <p class="font-bold">Jane Smith</p>
                            <p class="text-sm">Third Visit | Age: 30</p>
                          </div>
                        </div>
                        <p class="text-sm text-gray-500">1:45 PM</p>
                      </div>
                    </div>
                  </a>
                </div>
              </div>

              <!-- Incident Map -->
              <div class="m-4 border-black bg-white rounded-md p-4 w-1/2 inline-block">
                <div class="ml-5 flex flex-col h-full">
                  <div class="font-bold mb-2 text-2xl flex">
                    <p class="mt-3">Incident Map</p>
                  </div>
                  <div class="text-sm mb-2 flex justify-end relative bottom-8">
                    <p>As of 9:43 am</p>
                  </div>
                  <img src="../assets/icons/Figmap.svg" alt="Incident Map" class="w-60 h-60 rounded-lg relative bottom-10">
                  <div class="text-sm">
                    <p class="">BULLYING</p>
                    <p class="mb-2 flex">At Umingan Pangasinan</p>
                    <p class="text-gray-500 ">Time: Time of the Incident at Umingan Pangasinan</p>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>


  </div>

  <!--Notifications-->
  <div id="notification-modal" class="w-full h-full bg-brand-400 bg-opacity-40 hidden place-items-center absolute">
    <div class="bg-white p-8 w-2/3 max-h-96 rounded-xl">
      <div class="header flex justify-between mb-6">
        <h2 class="text-xl">Notifications</h2>
        <button type="button" id="close-notification">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M18 5.99994L6 17.9999M6 5.99994L18 17.9999" stroke="#101828" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </button>
      </div>
      <!--Call notification-->
      <div class="flex justify-between bg-brand-100 p-4 rounded-xl mb-2">
        <div class="flex gap-4 items-center">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M16 2V6M8 2V6M3 10H21M5 4H19C20.1046 4 21 4.89543 21 6V20C21 21.1046 20.1046 22 19 22H5C3.89543 22 3 21.1046 3 20V6C3 4.89543 3.89543 4 5 4Z" stroke="#344054" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
          <div>
            <p class="text-sm font-semibold">Magno started a meeting</p>
            <p class="text-xs text-gray-600">Monday, December 25, 2023 | 12:00am</p>
          </div>
        </div>
        <button type="button" class="text-white text-sm font-medium bg-brand-600 h-min py-2 px-4 rounded-xl hover:bg-brand-700">
          Join
        </button>
      </div>
      <!--Message notification-->
      <div class="flex items-center justify-between bg-brand-100 p-4 rounded-xl">
        <div class="flex gap-4 items-center">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M21 15C21 15.5304 20.7893 16.0391 20.4142 16.4142C20.0391 16.7893 19.5304 17 19 17H7L3 21V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H19C19.5304 3 20.0391 3.21071 20.4142 3.58579C20.7893 3.96086 21 4.46957 21 5V15Z" stroke="#344054" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
          <div>
            <p class="text-sm font-semibold">Magno messaged you</p>
            <p class="text-xs text-gray-600">Monday, December 25, 2023 | 12:00am</p>
          </div>
        </div>
        <p class="text-sm">"Hallo good morning hahahahhhh"</p>
      </div>
    </div>
  </div>

  <!--Create appointment modal-->
  <div id="appointment-modal" class="w-full h-full bg-brand-400 bg-opacity-40 hidden place-items-center absolute">
    <div class="bg-white p-8 w-2/3 rounded-xl">
      <div class="header flex justify-between mb-6">
        <h2 class="text-xl font-medium">Create an appointment</h2>
        <button type="button" id="close-appointment">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M18 5.99994L6 17.9999M6 5.99994L18 17.9999" stroke="#101828" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </button>
      </div>

      <form id="appointment">
        <input type="hidden" name="latitude" id="latitude">
        <input type="hidden" name="longitude" id="longitude">
        <div class="grid grid-cols-2 w-full gap-4">
          <div id="left-form">
            <div class="flex flex-col gap-1 mb-2">
              <label for="violence" class="flex gap-4 items-center justify-between">
                <span class="text-sm">Type of violence</span>
                <span class="text-error-500 text-xs hidden error-msg">Must not be empty</span>
              </label>
              <input type="text" name="violence" id="violence" class="input outline-none border border-gray-400 px-4 py-2 rounded-lg" placeholder="What did they do?">
            </div>
            <div class="flex flex-col gap-1 mb-2">
              <label for="description" class="flex gap-4 items-center justify-between">
                <span class="text-sm">Event description</span>
                <span class="text-error-500 text-xs hidden error-msg">Must not be empty</span>
              </label>
              <textarea name="description" id="description" cols="30" rows="4" placeholder="What happened?" class="border border-gray-400 input outline-none px-4 py-2 resize-none rounded-lg"></textarea>
            </div>
            <div class="flex flex-col gap-1">
              <label for="location" class="flex gap-4 items-center justify-between">
                <span class="text-sm">Location</span>

              </label>
              <div id="map" class="w-full h-56 rounded-lg">

              </div>
              <button type="button" id="locate" class="w-max px-4 py-2 border border-gray-500 rounded-lg text-sm hover:bg-gray-100">Locate me</button>
            </div>
          </div>
          <div id="right-form">
            <div class="flex flex-col gap-1 mb-2">
              <label for="date-of-event" class="flex gap-4 items-center justify-between">
                <span class="text-sm">Date of event</span>
                <span class="text-error-500 text-xs hidden error-msg">Must not be empty</span>
              </label>
              <input type="text" name="date-of-event" id="date-of-event" class="input outline-none border border-gray-400 px-4 py-2 rounded-lg" placeholder="Select date">
            </div>
            <div class="flex flex-col gap-1 mb-8">
              <label for="time-of-event" class="flex gap-4 items-center justify-between">
                <span class="text-sm">Time of event</span>
                <span class="text-error-500 text-xs hidden error-msg">Must not be empty</span>
              </label>
              <input type="time" name="time-of-event" id="time-of-event" class="input outline-none border border-gray-400 px-4 py-2 rounded-lg" placeholder="Select time">
            </div>
            <div class="flex flex-col gap-1 mb-4">
              <label for="counselor" class="flex gap-4 items-center justify-between">
                <span class="text-sm">Counselor</span>
                <span class="text-error-500 text-xs hidden error-msg">Must select a counselor</span>
              </label>
              <select name="counselor" id="counselor" class="input outline-none border border-gray-400 px-4 py-2 rounded-lg text-gray-500 bg-white">
                <option value="">Select option</option>
                <?php
                foreach ($counselors as $counselor) {
                    $id = $counselor['user_id'];
                    $name = $counselor['full_name'];
                    echo "<option value='$id'>$name</option>";
                }

?>
              </select>
              <a href="" class="text-brand-600 font-medium text-sm">View profile</a>
            </div>
            <div class="flex flex-col gap-1 mb-2">
              <label for="date-of-appointment" class="flex gap-4 items-center justify-between">
                <span class="text-sm">Date of appointment</span>
                <span class="text-error-500 text-xs hidden error-msg">Must not be empty</span>
              </label>
              <input type="text" name="date-of-appointment" id="date-of-appointment" class="input outline-none border border-gray-400 px-4 py-2 rounded-lg" placeholder="Select date">
            </div>
            <div class="flex flex-col gap-1 mb-12">
              <label for="time-of-appointment" class="flex gap-4 items-center justify-between">
                <span class="text-sm">Time of appointment</span>
                <span class="text-error-500 text-xs hidden error-msg">Must not be empty</span>
              </label>
              <select name="time-of-appointment" id="time-of-appointment" class="input outline-none border border-gray-400 px-4 py-2 rounded-lg text-gray-500 bg-white">
                <option value="">Select time</option>
                <!--							<option value="08:00">8:00 am to 9:00 am</option>-->
                <!--							<option value="09:00">9:00 am to 10:00 am</option>-->
                <!--							<option value="10:00">10:00 am to 11:00 am</option>-->
                <!--							<option value="11:00">11:00 am to 12:00 pm</option>-->
                <!--							<option value="13:00">1:00 pm to 2:00 pm</option>-->
                <!--							<option value="14:00">2:00 pm to 3:00 pm</option>-->
                <!--							<option value="15:00">3:00 pm to 4:00pm</option>-->
                <!--							<option value="16:00">4:00 pm to 5:00 pm</option>-->
              </select>
            </div>
            <div class="flex text-sm items-center justify-between">
              <div id="msg" class="text-success-600 flex items-center gap-2 opacity-0">
                Successfully appointed
                <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <g clip-path="url(#clip0_296_882)">
                    <path d="M14.6668 7.45656V8.0699C14.666 9.50751 14.2005 10.9063 13.3397 12.0578C12.4789 13.2092 11.269 14.0515 9.8904 14.4592C8.51178 14.8668 7.03834 14.8178 5.68981 14.3196C4.34128 13.8214 3.18993 12.9006 2.40747 11.6946C1.62501 10.4886 1.25336 9.06194 1.34795 7.62744C1.44254 6.19294 1.9983 4.82745 2.93235 3.73461C3.8664 2.64178 5.12869 1.88015 6.53096 1.56333C7.93323 1.2465 9.40034 1.39145 10.7135 1.97656M14.6668 2.73656L8.00017 9.4099L6.00017 7.4099" stroke="#039855" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                  </g>
                  <defs>
                    <clipPath id="clip0_296_882">
                      <rect width="16" height="16" fill="white" transform="translate(0 0.0698853)" />
                    </clipPath>
                  </defs>
                </svg>
              </div>
              <button type="submit" class="px-4 py-2 bg-brand-600 text-white font-medium rounded-lg hover:bg-brand-700">Set appointment</button>
            </div>

          </div>

        </div>



      </form>

    </div>
  </div>

  <!--<script src="js/calendar.js"></script>-->
  <!--<script src="js/leaflet.js"></script>-->
  <script src="../js/close_modal.js"></script>
  <script src="../js/create_appointment.js"></script>
</body>

</html>
