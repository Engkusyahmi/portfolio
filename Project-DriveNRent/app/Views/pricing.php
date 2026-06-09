<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Bustracker Pricing</title>
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
                     <li class="nav-item"><a href="<?= base_url('/features') ?>" class="nav-link">Features</a></li>
                    <li class="nav-item active"><a href="<?= base_url('/pricing') ?>" class="nav-link">Pricing</a></li>
                    <li class="nav-item"><a href="<?= base_url('/solution') ?>" class="nav-link">Solution</a></li>
                  <li class="nav-item"><a href="<?= base_url('/login') ?>" class="nav-link">login</a></li>
                
	        </ul>
	      </div>
	    </div>
	  </nav>
    <!-- END nav -->
    
    
    <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('images/bg_3.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
          <div class="col-md-9 ftco-animate pb-5">
          	<p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Pricing <i class="ion-ios-arrow-forward"></i></span></p>
            <h1 class="mb-3 bread">Pricing</h1>
          </div>
        </div>
      </div>
    </section>

 <!-- Link your CSS here or use the embedded CSS below -->
  <link rel="stylesheet" href="<?= base_url('css/pricing.css') ?>">
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(to right, #f7f7f7, #e9f7ff);
      color: #333;
      margin: 0;
      padding: 0;
    }

    .ftco-section {
      padding: 60px 0;
    }

    h2 {
      font-weight: bold;
      font-size: 2.5rem;
      color: #114B5F;
    }

    .text-center {
      text-align: center;
    }

    .car-list {
      margin-top: 40px;
      background: white;
      box-shadow: 0 0 30px rgba(0, 0, 0, 0.05);
      border-radius: 15px;
      overflow-x: auto;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    .thead-primary {
      background: #1A936F;
      color: #fff;
    }

    th, td {
      padding: 16px;
      border: 1px solid #dee2e6;
    }

    tr:nth-child(even):not(.bg-light) {
      background-color: #f8f9fa;
    }

    tr.bg-light {
      background-color: #e2f0d9 !important;
    }

    strong {
      color: #333;
    }

    @media (max-width: 768px) {
      h2 {
        font-size: 1.8rem;
      }
      th, td {
        font-size: 0.9rem;
        padding: 10px;
      }
    }

  /* Style for the top three pricing cards */
  .price-card {
    background-color: #ffffff; /* White background */
    border-radius: 8px; /* Rounded corners */
    padding: 25px; /* Internal spacing */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    text-align: left; /* Align text to left as in image */
    height: 100%; /* Ensures cards in a row have same height */
    display: flex; /* For flex layout */
    flex-direction: column; /* Stack content vertically */
    justify-content: space-between; /* Push description to bottom if needed */
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out; /* Smooth hover effect */
  }

  .price-card:hover {
    transform: translateY(-5px); /* Lift effect on hover */
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Stronger shadow on hover */
  }

  .price-card-title {
    font-size: 1.25rem; /* Larger font for title */
    font-weight: bold;
    color: #343a40; /* Darker text for titles */
    margin-bottom: 10px; /* Space between title and description */
  }

  .price-card-description {
    font-size: 0.95rem;
    color: #6c757d; /* Slightly lighter text for descriptions */
    line-height: 1.5;
  }

  /* Styling for the table headers */
  .bus-list .thead-primary th {
    background: #343a40; /* Dark grey/blue background for header, similar to image */
    color: #fff; /* White text */
    border-color: #343a40; /* Match border color */
    padding: 12px;
    font-weight: bold;
    text-transform: uppercase; /* Uppercase text */
    font-size: 0.9rem;
  }

  /* Styling for table rows */
  .bus-list .table tbody tr {
    background-color: #ffffff; /* White background for rows */
    border-bottom: 1px solid #e9ecef; /* Light separator lines */
  }

  .bus-list .table tbody td {
    padding: 12px;
    vertical-align: middle; /* Align content vertically */
    color: #495057; /* Darker text for table content */
    font-size: 0.95rem;
  }

  .bus-list .table tbody strong {
    font-weight: 700; /* Bolder for "Basic", "Pro", etc. */
    color: #343a40;
  }

  /* Styling for the Total Estimated Monthly Income row in the table */
  .bus-list .table tbody .bg-light {
    background-color: #f1f3f5 !important; /* Slightly distinct lighter background for the total row */
    font-weight: bold;
    color: #343a40;
    font-size: 1rem;
  }

</style>

</head>
<body>

<section class="ftco-section ftco-cart">
  <div class="container">
    <div class="row">
      <div class="col-md-12 ftco-animate">
        <h2 class="mb-4 text-center">BusTracker Revenue Model</h2>
        <p class="text-center">Here is a breakdown of how BusTracker generates revenue while remaining free for UniSZA students.</p>

        <div class="bus-list">
          <table class="table">
            <thead class="thead-primary">
              <tr class="text-center">
                <th>Revenue Source</th>
                <th>Description</th>
                <th>Rate</th>
              </tr>
            </thead>
            <tbody>
              <tr class="text-center">
                <td>Driver Listing</td>
                <td>Paid monthly by individual or small group drivers to appear in system</td>
                <td>RM 10/month per driver</td>
              </tr>
              <tr class="text-center">
                <td>Custom Admin Dashboard</td>
                <td>Sold to institutions for managing bookings and reporting</td>
                <td>Setup RM 300 + RM 100/month</td>
              </tr>
              <tr class="text-center">
                <td>Advertisements</td>
                <td>Banner ads on homepage or trip pages from local businesses</td>
                <td>RM 50–RM 200/month (depends on location)</td>
              </tr>
              <tr class="text-center">
                <td>Affiliate Partnerships</td>
                <td>Commission-based income through referrals (transport, travel, events)</td>
                <td>5% – 10% per transaction</td>
              </tr>
              <tr class="text-center">
                <td>Optional Premium Features</td>
                <td>SMS alerts, white-label versions, role management, etc.</td>
                <td>RM 5–RM 10/user/month</td>
              </tr>
              <tr class="text-center bg-light">
                <td colspan="2"><strong>Estimated Monthly Income</strong></td>
                <td><strong>RM 1,100+</strong></td>
              </tr>
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>
</section>

    <section class="ftco-section ftco-cart">
			<div class="container">
				<div class="row">
    			<div class="col-md-12 ftco-animate">
    				<div class="car-list">
	    				<table class="table">
						    <thead class="thead-primary">
						      <tr class="text-center">
						        <th>&nbsp;</th>
						        <th>&nbsp;</th>
						        <th class="bg-dark heading">UniSZA Booking</th>
						         <th class="bg-dark heading">Standard Booking</th>
						          <th class="bg-dark heading">Monthly Booking</th>
						      </tr>
						    </thead>
						    <tbody>
						      <tr class="">
        			      	<td class="car-image">
                            <img src="<?= base_url('images/bus1.jpg') ?>" alt="Bus" width="300" height="200" />

						        <td class="product-name">
						        	<h3>Montana Turismo</h3>
						        	<p class="mb-0 rated">
						        		<span>rated:</span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        	</p>
						        </td>
						        
						        <td class="price">
						        	<p class="btn-custom"><a href="#">Book a bus</a></p>
						        	<div class="price-rate">
							        	<h3>
							        		<span class="num"><span class="currency"></span>FREE</span>
							        		<span class="per">/per day</span>
							        	</h3>
							        	<span class="subheading">Only UniSZA students/staff</span>
						        	</div>
						        </td>
						        <td class="price">
						        	<p class="btn-custom"><a href="#">Book a bus</a></p>
						        		<h3>
							        		<span class="num"><span class="currency">RM</span> 1000</span>
							        		<span class="per">/per day</span>
							        	</h3>
							        	<span class="subheading">Other schools/universities</span>
						        </td>
						        <td class="price">
						        	<p class="btn-custom"><a href="#">Book a bus</a></p>
						        		<h3>
							        		<span class="num"><span class="currency">RM</span>2000</span>
							        		<span class="per">/per day</span>
							        	</h3>
							        		<span class="subheading">Unlimited bus bookings for the whole month.<div>
							        		Good for universities with frequent trips</span></div>
						        	
						        </td>
						        <td class="price">
						        	<p class="btn-custom"><a href="#">Book a bus</a></p>
						        </td>

						        
						      </tr><!-- END TR-->

						      <tr class="">
						      <td class="car-image">
                           <img src="<?= base_url('images/bus2.jpg') ?>" alt="Bus" width="300" height="200" />
                              </td>
						        <td class="product-name">
						        	<h3>Zeus 360 Travel</h3>
						        	<p class="mb-0 rated">
						        		<span>rated:</span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        	</p>
						        </td>
						        
						        <td class="price">
						        	<p class="btn-custom"><a href="#">Book a bus</a></p>
						        	<div class="price-rate">
							        	<h3>
							        		<span class="num"><span class="currency"></span>FREE</span>
							        		<span class="per">/per hour</span>
							        	</h3>
							        	<span class="subheading">Only UniSZA students/staff</span>
						        	</div>
						        </td>
						        
						       <td class="price">
						        	<p class="btn-custom"><a href="#">Book a bus</a></p>
						        		<h3>
							        		<span class="num"><span class="currency">RM</span> 1000</span>
							        		<span class="per">/per day</span>
							        	</h3>
							        	<span class="subheading">Other schools/universities</span>
						        </td>
						         <td class="price">
						        	<p class="btn-custom"><a href="#">Book a bus</a></p>
						        		<h3>
							        		<span class="num"><span class="currency">RM</span>2000</span>
							        		<span class="per">/per day</span>
							        	</h3>
							        		<span class="subheading">Unlimited bus bookings for the whole month.<div>
							        		Good for universities with frequent trips</span></div>
						        	
						        </td>
						      </tr><!-- END TR-->

						      <tr class="">
						      	<td class="car-image">
                            <img src="<?= base_url('images/bus3.jpg') ?>" alt="Bus" width="300" height="200" />
                              </td>
						        <td class="product-name">
						        	<h3>Ekspress Perdana</h3>
						        	<p class="mb-0 rated">
						        		<span>rated:</span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        	</p>
						        </td>
						        
						        <td class="price">
						        	<p class="btn-custom"><a href="#">Book a bus</a></p>
						        <div class="price-rate">
							        	<h3>
							        		<span class="num"><span class="currency"></span>FREE</span>
							        		<span class="per">/per hour</span>
							        	</h3>
							        	<span class="subheading">Only UniSZA students/staff</span>
						        	</div>
						        </td>
						        
						        <td class="price">
						        	<p class="btn-custom"><a href="#">Book a bus</a></p>
						        		<h3>
							        		<span class="num"><span class="currency">RM</span> 1000</span>
							        		<span class="per">/per day</span>
							        	</h3>
							        	<span class="subheading">Other schools/universities</span>
						        </td>

						        <td class="price">
						        	<p class="btn-custom"><a href="#">Book a bus</a></p>
						        		<h3>
							        		<span class="num"><span class="currency">RM</span>2000</span>
							        		<span class="per">/per day</span>
							        	</h3>
							        		<span class="subheading">Unlimited bus bookings for the whole month.<div>
							        		Good for universities with frequent trips</span></div>
						        	
						        </td>
						      </tr><!-- END TR-->

						      <tr class="">
						      <td class="car-image">
                         <img src="<?= base_url('images/bus4.jpg') ?>" alt="Bus" width="300" height="200" />
                              </td>
						        <td class="product-name">
						        	<h3>Konsortium Mutiara</h3>
						        	<p class="mb-0 rated">
						        		<span>rated:</span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        	</p>
						        </td>
						        
						        <td class="price">
						        	<p class="btn-custom"><a href="#">Book a bus</a></p>
						        	<div class="price-rate">
							        	<h3>
							        		<span class="num"><span class="currency"></span>FREE</span>
							        		<span class="per">/per hour</span>
							        	</h3>
							        	<span class="subheading">Only UniSZA students/staff</span>
						        	</div>
						        </td>
						        
						       <td class="price">
						        	<p class="btn-custom"><a href="#">Book a bus</a></p>
						        		<h3>
							        		<span class="num"><span class="currency">RM</span> 1000</span>
							        		<span class="per">/per day</span>
							        	</h3>
							        	<span class="subheading">Other schools/universities</span>
						        </td>

						       <td class="price">
						        	<p class="btn-custom"><a href="#">Book a bus</a></p>
						        		<h3>
							        		<span class="num"><span class="currency">RM</span>2000</span>
							        		<span class="per">/per day</span>
							        	</h3>
							        		<span class="subheading">Unlimited bus bookings for the whole month.<div>
							        		Good for universities with frequent trips</span></div>
						        	
						        </td>
						      </tr><!-- END TR-->


						      <tr class="">
						      <td class="car-image">
                              
                        <img src="<?= base_url('images/bus5.jpg') ?>" alt="Bus" width="300" height="200" />
                              </td>

						        <td class="product-name">
						        	<h3>Pancaran Matahari</h3>
						        	<p class="mb-0 rated">
						        		<span>rated:</span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        	</p>
						        </td>
						        
						        <td class="price">
						        	<p class="btn-custom"><a href="#">Book a bus</a></p>
						        <div class="price-rate">
							        	<h3>
							        		<span class="num"><span class="currency"></span>FREE</span>
							        		<span class="per">/per hour</span>
							        	</h3>
							        	<span class="subheading">Only UniSZA students/staff</span>
						        	</div>
						        </td>
						        
						       <td class="price">
						        	<p class="btn-custom"><a href="#">Book a bus</a></p>
						        		<h3>
							        		<span class="num"><span class="currency">RM</span> 1000</span>
							        		<span class="per">/per day</span>
							        	</h3>
							        	<span class="subheading">Other schools/universities</span>
						        </td>

						         <td class="price">
						        	<p class="btn-custom"><a href="#">Book a bus</a></p>
						        		<h3>
							        		<span class="num"><span class="currency">RM</span>2000</span>
							        		<span class="per">/per day</span>
							        	</h3>
							        		<span class="subheading">Unlimited bus bookings for the whole month.<div>
							        		Good for universities with frequent trips</span></div>
						        	
						        </td>
						      </tr><!-- END TR-->


						      <tr class="">
						      	<td class="car-image">
                          <img src="<?= base_url('images/bus6.jpg') ?>" alt="Bus" width="300" height="200" />
                              </td>
						        <td class="product-name">
						        	<h3>JetBus 5</h3>
						        	<p class="mb-0 rated">
						        		<span>rated:</span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		<span class="ion-ios-star"></span>
						        		
						        	</p>
						        </td>
						        
						        <td class="price">
						        	<p class="btn-custom"><a href="#">Book a bus</a></p>
						        <div class="price-rate">
							        	<h3>
							        		<span class="num"><span class="currency"></span>FREE</span>
							        		<span class="per">/per hour</span>
							        	</h3>
							        	<span class="subheading">Only UniSZA students/staff</span>
						        	</div>
						        </td>
						        
						       <td class="price">
						        	<p class="btn-custom"><a href="#">Book a bus</a></p>
						        		<h3>
							        		<span class="num"><span class="currency">RM</span> 1000</span>
							        		<span class="per">/per day</span>
							        	</h3>
							        	<span class="subheading">Other schools/universities</span>
						        </td>

						         <td class="price">
						        	<p class="btn-custom"><a href="#">Book a bus</a></p>
						        		<h3>
							        		<span class="num"><span class="currency">RM</span>2000</span>
							        		<span class="per">/per day</span>
							        	</h3>
							        		<span class="subheading">Unlimited bus bookings for the whole month.<div>
							        		Good for universities with frequent trips</span></div>
						        </td>
						        </td>
						      </tr><!-- END TR-->
						    </tbody>
						  </table>
					  </div>
    			</div>
    		</div>
			</div>
		</section>


    <!-- Section bwh sekli -->
    

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