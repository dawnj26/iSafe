<?php
require '../../config/config.php';

$counselors = get_counselors();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!--google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <!--tailwindcss file-->
    <link rel="stylesheet" href="../css/style.css">
    <!--Leaflet-->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
          crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
            crossorigin=""></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css"/>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <!--jquery-->
    <link rel="stylesheet" href="../js/jquery-ui-1.13.2.custom/jquery-ui.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="../js/jquery-ui-1.13.2.custom/jquery-ui.min.js"></script>
    <style>
        /* Toggle A */
        input:checked ~ .dot {
            transform: translateX(100%);
            background-color: #7F56D9;
        }
    </style>
    <title>Document</title>
</head>
<body class="h-screen max-h-screen flex flex-col font-inter relative overflow-hidden">
<header class="py-4 px-6 flex w-full items-center justify-between shadow">
    <div class="logo flex items-center gap-2">
        <svg width="32" height="32" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect width="40" height="40" rx="8" fill="#7F56D9"/>
            <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M19.064 6.92666C19.5902 6.7298 20.1651 6.70413 20.7067 6.85333L20.936 6.92666L30.2693 10.4267C30.7426 10.6041 31.1556 10.9124 31.4604 11.3156C31.7652 11.7188 31.9491 12.2003 31.9907 12.704L32 12.924V20.0747C31.9999 22.2352 31.4166 24.3557 30.3115 26.2122C29.2064 28.0688 27.6205 29.5926 25.7213 30.6227L25.3667 30.808L20.8947 33.044C20.6484 33.1669 20.3795 33.2377 20.1046 33.252C19.8298 33.2662 19.5549 33.2235 19.2973 33.1267L19.1053 33.044L14.6333 30.808C12.7008 29.8417 11.065 28.3716 9.89867 26.5528C8.73231 24.734 8.07864 22.6341 8.00667 20.4747L8 20.0747V12.924C8.00001 12.4188 8.1435 11.9241 8.41378 11.4973C8.68405 11.0705 9.06999 10.7293 9.52667 10.5133L9.73067 10.4267L19.064 6.92666ZM20 9.42399L10.6667 12.924V20.0747C10.6667 21.748 11.1166 23.3906 11.9693 24.8304C12.8219 26.2702 14.046 27.4543 15.5133 28.2587L15.8267 28.4227L20 30.5093L24.1733 28.4227C25.6703 27.6743 26.9385 26.5372 27.8452 25.1305C28.7518 23.7237 29.2635 22.0991 29.3267 20.4267L29.3333 20.0747V12.924L20 9.42399ZM19.344 14.0213C19.7051 13.8862 20.0991 13.8662 20.472 13.964L20.656 14.0213L24.3893 15.4213C24.7168 15.5442 25.0032 15.7565 25.2158 16.0342C25.4285 16.3119 25.5588 16.6438 25.592 16.992L25.6 17.1693V20.0293C25.6 21.0204 25.337 21.9937 24.8378 22.8499C24.3386 23.7061 23.6211 24.4144 22.7587 24.9027L22.5053 25.0387L20.716 25.932C20.5222 26.029 20.3107 26.0857 20.0943 26.0985C19.878 26.1114 19.6613 26.0801 19.4573 26.0067L19.284 25.9333L17.496 25.0387C16.6097 24.5955 15.8569 23.9251 15.3144 23.0958C14.7719 22.2666 14.4591 21.3083 14.408 20.3187L14.4 20.0293V17.1693C14.4 16.8196 14.4983 16.477 14.6836 16.1805C14.8689 15.8839 15.1337 15.6454 15.448 15.492L15.6107 15.4213L19.344 14.0213ZM20 16.624L17.0667 17.724V20.0307C17.0668 20.5376 17.1983 21.0358 17.4483 21.4767C17.6984 21.9177 18.0584 22.2863 18.4933 22.5467L18.688 22.6533L20 23.3093L21.312 22.6533C21.7657 22.4265 22.1528 22.0859 22.4356 21.6648C22.7184 21.2437 22.8871 20.7565 22.9253 20.2507L22.9333 20.0293V17.724L20 16.624Z"
                  fill="white"/>
        </svg>
        <h3 class="text-lg text-brand-600 font-inter font-medium">iSafe</h3>
    </div>

    <!--	Ito yung nasa left side-->
    <div class="flex items-center gap-10">
        <!--		create an appointment button-->
        <button type="button" id="open-appointment"
                class="font-inter text-xs bg-brand-600 text-white font-semibold flex gap-2 items-center py-2 px-4 rounded-lg hover:bg-brand-700 h-min">
            Create an appointment
            <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9.99984 4.16666V15.8333M4.1665 9.99999H15.8332" stroke="white" stroke-width="1.67"
                      stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
        <div class="flex gap-6">
            <!--			notification button-->
            <label for="checkbox-modal" class="rounded-full hover:bg-slate-100 p-2" id="open-notification">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M13.73 21C13.5542 21.3031 13.3018 21.5547 12.9982 21.7295C12.6946 21.9044 12.3504 21.9965 12 21.9965C11.6496 21.9965 11.3054 21.9044 11.0018 21.7295C10.6982 21.5547 10.4458 21.3031 10.27 21M18 8C18 6.4087 17.3679 4.88258 16.2426 3.75736C15.1174 2.63214 13.5913 2 12 2C10.4087 2 8.88258 2.63214 7.75736 3.75736C6.63214 4.88258 6 6.4087 6 8C6 15 3 17 3 17H21C21 17 18 15 18 8Z"
                          stroke="#667085" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </label>
            <input type="checkbox" name="checkbox-modal" id="checkbox-modal" class="hidden">
            <!--			profile-->
            <div class="flex items-center gap-4">
                <svg width="32" height="32" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="48" height="48" rx="24" fill="#F9F5FF"/>
                    <path d="M34.6668 36V33.3333C34.6668 31.9188 34.1049 30.5623 33.1047 29.5621C32.1045 28.5619 30.748 28 29.3335 28H18.6668C17.2523 28 15.8958 28.5619 14.8956 29.5621C13.8954 30.5623 13.3335 31.9188 13.3335 33.3333V36M29.3335 17.3333C29.3335 20.2789 26.9457 22.6667 24.0002 22.6667C21.0546 22.6667 18.6668 20.2789 18.6668 17.3333C18.6668 14.3878 21.0546 12 24.0002 12C26.9457 12 29.3335 14.3878 29.3335 17.3333Z"
                          stroke="#7F56D9" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <p class="text-sm">Hanni Pham</p>
            </div>

        </div>
    </div>

</header>

<!-- Navigation -->
<div class="grid grid-cols-[12rem_1fr] max-h-full h-full">
    <!-- Wrap in anchor tag to navigate through pages, yung li element-->
    <aside class="h-full pt-2 shadow-[rgba(0,0,0,0.1)_2px_0_0_0]">
        <ul>
            <li class="flex items-center p-4 gap-2 active-tab text-brand-600 w-full border-r-4 border-brand-600 hover:bg-slate-100 cursor-pointer">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 22V12H15V22M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z"
                          stroke="#7F56D9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Dashboard
            </li>
            <li class="flex items-center p-4 gap-2 w-full hover:bg-slate-100 cursor-pointer">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16 2V6M8 2V6M3 10H21M5 4H19C20.1046 4 21 4.89543 21 6V20C21 21.1046 20.1046 22 19 22H5C3.89543 22 3 21.1046 3 20V6C3 4.89543 3.89543 4 5 4Z"
                          stroke="#344054" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>

                Appointments
            </li>
            <li class="flex items-center p-4 gap-2 w-full hover:bg-slate-100 cursor-pointer">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M21 15C21 15.5304 20.7893 16.0391 20.4142 16.4142C20.0391 16.7893 19.5304 17 19 17H7L3 21V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H19C19.5304 3 20.0391 3.21071 20.4142 3.58579C20.7893 3.96086 21 4.46957 21 5V15Z"
                          stroke="#344054" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>

                Chat
            </li>
            <li class="flex items-center p-4 gap-2 w-full hover:bg-slate-100 cursor-pointer">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19 3H5C3.89543 3 3 3.89543 3 5V19C3 20.1046 3.89543 21 5 21H19C20.1046 21 21 20.1046 21 19V5C21 3.89543 20.1046 3 19 3Z"
                          stroke="#344054" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M10 7H7V16H10V7Z" stroke="#344054" stroke-width="2" stroke-linecap="round"
                          stroke-linejoin="round"/>
                    <path d="M17 7H14V12H17V7Z" stroke="#344054" stroke-width="2" stroke-linecap="round"
                          stroke-linejoin="round"/>
                </svg>

                News Feed
            </li>
            <li class="flex items-center p-4 gap-2 w-full hover:bg-slate-100 cursor-pointer">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_280_734)">
                        <path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z"
                              stroke="#344054" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M19.4 15C19.2669 15.3016 19.2272 15.6362 19.286 15.9606C19.3448 16.285 19.4995 16.5843 19.73 16.82L19.79 16.88C19.976 17.0657 20.1235 17.2863 20.2241 17.5291C20.3248 17.7719 20.3766 18.0322 20.3766 18.295C20.3766 18.5578 20.3248 18.8181 20.2241 19.0609C20.1235 19.3037 19.976 19.5243 19.79 19.71C19.6043 19.896 19.3837 20.0435 19.1409 20.1441C18.8981 20.2448 18.6378 20.2966 18.375 20.2966C18.1122 20.2966 17.8519 20.2448 17.6091 20.1441C17.3663 20.0435 17.1457 19.896 16.96 19.71L16.9 19.65C16.6643 19.4195 16.365 19.2648 16.0406 19.206C15.7162 19.1472 15.3816 19.1869 15.08 19.32C14.7842 19.4468 14.532 19.6572 14.3543 19.9255C14.1766 20.1938 14.0813 20.5082 14.08 20.83V21C14.08 21.5304 13.8693 22.0391 13.4942 22.4142C13.1191 22.7893 12.6104 23 12.08 23C11.5496 23 11.0409 22.7893 10.6658 22.4142C10.2907 22.0391 10.08 21.5304 10.08 21V20.91C10.0723 20.579 9.96512 20.258 9.77251 19.9887C9.5799 19.7194 9.31074 19.5143 9 19.4C8.69838 19.2669 8.36381 19.2272 8.03941 19.286C7.71502 19.3448 7.41568 19.4995 7.18 19.73L7.12 19.79C6.93425 19.976 6.71368 20.1235 6.47088 20.2241C6.22808 20.3248 5.96783 20.3766 5.705 20.3766C5.44217 20.3766 5.18192 20.3248 4.93912 20.2241C4.69632 20.1235 4.47575 19.976 4.29 19.79C4.10405 19.6043 3.95653 19.3837 3.85588 19.1409C3.75523 18.8981 3.70343 18.6378 3.70343 18.375C3.70343 18.1122 3.75523 17.8519 3.85588 17.6091C3.95653 17.3663 4.10405 17.1457 4.29 16.96L4.35 16.9C4.58054 16.6643 4.73519 16.365 4.794 16.0406C4.85282 15.7162 4.81312 15.3816 4.68 15.08C4.55324 14.7842 4.34276 14.532 4.07447 14.3543C3.80618 14.1766 3.49179 14.0813 3.17 14.08H3C2.46957 14.08 1.96086 13.8693 1.58579 13.4942C1.21071 13.1191 1 12.6104 1 12.08C1 11.5496 1.21071 11.0409 1.58579 10.6658C1.96086 10.2907 2.46957 10.08 3 10.08H3.09C3.42099 10.0723 3.742 9.96512 4.0113 9.77251C4.28059 9.5799 4.48572 9.31074 4.6 9C4.73312 8.69838 4.77282 8.36381 4.714 8.03941C4.65519 7.71502 4.50054 7.41568 4.27 7.18L4.21 7.12C4.02405 6.93425 3.87653 6.71368 3.77588 6.47088C3.67523 6.22808 3.62343 5.96783 3.62343 5.705C3.62343 5.44217 3.67523 5.18192 3.77588 4.93912C3.87653 4.69632 4.02405 4.47575 4.21 4.29C4.39575 4.10405 4.61632 3.95653 4.85912 3.85588C5.10192 3.75523 5.36217 3.70343 5.625 3.70343C5.88783 3.70343 6.14808 3.75523 6.39088 3.85588C6.63368 3.95653 6.85425 4.10405 7.04 4.29L7.1 4.35C7.33568 4.58054 7.63502 4.73519 7.95941 4.794C8.28381 4.85282 8.61838 4.81312 8.92 4.68H9C9.29577 4.55324 9.54802 4.34276 9.72569 4.07447C9.90337 3.80618 9.99872 3.49179 10 3.17V3C10 2.46957 10.2107 1.96086 10.5858 1.58579C10.9609 1.21071 11.4696 1 12 1C12.5304 1 13.0391 1.21071 13.4142 1.58579C13.7893 1.96086 14 2.46957 14 3V3.09C14.0013 3.41179 14.0966 3.72618 14.2743 3.99447C14.452 4.26276 14.7042 4.47324 15 4.6C15.3016 4.73312 15.6362 4.77282 15.9606 4.714C16.285 4.65519 16.5843 4.50054 16.82 4.27L16.88 4.21C17.0657 4.02405 17.2863 3.87653 17.5291 3.77588C17.7719 3.67523 18.0322 3.62343 18.295 3.62343C18.5578 3.62343 18.8181 3.67523 19.0609 3.77588C19.3037 3.87653 19.5243 4.02405 19.71 4.21C19.896 4.39575 20.0435 4.61632 20.1441 4.85912C20.2448 5.10192 20.2966 5.36217 20.2966 5.625C20.2966 5.88783 20.2448 6.14808 20.1441 6.39088C20.0435 6.63368 19.896 6.85425 19.71 7.04L19.65 7.1C19.4195 7.33568 19.2648 7.63502 19.206 7.95941C19.1472 8.28381 19.1869 8.61838 19.32 8.92V9C19.4468 9.29577 19.6572 9.54802 19.9255 9.72569C20.1938 9.90337 20.5082 9.99872 20.83 10H21C21.5304 10 22.0391 10.2107 22.4142 10.5858C22.7893 10.9609 23 11.4696 23 12C23 12.5304 22.7893 13.0391 22.4142 13.4142C22.0391 13.7893 21.5304 14 21 14H20.91C20.5882 14.0013 20.2738 14.0966 20.0055 14.2743C19.7372 14.452 19.5268 14.7042 19.4 15Z"
                              stroke="#344054" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </g>
                    <defs>
                        <clipPath id="clip0_280_734">
                            <rect width="24" height="24" fill="white"/>
                        </clipPath>
                    </defs>
                </svg>

                Settings
            </li>
        </ul>
    </aside>


    <div class="bg-gray-100 h-full max-h-full w-full p-2 relative">
        <div class="h-[35.3rem] w-full bg-white rounded-lg p-4 overflow-y-scroll grid grid-cols-[45rem_1fr] gap-2 relative">
            <div class="post place-self-center m-auto">
                <div class="bg-brand-200 rounded-lg w-[30rem] h-fit px-4 pt-4 pb-0 mb-4">
                    <div class="post-header flex items-center justify-between mb-6">
                        <div class="profile flex items-center gap-2">
                            <img src="../assets/img/Avatar.png" alt="">
                            <div class="profile-details">
                                <p class="text-sm font-medium">Hanni Pham</p>
                                <p class="text-sm text-gray-500">Student | December 25, 2023</p>
                            </div>
                        </div>
                        <button type="button">
                            <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M18 6.5L6 18.5M6 6.5L18 18.5" stroke="#101828" stroke-width="2"
                                      stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>

                    <div class="post-content mb-2">
                        <p class="text-sm mb-4">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias asperiores at autem debitis,
                            doloremque
                            esse eum facere illum labore maiores molestias nostrum officia officiis quidem repellat,
                            repudiandae
                            tenetur? Accusamus aliquid architecto dolor doloremque doloribus eius eligendi enim eveniet
                            ipsum maxime
                            m

                        </p>
                        <div class="h-56 w-full overflow-hidden rounded-lg object-cover">
                            <img src="../assets/img/sample-post-image.png" alt="" class="w-full">
                        </div>
                    </div>
                    <div class="react flex items-center justify-around border-t border-gray-400">
                        <button type="button"
                                class="flex items-center justify-center px-4 py-2 hover:bg-gray-300 rounded-lg text-sm gap-2 font-medium">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M7 22H4C3.46957 22 2.96086 21.7893 2.58579 21.4142C2.21071 21.0391 2 20.5304 2 20V13C2 12.4696 2.21071 11.9609 2.58579 11.5858C2.96086 11.2107 3.46957 11 4 11H7M14 9V5C14 4.20435 13.6839 3.44129 13.1213 2.87868C12.5587 2.31607 11.7956 2 11 2L7 11V22H18.28C18.7623 22.0055 19.2304 21.8364 19.5979 21.524C19.9654 21.2116 20.2077 20.7769 20.28 20.3L21.66 11.3C21.7035 11.0134 21.6842 10.7207 21.6033 10.4423C21.5225 10.1638 21.3821 9.90629 21.1919 9.68751C21.0016 9.46873 20.7661 9.29393 20.5016 9.17522C20.2371 9.0565 19.9499 8.99672 19.66 9H14Z"
                                      stroke="#475467" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>

                            Like
                        </button>
                        <button type="button"
                                class="flex items-center justify-center px-4 py-2 hover:bg-gray-300 rounded-lg text-sm gap-2 font-medium">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M21 11.5C21.0034 12.8199 20.6951 14.1219 20.1 15.3C19.3944 16.7118 18.3098 17.8992 16.9674 18.7293C15.6251 19.5594 14.0782 19.9994 12.5 20C11.1801 20.0035 9.87812 19.6951 8.7 19.1L3 21L4.9 15.3C4.30493 14.1219 3.99656 12.8199 4 11.5C4.00061 9.92179 4.44061 8.37488 5.27072 7.03258C6.10083 5.69028 7.28825 4.6056 8.7 3.90003C9.87812 3.30496 11.1801 2.99659 12.5 3.00003H13C15.0843 3.11502 17.053 3.99479 18.5291 5.47089C20.0052 6.94699 20.885 8.91568 21 11V11.5Z"
                                      stroke="#475467" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>

                            Comment
                        </button>
                    </div>

                </div>
                <div class="bg-brand-200 rounded-lg w-[30rem] h-fit px-4 pt-4 pb-0 mb-4">
                    <div class="post-header flex items-center justify-between mb-6">
                        <div class="profile flex items-center gap-2">
                            <img src="../assets/img/Avatar.png" alt="">
                            <div class="profile-details">
                                <p class="text-sm font-medium">Hanni Pham</p>
                                <p class="text-sm text-gray-500">Student | December 25, 2023</p>
                            </div>
                        </div>
                        <button type="button">
                            <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M18 6.5L6 18.5M6 6.5L18 18.5" stroke="#101828" stroke-width="2"
                                      stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>

                    <div class="post-content mb-2">
                        <p class="text-sm mb-4">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias asperiores at autem debitis,
                            doloremque
                            esse eum facere illum labore maiores molestias nostrum officia officiis quidem repellat,
                            repudiandae
                            tenetur? Accusamus aliquid architecto dolor doloremque doloribus eius eligendi enim eveniet
                            ipsum maxime
                            m

                        </p>
                        <div class="h-56 w-full overflow-hidden rounded-lg object-cover">
                            <img src="../assets/img/sample-post-image.png" alt="" class="w-full">
                        </div>


                    </div>
                    <div class="react flex items-center justify-around border-t border-gray-400">
                        <button type="button"
                                class="flex items-center justify-center px-4 py-2 hover:bg-gray-300 rounded-lg text-sm gap-2 font-medium">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M7 22H4C3.46957 22 2.96086 21.7893 2.58579 21.4142C2.21071 21.0391 2 20.5304 2 20V13C2 12.4696 2.21071 11.9609 2.58579 11.5858C2.96086 11.2107 3.46957 11 4 11H7M14 9V5C14 4.20435 13.6839 3.44129 13.1213 2.87868C12.5587 2.31607 11.7956 2 11 2L7 11V22H18.28C18.7623 22.0055 19.2304 21.8364 19.5979 21.524C19.9654 21.2116 20.2077 20.7769 20.28 20.3L21.66 11.3C21.7035 11.0134 21.6842 10.7207 21.6033 10.4423C21.5225 10.1638 21.3821 9.90629 21.1919 9.68751C21.0016 9.46873 20.7661 9.29393 20.5016 9.17522C20.2371 9.0565 19.9499 8.99672 19.66 9H14Z"
                                      stroke="#475467" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>

                            Like
                        </button>
                        <button type="button"
                                class="flex items-center justify-center px-4 py-2 hover:bg-gray-300 rounded-lg text-sm gap-2 font-medium">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M21 11.5C21.0034 12.8199 20.6951 14.1219 20.1 15.3C19.3944 16.7118 18.3098 17.8992 16.9674 18.7293C15.6251 19.5594 14.0782 19.9994 12.5 20C11.1801 20.0035 9.87812 19.6951 8.7 19.1L3 21L4.9 15.3C4.30493 14.1219 3.99656 12.8199 4 11.5C4.00061 9.92179 4.44061 8.37488 5.27072 7.03258C6.10083 5.69028 7.28825 4.6056 8.7 3.90003C9.87812 3.30496 11.1801 2.99659 12.5 3.00003H13C15.0843 3.11502 17.053 3.99479 18.5291 5.47089C20.0052 6.94699 20.885 8.91568 21 11V11.5Z"
                                      stroke="#475467" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>

                            Comment
                        </button>
                    </div>
                </div>
            </div>
            <!--Quote-->
            <div class="h-full relative">
                <div class="flex flex-col w-full bg-brand-200 h-fit rounded-lg overflow-hidden sticky top-0">
                    <div class="quote-img">
                        <img src="../assets/img/quote-img.png" alt="">
                    </div>
                    <div class="quote-content p-4 flex flex-col gap-4">
                        <p class="text-sm text-gray-500">Quote of the day</p>
                        <p class="text-sm font-medium">“Darkness cannot drive out darkness: only light can do that. Hate
                            cannot drive out hate: only love can do that.”</p>
                        <p class="text-xs">- Martin Luther King Jr</p>
                    </div>
                </div>

            </div>


        </div>
        <button type="button"
                class="flex items-center gap-4 px-4 py-2 bg-brand-600 text-white rounded-lg font-medium absolute bottom-16 right-36 hover:bg-brand-700">
            New post
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9.99984 4.16666V15.8333M4.1665 9.99999H15.8332" stroke="white" stroke-width="1.67"
                      stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
    </div>


</div>

<!--Notifications-->
<div id="notification-modal" class="w-full h-full bg-brand-400 bg-opacity-40 hidden place-items-center absolute">
    <div class="bg-white p-8 w-2/3 max-h-96 rounded-xl">
        <div class="header flex justify-between mb-6">
            <h2 class="text-xl">Notifications</h2>
            <button type="button" id="close-notification">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18 5.99994L6 17.9999M6 5.99994L18 17.9999" stroke="#101828" stroke-width="2"
                          stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>
        <!--Call notification-->
        <div class="flex justify-between bg-brand-100 p-4 rounded-xl mb-2">
            <div class="flex gap-4 items-center">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16 2V6M8 2V6M3 10H21M5 4H19C20.1046 4 21 4.89543 21 6V20C21 21.1046 20.1046 22 19 22H5C3.89543 22 3 21.1046 3 20V6C3 4.89543 3.89543 4 5 4Z"
                          stroke="#344054" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <div>
                    <p class="text-sm font-semibold">Magno started a meeting</p>
                    <p class="text-xs text-gray-600">Monday, December 25, 2023 | 12:00am</p>
                </div>
            </div>
            <button type="button"
                    class="text-white text-sm font-medium bg-brand-600 h-min py-2 px-4 rounded-xl hover:bg-brand-700">
                Join
            </button>
        </div>
        <!--Message notification-->
        <div class="flex items-center justify-between bg-brand-100 p-4 rounded-xl">
            <div class="flex gap-4 items-center">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M21 15C21 15.5304 20.7893 16.0391 20.4142 16.4142C20.0391 16.7893 19.5304 17 19 17H7L3 21V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H19C19.5304 3 20.0391 3.21071 20.4142 3.58579C20.7893 3.96086 21 4.46957 21 5V15Z"
                          stroke="#344054" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
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
                    <path d="M18 5.99994L6 17.9999M6 5.99994L18 17.9999" stroke="#101828" stroke-width="2"
                          stroke-linecap="round" stroke-linejoin="round"/>
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
                        <input type="text" name="violence" id="violence"
                               class="input outline-none border border-gray-400 px-4 py-2 rounded-lg"
                               placeholder="What did they do?">
                    </div>
                    <div class="flex flex-col gap-1 mb-2">
                        <label for="description" class="flex gap-4 items-center justify-between">
                            <span class="text-sm">Event description</span>
                            <span class="text-error-500 text-xs hidden error-msg">Must not be empty</span>
                        </label>
                        <textarea name="description" id="description" cols="30" rows="4" placeholder="What happened?"
                                  class="border border-gray-400 input outline-none px-4 py-2 resize-none rounded-lg"></textarea>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="location" class="flex gap-4 items-center justify-between">
                            <span class="text-sm">Location</span>

                        </label>
                        <div id="map" class="w-full h-56 rounded-lg">

                        </div>
                        <button type="button" id="locate"
                                class="w-max px-4 py-2 border border-gray-500 rounded-lg text-sm hover:bg-gray-100">
                            Locate me
                        </button>
                    </div>
                </div>
                <div id="right-form">
                    <div class="flex flex-col gap-1 mb-2">
                        <label for="date-of-event" class="flex gap-4 items-center justify-between">
                            <span class="text-sm">Date of event</span>
                            <span class="text-error-500 text-xs hidden error-msg">Must not be empty</span>
                        </label>
                        <input type="text" name="date-of-event" id="date-of-event"
                               class="input outline-none border border-gray-400 px-4 py-2 rounded-lg"
                               placeholder="Select date">
                    </div>
                    <div class="flex flex-col gap-1 mb-8">
                        <label for="time-of-event" class="flex gap-4 items-center justify-between">
                            <span class="text-sm">Time of event</span>
                            <span class="text-error-500 text-xs hidden error-msg">Must not be empty</span>
                        </label>
                        <input type="time" name="time-of-event" id="time-of-event"
                               class="input outline-none border border-gray-400 px-4 py-2 rounded-lg"
                               placeholder="Select time">
                    </div>
                    <div class="flex flex-col gap-1 mb-4">
                        <label for="counselor" class="flex gap-4 items-center justify-between">
                            <span class="text-sm">Counselor</span>
                            <span class="text-error-500 text-xs hidden error-msg">Must select a counselor</span>
                        </label>
                        <select name="counselor" id="counselor"
                                class="input outline-none border border-gray-400 px-4 py-2 rounded-lg text-gray-500 bg-white">
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
                        <input type="text" name="date-of-appointment" id="date-of-appointment"
                               class="input outline-none border border-gray-400 px-4 py-2 rounded-lg"
                               placeholder="Select date">
                    </div>
                    <div class="flex flex-col gap-1 mb-12">
                        <label for="time-of-appointment" class="flex gap-4 items-center justify-between">
                            <span class="text-sm">Time of appointment</span>
                            <span class="text-error-500 text-xs hidden error-msg">Must not be empty</span>
                        </label>
                        <select name="time-of-appointment" id="time-of-appointment"
                                class="input outline-none border border-gray-400 px-4 py-2 rounded-lg text-gray-500 bg-white">
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
                            <svg width="16" height="17" viewBox="0 0 16 17" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_296_882)">
                                    <path d="M14.6668 7.45656V8.0699C14.666 9.50751 14.2005 10.9063 13.3397 12.0578C12.4789 13.2092 11.269 14.0515 9.8904 14.4592C8.51178 14.8668 7.03834 14.8178 5.68981 14.3196C4.34128 13.8214 3.18993 12.9006 2.40747 11.6946C1.62501 10.4886 1.25336 9.06194 1.34795 7.62744C1.44254 6.19294 1.9983 4.82745 2.93235 3.73461C3.8664 2.64178 5.12869 1.88015 6.53096 1.56333C7.93323 1.2465 9.40034 1.39145 10.7135 1.97656M14.6668 2.73656L8.00017 9.4099L6.00017 7.4099"
                                          stroke="#039855" stroke-width="2" stroke-linecap="round"
                                          stroke-linejoin="round"/>
                                </g>
                                <defs>
                                    <clipPath id="clip0_296_882">
                                        <rect width="16" height="16" fill="white" transform="translate(0 0.0698853)"/>
                                    </clipPath>
                                </defs>
                            </svg>
                        </div>
                        <button type="submit"
                                class="px-4 py-2 bg-brand-600 text-white font-medium rounded-lg hover:bg-brand-700">Set
                            appointment
                        </button>
                    </div>

                </div>

            </div>


        </form>

    </div>
</div>

<!--Create new post-->
<div id="new-post-modal" class="w-full h-full bg-brand-400 bg-opacity-40 grid place-items-center absolute">
    <div class="bg-white p-8 w-3/6 rounded-xl">
        <div class="header flex justify-between mb-6">
            <h2 class="text-xl">Create new post</h2>
            <button type="button" id="close-new-post">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18 5.99994L6 17.9999M6 5.99994L18 17.9999" stroke="#101828" stroke-width="2"
                          stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>
        <div class="flex items-center justify-between mb-4">
            <div class="profile flex items-center gap-2">
                <img src="../assets/img/Avatar.png" alt="">
                <div class="profile-details">
                    <p class="text-sm font-medium">Hanni Pham</p>
                    <p class="text-sm text-gray-500">Student</p>
                </div>
            </div>
            <label
                    for="anonymous-post"
                    class="flex items-center cursor-pointer"
            >
                <!-- toggle -->
                <div class="relative">
                    <!-- input -->
                    <input id="anonymous-post" type="checkbox" class="sr-only"/>
                    <!-- line -->
                    <div class="w-6 h-2 bg-gray-400 rounded-full shadow-inner"></div>
                    <!-- dot -->
                    <div class="dot absolute w-4 h-4 bg-gray-200 rounded-full shadow -left-1 -top-1 transition"></div>
                </div>
                <!-- label -->
                <div class="ml-3 text-gray-700 font-medium">
                    Post anonymously
                </div>
            </label>
        </div>

        <div class="flex flex-col">
            <textarea name="description" id="description" cols="30" rows="4" placeholder="What's on your mind?"
                      class="placeholder:text-xl outline-none py-2 resize-none rounded-lg"></textarea>
        </div>

        <!-- component -->
        <div class="flex w-full items-center justify-center bg-grey-lighter">
            <label
                    class="w-full flex flex-col items-center px-2 py-4 bg-white text-blue rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue hover:text-blue-500 mb-4">
                <svg class="w-6 h-6" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 20 20">
                    <path
                            d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z"/>
                </svg>
                <span class="mt-2 text-sm leading-normal">Select an image</span>
                <input type='file' class="hidden" id="image" required name="image"
                       accept="image/png, image/jpeg"/>
            </label>
        </div>

        <div class="mb-5 rounded-md bg-blue-200 py-4 px-8 hidden" id="fileUpload">
            <div class="flex items-center justify-between">
                                    <span class="truncate pr-3 text-base font-medium text-[#07074D]" id="fileName">

                                    </span>
                <button class="text-[#07074D]" id="removeFile">
                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M0.279337 0.279338C0.651787 -0.0931121 1.25565 -0.0931121 1.6281 0.279338L9.72066 8.3719C10.0931 8.74435 10.0931 9.34821 9.72066 9.72066C9.34821 10.0931 8.74435 10.0931 8.3719 9.72066L0.279337 1.6281C-0.0931125 1.25565 -0.0931125 0.651788 0.279337 0.279338Z"
                              fill="currentColor"/>
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M0.279337 9.72066C-0.0931125 9.34821 -0.0931125 8.74435 0.279337 8.3719L8.3719 0.279338C8.74435 -0.0931127 9.34821 -0.0931123 9.72066 0.279338C10.0931 0.651787 10.0931 1.25565 9.72066 1.6281L1.6281 9.72066C1.25565 10.0931 0.651787 10.0931 0.279337 9.72066Z"
                              fill="currentColor"/>
                    </svg>
                </button>
            </div>
        </div>
        <button type="button" class="bg-brand-600 text-white font-medium py-2 px-4 rounded-lg w-full hover:bg-brand-700">Post</button>


    </div>
</div>

<!--<script src="js/calendar.js"></script>-->
<!--<script src="js/leaflet.js"></script>-->
<script src="../js/close_modal.js"></script>
<script src="../js/create_appointment.js"></script>
</body>
</html>