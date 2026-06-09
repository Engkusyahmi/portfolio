<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Bustrackerr</title>
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
  <style>
  .hero { position: relative; height: 400px; background: url('https://source.unsplash.com/random/1600x900/?bus,road') no-repeat center center/cover; display: flex; align-items: center; justify-content: center; text-align: center; color: white; margin-bottom: 2rem; }
      
        .hero-content { position: relative; z-index: 1; max-width: 800px; padding: 0 1rem; }
        .hero-content h1 { font-size: 3.5rem; margin-bottom: 1rem; font-weight: 700; }
        .hero-content p { font-size: 1.2rem; margin-bottom: 2rem; opacity: 0.9; }
        .hero-content .btn { background-color: #2F4F4F; color: white; padding: 12px 25px; border-radius: 5px; text-decoration: none; font-weight: 600; transition: background-color 0.3s ease, transform 0.2s ease; }
        .hero-content .btn:hover { background-color: #228B22; transform: translateY(-2px); }
        
        .center-heading span { color: #ec5800; }
   </style>
	  <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	    <div class="container">
	      <a class="navbar-brand" href="index.html">Bus<span>Tracker</span></a>
	      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="oi oi-menu"></span> Menu
	      </button>

	      <div class="collapse navbar-collapse" id="ftco-nav">
	        <ul class="navbar-nav ml-auto">
            	   <li class="nav-item active"><a href="<?= base_url('/') ?>" class="nav-link">Home</a></li>
            	   <li class="nav-item"><a href="<?= base_url('/dashboard') ?>" class="nav-link">Dashboard</a></li>
                    <li class="nav-item"><a href="<?= base_url('/about') ?>" class="nav-link">About</a></li>
                     <li class="nav-item"><a href="<?= base_url('/features') ?>" class="nav-link">Features</a></li>
                    <li class="nav-item"><a href="<?= base_url('/pricing') ?>" class="nav-link">Pricing</a></li>
                    <li class="nav-item"><a href="<?= base_url('/solution') ?>" class="nav-link">Solution</a></li>
                  <li class="nav-item"><a href="<?= base_url('/login') ?>" class="nav-link">login</a></li>
	        </ul>
	      </div>
	    </div>
	  </nav>
    <!-- END nav -->
    
    <div class="hero-wrap ftco-degree-bg" style="background-image: url('images/bgbus.jpg');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text justify-content-start align-items-center justify-content-center">
          <div class="col-lg-8 ftco-animate">
          	<div class="text w-100 text-center mb-md-5 pb-md-5">
	           

<main class="flex flex-col items-center p-6 lg rounded-xl max-w-4xl w-full">
       
           
            <section class="hero">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>Welcome to Bus<span style="color:#ffffff;">Tracker</span></h1>
            <p>Fast &amp; Easy Way To Track &  Booking Bus</p>
            <a href="<?= base_url('/features'); ?>" class="btn">Discover Features</a>
        </div>
    </section>
        
    </main>
	            </a>
            </div>
          </div>
        </div>
      </div>
    </div>

<!--Label section-->
     <section class="ftco-section ftco-no-pt bg-light">
    	<div class="container">
    		<div class="row no-gutters">
    			<div class="col-md-12	featured-top">
    				<div class="row no-gutters">
	  					<div class="col-md-4 d-flex align-items-center">
	  						<form action="#" class="request-form ftco-animate bg-primary">
		          	    	<h2>Make your trip</h2>
			    			    <div class="form-group">
			    					<label for="" class="label">Pick-up location</label>
			    					<input type="text" class="form-control" placeholder=" Station, etc">
			    				</div>
			    				<div class="form-group">
			    					<label for="" class="label">Drop-off location</label>
			    					<input type="text" class="form-control" placeholder="Station, etc">
			    				</div>
			    				<div class="d-flex">
			    				<div class="form-group mr-2">
			                         <label for="" class="label">Pick-up date</label>
			                         <input type="text" class="form-control" id="book_pick_date" placeholder="Date">
			                    </div>
			                    <div class="form-group ml-2">
			                         <label for="" class="label">Drop-off date</label>
			                         <input type="text" class="form-control" id="book_off_date" placeholder="Date">
			                    </div>
		                    </div>
		                        <div class="form-group">
		                            <label for="" class="label">Pick-up time</label>
		                            <input type="text" class="form-control" id="time_pick" placeholder="Time">
		                        </div>
			                    <div class="form-group">
			                    </div> 
                                <a href="<?= base_url('login') ?>" target="_blank" class="btn btn-secondary btn-lg py-4 px-5 w-100">Login & Register First too see schedule </a>


	  					    </div>
	  					        <div class="col-md-8 d-flex align-items-center">
	  						    <div class="services-wrap rounded-right w-100">
	  							        <h3 class="heading-section mb-4">Better Way to Track Bus Driver</h3>
	  							<div class="row d-flex mb-4">
					            <div class="col-md-4 d-flex align-self-stretch">
					            <div class="services w-100 text-center">
				                <div class="icon d-flex align-items-center justify-content-center">
                                <span style="background-image: url('<?= base_url('images/tracking.png') ?>'); width: 60px; height: 60px; display: block; background-size: cover;"></span>
                                </div> 
				              	<div class="text w-100">
					                    <h3 class="heading mb-2">Choose Your Pickup Location</h3>
				                </div>
					           </div>      
					           </div>
					            <div class="col-md-4 d-flex align-self-stretch ftco-animate">
					            <div class="services w-100 text-center">
				                <div class="icon d-flex align-items-center justify-content-center">
                                <span style="background-image: url('<?= base_url('images/bus.png') ?>'); width: 60px; height: 60px; display: block; background-size: cover;"></span>
                                 </div> 
				              	<div class="text w-100">
					                <h3 class="heading mb-2">Show Bus Driver</h3>
					              </div>
					            </div>      
					          </div>
					          <div class="col-md-4 d-flex align-self-stretch">
					            <div class="services w-100 text-center">
				              	  <div class="icon d-flex align-items-center justify-content-center">
                                <span style="background-image: url('<?= base_url('images/ctc.png') ?>'); width: 60px; height: 60px; display: block; background-size: cover;"></span>
                                 </div> 
    
				              	<div class="text w-100">
					                <h3 class="heading mb-2">Chat or contact bus driver</h3>
					              </div>
					            </div>      
					          </div>
					        </div>
					        <a href="<?= base_url('login') ?>" class="btn btn-secondary btn-lg py-4 px-5 w-100">Register or Login First to Chat Driver</a></form>
	  						</div>
	  					</div>
	  				</div>
				</div>
  		</div>
    </section>
    <!-- End Label -->


    <!--Booking section-->
    <section class="ftco-section ftco-no-pt bg-light">
    	<div class="container">
    		<div class="row justify-content-center">
          <div class="col-md-12 heading-section text-center ftco-animate mb-5">
          	<span class="subheading">Bustracker</span>
            <h2 class="mb-2">Booking Bus For Program</h2>
          </div>
        </div>
    		<div class="row">
    			<div class="col-md-12">
    				<div class="carousel-car owl-carousel">
    					<div class="item">
    						<div class="car-wrap rounded ftco-animate">
		    					<div class="img rounded d-flex align-items-end" style="background-image: url(images/bus1.jpg);">
		    					</div>
		    					<div class="text">
		    						<h2 class="mb-0"><a href=""<?= base_url('pricing') ?>" ">Montana Turismo</a></h2>
		    						<div class="d-flex mb-3">
			    						<span class="cat">Standard Booking</span>
			    						<p class="price ml-auto">RM1000 <span>/day</span></p>
		    						</div>
		    					        <p class="d-flex mb-0 d-block">
                                        <a href="<?= base_url('pricing') ?>" class="btn btn-primary py-2 mr-1">Book now</a> 
                                        <a href="<?= base_url('pricing') ?>" class="btn btn-secondary py-2 ml-1">Details</a>
                                    </p>
                            	</div>
		    				</div>
    					</div>
    					<div class="item">
    						<div class="car-wrap rounded ftco-animate">
		    					<div class="img rounded d-flex align-items-end" style="background-image: url(images/bus2.jpg);">
		    					</div>
		    					<div class="text">
		    						<h2 class="mb-0"><a href=""<?= base_url('pricing') ?>" ">Zeus 360 Travel</a></h2>
		    						<div class="d-flex mb-3">
			    						<span class="cat">Standard Booking</span>
			    						<p class="price ml-auto">RM1000<span>/day</span></p>
		    						</div>
		    					 <p class="d-flex mb-0 d-block">
                                        <a href="<?= base_url('pricing') ?>" class="btn btn-primary py-2 mr-1">Book now</a> 
                                        <a href="<?= base_url('pricing') ?>" class="btn btn-secondary py-2 ml-1">Details</a>
                                    </p>
		    					</div>
		    				</div>
    					</div>
    					<div class="item">
    						<div class="car-wrap rounded ftco-animate">
		    					<div class="img rounded d-flex align-items-end" style="background-image: url(images/bus3.jpg);">
		    					</div>
		    					<div class="text">
		    						<h2 class="mb-0"><a href=""<?= base_url('pricing') ?>" ">Ekspress Perdana</a></h2>
		    						<div class="d-flex mb-3">
			    						<span class="cat">Standard Booking</span>
			    						<p class="price ml-auto">RM1000<span>/day</span></p>
		    						</div>
		    					 <p class="d-flex mb-0 d-block">
                                        <a href="<?= base_url('pricing') ?>" class="btn btn-primary py-2 mr-1">Book now</a> 
                                        <a href="<?= base_url('pricing') ?>" class="btn btn-secondary py-2 ml-1">Details</a>
                                    </p>
		    					</div>
		    				</div>
    					</div>
    					<div class="item">
    						<div class="car-wrap rounded ftco-animate">
		    					<div class="img rounded d-flex align-items-end" style="background-image: url(images/bus4.jpg);">
		    					</div>
		    					<div class="text">
		    						<h2 class="mb-0"><a href=""<?= base_url('pricing') ?>" ">Konsortium Mutara</a></h2>
		    						<div class="d-flex mb-3">
			    						<span class="cat">Standard Booking</span>
			    						<p class="price ml-auto">RM 1000<span>/day</span></p>
		    						</div>
		    					 <p class="d-flex mb-0 d-block">
                                        <a href="<?= base_url('pricing') ?>" class="btn btn-primary py-2 mr-1">Book now</a> 
                                        <a href="<?= base_url('pricing') ?>" class="btn btn-secondary py-2 ml-1">Details</a>
                                    </p>
		    					</div>
		    				</div>
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>
    </section>
     <!-- End Booking section -->
    
    <section class="ftco-section ftco-no-pt" style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('<?= base_url('images/bus_background.jpg') ?>') no-repeat center center/cover; width: 100%; margin: 0; padding: 0;">
                 <div class="container-fluid animate-on-scroll" style="background-color: rgba(255,255,255,0.9); padding: 60px 80px; border-radius: 10px;">
             
    <!-- Overview -->
        <div class="row justify-content-center mb-5">
          <div class="col-md-10 heading-section text-center ftco-animate">
            <span class="subheading">About BusTracker</span>
            <h2 class="mb-4">Overview</h2>
            <p class="overview-text mx-auto">BusTracker is a modern web application that simplifies communication and scheduling for student transportation. Designed for schools, universities, and student groups, it eliminates the confusion often caused by unexpected delays or route changes.

            Instead of relying on GPS systems or waiting in uncertainty, students can instantly message their bus drivers using the built in chat feature. This ensures quick, direct updates when timing matters most.

            BusTracker also offers a seamless bus booking system ideal for regular commutes or organizing special trips. Schools, clubs, and teams can plan ahead, reserve seats, and manage transport without hassle.

            Built with a clean, intuitive interface, BusTracker keeps commuting smart, simple, and stress free for students, drivers, and institutions alike.</p>
          </div>
        </div>
       
       
       <!-- Tagline -->
        <div class="row justify-content-center mb-4">
          <div class="col-md-8 text-center">
          <span class="subheading">Tagline</span>
            <p class="tagline text-uppercase font-weight-bold text-primary">"Stay on Track- Book with Ease, Chat When It is Late.</p>
             </div>
             </div>
        
        <!-- Visual Section -->
        <div class="row justify-content-center">
          <div class="col-md-10 text-center">
            
          </div>
        </div>
      </div>
</section>

    <!-- Start About BusTracker section -->
    <section class="ftco-section ftco-about">
			<div class="container">
				<div class="row no-gutters">
				<div class="col-md-6 p-md-5 img img-2 d-flex justify-content-center align-items-center" 
                                 style="background-image: url('<?= base_url('images/aboutbus.jpg') ?>');">
                </div>
    
					<div class="col-md-6 wrap-about ftco-animate">
	          <div class="heading-section heading-section-white pl-md-5">
	          	<span class="subheading">Introduction</span>
	          	
	            <h2 class="mb-4">BusTracker</h2>

	            <p>Every journey to class should feel easy, informed, and stress free. That’s the mission behind BusTracker a student first platform designed to improve how students interact with their school or university transportation system. Whether you are heading to a lecture or organizing a group outing, BusTracker empowers you to stay connected, plan ahead, and move with confidence. </p>
	            <p>At its heart, BusTracker is about more than just logistics it is about communication, clarity, and convenience. With real-time messaging and simple bus reservation tools, students no longer need to guess or wait. Instead, they can engage directly with drivers, stay informed during delays, and book rides for daily routes or special events all from one streamlined platform.</p>
	            <p><a href="#" class="btn btn-primary py-3 px-4">sokmosempoi@gmail.com</a></p>
	          </div>
					</div>
				</div>
			</div>
		</section>
		 <!-- End About BusTracker Section -->
		 
		 
         <!-- Start solution section -->
	<section class="ftco-section">
			<div class="container">
				<div class="row justify-content-center mb-5">
          <div class="col-md-7 text-center heading-section ftco-animate">
          	<span class="subheading">Product Solution</span>
            <h2 class="mb-3">Our Problem & Solution</h2>
          </div>
        </div>
				<div class="row">
					<div class="col-md-3">
						<div class="services services-2 w-100 text-center">
         <div class="icon d-flex align-items-center justify-content-center">
    <span style="background-image: url('<?= base_url('images/web.png') ?>'); width: 60px; height: 60px; display: block; background-size: cover;"></span>
    </div>


            	<div class="text w-100">
                <h3 class="heading mb-2">Centralized,Accessible Platform <div>(One website=one destination for students)</div></h3>
                <p><div>Problem</div>No centralized information</p>
              </div>
            </div>
					</div>
					<div class="col-md-3">
						<div class="services services-2 w-100 text-center">
            	 <div class="icon d-flex align-items-center justify-content-center">
    <span style="background-image: url('<?= base_url('images/map.png') ?>'); width: 60px; height: 60px; display: block; background-size: cover;"></span>
    </div>
            	<div class="text w-100">
                 <h3 class="heading mb-2">Map view for easy navigation</h3>
                <p><div>Problem </div>Student may wait minute with no real time update</p>
              </div>
            </div>
					</div>
					<div class="col-md-3">
						<div class="services services-2 w-100 text-center">
             <div class="icon d-flex align-items-center justify-content-center">
    <span style="background-image: url('<?= base_url('images/contact.png') ?>'); width: 60px; height: 60px; display: block; background-size: cover;"></span>
    </div>

            	<div class="text w-100">
                <h3 class="heading mb-2">Optional Driver number  for Contact and Message</h3>
               <p><div>Problem </div>When student late  </p>
              </div>
            </div>
					</div>
					<div class="col-md-3">
						<div class="services services-2 w-100 text-center">
             <div class="icon d-flex align-items-center justify-content-center">
    <span style="background-image: url('<?= base_url('images/sch.png') ?>'); width: 60px; height: 60px; display: block; background-size: cover;"></span>
    </div>
            	<div class="text w-100">
                <h3 class="heading mb-2">Student can view Timetable bus </h3>
                <p><div>Problem </div>Student do not know when the bus will arrive or depart</p>
              </div>
            </div>
					</div>
				</div>
			</div>
		</section>
		 <!-- End solution section -->
		 
         <!-- Start testimonial section-->
    <section class="ftco-section testimony-section bg-light">
      <div class="container">
        <div class="row justify-content-center mb-5">
          <div class="col-md-7 text-center heading-section ftco-animate">
          	<span class="subheading">Testimonial</span>
            <h2 class="mb-3">Happy Clients</h2>
          </div>
        </div>
        <div class="row ftco-animate">
          <div class="col-md-12">
            <div class="carousel-testimony owl-carousel ftco-owl">
              <div class="item">
                <div class="testimony-wrap rounded text-center py-4 pb-5">
                  <div class="user-img mb-2" style="background-image: url(images/t2.jpg)">
                  </div>
                  <div class="text pt-4">
                    <p class="mb-4">“BusTracker is a very nice website to use! It’s simple, fast, and helps me plan my trips around campus easily. I hope they add more features like live tracking soon!”</p>
                    <p class="name">Afif</p>
                    <span class="position">Student UniSZA</span>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="testimony-wrap rounded text-center py-4 pb-5">
                  <div class="user-img mb-2" style="background-image: url(images/t3.jpg)">
                  </div>
                  <div class="text pt-4">
                    <p class="mb-4">“Our school used BusTracker for a trip booking  very smooth experience. It’s convenient, affordable, and saves us time. The interface is friendly for new users too.”</p>
                    <p class="name">Intan</p>
                    <span class="position">Teacher</span>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="testimony-wrap rounded text-center py-4 pb-5">
                  <div class="user-img mb-2" style="background-image: url(images/t4.jpg)">
                  </div>
                  <div class="text pt-4">
                    <p class="mb-4">“With BusTracker, I can see all my schedules clearly. It reduces miscommunication with students and makes my job more organized. Good job to the team!”</p>
                    <p class="name">Din</p>
                    <span class="position">Driver</span>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="testimony-wrap rounded text-center py-4 pb-5">
                  <div class="user-img mb-2" style="background-image: url(images/t5.jpg)">
                  </div>
                  <div class="text pt-4">
                    <p class="mb-4">“As a new student, I found BusTracker super helpful. I don’t get lost anymore when looking for buses. It’s very beginner-friendly.”</p>
                    <p class="name">Thalhah</p>
                    <span class="position">New Student UniSZA</span>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="testimony-wrap rounded text-center py-4 pb-5">
                  <div class="user-img mb-2" style="background-image: url(images/t1.jpg)">
                  </div>
                  <div class="text pt-4">
                    <p class="mb-4">“Before this, we used WhatsApp for updates. Now with BusTracker, everything is in one place clear schedules, less confusion, and better communication.”</p>
                    <p class="name">Hisyam</p>
                    <span class="position">Senior Driver</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
     <!-- End Testimonial section -->

     <!-- Start features section -->
    <section class="ftco-section">
      <div class="container">
        <div class="row justify-content-center mb-5">
          <div class="col-md-7 heading-section text-center ftco-animate">
          	<span class="subheading">Features</span>
            <h2>Discover Features</h2>
          </div>
        </div>
        <div class="row d-flex">
          <div class="col-md-4 d-flex ftco-animate">
          	<div class="blog-entry justify-content-end">
              <a href="blog-single.html" class="block-20" style="background-image: url('images/login.png');">
              </a>
              <div class="text pt-4">
              	<div class="meta mb-3">
                  <div><a href="#">Login and Register</a></div>
                </div>
                <h3 class="heading mt-2"><a href="#">To Access dashboard and features</a></h3>
               <p><a href="<?= base_url('features') ?>" class="btn btn-primary">Read more</a></p>
              </div>
            </div>
          </div>
          <div class="col-md-4 d-flex ftco-animate">
          	<div class="blog-entry justify-content-end">
              <a href="blog-single.html" class="block-20" style="background-image: url('images/dashadmin.jpg');">
              </a>
              <div class="text pt-4">
              	<div class="meta mb-3">
                  <div><a href="#">Admin Dashboard</a></div>
                </div>
                <h3 class="heading mt-2"><a href="#">To manage BusTracker System</a></h3>
               <p><a href="<?= base_url('features') ?>" class="btn btn-primary">Read more</a></p>
              </div>
            </div>
          </div>
          <div class="col-md-4 d-flex ftco-animate">
          	<div class="blog-entry">
              <a href="blog-single.html" class="block-20" style="background-image: url('images/dashdriver.jpg');">
              </a>
              <div class="text pt-4">
              	<div class="meta mb-3">
                  <div><a href="#">Driver Dashboard</a></div>
                <h3 class="heading mt-2"><a href="#">To manage their tasks and communicate with students.</a></h3>
                <p><a href="<?= base_url('features') ?>" class="btn btn-primary">Read more</a></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>	
     <!-- End features section -->

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