<?php
date_default_timezone_set('Asia/Manila');
session_start();
if (!isset($_SESSION['id']) || !isset($_SESSION['role'])) {
  session_destroy();
  header('Location: ../login.php');
  exit();
}
if ($_SESSION['role'] !== 'counselor') {
  session_destroy();
  header('Location: ../login.php');
  exit();
}
require '../../config/config.php';
$current_id = $_SESSION['id'];
$name = $mainConn->query("SELECT first_name, last_name FROM user WHERE user_id = '$current_id'")->fetch_assoc();

$fullname = $name['first_name'] . ' ' . $name['last_name'];
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
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;400;500;600&display=swap" rel="stylesheet">
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
  <style>
    /* Toggle A */
    input:checked~.dot {
      transform: translateX(100%);
      background-color: #7F56D9;
    }
  </style>
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
      <button type="button" id="set-sched" class="font-inter text-xs bg-brand-600 text-white font-semibold flex gap-2 items-center py-2 px-4 rounded-lg hover:bg-brand-700 h-min">
        Set schedule
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
          <a href="dashboard-new1.php">
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
        <li class="w-full">
          <a href="statistics.php">

            <div class="p-4 flex items-center gap-2 w-full h-full hover:bg-slate-100 cursor-pointer">

              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M21.2099 15.89C20.5737 17.3945 19.5787 18.7202 18.3118 19.7513C17.0449 20.7824 15.5447 21.4874 13.9424 21.8048C12.34 22.1221 10.6843 22.0421 9.12006 21.5718C7.55578 21.1014 6.13054 20.2551 4.96893 19.1067C3.80733 17.9582 2.94473 16.5428 2.45655 14.9839C1.96837 13.4251 1.86948 11.7705 2.16851 10.1646C2.46755 8.55878 3.15541 7.05063 4.17196 5.77203C5.18851 4.49343 6.5028 3.48332 7.99992 2.83M21.9999 12C21.9999 10.6868 21.7413 9.38642 21.2387 8.17317C20.7362 6.95991 19.9996 5.85752 19.071 4.92893C18.1424 4.00035 17.04 3.26375 15.8267 2.7612C14.6135 2.25866 13.3131 2 11.9999 2V12H21.9999Z" stroke="#101828" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              </svg>

              Statistics
            </div>
          </a>
        </li>
        <li class="w-full flex justify-center mt-4">
          <button type="button" class="flex gap-2 px-4 py-2 bg-error-600 rounded-lg text-white" onclick="logout()">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M10.09 15.59L11.5 17L16.5 12L11.5 7L10.09 8.41L12.67 11H3V13H12.67L10.09 15.59ZM19 3H5C3.89 3 3 3.9 3 5V9H5V5H19V19H5V15H3V19C3 20.1 3.89 21 5 21H19C20.1 21 21 20.1 21 19V5C21 3.9 20.1 3 19 3Z" fill="white" />
            </svg>
            Logout
          </button>
        </li>
      </ul>
    </aside>


    <div class="bg-gray-100 h-full max-h-full w-full p-2 relative">
      <div class="h-[34.9rem] w-full bg-gray-100 overflow-y-scroll">
        <div class="flex p-6 items-center justify-between bg-white mb-2 rounded-lg">
          <div class="flex flex-col text-sm gap-4">
            <p class="text-gray-400 text-xs">Friday, 24 November 2023</p>
            <h1 class="text-3xl font-extralight">Good evening, <span class="font-medium"><?php echo $fullname ?></span></h1>
            <p class="text-gray-500">"The purpose of our life is to be <span class="font-medium text-brand-600">happy</span>" - <span class="italic">Dalai Lama</span></p>
          </div>

          <div class="w-[22rem]">

            <svg class="mx-auto" width="199" height="151" viewBox="0 0 288 219" fill="none" xmlns="http://www.w3.org/2000/svg">
              <g clip-path="url(#clip0_280_1046)">
                <path d="M0 198.501C0 198.741 0.193541 198.935 0.434554 198.935H287.565C287.806 198.935 288 198.741 288 198.501C288 198.26 287.806 198.067 287.565 198.067H0.434554C0.193541 198.067 0 198.26 0 198.501Z" fill="#3F3D56" />
                <path d="M157.776 75.7787L160.741 57.2951L140.741 49.1632L137.779 77.2549L157.776 75.7787Z" fill="#A0616A" />
                <path d="M152.722 63.2364C163.986 63.2364 173.117 54.1222 173.117 42.8793C173.117 31.6364 163.986 22.5222 152.722 22.5222C141.458 22.5222 132.327 31.6364 132.327 42.8793C132.327 54.1222 141.458 63.2364 152.722 63.2364Z" fill="#A0616A" />
                <path d="M151.097 15.5129C151.689 15.8556 152.478 15.338 152.667 14.6819C152.857 14.0258 152.635 13.3296 152.419 12.6844C152.054 11.6019 151.685 10.5157 151.32 9.43314C150.538 7.12588 149.71 4.73844 148.022 2.98157C145.47 0.331682 141.417 -0.342635 137.768 0.145789C133.083 0.772722 128.457 3.30597 126.28 7.49402C124.1 11.6821 125.028 17.5286 128.968 20.142C123.355 26.5608 121.398 33.7195 121.708 42.2341C122.019 50.7487 131.312 58.5854 137.378 64.585C138.732 63.7649 139.963 59.9267 139.218 58.5307C138.473 57.1347 139.54 55.52 138.619 54.237C137.699 52.9539 136.925 54.9988 137.86 53.7194C138.448 52.9138 136.151 51.0586 137.027 50.5774C141.256 48.2447 142.662 42.9813 145.32 38.9537C148.523 34.0949 154.008 30.8035 159.81 30.2568C163.005 29.9543 166.383 30.501 169.002 32.3526C171.62 34.2043 173.318 37.5139 172.712 40.6631C174.286 39.0667 175.067 36.7302 174.771 34.5141C174.476 32.298 173.11 30.2422 171.171 29.1159C172.347 25.2304 171.339 20.7617 168.607 17.7546C165.876 14.7475 154.789 15.2614 150.801 16.0524" fill="#2F2E41" />
                <path d="M150.476 30.3698C145.192 30.9384 141.376 35.5092 138.155 39.7264C136.3 42.1576 134.354 44.8439 134.401 47.902C134.449 50.993 136.519 53.6428 137.509 56.5734C139.127 61.3629 137.549 67.0563 133.7 70.3367C137.505 71.0584 141.617 68.2117 142.274 64.4028C143.038 59.9705 139.671 55.6913 140.069 51.208C140.419 47.2605 143.538 44.2206 146.185 41.2682C148.833 38.3158 151.323 34.3975 150.104 30.6249" fill="#2F2E41" />
                <path d="M151.488 216.813C151.488 216.813 107.302 221.187 104.015 216.084C100.729 210.981 148.855 205.878 148.855 205.878L151.488 216.813Z" fill="#A0616A" />
                <path d="M123.315 135.042L122.402 139.879C124.889 143.542 125.126 147.413 123.68 151.444L174.074 151.809C173.533 146.36 172.938 140.52 175.012 135.166L123.315 135.042Z" fill="#A0616A" />
                <path d="M205.858 171.007L187.581 156.412C185.153 154.473 183.579 151.59 183.269 148.503L180.453 120.703L197.233 115.119L201.279 142.645L211.361 165.518L205.862 171.007H205.858Z" fill="#A0616A" />
                <path d="M135.913 73.989L160.38 72.8955L186.307 85.2228L175.717 135.589L122.037 139.598L114.733 83.8304L135.913 73.989Z" fill="#7F56D9" />
                <path d="M175.012 147.194C178.689 152.031 180.23 163.677 181.793 175.26C181.793 175.26 113.871 174.896 113.506 174.896C113.141 174.896 123.888 150.475 123.888 150.475L175.012 147.194Z" fill="#2F2E41" />
                <path d="M177.233 172.17L181.797 175.26C181.797 175.26 246.433 170.887 240.955 191.298C235.477 211.71 218.314 214.991 218.314 214.991L148.932 219L148.201 207.701C148.201 207.701 81.375 222.645 75.1671 192.027C68.9592 161.41 113.51 174.896 113.51 174.896L177.233 172.17Z" fill="#2F2E41" />
                <path d="M149.958 196.401C149.958 196.401 151.488 188.382 162.443 191.663C173.398 194.943 179.606 199.317 179.606 199.317L153.314 205.878L149.958 196.401Z" fill="#A0616A" />
                <path d="M177.36 84.3771C177.36 84.3771 189.776 80.0032 194.523 94.2185C199.271 108.434 198.175 120.098 198.175 120.098L179.917 125.93L177.36 84.3771Z" fill="#7F56D9" />
                <path d="M92.2203 173.227L88.2363 166.221L96.8434 144.836L100.89 117.306L117.669 122.89L114.817 151.029C114.525 153.905 113.061 156.587 110.8 158.392L92.2203 173.23V173.227Z" fill="#A0616A" />
                <path d="M120.759 84.3771C120.759 84.3771 108.343 80.0032 103.595 94.2185C98.8482 108.434 99.9437 120.098 99.9437 120.098L118.202 125.93L120.759 84.3771Z" fill="#7F56D9" />
                <path d="M211.139 174.225C215.979 174.225 219.903 168.432 219.903 161.286C219.903 154.139 215.979 148.346 211.139 148.346C206.298 148.346 202.375 154.139 202.375 161.286C202.375 168.432 206.298 174.225 211.139 174.225Z" fill="#A0616A" />
                <path d="M88.0756 176.412C92.9159 176.412 96.8398 170.619 96.8398 163.473C96.8398 156.326 92.9159 150.533 88.0756 150.533C83.2354 150.533 79.3115 156.326 79.3115 163.473C79.3115 170.619 83.2354 176.412 88.0756 176.412Z" fill="#A0616A" />
                <path d="M121.544 185.102L153.314 194.214L159.522 205.149L147.65 207.701" fill="#2F2E41" />
              </g>
              <defs>
                <clipPath id="clip0_280_1046">
                  <rect width="288" height="219" fill="white" />
                </clipPath>
              </defs>
            </svg>
          </div>

        </div>

        <div class="flex flex-col p-6 items-center bg-white rounded-lg gap-2 mb-2">
          <div class="head flex items-center justify-between w-full">
            <h2 class="text-md font-medium">Latest posts</h2>
            <a href="news-feed.php" class="text-gray-500 text-sm font-medium">View all</a>
          </div>

          <div id="posts" class="flex items-center justify-between w-full gap-2">

            <!-- <!-- Post --> -->
            <!-- <div class='bg-brand-200 rounded-lg w-full h-fit px-4 pt-4 pb-0' data-id=''> -->
            <!--   <!-- Post header --> -->
            <!--   <div class='post-header flex items-center justify-between mb-6' data-id=''> -->
            <!--     <div class='profile flex items-center gap-2'> -->
            <!--       <img src='https://ui-avatars.com/api/?name=Anonymous+user&size=48&rounded=true&color=7F56D9&background=F9F5FF' alt=''> -->
            <!--       <div class='profile-details'> -->
            <!--         <p class='text-sm font-medium'>Hanni Pham</p> -->
            <!--         <p class='text-sm text-gray-500'><span class='capitalize'>student</span> | January 3, 2024</p> -->
            <!--       </div> -->
            <!--     </div> -->
            <!--     <button type='button'> -->
            <!--       <svg width='20' height='21' viewBox='0 0 24 25' fill='none' xmlns='http://www.w3.org/2000/svg'> -->
            <!--         <path d='M18 6.5L6 18.5M6 6.5L18 18.5' stroke='#101828' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' /> -->
            <!--       </svg> -->
            <!--     </button> -->
            <!--   </div> -->
            <!---->
            <!--   <div class='post-content mb-2'> -->
            <!--     <p class='text-sm mb-4'> -->
            <!--       ${data.post_text} -->
            <!--     </p> -->
            <!---->
            <!--     <div class='mt-2 flex justify-between items-center'> -->
            <!--       <!-- Number of likes --> -->
            <!--       <div class='flex items-center gap-2 like-counter'> -->
            <!--         <svg width='16' height='16' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'> -->
            <!--           <path d='M23.3041 11.944C23.3041 11.6086 23.2241 11.294 23.0901 11.008C22.1961 8.12398 18.0107 8.33464 12.0574 8.19398C11.0621 8.17064 11.6314 6.99531 11.9807 4.41531C12.2081 2.73731 11.1261 0.160645 9.30741 0.160645C6.30874 0.160645 9.19341 2.52598 6.54207 8.37531C5.12541 11.5006 1.95874 9.74998 1.95874 12.8893V20.0353C1.95874 21.2573 2.07874 22.432 3.79741 22.6253C5.46341 22.8126 5.08874 24 7.49207 24H19.5214C20.1106 23.9993 20.6755 23.7648 21.0921 23.3482C21.5086 22.9315 21.7429 22.3665 21.7434 21.7773C21.7434 21.2693 21.5654 20.8066 21.2781 20.432C21.9581 20.0513 22.4247 19.3326 22.4247 18.4993C22.4247 17.9926 22.2474 17.53 21.9607 17.156C22.6427 16.776 23.1107 16.0566 23.1107 15.222C23.1107 14.616 22.8654 14.0666 22.4701 13.6646C22.7292 13.4587 22.9387 13.1972 23.0831 12.8993C23.2274 12.6015 23.303 12.275 23.3041 11.944Z' fill='#FFDB5E' /> -->
            <!--           <path d='M15.3468 14.1659H21.0828C21.8628 14.1659 22.5948 13.7486 22.9934 13.0773C23.0644 12.9446 23.0814 12.7896 23.0409 12.6446C23.0005 12.4997 22.9056 12.376 22.7761 12.2993C22.6466 12.2226 22.4925 12.1989 22.346 12.233C22.1994 12.2672 22.0717 12.3566 21.9894 12.4826C21.8957 12.6398 21.7629 12.77 21.6039 12.8606C21.4449 12.9511 21.2651 12.9989 21.0821 12.9993H15.2088C14.6268 12.9993 14.1534 12.5259 14.1534 11.9439C14.1534 11.3619 14.6268 10.8886 15.2088 10.8886H19.1334C19.2881 10.8886 19.4365 10.8271 19.5459 10.7177C19.6553 10.6083 19.7168 10.46 19.7168 10.3053C19.7168 10.1505 19.6553 10.0022 19.5459 9.89278C19.4365 9.78338 19.2881 9.72192 19.1334 9.72192H15.2081C14.619 9.72263 14.0542 9.95696 13.6377 10.3735C13.2211 10.7901 12.9868 11.3548 12.9861 11.9439C12.9861 12.6273 13.3028 13.2319 13.7894 13.6399C13.5788 13.846 13.4114 14.0922 13.2972 14.3638C13.1829 14.6355 13.1241 14.9272 13.1241 15.2219C13.1241 15.9073 13.4428 16.5139 13.9321 16.9213C13.701 17.1486 13.5226 17.424 13.4097 17.7279C13.2969 18.0319 13.2521 18.3569 13.2788 18.68C13.3054 19.0031 13.4028 19.3164 13.564 19.5977C13.7251 19.8791 13.9462 20.1215 14.2114 20.3079C13.8475 20.711 13.6452 21.2342 13.6434 21.7773C13.6441 22.3664 13.8785 22.9311 14.295 23.3477C14.7116 23.7642 15.2763 23.9986 15.8654 23.9993H19.5214C19.9068 23.9982 20.2854 23.8975 20.6203 23.7068C20.9552 23.5162 21.2351 23.2421 21.4327 22.9113C21.5081 22.7785 21.5284 22.6214 21.4893 22.4739C21.4501 22.3263 21.3547 22.2 21.2235 22.1219C21.0922 22.0439 20.9356 22.0205 20.7873 22.0566C20.639 22.0928 20.5107 22.1856 20.4301 22.3153C20.3361 22.4725 20.203 22.6028 20.0438 22.6934C19.8846 22.7841 19.7046 22.832 19.5214 22.8326H15.8654C15.2834 22.8326 14.8101 22.3593 14.8101 21.7773C14.8101 21.1953 15.2834 20.7219 15.8654 20.7219H20.2028C20.5882 20.7208 20.9668 20.62 21.3017 20.4292C21.6367 20.2384 21.9165 19.9642 22.1141 19.6333C22.1551 19.5674 22.1825 19.494 22.1948 19.4173C22.207 19.3407 22.2039 19.2624 22.1855 19.187C22.1671 19.1117 22.1339 19.0407 22.0878 18.9783C22.0416 18.9159 21.9835 18.8633 21.9168 18.8237C21.8501 18.7841 21.7762 18.7581 21.6993 18.7474C21.6225 18.7367 21.5443 18.7414 21.4693 18.7613C21.3943 18.7812 21.324 18.8158 21.2625 18.8632C21.2011 18.9106 21.1497 18.9698 21.1114 19.0373C21.0186 19.1956 20.8858 19.3268 20.7263 19.4177C20.5669 19.5086 20.3863 19.5561 20.2028 19.5553H15.4941C15.2221 19.5434 14.9651 19.427 14.7768 19.2303C14.5885 19.0337 14.4834 18.7719 14.4834 18.4996C14.4834 18.2273 14.5885 17.9655 14.7768 17.7688C14.9651 17.5722 15.2221 17.4558 15.4941 17.4439H20.8881C21.2735 17.4429 21.652 17.3422 21.987 17.1515C22.3219 16.9609 22.6018 16.6868 22.7994 16.3559C22.8748 16.2231 22.895 16.0661 22.8559 15.9185C22.8168 15.771 22.7214 15.6446 22.5901 15.5666C22.4589 15.4886 22.3023 15.4652 22.154 15.5013C22.0056 15.5374 21.8774 15.6303 21.7968 15.7599C21.7038 15.9181 21.5709 16.0491 21.4115 16.1399C21.252 16.2307 21.0716 16.2781 20.8881 16.2773H15.3468C15.0747 16.2654 14.8178 16.149 14.6295 15.9523C14.4412 15.7557 14.336 15.4939 14.336 15.2216C14.336 14.9493 14.4412 14.6875 14.6295 14.4908C14.8178 14.2942 15.0747 14.1778 15.3468 14.1659Z' fill='#EE9547' /> -->
            <!--         </svg> -->
            <!--         <span class='text-sm num_likes'>25</span> -->
            <!--       </div> -->
            <!--       <!-- Number of comments --> -->
            <!--       <div class='flex items-center gap-2 comment-counter'> -->
            <!--         <svg width='16' height='16' viewBox='0 0 24 24' fill='#475467' xmlns='http://www.w3.org/2000/svg'> -->
            <!--           <path d='M21 11.5C21.0034 12.8199 20.6951 14.1219 20.1 15.3C19.3944 16.7118 18.3098 17.8992 16.9674 18.7293C15.6251 19.5594 14.0782 19.9994 12.5 20C11.1801 20.0035 9.87812 19.6951 8.7 19.1L3 21L4.9 15.3C4.30493 14.1219 3.99656 12.8199 4 11.5C4.00061 9.92179 4.44061 8.37488 5.27072 7.03258C6.10083 5.69028 7.28825 4.6056 8.7 3.90003C9.87812 3.30496 11.1801 2.99659 12.5 3.00003H13C15.0843 3.11502 17.053 3.99479 18.5291 5.47089C20.0052 6.94699 20.885 8.91568 21 11V11.5Z' stroke='#475467' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' /> -->
            <!--         </svg> -->
            <!--         <span class='text-sm num_comments'>25</span> -->
            <!--       </div> -->
            <!--     </div> -->
            <!--   </div> -->
            <!--   <div class='react flex items-center justify-around border-t border-gray-400'> -->
            <!--     <button type='button' class='like-btn flex items-center justify-center px-4 py-2 hover:bg-gray-300 rounded-lg text-sm gap-2 font-medium' data-post-id='${data.post_id}' data-user-id='${data.poster_id}'> -->
            <!--       <svg class='fill-brand-200' width='16' height='16' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'> -->
            <!--         <path d='M7 22H4C3.46957 22 2.96086 21.7893 2.58579 21.4142C2.21071 21.0391 2 20.5304 2 20V13C2 12.4696 2.21071 11.9609 2.58579 11.5858C2.96086 11.2107 3.46957 11 4 11H7M14 9V5C14 4.20435 13.6839 3.44129 13.1213 2.87868C12.5587 2.31607 11.7956 2 11 2L7 11V22H18.28C18.7623 22.0055 19.2304 21.8364 19.5979 21.524C19.9654 21.2116 20.2077 20.7769 20.28 20.3L21.66 11.3C21.7035 11.0134 21.6842 10.7207 21.6033 10.4423C21.5225 10.1638 21.3821 9.90629 21.1919 9.68751C21.0016 9.46873 20.7661 9.29393 20.5016 9.17522C20.2371 9.0565 19.9499 8.99672 19.66 9H14Z' stroke='#475467' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' /> -->
            <!--       </svg> -->
            <!---->
            <!--       Like -->
            <!--     </button> -->
            <!--     <button type='button' class='comment-btn flex items-center justify-center px-4 py-2 hover:bg-gray-300 rounded-lg text-sm gap-2 font-medium'> -->
            <!--       <svg width='16' height='16' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'> -->
            <!--         <path d='M21 11.5C21.0034 12.8199 20.6951 14.1219 20.1 15.3C19.3944 16.7118 18.3098 17.8992 16.9674 18.7293C15.6251 19.5594 14.0782 19.9994 12.5 20C11.1801 20.0035 9.87812 19.6951 8.7 19.1L3 21L4.9 15.3C4.30493 14.1219 3.99656 12.8199 4 11.5C4.00061 9.92179 4.44061 8.37488 5.27072 7.03258C6.10083 5.69028 7.28825 4.6056 8.7 3.90003C9.87812 3.30496 11.1801 2.99659 12.5 3.00003H13C15.0843 3.11502 17.053 3.99479 18.5291 5.47089C20.0052 6.94699 20.885 8.91568 21 11V11.5Z' stroke='#475467' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' /> -->
            <!--       </svg> -->
            <!---->
            <!--       Comment -->
            <!--     </button> -->
            <!--   </div> -->
            <!---->
            <!-- </div> -->
            <!---->
            <!-- <!-- Post --> -->
            <!-- <div class='bg-brand-200 rounded-lg w-full h-fit px-4 pt-4 pb-0' data-id=''> -->
            <!--   <!-- Post header --> -->
            <!--   <div class='post-header flex items-center justify-between mb-6' data-id=''> -->
            <!--     <div class='profile flex items-center gap-2'> -->
            <!--       <img src='https://ui-avatars.com/api/?name=Anonymous+user&size=48&rounded=true&color=7F56D9&background=F9F5FF' alt=''> -->
            <!--       <div class='profile-details'> -->
            <!--         <p class='text-sm font-medium'>Hanni Pham</p> -->
            <!--         <p class='text-sm text-gray-500'><span class='capitalize'>student</span> | January 3, 2024</p> -->
            <!--       </div> -->
            <!--     </div> -->
            <!--     <button type='button'> -->
            <!--       <svg width='20' height='21' viewBox='0 0 24 25' fill='none' xmlns='http://www.w3.org/2000/svg'> -->
            <!--         <path d='M18 6.5L6 18.5M6 6.5L18 18.5' stroke='#101828' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' /> -->
            <!--       </svg> -->
            <!--     </button> -->
            <!--   </div> -->
            <!---->
            <!--   <div class='post-content mb-2'> -->
            <!--     <p class='text-sm mb-4'> -->
            <!--       ${data.post_text} -->
            <!--     </p> -->
            <!---->
            <!--     <div class='mt-2 flex justify-between items-center'> -->
            <!--       <!-- Number of likes --> -->
            <!--       <div class='flex items-center gap-2 like-counter'> -->
            <!--         <svg width='16' height='16' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'> -->
            <!--           <path d='M23.3041 11.944C23.3041 11.6086 23.2241 11.294 23.0901 11.008C22.1961 8.12398 18.0107 8.33464 12.0574 8.19398C11.0621 8.17064 11.6314 6.99531 11.9807 4.41531C12.2081 2.73731 11.1261 0.160645 9.30741 0.160645C6.30874 0.160645 9.19341 2.52598 6.54207 8.37531C5.12541 11.5006 1.95874 9.74998 1.95874 12.8893V20.0353C1.95874 21.2573 2.07874 22.432 3.79741 22.6253C5.46341 22.8126 5.08874 24 7.49207 24H19.5214C20.1106 23.9993 20.6755 23.7648 21.0921 23.3482C21.5086 22.9315 21.7429 22.3665 21.7434 21.7773C21.7434 21.2693 21.5654 20.8066 21.2781 20.432C21.9581 20.0513 22.4247 19.3326 22.4247 18.4993C22.4247 17.9926 22.2474 17.53 21.9607 17.156C22.6427 16.776 23.1107 16.0566 23.1107 15.222C23.1107 14.616 22.8654 14.0666 22.4701 13.6646C22.7292 13.4587 22.9387 13.1972 23.0831 12.8993C23.2274 12.6015 23.303 12.275 23.3041 11.944Z' fill='#FFDB5E' /> -->
            <!--           <path d='M15.3468 14.1659H21.0828C21.8628 14.1659 22.5948 13.7486 22.9934 13.0773C23.0644 12.9446 23.0814 12.7896 23.0409 12.6446C23.0005 12.4997 22.9056 12.376 22.7761 12.2993C22.6466 12.2226 22.4925 12.1989 22.346 12.233C22.1994 12.2672 22.0717 12.3566 21.9894 12.4826C21.8957 12.6398 21.7629 12.77 21.6039 12.8606C21.4449 12.9511 21.2651 12.9989 21.0821 12.9993H15.2088C14.6268 12.9993 14.1534 12.5259 14.1534 11.9439C14.1534 11.3619 14.6268 10.8886 15.2088 10.8886H19.1334C19.2881 10.8886 19.4365 10.8271 19.5459 10.7177C19.6553 10.6083 19.7168 10.46 19.7168 10.3053C19.7168 10.1505 19.6553 10.0022 19.5459 9.89278C19.4365 9.78338 19.2881 9.72192 19.1334 9.72192H15.2081C14.619 9.72263 14.0542 9.95696 13.6377 10.3735C13.2211 10.7901 12.9868 11.3548 12.9861 11.9439C12.9861 12.6273 13.3028 13.2319 13.7894 13.6399C13.5788 13.846 13.4114 14.0922 13.2972 14.3638C13.1829 14.6355 13.1241 14.9272 13.1241 15.2219C13.1241 15.9073 13.4428 16.5139 13.9321 16.9213C13.701 17.1486 13.5226 17.424 13.4097 17.7279C13.2969 18.0319 13.2521 18.3569 13.2788 18.68C13.3054 19.0031 13.4028 19.3164 13.564 19.5977C13.7251 19.8791 13.9462 20.1215 14.2114 20.3079C13.8475 20.711 13.6452 21.2342 13.6434 21.7773C13.6441 22.3664 13.8785 22.9311 14.295 23.3477C14.7116 23.7642 15.2763 23.9986 15.8654 23.9993H19.5214C19.9068 23.9982 20.2854 23.8975 20.6203 23.7068C20.9552 23.5162 21.2351 23.2421 21.4327 22.9113C21.5081 22.7785 21.5284 22.6214 21.4893 22.4739C21.4501 22.3263 21.3547 22.2 21.2235 22.1219C21.0922 22.0439 20.9356 22.0205 20.7873 22.0566C20.639 22.0928 20.5107 22.1856 20.4301 22.3153C20.3361 22.4725 20.203 22.6028 20.0438 22.6934C19.8846 22.7841 19.7046 22.832 19.5214 22.8326H15.8654C15.2834 22.8326 14.8101 22.3593 14.8101 21.7773C14.8101 21.1953 15.2834 20.7219 15.8654 20.7219H20.2028C20.5882 20.7208 20.9668 20.62 21.3017 20.4292C21.6367 20.2384 21.9165 19.9642 22.1141 19.6333C22.1551 19.5674 22.1825 19.494 22.1948 19.4173C22.207 19.3407 22.2039 19.2624 22.1855 19.187C22.1671 19.1117 22.1339 19.0407 22.0878 18.9783C22.0416 18.9159 21.9835 18.8633 21.9168 18.8237C21.8501 18.7841 21.7762 18.7581 21.6993 18.7474C21.6225 18.7367 21.5443 18.7414 21.4693 18.7613C21.3943 18.7812 21.324 18.8158 21.2625 18.8632C21.2011 18.9106 21.1497 18.9698 21.1114 19.0373C21.0186 19.1956 20.8858 19.3268 20.7263 19.4177C20.5669 19.5086 20.3863 19.5561 20.2028 19.5553H15.4941C15.2221 19.5434 14.9651 19.427 14.7768 19.2303C14.5885 19.0337 14.4834 18.7719 14.4834 18.4996C14.4834 18.2273 14.5885 17.9655 14.7768 17.7688C14.9651 17.5722 15.2221 17.4558 15.4941 17.4439H20.8881C21.2735 17.4429 21.652 17.3422 21.987 17.1515C22.3219 16.9609 22.6018 16.6868 22.7994 16.3559C22.8748 16.2231 22.895 16.0661 22.8559 15.9185C22.8168 15.771 22.7214 15.6446 22.5901 15.5666C22.4589 15.4886 22.3023 15.4652 22.154 15.5013C22.0056 15.5374 21.8774 15.6303 21.7968 15.7599C21.7038 15.9181 21.5709 16.0491 21.4115 16.1399C21.252 16.2307 21.0716 16.2781 20.8881 16.2773H15.3468C15.0747 16.2654 14.8178 16.149 14.6295 15.9523C14.4412 15.7557 14.336 15.4939 14.336 15.2216C14.336 14.9493 14.4412 14.6875 14.6295 14.4908C14.8178 14.2942 15.0747 14.1778 15.3468 14.1659Z' fill='#EE9547' /> -->
            <!--         </svg> -->
            <!--         <span class='text-sm num_likes'>25</span> -->
            <!--       </div> -->
            <!--       <!-- Number of comments --> -->
            <!--       <div class='flex items-center gap-2 comment-counter'> -->
            <!--         <svg width='16' height='16' viewBox='0 0 24 24' fill='#475467' xmlns='http://www.w3.org/2000/svg'> -->
            <!--           <path d='M21 11.5C21.0034 12.8199 20.6951 14.1219 20.1 15.3C19.3944 16.7118 18.3098 17.8992 16.9674 18.7293C15.6251 19.5594 14.0782 19.9994 12.5 20C11.1801 20.0035 9.87812 19.6951 8.7 19.1L3 21L4.9 15.3C4.30493 14.1219 3.99656 12.8199 4 11.5C4.00061 9.92179 4.44061 8.37488 5.27072 7.03258C6.10083 5.69028 7.28825 4.6056 8.7 3.90003C9.87812 3.30496 11.1801 2.99659 12.5 3.00003H13C15.0843 3.11502 17.053 3.99479 18.5291 5.47089C20.0052 6.94699 20.885 8.91568 21 11V11.5Z' stroke='#475467' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' /> -->
            <!--         </svg> -->
            <!--         <span class='text-sm num_comments'>25</span> -->
            <!--       </div> -->
            <!--     </div> -->
            <!--   </div> -->
            <!--   <div class='react flex items-center justify-around border-t border-gray-400'> -->
            <!--     <button type='button' class='like-btn flex items-center justify-center px-4 py-2 hover:bg-gray-300 rounded-lg text-sm gap-2 font-medium' data-post-id='${data.post_id}' data-user-id='${data.poster_id}'> -->
            <!--       <svg class='fill-brand-200' width='16' height='16' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'> -->
            <!--         <path d='M7 22H4C3.46957 22 2.96086 21.7893 2.58579 21.4142C2.21071 21.0391 2 20.5304 2 20V13C2 12.4696 2.21071 11.9609 2.58579 11.5858C2.96086 11.2107 3.46957 11 4 11H7M14 9V5C14 4.20435 13.6839 3.44129 13.1213 2.87868C12.5587 2.31607 11.7956 2 11 2L7 11V22H18.28C18.7623 22.0055 19.2304 21.8364 19.5979 21.524C19.9654 21.2116 20.2077 20.7769 20.28 20.3L21.66 11.3C21.7035 11.0134 21.6842 10.7207 21.6033 10.4423C21.5225 10.1638 21.3821 9.90629 21.1919 9.68751C21.0016 9.46873 20.7661 9.29393 20.5016 9.17522C20.2371 9.0565 19.9499 8.99672 19.66 9H14Z' stroke='#475467' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' /> -->
            <!--       </svg> -->
            <!---->
            <!--       Like -->
            <!--     </button> -->
            <!--     <button type='button' class='comment-btn flex items-center justify-center px-4 py-2 hover:bg-gray-300 rounded-lg text-sm gap-2 font-medium'> -->
            <!--       <svg width='16' height='16' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'> -->
            <!--         <path d='M21 11.5C21.0034 12.8199 20.6951 14.1219 20.1 15.3C19.3944 16.7118 18.3098 17.8992 16.9674 18.7293C15.6251 19.5594 14.0782 19.9994 12.5 20C11.1801 20.0035 9.87812 19.6951 8.7 19.1L3 21L4.9 15.3C4.30493 14.1219 3.99656 12.8199 4 11.5C4.00061 9.92179 4.44061 8.37488 5.27072 7.03258C6.10083 5.69028 7.28825 4.6056 8.7 3.90003C9.87812 3.30496 11.1801 2.99659 12.5 3.00003H13C15.0843 3.11502 17.053 3.99479 18.5291 5.47089C20.0052 6.94699 20.885 8.91568 21 11V11.5Z' stroke='#475467' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' /> -->
            <!--       </svg> -->
            <!---->
            <!--       Comment -->
            <!--     </button> -->
            <!--   </div> -->
            <!---->
            <!-- </div> -->
            <!---->
            <!-- <!-- Post --> -->
            <!-- <div class='bg-brand-200 rounded-lg w-full h-fit px-4 pt-4 pb-0' data-id=''> -->
            <!--   <!-- Post header --> -->
            <!--   <div class='post-header flex items-center justify-between mb-6' data-id=''> -->
            <!--     <div class='profile flex items-center gap-2'> -->
            <!--       <img src='https://ui-avatars.com/api/?name=Anonymous+user&size=48&rounded=true&color=7F56D9&background=F9F5FF' alt=''> -->
            <!--       <div class='profile-details'> -->
            <!--         <p class='text-sm font-medium'>Hanni Pham</p> -->
            <!--         <p class='text-sm text-gray-500'><span class='capitalize'>student</span> | January 3, 2024</p> -->
            <!--       </div> -->
            <!--     </div> -->
            <!--     <button type='button'> -->
            <!--       <svg width='20' height='21' viewBox='0 0 24 25' fill='none' xmlns='http://www.w3.org/2000/svg'> -->
            <!--         <path d='M18 6.5L6 18.5M6 6.5L18 18.5' stroke='#101828' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' /> -->
            <!--       </svg> -->
            <!--     </button> -->
            <!--   </div> -->
            <!---->
            <!--   <div class='post-content mb-2'> -->
            <!--     <p class='text-sm mb-4'> -->
            <!--       ${data.post_text} -->
            <!--     </p> -->
            <!---->
            <!--     <div class='mt-2 flex justify-between items-center'> -->
            <!--       <!-- Number of likes --> -->
            <!--       <div class='flex items-center gap-2 like-counter'> -->
            <!--         <svg width='16' height='16' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'> -->
            <!--           <path d='M23.3041 11.944C23.3041 11.6086 23.2241 11.294 23.0901 11.008C22.1961 8.12398 18.0107 8.33464 12.0574 8.19398C11.0621 8.17064 11.6314 6.99531 11.9807 4.41531C12.2081 2.73731 11.1261 0.160645 9.30741 0.160645C6.30874 0.160645 9.19341 2.52598 6.54207 8.37531C5.12541 11.5006 1.95874 9.74998 1.95874 12.8893V20.0353C1.95874 21.2573 2.07874 22.432 3.79741 22.6253C5.46341 22.8126 5.08874 24 7.49207 24H19.5214C20.1106 23.9993 20.6755 23.7648 21.0921 23.3482C21.5086 22.9315 21.7429 22.3665 21.7434 21.7773C21.7434 21.2693 21.5654 20.8066 21.2781 20.432C21.9581 20.0513 22.4247 19.3326 22.4247 18.4993C22.4247 17.9926 22.2474 17.53 21.9607 17.156C22.6427 16.776 23.1107 16.0566 23.1107 15.222C23.1107 14.616 22.8654 14.0666 22.4701 13.6646C22.7292 13.4587 22.9387 13.1972 23.0831 12.8993C23.2274 12.6015 23.303 12.275 23.3041 11.944Z' fill='#FFDB5E' /> -->
            <!--           <path d='M15.3468 14.1659H21.0828C21.8628 14.1659 22.5948 13.7486 22.9934 13.0773C23.0644 12.9446 23.0814 12.7896 23.0409 12.6446C23.0005 12.4997 22.9056 12.376 22.7761 12.2993C22.6466 12.2226 22.4925 12.1989 22.346 12.233C22.1994 12.2672 22.0717 12.3566 21.9894 12.4826C21.8957 12.6398 21.7629 12.77 21.6039 12.8606C21.4449 12.9511 21.2651 12.9989 21.0821 12.9993H15.2088C14.6268 12.9993 14.1534 12.5259 14.1534 11.9439C14.1534 11.3619 14.6268 10.8886 15.2088 10.8886H19.1334C19.2881 10.8886 19.4365 10.8271 19.5459 10.7177C19.6553 10.6083 19.7168 10.46 19.7168 10.3053C19.7168 10.1505 19.6553 10.0022 19.5459 9.89278C19.4365 9.78338 19.2881 9.72192 19.1334 9.72192H15.2081C14.619 9.72263 14.0542 9.95696 13.6377 10.3735C13.2211 10.7901 12.9868 11.3548 12.9861 11.9439C12.9861 12.6273 13.3028 13.2319 13.7894 13.6399C13.5788 13.846 13.4114 14.0922 13.2972 14.3638C13.1829 14.6355 13.1241 14.9272 13.1241 15.2219C13.1241 15.9073 13.4428 16.5139 13.9321 16.9213C13.701 17.1486 13.5226 17.424 13.4097 17.7279C13.2969 18.0319 13.2521 18.3569 13.2788 18.68C13.3054 19.0031 13.4028 19.3164 13.564 19.5977C13.7251 19.8791 13.9462 20.1215 14.2114 20.3079C13.8475 20.711 13.6452 21.2342 13.6434 21.7773C13.6441 22.3664 13.8785 22.9311 14.295 23.3477C14.7116 23.7642 15.2763 23.9986 15.8654 23.9993H19.5214C19.9068 23.9982 20.2854 23.8975 20.6203 23.7068C20.9552 23.5162 21.2351 23.2421 21.4327 22.9113C21.5081 22.7785 21.5284 22.6214 21.4893 22.4739C21.4501 22.3263 21.3547 22.2 21.2235 22.1219C21.0922 22.0439 20.9356 22.0205 20.7873 22.0566C20.639 22.0928 20.5107 22.1856 20.4301 22.3153C20.3361 22.4725 20.203 22.6028 20.0438 22.6934C19.8846 22.7841 19.7046 22.832 19.5214 22.8326H15.8654C15.2834 22.8326 14.8101 22.3593 14.8101 21.7773C14.8101 21.1953 15.2834 20.7219 15.8654 20.7219H20.2028C20.5882 20.7208 20.9668 20.62 21.3017 20.4292C21.6367 20.2384 21.9165 19.9642 22.1141 19.6333C22.1551 19.5674 22.1825 19.494 22.1948 19.4173C22.207 19.3407 22.2039 19.2624 22.1855 19.187C22.1671 19.1117 22.1339 19.0407 22.0878 18.9783C22.0416 18.9159 21.9835 18.8633 21.9168 18.8237C21.8501 18.7841 21.7762 18.7581 21.6993 18.7474C21.6225 18.7367 21.5443 18.7414 21.4693 18.7613C21.3943 18.7812 21.324 18.8158 21.2625 18.8632C21.2011 18.9106 21.1497 18.9698 21.1114 19.0373C21.0186 19.1956 20.8858 19.3268 20.7263 19.4177C20.5669 19.5086 20.3863 19.5561 20.2028 19.5553H15.4941C15.2221 19.5434 14.9651 19.427 14.7768 19.2303C14.5885 19.0337 14.4834 18.7719 14.4834 18.4996C14.4834 18.2273 14.5885 17.9655 14.7768 17.7688C14.9651 17.5722 15.2221 17.4558 15.4941 17.4439H20.8881C21.2735 17.4429 21.652 17.3422 21.987 17.1515C22.3219 16.9609 22.6018 16.6868 22.7994 16.3559C22.8748 16.2231 22.895 16.0661 22.8559 15.9185C22.8168 15.771 22.7214 15.6446 22.5901 15.5666C22.4589 15.4886 22.3023 15.4652 22.154 15.5013C22.0056 15.5374 21.8774 15.6303 21.7968 15.7599C21.7038 15.9181 21.5709 16.0491 21.4115 16.1399C21.252 16.2307 21.0716 16.2781 20.8881 16.2773H15.3468C15.0747 16.2654 14.8178 16.149 14.6295 15.9523C14.4412 15.7557 14.336 15.4939 14.336 15.2216C14.336 14.9493 14.4412 14.6875 14.6295 14.4908C14.8178 14.2942 15.0747 14.1778 15.3468 14.1659Z' fill='#EE9547' /> -->
            <!--         </svg> -->
            <!--         <span class='text-sm num_likes'>25</span> -->
            <!--       </div> -->
            <!--       <!-- Number of comments --> -->
            <!--       <div class='flex items-center gap-2 comment-counter'> -->
            <!--         <svg width='16' height='16' viewBox='0 0 24 24' fill='#475467' xmlns='http://www.w3.org/2000/svg'> -->
            <!--           <path d='M21 11.5C21.0034 12.8199 20.6951 14.1219 20.1 15.3C19.3944 16.7118 18.3098 17.8992 16.9674 18.7293C15.6251 19.5594 14.0782 19.9994 12.5 20C11.1801 20.0035 9.87812 19.6951 8.7 19.1L3 21L4.9 15.3C4.30493 14.1219 3.99656 12.8199 4 11.5C4.00061 9.92179 4.44061 8.37488 5.27072 7.03258C6.10083 5.69028 7.28825 4.6056 8.7 3.90003C9.87812 3.30496 11.1801 2.99659 12.5 3.00003H13C15.0843 3.11502 17.053 3.99479 18.5291 5.47089C20.0052 6.94699 20.885 8.91568 21 11V11.5Z' stroke='#475467' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' /> -->
            <!--         </svg> -->
            <!--         <span class='text-sm num_comments'>25</span> -->
            <!--       </div> -->
            <!--     </div> -->
            <!--   </div> -->
            <!--   <div class='react flex items-center justify-around border-t border-gray-400'> -->
            <!--     <button type='button' class='like-btn flex items-center justify-center px-4 py-2 hover:bg-gray-300 rounded-lg text-sm gap-2 font-medium' data-post-id='${data.post_id}' data-user-id='${data.poster_id}'> -->
            <!--       <svg class='fill-brand-200' width='16' height='16' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'> -->
            <!--         <path d='M7 22H4C3.46957 22 2.96086 21.7893 2.58579 21.4142C2.21071 21.0391 2 20.5304 2 20V13C2 12.4696 2.21071 11.9609 2.58579 11.5858C2.96086 11.2107 3.46957 11 4 11H7M14 9V5C14 4.20435 13.6839 3.44129 13.1213 2.87868C12.5587 2.31607 11.7956 2 11 2L7 11V22H18.28C18.7623 22.0055 19.2304 21.8364 19.5979 21.524C19.9654 21.2116 20.2077 20.7769 20.28 20.3L21.66 11.3C21.7035 11.0134 21.6842 10.7207 21.6033 10.4423C21.5225 10.1638 21.3821 9.90629 21.1919 9.68751C21.0016 9.46873 20.7661 9.29393 20.5016 9.17522C20.2371 9.0565 19.9499 8.99672 19.66 9H14Z' stroke='#475467' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' /> -->
            <!--       </svg> -->
            <!---->
            <!--       Like -->
            <!--     </button> -->
            <!--     <button type='button' class='comment-btn flex items-center justify-center px-4 py-2 hover:bg-gray-300 rounded-lg text-sm gap-2 font-medium'> -->
            <!--       <svg width='16' height='16' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'> -->
            <!--         <path d='M21 11.5C21.0034 12.8199 20.6951 14.1219 20.1 15.3C19.3944 16.7118 18.3098 17.8992 16.9674 18.7293C15.6251 19.5594 14.0782 19.9994 12.5 20C11.1801 20.0035 9.87812 19.6951 8.7 19.1L3 21L4.9 15.3C4.30493 14.1219 3.99656 12.8199 4 11.5C4.00061 9.92179 4.44061 8.37488 5.27072 7.03258C6.10083 5.69028 7.28825 4.6056 8.7 3.90003C9.87812 3.30496 11.1801 2.99659 12.5 3.00003H13C15.0843 3.11502 17.053 3.99479 18.5291 5.47089C20.0052 6.94699 20.885 8.91568 21 11V11.5Z' stroke='#475467' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' /> -->
            <!--       </svg> -->
            <!---->
            <!--       Comment -->
            <!--     </button> -->
            <!--   </div> -->
            <!---->
            <!-- </div> -->
          </div>
        </div>

        <!-- Appointments and incidents -->
        <div class="flex gap-2 justify-between w-full">

          <div class="w-full bg-white rounded-lg px-4 pb-4">

            <div class="w-full h-full">
              <div class="head flex items-center justify-between mb-4 px-2 pt-6">
                <h2 class="text-md font-medium">Appointments</h2>
                <a href="appointments.php" class="text-gray-500 text-sm font-medium">View all</a>
              </div>

              <!-- Appointments -->
              <div id="appointments" class="flex flex-col gap-2 h-96">


                <!-- <div class='flex items-center justify-between hover:bg-brand-100 px-2 py-4 rounded-lg cursor-pointer' data-id=''> -->
                <!--   <div class='profile flex items-center gap-2'> -->
                <!--     <img src='https://ui-avatars.com/api/?name=Anonymous+user&size=48&rounded=true&color=7F56D9&background=F9F5FF' alt=''> -->
                <!--     <div class='profile-details'> -->
                <!--       <p class='text-sm font-medium'>Hanni Pham</p> -->
                <!--       <p class='text-sm text-gray-500'><span class='capitalize'>student</span> | January 3, 2024</p> -->
                <!--     </div> -->
                <!--   </div> -->
                <!--   <div class="text-sm text-right"> -->
                <!--     <p class=''>January 3, 2024</p> -->
                <!--     <p class='text-gray-500'>9:00 AM</p> -->
                <!--   </div> -->
                <!-- </div> -->
                <!-- <div class='flex items-center justify-between hover:bg-brand-100 px-2 py-4 rounded-lg cursor-pointer' data-id=''> -->
                <!--   <div class='profile flex items-center gap-2'> -->
                <!--     <img src='https://ui-avatars.com/api/?name=Anonymous+user&size=48&rounded=true&color=7F56D9&background=F9F5FF' alt=''> -->
                <!--     <div class='profile-details'> -->
                <!--       <p class='text-sm font-medium'>Hanni Pham</p> -->
                <!--       <p class='text-sm text-gray-500'><span class='capitalize'>student</span> | January 3, 2024</p> -->
                <!--     </div> -->
                <!--   </div> -->
                <!--   <div class="text-sm text-right"> -->
                <!--     <p class=''>January 3, 2024</p> -->
                <!--     <p class='text-gray-500'>9:00 AM</p> -->
                <!--   </div> -->
                <!-- </div> -->
                <!-- <div class='flex items-center justify-between hover:bg-brand-100 px-2 py-4 rounded-lg cursor-pointer' data-id=''> -->
                <!--   <div class='profile flex items-center gap-2'> -->
                <!--     <img src='https://ui-avatars.com/api/?name=Anonymous+user&size=48&rounded=true&color=7F56D9&background=F9F5FF' alt=''> -->
                <!--     <div class='profile-details'> -->
                <!--       <p class='text-sm font-medium'>Hanni Pham</p> -->
                <!--       <p class='text-sm text-gray-500'><span class='capitalize'>student</span> | January 3, 2024</p> -->
                <!--     </div> -->
                <!--   </div> -->
                <!--   <div class="text-sm text-right"> -->
                <!--     <p class=''>January 3, 2024</p> -->
                <!--     <p class='text-gray-500'>9:00 AM</p> -->
                <!--   </div> -->
                <!-- </div> -->
              </div>

            </div>

          </div>
          <!-- incidents -->
          <div class="flex flex-col w-full bg-white rounded-lg p-6 gap-2">
            <div class="head flex items-center justify-between">
              <h2 class="text-md font-medium">Incident map <span class="font-normal text-sm">(click markers for details)</span></h2>
              <p class="text-gray-500 text-sm font-medium"><?php echo "As of " . date("h:i A") ?></p>
            </div>

            <div id="incident-map" class="w-full h-full bg-brand-400 rounded-lg z-0 min-h-[22rem]">
            </div>
          </div>

        </div>

      </div>

    </div>
  </div>


  </div>

  <!--Notifications-->
  <div id="notification-modal" class="w-full h-full bg-brand-400 bg-opacity-40 hidden place-items-center absolute">
    <div class="bg-white p-8 w-3/6 max-h-96 rounded-xl">
      <div class="header flex justify-between mb-6">
        <h2 class="text-xl">Notifications</h2>
        <button type="button" id="close-notification">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M18 5.99994L6 17.9999M6 5.99994L18 17.9999" stroke="#101828" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </button>
      </div>
      <div class="flex flex-col gap-2" id="notification-container">

        <!-- Call notification-->
        <!-- <div class="flex justify-between bg-brand-100 p-4 rounded-xl"> -->
        <!--   <div class="flex gap-4 items-center"> -->
        <!--     <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> -->
        <!--       <path d="M16 2V6M8 2V6M3 10H21M5 4H19C20.1046 4 21 4.89543 21 6V20C21 21.1046 20.1046 22 19 22H5C3.89543 22 3 21.1046 3 20V6C3 4.89543 3.89543 4 5 4Z" stroke="#344054" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /> -->
        <!--     </svg> -->
        <!--     <div> -->
        <!--       <p class="text-sm font-semibold">Magno started a meeting</p> -->
        <!--       <p class="text-xs text-gray-600">Monday, December 25, 2023 | 12:00am</p> -->
        <!--     </div> -->
        <!--   </div> -->
        <!--   <button type="button" class="text-white text-sm font-medium bg-brand-600 h-min py-2 px-4 rounded-xl hover:bg-brand-700"> -->
        <!--     Join -->
        <!--   </button> -->
        <!-- </div> -->
        <!-- Message notification-->
        <!-- <div class="flex items-center justify-between bg-brand-100 p-4 rounded-xl"> -->
        <!--   <div class="flex gap-4 items-center"> -->
        <!--     <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> -->
        <!--       <path d="M21 15C21 15.5304 20.7893 16.0391 20.4142 16.4142C20.0391 16.7893 19.5304 17 19 17H7L3 21V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H19C19.5304 3 20.0391 3.21071 20.4142 3.58579C20.7893 3.96086 21 4.46957 21 5V15Z" stroke="#344054" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /> -->
        <!--     </svg> -->
        <!--     <div> -->
        <!--       <p class="text-sm font-semibold">Magno messaged you</p> -->
        <!--       <p class="text-xs text-gray-600">Monday, December 25, 2023 | 12:00am</p> -->
        <!--     </div> -->
        <!--   </div> -->
        <!--     <button type="button" class="p-2 rounded-lg bg-brand-600"> -->
        <!---->
        <!--       <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"> -->
        <!--         <path d="M10 8.5V4.5L3 11.5L10 18.5V14.4C15 14.4 18.5 16 21 19.5C20 14.5 17 9.5 10 8.5Z" fill="white"/> -->
        <!--       </svg> -->
        <!--     </button> -->
        <!-- </div> -->
      </div>
    </div>
  </div>

  <!--Create appointment modal-->
  <div id="appointment-modal" class="w-full h-full bg-brand-400 bg-opacity-40 hidden place-items-center absolute z-50">
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
              <!-- <input type="text" name="violence" id="violence" class="input outline-none border border-gray-400 px-4 py-2 rounded-lg" placeholder="What did they do?"> -->
              <select name="violence" id="violence" class="input outline-none border border-gray-400 px-4 py-2 rounded-lg bg-white">
                <option value="">--Select violence--</option>
                <option value="Bullying">Bullying</option>
                <option value="Cyberbullying">Cyberbullying</option>
                <option value="Discrimination">Discrimination</option>
                <option value="Racism">Racism</option>
                <option value="Sexual Violence">Sexual Violence</option>
              </select>
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

  <div id="comment-modal" class="w-full h-full bg-brand-400 bg-opacity-40 hidden place-items-center absolute">
    <div class="bg-white p-8 w-3/6 rounded-xl">
      <div class="header flex justify-between mb-6">
        <h2 class="text-xl">Comments</h2>
        <button type="button" id="close-comment-modal">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M18 5.99994L6 17.9999M6 5.99994L18 17.9999" stroke="#101828" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </button>
      </div>

      <div class="h-72 overflow-y-scroll mb-4">
        <div class="w-full">
          <div class="flex flex-col gap-4" id="comments">
            <!-- <div class='grid grid-cols-[auto_1fr] w-full gap-2'> -->
            <!--   <div class="avatar"> -->
            <!--     <img src='https://ui-avatars.com/api/?name=Donn+Jayson&size=40&rounded=true&color=7F56D9&background=F9F5FF' alt=''> -->
            <!--   </div> -->
            <!--   <div class='max-w-fit flex flex-col mr-4'> -->
            <!--     <div class='flex items-center justify-between mb-2'> -->
            <!--       <p class='text-xs text-gray-700 font-medium'>Donn Jayson Quinto</p> -->
            <!--       <p class='text-xs text-gray-700'>January 2, 2024</p> -->
            <!--     </div> -->
            <!--     <div class='bg-brand-500 text-white text-sm rounded-lg px-4 py-2 flex items-center gap-2'> -->
            <!--       Someone started a calling me what? -->
            <!--     </div> -->
            <!--   </div> -->
            <!-- </div> -->
          </div>

        </div>
      </div>

      <form id="send-comment">
        <div class="bg-white flex items-center justify-between h-full gap-4">
          <input type="hidden" name="current_user" id="current_user" value="<?php echo $current_id ?>">
          <input type="hidden" name="post_id" id="post_id">
          <input type="text" name="comment" id="comment" class="px-4 py-2 border border-gray-400 rounded-lg w-full outline-none" placeholder="Comment here...">
          <button type="submit" class="p-2 bg-brand-600 hover:bg-brand-700 rounded-lg" id="send-comment-btn">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
              <g clip-path="url(#clip0_480_69)">
                <path d="M18.3334 1.66663L9.16675 10.8333M18.3334 1.66663L12.5001 18.3333L9.16675 10.8333M18.3334 1.66663L1.66675 7.49996L9.16675 10.8333" stroke="white" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round" />
              </g>
              <defs>
                <clipPath id="clip0_480_69">
                  <rect width="20" height="20" fill="white" />
                </clipPath>
              </defs>
            </svg>

          </button>

        </div>
      </form>
    </div>
  </div>
  <div id="sched-modal" class="w-full h-full bg-brand-400 bg-opacity-40 hidden place-items-center absolute">
    <div class="bg-white p-8 w-[20rem] rounded-xl">
      <div class="header flex gap-6 justify-between mb-6">
        <h2 class="text-xl">Set schedule</h2>
        <button type="button" id="close-sched-modal">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M18 5.99994L6 17.9999M6 5.99994L18 17.9999" stroke="#101828" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </button>
      </div>

      <div class="mb-4 ">
        <form id="sched-form">
          <div class="flex flex-col gap-8 items-center ">
            <label for="schedule-mon" class="flex items-center cursor-pointer">
              <!-- toggle -->
              <div class="relative">
                <!-- input -->
                <input name="schedule[]" id="schedule-mon" type="checkbox" class="sr-only" value="Monday" />
                <!-- line -->
                <div class="w-6 h-2 bg-gray-400 rounded-full shadow-inner"></div>
                <!-- dot -->
                <div class="dot absolute w-4 h-4 bg-gray-200 rounded-full shadow -left-1 -top-1 transition"></div>
              </div>
              <!-- label -->
              <div class="ml-3 text-gray-700 font-medium">
                Monday
              </div>
            </label>
            <label for="schedule-tue" class="flex items-center cursor-pointer">
              <!-- toggle -->
              <div class="relative">
                <!-- input -->
                <input name="schedule[]" id="schedule-tue" type="checkbox" class="sr-only" value="Tuesday" />
                <!-- line -->
                <div class="w-6 h-2 bg-gray-400 rounded-full shadow-inner"></div>
                <!-- dot -->
                <div class="dot absolute w-4 h-4 bg-gray-200 rounded-full shadow -left-1 -top-1 transition"></div>
              </div>
              <!-- label -->
              <div class="ml-3 text-gray-700 font-medium">
                Tuesday
              </div>
            </label>
            <label for="schedule-wed" class="flex items-center cursor-pointer">
              <!-- toggle -->
              <div class="relative">
                <!-- input -->
                <input name="schedule[]" id="schedule-wed" type="checkbox" class="sr-only" value="Wednesday" />
                <!-- line -->
                <div class="w-6 h-2 bg-gray-400 rounded-full shadow-inner"></div>
                <!-- dot -->
                <div class="dot absolute w-4 h-4 bg-gray-200 rounded-full shadow -left-1 -top-1 transition"></div>
              </div>
              <!-- label -->
              <div class="ml-3 text-gray-700 font-medium">
                Wednesday
              </div>
            </label>
            <label for="schedule-thur" class="flex items-center cursor-pointer">
              <!-- toggle -->
              <div class="relative">
                <!-- input -->
                <input name="schedule[]" id="schedule-thur" type="checkbox" class="sr-only" value="Thursday" />
                <!-- line -->
                <div class="w-6 h-2 bg-gray-400 rounded-full shadow-inner"></div>
                <!-- dot -->
                <div class="dot absolute w-4 h-4 bg-gray-200 rounded-full shadow -left-1 -top-1 transition"></div>
              </div>
              <!-- label -->
              <div class="ml-3 text-gray-700 font-medium">
                Thursday
              </div>
            </label>
            <label for="schedule-fri" class="flex items-center cursor-pointer">
              <!-- toggle -->
              <div class="relative">
                <!-- input -->
                <input name="schedule[]" id="schedule-fri" type="checkbox" class="sr-only" value="Friday" />
                <!-- line -->
                <div class="w-6 h-2 bg-gray-400 rounded-full shadow-inner"></div>
                <!-- dot -->
                <div class="dot absolute w-4 h-4 bg-gray-200 rounded-full shadow -left-1 -top-1 transition"></div>
              </div>
              <!-- label -->
              <div class="ml-3 text-gray-700 font-medium">
                Friday
              </div>
            </label>
            <button class="px-4 py-2 rounded-lg bg-brand-600 text-white font-medium" type="submit">Save</button>
          </div>


        </form>

      </div>

    </div>
  </div>
  <!--<script src="js/calendar.js"></script>-->
  <!--<script src="js/leaflet.js"></script>-->
  <script src="../js/close_modal.js"></script>
  <script src="../js/create_appointment.js"></script>
  <script src="../js/incident-map.js"></script>
  <script src="../js/dashboard.js"></script>
  <script src="../js/comment.js"></script>
  <script src="../js/notification.js"></script>
  <script src="../js/set_sched.js"></script>
</body>

</html>