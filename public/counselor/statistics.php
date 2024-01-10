<?php
date_default_timezone_set('Asia/Manila');
session_start();
if (! isset($_SESSION['id']) || ! isset($_SESSION['role'])) {
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
          <a href="dashboard-new1.php">
            <div class="p-4 flex items-center gap-2 w-full h-full hover:bg-slate-100 cursor-pointer">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9 22V12H15V22M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z" stroke="#344054" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
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

            <div class="p-4 active-tab text-brand-600 w-full f-full border-r-4 border-brand-600 hover:bg-slate-100 cursor-pointer flex items-center gap-2">

              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M21.2099 15.89C20.5737 17.3945 19.5787 18.7202 18.3118 19.7513C17.0449 20.7824 15.5447 21.4874 13.9424 21.8048C12.34 22.1221 10.6843 22.0421 9.12006 21.5718C7.55578 21.1014 6.13054 20.2551 4.96893 19.1067C3.80733 17.9582 2.94473 16.5428 2.45655 14.9839C1.96837 13.4251 1.86948 11.7705 2.16851 10.1646C2.46755 8.55878 3.15541 7.05063 4.17196 5.77203C5.18851 4.49343 6.5028 3.48332 7.99992 2.83M21.9999 12C21.9999 10.6868 21.7413 9.38642 21.2387 8.17317C20.7362 6.95991 19.9996 5.85752 19.071 4.92893C18.1424 4.00035 17.04 3.26375 15.8267 2.7612C14.6135 2.25866 13.3131 2 11.9999 2V12H21.9999Z" stroke="#7F56D9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>

             Statistics 
            </div>
          </a>
        </li>
        <li class="w-full flex justify-center mt-4">
          <button type="button" class="flex gap-2 px-4 py-2 bg-error-600 rounded-lg text-white" onclick="logout()">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M10.09 15.59L11.5 17L16.5 12L11.5 7L10.09 8.41L12.67 11H3V13H12.67L10.09 15.59ZM19 3H5C3.89 3 3 3.9 3 5V9H5V5H19V19H5V15H3V19C3 20.1 3.89 21 5 21H19C20.1 21 21 20.1 21 19V5C21 3.9 20.1 3 19 3Z" fill="white"/>
            </svg>
            Logout
          </button>
        </li>
      </ul>
    </aside>


    <div class="bg-gray-100 h-full max-h-full w-full p-2 relative">
        <div class="flex flex-col w-full h-full bg-white rounded-lg p-4">
          <div class="flex justify-between p-2">
            <h2 class="text-xl">Statistics</h2>
            <div class="">
              <label for="chart_filter text-sm mr-2">Filter</label>
            <select name="chart_filter" id="chart_filter" class="outline-none border border-gray-400 px-4 py-2 rounded-lg bg-white">
              <option value="day">Day</option>
              <option value="month">Month</option>
              <option value="year">Year</option>
            </select> 
            </div>
          </div>
          <canvas id="myChart" class="w-full h-full"></canvas>
          
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
  <!--<script src="js/calendar.js"></script>-->
  <!--<script src="js/leaflet.js"></script>-->
  <script src="../js/close_modal.js"></script>
  <script src="../js/create_appointment.js"></script>
    <script src="../js/notification.js"></script>
    <script src="../js/statistics.js"></script>
</body>

</html>
