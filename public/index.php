<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Tailwind CSS Page</title>
    <!-- Add the link to the Tailwind CSS CDN -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-gray-100">

<div class="p-4 shadow-lg">
    <nav class="container mx-auto flex items-center justify-between">
        <!-- Left side of the navbar -->
        <div class="flex items-center">
            <div class="text-white text-xl font-bold">
                <div class="inline-block"><img src="assets/icons/logo.svg" alt=""></div>
                <div class="inline-block relative bottom-3 text-2xl" style="color: #7F56D9;">iSafe</div>
            </div>
        </div>


        <div class="">
            <a href="#" class="mx-2">Home</a>
            <a href="#" class="mx-2">About us</a>
            <a href="#" class="mx-2">Contact</a>
        </div>

        <!-- Right side of the navbar -->
        <div class="">
            <a href="#" class="rounded-md px-4 py-2 mx-2">Login</a>
            <a href="#" class="border font-semibold rounded-md px-4 py-2 mx-2 bg-brand-600" style="background-color: #7F56D9; color: white;">Sign up</a>
        </div>
    </nav>
</div>

<!-- Main content centered on the page -->
<div class="container mx-auto mt-36 border w-3/4">
    <div><img src="assets/icons/hero-img.svg" alt="Placeholder Image" class="relative mr-20 float-right inline-block rounded-lg"></div>

    <div class="text-3xl font-bold w-25 inline-block"><h1 >Empowering PSUians: Creating <br> a Safe Haven Against Gender- <br>Based Violence</h1></div>

    <div class=" mb-4 inline-block mt-14 text-2xl"><p>
            iSafe is a pioneering web-based system dedicated to <br> combating gender-based violence within the Pangasinan <br> State University (PSU) community
        </p></div>

    <br><br><br><div class="inline-block border font-semibold rounded-md px-4 py-2 mt-10 " style="background-color: #7F56D9; color: white;"><a href="#" >Join now</a></div>
</div>

<section>

    <div class="container mx-auto mt-36 border w-3/4 justify-between flex bg-brand-400 p-5 rounded-lg" style="background-color: #B692F6; color: black;">

        <div><div class="inline-block ml-10"><img src="assets/icons/solar_user-check-outline.svg" alt=""></div>
            <div class="inline-block ml-10"><p>User-friendly <br> interface</p></div></div>

        <div><div class="inline-block"><img src="assets/icons/heart.svg" alt=""></div>
            <div class="inline-block ml-10"><p>Supportive <br> community</p></div></div>

        <div><div class="inline-block"><img src="assets/icons/carbon_ibm-private-path-services.svg" alt=""></div>
            <div class="inline-block ml-10 mr-10"><p>Privacy oriented <br> communication </p></div></div>
    </div>

</section>

<section>

    <div class="container mx-auto mt-36 border w-3/4 bg-brand-400">

        <div class="ml-10 mt-10 inline-block"><img src="assets/icons/logo.svg" class="inline-block"></div>
        <div class="inline-block text-2xl relative top-1"><p>iSafe</p></div>
        <div class="inline-block float-right mt-10 w-96 h-2/4"><img src="assets/icons/teacher.svg" alt=""></div>

        <div class="ml-10 font-semibold text-3xl mt-10"><p>Empower your success with a <br> counselor's expert guidance.</p></div>

        <div class="ml-10 mt-8"><p>We provide personalized support, empowers individuals to overcome <br> obstacles, and helps them discover their strengths, enabling them to <br> navigate challenges and achieve personal and academic success <br> effectively.</p></div>
        <div class="ml-10 mt-8 border font-semibold rounded-md px-4 py-2 mx-2 bg-brand-600 inline-block"><a href="#">Try it now</a></div>
    </div>

</section>

<section >
    <div class="mx-auto border-4 mt-28 bg-black text-white">
        <footer style="background-color: #7F56D9; color: black;">

            <div class="container mx-auto  w-3/4 ">
                <div class=" container mx-auto mt-20  w-2/4 inline-block ">
                    <div class="inline-block"><img src="assets/icons/logo.svg" alt="" ></div>
                    <div class="inline-block relative bottom-3 left-3 text-2xl"><p class="text-white">iSafe</p></div>

                    <div class="flex justify-between w-60">
                        <div><a href="#"><img src="assets/icons/fb.svg" alt=""></a></div>
                        <div><a href="#"><img src="assets/icons/ig.svg" alt=""></a></div>
                        <div><a href="#"><img src="assets/icons/x.svg" alt=""></a></div>
                        <div><a href="#"><img src="assets/icons/yt.svg" alt=""></a></div>
                    </div>
                </div>

                <div class="float-right container mx-auto mt-20  w-2/4">
                    <div class=" flex justify-end"><p class="text-white">Empowering PSUians</p></div>
                    <div class="float-right">
                        <div class=" flex justify-between text-white">
                            <a class="mr-3" href="#">Home</a>
                            <a class="mr-3" href="#">About us</a>
                            <a class="" href="#">Contact</a>
                        </div>
                    </div>

                </div>

                <hr class="mt-10">
                <div>

                    <div class="mt-10 text-white"><p>2023 Copyright iSafe Company ©</p></div>
                    <div class="mt-5 flex justify-evenly w-3/4 relative right-14 text-white"><a href="#">Legal</a>
                        <a href="#">Privacy Center</a>
                        <a href="#">Privacy Policy</a>
                        <a href="#">Cookies</a>
                        <a href="#">About Ads</a>
                        <a href="#">Accessibility</a>

                    </div>

                </div>

            </div>
        </footer>
    </div>
</section>

</body>
</html>
