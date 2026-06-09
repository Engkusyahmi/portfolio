<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Bustracker Features</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
     <!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">

<!-- Local CSS Files -->
<link rel="stylesheet" href="<?= base_url('css/open-iconic-bootstrap.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('css/animate.css') ?>">
<link rel="stylesheet" href="<?= base_url('css/owl.carousel.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('css/owl.theme.default.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('css/magnific-popup.css') ?>">
<link rel="stylesheet" href="<?= base_url('css/aos.css') ?>">
<link rel="stylesheet" href="<?= base_url('css/ionicons.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('css/bootstrap-datepicker.css') ?>">
<link rel="stylesheet" href="<?= base_url('css/jquery.timepicker.css') ?>">
<link rel="stylesheet" href="<?= base_url('css/flaticon.css') ?>">
<link rel="stylesheet" href="<?= base_url('css/icomoon.css') ?>">
<link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
  </head>
  <body>
    
	  <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	    <div class="container">
	      <a class="navbar-brand" href="index.html">Bus<span>Tracker</span></a>
	      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="oi oi-menu"></span> Menu
	      </button>

	      <div class="collapse navbar-collapse" id="ftco-nav">
	        <ul class="navbar-nav ml-auto">
        	   <li class="nav-item"><a href="<?= base_url('/') ?>" class="nav-link">Home</a></li>
        	    <li class="nav-item"><a href="<?= base_url('/dashboard') ?>" class="nav-link">Dashboard</a></li>
                    <li class="nav-item"><a href="<?= base_url('/about') ?>" class="nav-link">About</a></li>
                     <li class="nav-item active"><a href="<?= base_url('/features') ?>" class="nav-link">Features</a></li>
                    <li class="nav-item"><a href="<?= base_url('/pricing') ?>" class="nav-link">Pricing</a></li>
                    <li class="nav-item"><a href="<?= base_url('/solution') ?>" class="nav-link">Solution</a></li>
                  <li class="nav-item"><a href="<?= base_url('/login') ?>" class="nav-link">login</a></li>
	        </ul>
	      </div>
	    </div>
	  </nav>
    <!-- END nav -->
    
    <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('images/bgbus.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
          <div class="col-md-9 ftco-animate pb-5">
          	<p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Features<i class="ion-ios-arrow-forward"></i></span></p>
            <h1 class="mb-3 bread">Features</h1>
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section">
      <div class="container">
        <div class="row d-flex justify-content-center">
          <div class="col-md-12 text-center d-flex ftco-animate">
          	<div class="blog-entry justify-content-end mb-md-5">
           <a href="#" class="block-20 img" style="background-image: url('<?= base_url('images/login.png'); ?>');">

              </a>
              <div class="text px-md-5 pt-4">
              	<div class="meta mb-3">
                </div>
                <h3 class="heading mt-2"><a href="#"><strong>Login & Registration</strong></a></h3>
                 <span>To Access dashboard and features</span>
                <p>Login System Secure login for 3 roles: Admin, Driver, Student."Remember Me" option (optional).Session based login with access control.Password validation and error handling.</p>
              </div>
            </div>
          </div>
          <div class="col-md-12 text-center d-flex ftco-animate">
          	<div class="blog-entry justify-content-end mb-md-5">
             <a href="#" class="block-20 img" style="background-image: url('<?= base_url('images/dashadmin.jpg'); ?>');">
              </a>
              <div class="text px-md-5 pt-4">
              	<div class="meta mb-3">
                </div>
                <h3 class="heading mt-2"><a href="#"><strong>Admin Dashboard</strong></a></h3>
                 <span>To Manage BusTracker System</span>
                <p>Admin has full control over the system: Manage Users Add, edit, delete students and drivers.
                View user profile information and user level.
                Automatically updates user count and lists.
                Manage Buses Add new buses with image, plate number, and seat capacity.
                Edit or delete existing buses. Manage Schedule Add and update bus schedules: destination, date, time, assigned driver, and bus.
                Delete outdated or canceled schedules.Schedule filtering and sorting (future feature).
                Dashboard Stats Real time summary: Total Users, Buses, Active Trips, Drivers.Quick links to view detailed data.
                View Bookings/Requests (Optional Feature) View upcoming trips booked by students or institutions.</p>
              </div>
            </div>
          </div>
          <div class="col-md-12 text-center d-flex ftco-animate">
          	<div class="blog-entry">
              <a href="#" class="block-20 img" style="background-image: url('<?= base_url('images/dashdriver.jpg'); ?>');">
              </a>
              <div class="text px-md-5 pt-4">
              	<div class="meta mb-3">
                </div>
                <h3 class="heading mt-2"><a href="#"><strong>Driver Dashboard</strong></a></h3>
                <span>To Manage Their tasks and communicate with students</span>
                <p>Driver can log in and manage: My Bus Schedules See a list of assigned trips with dates, times, 
                destinations.View which students are booked (optional).💬 Chat SystemChat directly with students for coordination.
                Receive notifications for new messages. Profile View
                View/update personal details (except username/user level).</p>
              </div>
            </div>
          </div>
          <div class="col-md-12 text-center d-flex ftco-animate">
          	<div class="blog-entry justify-content-end mb-md-5">
              <a href="blog-single.html" class="block-20 img" style="background-image: url('images/dashstudent.jpg');">
              </a>
              <div class="text px-md-5 pt-4">
              	<div class="meta mb-3">
                </div>
                <h3 class="heading mt-2"><a href="#"><strong>Student Dashboard</strong></a></h3>
                 <span>To View Schedule and chat with Driver also can booking bus </span>
                 <p>Student-friendly interface for easy trip planning: View Bus Schedules
                    See all upcoming buses with destination, date, and driver.
                    Filter by date or destination.
                    Trip Booking (if implemented)
                    Option to booking bus.
                     Chat with Driver Ask questions or get updates directly from the assigned driver.
                     Profile View
                    View personal information and assigned trips.
                    </p>
              </div>
            </div>
          </div>
         
                
         
       
    </section>

    <footer class="ftco-footer ftco-bg-dark ftco-section">
      <div class="container">
        <div class="row mb-5">
          <div class="col-md">
            <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2"><a href="#" class="logo">Bus<span>Tracker</span></a></h2>
              <p>One tap to book. One message to connect.BusTracker keeps you one step ahead.</p>
              <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-5">
                <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
              </ul>
            </div>
          </div>
          <div class="col-md">
            <div class="ftco-footer-widget mb-4 ml-md-5">
              <h2 class="ftco-heading-2">Information</h2>
              <ul class="list-unstyled">
                <li><a href="#" class="py-2 d-block">About</a></li>
                <li><a href="#" class="py-2 d-block">Services</a></li>
                <li><a href="#" class="py-2 d-block">Term and Conditions</a></li>
                <li><a href="#" class="py-2 d-block">Best Price Guarantee</a></li>
                <li><a href="#" class="py-2 d-block">Privacy &amp; Cookies Policy</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md">
             <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">Customer Support</h2>
              <ul class="list-unstyled">
                <li><a href="#" class="py-2 d-block">FAQ</a></li>
                <li><a href="#" class="py-2 d-block">Payment Option</a></li>
                <li><a href="#" class="py-2 d-block">Booking Tips</a></li>
                <li><a href="#" class="py-2 d-block">How it works</a></li>
                <li><a href="#" class="py-2 d-block">Contact Us</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md">
            <div class="ftco-footer-widget mb-4">
            	<h2 class="ftco-heading-2">Have a Questions?</h2>
            	<div class="block-23 mb-3">
	              <ul>
	                <li><span class="icon icon-map-marker"></span><span class="text">Rawang,Selangor</span></li>
	                <li><a href="#"><span class="icon icon-phone"></span><span class="text">011-23278236</span></a></li>
	                <li><a href="#"><span class="icon icon-envelope"></span><span class="text">sokmosempoi@gmail.com</span></a></li>
	              </ul>
	            </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">

             <p>Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made  by <a href="https://colorlib.com" target="_blank">Fahim Najme</a></p>
          </div>
        </div>
      </div>
    </footer>
    
  

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>


  <!-- Core JS Files -->
<script src="<?= base_url('js/jquery.min.js') ?>"></script>
<script src="<?= base_url('js/jquery-migrate-3.0.1.min.js') ?>"></script>
<script src="<?= base_url('js/popper.min.js') ?>"></script>
<script src="<?= base_url('js/bootstrap.min.js') ?>"></script>
<script src="<?= base_url('js/jquery.easing.1.3.js') ?>"></script>
<script src="<?= base_url('js/jquery.waypoints.min.js') ?>"></script>
<script src="<?= base_url('js/jquery.stellar.min.js') ?>"></script>
<script src="<?= base_url('js/owl.carousel.min.js') ?>"></script>
<script src="<?= base_url('js/jquery.magnific-popup.min.js') ?>"></script>
<script src="<?= base_url('js/aos.js') ?>"></script>
<script src="<?= base_url('js/jquery.animateNumber.min.js') ?>"></script>
<script src="<?= base_url('js/bootstrap-datepicker.js') ?>"></script>
<script src="<?= base_url('js/jquery.timepicker.min.js') ?>"></script>
<script src="<?= base_url('js/scrollax.min.js') ?>"></script>

<!-- Google Maps API -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
<script src="<?= base_url('js/google-map.js') ?>"></script>

<!-- Main JS -->
<script src="<?= base_url('js/main.js') ?>"></script>

    
  </body>
</html>