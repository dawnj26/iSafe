<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/style.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Display:wght@400;500&display=swap');
    </style>
    <title>Sign Up Page</title>
</head>

<body class="font-semibold bg-gray-100 h-screen flex justify-center items-center overflow-hidden">

    <div class="registration-container bg-white rounded-lg shadow-lg overflow-hidden flex w-3/4 min-h-[400px] transform scale-75">
        <div class="left-side bg-cover bg-center rounded-l-lg w-1/2">
            <img src="client/image/bg.jpg" alt="" class="w-full h-full object-cover m-0">
        </div>
        <div class="registration-form flex-grow p-5 flex flex-col justify-center">
            <div class="registration-form">
                <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="48" height="48" rx="8" fill="#6941C6" />
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M22.83 7.65839C23.4877 7.41231 24.2063 7.38023 24.8833 7.56672L25.17 7.65839L36.8367 12.0334C37.4282 12.2552 37.9445 12.6406 38.3255 13.1446C38.7064 13.6486 38.9363 14.2504 38.9883 14.8801L39 15.1551V24.0934C38.9999 26.7941 38.2707 29.4447 36.8893 31.7654C35.508 34.0861 33.5257 35.9908 31.1517 37.2784L30.7083 37.5101L25.1183 40.3051C24.8105 40.4587 24.4743 40.5472 24.1308 40.565C23.7872 40.5828 23.4437 40.5295 23.1217 40.4084L22.8817 40.3051L17.2917 37.5101C14.876 36.3022 12.8313 34.4645 11.3733 32.1911C9.91539 29.9176 9.0983 27.2927 9.00833 24.5934L9 24.0934V15.1551C9.00001 14.5236 9.17938 13.9051 9.51722 13.3717C9.85507 12.8382 10.3375 12.4117 10.9083 12.1417L11.1633 12.0334L22.83 7.65839ZM24 10.7801L12.3333 15.1551V24.0934C12.3334 26.1851 12.8958 28.2383 13.9616 30.038C15.0274 31.8378 16.5575 33.3179 18.3917 34.3234L18.7833 34.5284L24 37.1367L29.2167 34.5284C31.0879 33.593 32.6731 32.1716 33.8064 30.4132C34.9397 28.6547 35.5794 26.6239 35.6583 24.5334L35.6667 24.0934V15.1551L24 10.7801ZM23.18 16.5267C23.6313 16.3578 24.1239 16.3328 24.59 16.4551L24.82 16.5267L29.4867 18.2767C29.896 18.4303 30.254 18.6957 30.5198 19.0429C30.7856 19.39 30.9485 19.8048 30.99 20.2401L31 20.4617V24.0367C31 25.2756 30.6712 26.4922 30.0472 27.5624C29.4233 28.6327 28.5264 29.5181 27.4483 30.1284L27.1317 30.2984L24.895 31.4151C24.6527 31.5364 24.3884 31.6072 24.1179 31.6232C23.8475 31.6393 23.5766 31.6002 23.3217 31.5084L23.105 31.4167L20.87 30.2984C19.7621 29.7444 18.8211 28.9064 18.143 27.8698C17.4648 26.8333 17.0739 25.6354 17.01 24.3984L17 24.0367V20.4617C17.0001 20.0246 17.1229 19.5963 17.3545 19.2256C17.5861 18.8549 17.9172 18.5568 18.31 18.3651L18.5133 18.2767L23.18 16.5267ZM24 19.7801L20.3333 21.1551V24.0384C20.3335 24.672 20.4979 25.2948 20.8104 25.846C21.123 26.3972 21.573 26.8579 22.1167 27.1834L22.36 27.3167L24 28.1367L25.64 27.3167C26.2071 27.0332 26.691 26.6075 27.0445 26.0811C27.398 25.5547 27.6089 24.9456 27.6567 24.3134L27.6667 24.0367V21.1551L24 19.7801Z" fill="white" />
                </svg>

                <h2 class="font-display text-black text-3xl mt-4 font-bold">Sign up</h2>
                <br>
                <p class=" font-display mb-4">Please enter your details</p>
                <form action="#" method="post">
                    <div class="form-group mb-4">
                        <label for="idNumber" class="text-gray-700 block mb-2">ID</label>
                        <input type="text" id="idNumber" name="idNumber" placeholder="Enter your ID number" class="w-full px-4 py-2 border border-gray-300 rounded" required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="email" class="text-gray-700 block mb-2">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email" class="w-full px-4 py-2 border border-gray-300 rounded" required>
                    </div>
                    <div class="form-group mb-4">
                        <label for="password" class="text-gray-700 block mb-2">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter password" class="w-full px-4 py-2 border border-gray-300 rounded" required>
                    </div>
                    <div class="form-group mb-8">
                        <label for="retype-password" class="text-gray-700 block mb-2">Re-type Password</label>
                        <input type="password" id="retype-password" name="retype-password" placeholder="Re-enter your password" class="w-full px-4 py-2 border border-gray-300 rounded" required>
                    </div>

                    <button type="submit" class="reg-button text-white px-4 py-2 w-full rounded hover:bg-black-500 transition duration-300" style="background-color: #7F56D9;">Sign Up</button>
                </form>
                <br>
                <div class="register-link text-center mt-4">
                    Do have an account? <a href="#" class="text-blue-500" style="color: #7F56D9; text-decoration: underline;">Log in here</a>
                </div>
            </div>
        </div>
    </div>

</body>

</html>