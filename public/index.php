<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iSafe</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
    <!-- Add the link to the Tailwind CSS CDN -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-gray-100 font-inter">

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
            <a href="login.php" class="rounded-md px-4 py-2 mx-2">Login</a>
            <a href="registration.php" class="border font-semibold rounded-md px-4 py-2 mx-2 bg-brand-600" style="background-color: #7F56D9; color: white;">Sign up</a>
        </div>
    </nav>
</div>

<!-- Main content centered on the page -->
<div class="flex justify-between  container mx-auto mt-36 w-3/4 items-center">
	<div class="flex flex-col gap-12 mr-4">
		<div>
			<h1 class="text-4xl font-semibold mb-6">Empowering PSUians: Creating a Safe Haven Against Gender-Based Violence</h1>
			<p class="text-lg">
				iSafe is a pioneering web-based system dedicated to combating gender-based violence within the Pangasinan State University (PSU) community
			</p>
		</div>

		<a href="" class="px-4 py-2 bg-brand-600 w-max font-medium text-white rounded-lg hover:bg-brand-700">Join now!</a>
	</div>
	<img src="assets/icons/hero-img.svg" alt="Placeholder Image" class="">




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

    <div class="flex container mx-auto mt-36 border w-3/4 bg-brand-600 p-8 rounded-lg">

	    <div class="flex flex-col gap-10">
		    <div class="flex items-center gap-2">
			    <img src="assets/icons/logo.svg" class="">
			    <p class="text-2xl font-medium text-white">iSafe</p>
		    </div>


		    <div class="flex flex-col text-white">
			    <h3 class="font-semibold text-3xl mb-3">Empower your success with a counselor's expert guidance.</h3
			    <p>We provide personalized support, empowers individuals to overcome obstacles, and helps them discover their strengths, enabling them to navigate challenges and achieve personal and academic success effectively.</p>
		    </div>
		    <a href="#" class="text-brand-600 font-semibold rounded-md px-6 py-3 bg-white w-max">Try it now</a>
	    </div>


        <img src="assets/icons/teacher.svg" alt="">
    </div>

</section>

<section >
    <div class="mt-28 text-white">
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
