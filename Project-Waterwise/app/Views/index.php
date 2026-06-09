<?= $this->include('landing/header') ?>

        <link rel="icon" href="<?= base_url('favicon.ico') ?>" type="image/x-icon">
        
        <!-- Include the CSS files -->
        <link rel="stylesheet" href="<?= base_url('app/css/owl.carousel.css') ?>">
        <link rel="stylesheet" href="<?= base_url('app/css/main.css') ?>">
        
        <style>
            /* Carousel Section Styling */
            .section-padding {
                padding: 60px 0;
            }
            
            /* Carousel Container */
            .owl-carousel .item {
                display: flex;
                flex-direction: column;
                align-items: center;
                text-align: center;
                background: #fff;
                border-radius: 10px;
                box-shadow: 0 5px 20px rgba(0,0,0,0.1);
                overflow: hidden;
                transition: transform 0.3s ease;
            }
            
            .owl-carousel .item:hover {
                transform: translateY(-5px);
            }
            
            /* Image Styling */
            .owl-carousel .item img {
                width: 100%;
                height: 250px;
                object-fit: cover;
                border-radius: 10px 10px 0 0;
            }
            
            /* Caption Styling */
            .carousel-caption-item {
                padding: 20px;
                background: #fff;
            }
            
            .carousel-caption-item h3 {
                font-size: 18px;
                font-weight: 600;
                color: #333;
                margin-bottom: 10px;
            }
            
            .carousel-caption-item p {
                font-size: 14px;
                color: #666;
                line-height: 1.6;
                margin: 0;
            }
            
            /* Owl Carousel Custom Styles */
            .owl-carousel .owl-nav {
                margin-top: 20px;
            }
            
            .owl-carousel .owl-nav button {
                background: #3498db !important;
                color: white !important;
                border: none !important;
                border-radius: 50% !important;
                width: 40px !important;
                height: 40px !important;
                font-size: 18px !important;
                margin: 0 5px !important;
                transition: all 0.3s ease !important;
            }
            
            .owl-carousel .owl-nav button:hover {
                background: #2980b9 !important;
                transform: scale(1.1) !important;
            }
            
            .owl-carousel .owl-dots {
                text-align: center;
                margin-top: 20px;
            }
            
            .owl-carousel .owl-dot {
                display: inline-block;
                width: 12px;
                height: 12px;
                background: #ddd;
                border-radius: 50%;
                margin: 0 5px;
                transition: all 0.3s ease;
            }
            
            .owl-carousel .owl-dot.active {
                background: #3498db;
                transform: scale(1.2);
            }
            
            /* Section Title Styling */
            .section-title h2 {
                font-size: 32px;
                font-weight: 700;
                color: #333;
                margin-bottom: 20px;
                position: relative;
                display: inline-block;
            }
            
            .section-title h2:after {
                content: '';
                position: absolute;
                bottom: -10px;
                left: 50%;
                transform: translateX(-50%);
                width: 60px;
                height: 3px;
                background: #3498db;
            }
            
            /* Responsive Design */
            @media (max-width: 768px) {
                .owl-carousel .item img {
                    height: 200px;
                }
                
                .carousel-caption-item {
                    padding: 15px;
                }
                
                .carousel-caption-item h3 {
                    font-size: 16px;
                }
                
                .carousel-caption-item p {
                    font-size: 13px;
                }
            }
        </style>

    </head>

    <body id="home">

        <div id="preloader">
            <div class="loder-box">
                <div class="battery"></div>
            </div>
        </div>
        <header id="navigation" class="navbar-inverse navbar-fixed-top animated-header">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <h1 class="navbar-brand">
                        <a href="#home">WaterWise</a>
                    </h1>
                    </div>

                <nav class="collapse navbar-collapse navbar-right" role="navigation">
                    <ul id="nav" class="nav navbar-nav">
                        <li><a href="#home">Home</a></li>
                        <li><a href="#about">About Us</a></li>
                        <li><a href="#feature">Feature</a></li> 
                        <li><a href="#our-services">Service</a></li> 
                        <li><a href="#price">Price</a></li>
                    </ul>
                </nav>
                </div>
        <!-- ==================Start slider ================== -->
        </header>
        <main class="site-content" role="main">

            <section id="home-slider">
                <div id="slider" class="sl-slider-wrapper">

                    <div class="sl-slider">

                        <div class="sl-slide" data-orientation="horizontal" data-slice1-rotation="-25" data-slice2-rotation="-25" data-slice1-scale="2" data-slice2-scale="2">
                            <div class="sl-slide bg-img-1"></div>
                            <div class="slide-caption">
                                <div class="caption-content">
                                    <h2 class="animated fadeInDown">Track, Save, Triumph.</h2>
                                    <span class="animated fadeInDown">Gamify Your Goals, Conserve Every Drop.</span>
                                    <a href="<?= base_url('register') ?>" class="btn btn-blue btn-effect">Register Now</a>
                                </div>
                            </div>
                        </div>

                        <div class="sl-slide" data-orientation="vertical" data-slice1-rotation="10" data-slice2-rotation="-15" data-slice1-scale="1.5" data-slice2-scale="1.5">
                            <div class="sl-slide bg-img-2"></div>
                            <div class="slide-caption">
                                <div class="caption-content">
                                    <h2 class="animated fadeInDown">Every Drop Counts</h2>
                                    <span class="animated fadeInDown">Combat water waste with real tracking</span>
                                    <a href="#about" class="btn btn-blue btn-effect">Learn More</a>
                                </div>
                            </div>
                        </div>

                        <div class="sl-slide" data-orientation="horizontal" data-slice1-rotation="3" data-slice2-rotation="3" data-slice1-scale="2" data-slice2-scale="1">
                            <div class="sl-slide bg-img-3"></div>
                            <div class="slide-caption">
                                <div class="caption-content">
                                    <h2 class="animated fadeInDown">Save Water, Earn Rewards.</h2>
                                    <span class="animated fadeInDown">Climb leaderboards, unlock badges, and gain EcoPoints</span>
                                    <a href="<?= base_url('login') ?>" class="btn btn-blue btn-effect">Login</a>
                                </div>
                            </div>
                        </div>

                    </div><nav id="nav-arrows" class="nav-arrows hidden-xs hidden-sm visible-md visible-lg">
                        <a href="javascript:;" class="sl-prev">
                            <i class="fa fa-angle-left fa-3x"></i>
                        </a>
                        <a href="javascript:;" class="sl-next">
                            <i class="fa fa-angle-right fa-3x"></i>
                        </a>
                    </nav>

                    <nav id="nav-dots" class="nav-dots visible-xs visible-sm hidden-md hidden-lg">
                        <span class="nav-dot-current"></span>
                        <span></span>
                        <span></span>
                    </nav>

                </div></section>
                
            <!-- ==================End Header ================== -->
            
            
            <!-- ==================Start About ================== -->    
            <section id="about">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 wow animated fadeInLeft">
                            <div class="Community Impact">
                                <h3>Community Impact</h3>
                                <div id="works">
                                    <div class="work-item">
                                        💧 <strong>15,000+ liters</strong> of water saved collectively by our users — every drop counts toward a sustainable future.
                                    </div>
                                    <div class="work-item">
                                        📝 <strong>1,200+</strong> water usage records manually submitted by users to track and improve their daily habits.
                                    </div>
                                    <div class="work-item">
                                        🏆 <strong>450+ EcoBadges</strong> earned and <strong>Top User</strong> reduced their water consumption by 30% in just one month!
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 col-md-offset-1 wow animated fadeInRight">
                            <div class="welcome-block">
                                <h3>Welcome To Our Site</h3>
                                <div class="message-body">
                                    <img src="<?= base_url('/')?>/Waterwise/img/member-1.jpg" class="pull-left" alt="member">
                                    Welcome to Gaming Smart Water a platform designed to encourage water conservation through gamification and real accountability. Submit your water usage, earn EcoPoints, compete on leaderboards, and become part of a community making real change for the environment.
                                </div>
                                <a href="#testimonials" class="btn btn-border btn-effect pull-right">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- ==================End About ================== -->
            
            
            <!-- ==================Start Feature ================== -->
            
            <section id="feature" class="section-padding">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="section-title text-center wow animated fadeInDown">
                                <h2>Admin Dashboard</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 wow animated fadeInUp">
                            <div id="admin-dashboard-carousel" class="owl-carousel owl-theme">
                                <div class="item">
                                    <img src="<?= base_url('/')?>/Waterwise/img/features/1.png" alt="Admin Dashboard Image 1">
                                    <div class="carousel-caption-item">
                                        <h3>Admin Dashboard</h3>
                                        <p>Overview of the admin dashboard.</p>
                                    </div>
                                </div>
                                <div class="item">
                                    <img src="<?= base_url('/')?>/Waterwise/img/features/2.png" alt="Admin Dashboard Image 2">
                                    <div class="carousel-caption-item">
                                        <h3>Admin Dashboard</h3>
                                        <p>Details of admin management sections.</p>
                                    </div>
                                </div>
                                <div class="item">
                                    <img src="<?= base_url('/')?>/Waterwise/img/features/3.png" alt="Admin Dashboard Image 3">
                                    <div class="carousel-caption-item">
                                        <h3>Admin Dashboard</h3>
                                        <p>Further aspects of the admin interface.</p>
                                    </div>
                                </div>
                                <div class="item">
                                    <img src="<?= base_url('/')?>/Waterwise/img/features/4.png" alt="Admin Dashboard Image 4">
                                    <div class="carousel-caption-item">
                                        <h3>Admin Dashboard</h3>
                                        <p>Continues admin dashboard views.</p>
                                    </div>
                                </div>
                                <div class="item">
                                    <img src="<?= base_url('/')?>/Waterwise/img/features/5.png" alt="Admin Dashboard Image 5">
                                    <div class="carousel-caption-item">
                                        <h3>Admin Dashboard</h3>
                                        <p>Additional admin dashboard features.</p>
                                    </div>
                                </div>
                                <div class="item">
                                    <img src="<?= base_url('/')?>/Waterwise/img/features/6.png" alt="Admin Dashboard Image 6">
                                    <div class="carousel-caption-item">
                                        <h3>Admin Dashboard</h3>
                                        <p>More insights into the admin panel.</p>
                                    </div>
                                </div>
                                <div class="item">
                                    <img src="<?= base_url('/')?>/Waterwise/img/features/7.png" alt="Admin Dashboard Image 7">
                                    <div class="carousel-caption-item">
                                        <h3>Admin Dashboard</h3>
                                        <p>Final view of the admin dashboard section.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <section id="edit-admin-carousel-section" class="section-padding">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="section-title text-center wow animated fadeInDown">
                                <h2>Edit Admin</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 wow animated fadeInUp">
                            <div id="edit-admin-carousel" class="owl-carousel owl-theme">
                                <div class="item">
                                    <img src="<?= base_url('/')?>/Waterwise/img/features/8.png" alt="Edit Admin Image 8">
                                    <div class="carousel-caption-item">
                                        <h3>Edit Admin</h3>
                                        <p>Admin profile editing interface.</p>
                                    </div>
                                </div>
                                <div class="item">
                                    <img src="<?= base_url('/')?>/Waterwise/img/features/9.png" alt="Edit Admin Image 9">
                                    <div class="carousel-caption-item">
                                        <h3>Edit Admin</h3>
                                        <p>Specific fields for admin details.</p>
                                    </div>
                                </div>
                                <div class="item">
                                    <img src="<?= base_url('/')?>/Waterwise/img/features/10.png" alt="Edit Admin Image 10">
                                    <div class="carousel-caption-item">
                                        <h3>Edit Admin</h3>
                                        <p>Options for updating admin credentials.</p>
                                    </div>
                                </div>
                                <div class="item">
                                    <img src="<?= base_url('/')?>/Waterwise/img/features/11.png" alt="Edit Admin Image 11">
                                    <div class="carousel-caption-item">
                                        <h3>Edit Admin</h3>
                                        <p>Confirmation or save options for admin edits.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <section id="quick-action-carousel-section" class="section-padding">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="section-title text-center wow animated fadeInDown">
                                <h2>Quick Actions</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 wow animated fadeInUp">
                            <div id="quick-action-carousel" class="owl-carousel owl-theme">
                                <div class="item">
                                    <img src="<?= base_url('/')?>/Waterwise/img/features/12.png" alt="Quick Action Image 12">
                                    <div class="carousel-caption-item">
                                        <h3>Quick Actions</h3>
                                        <p>Shortcut buttons for common tasks.</p>
                                    </div>
                                </div>
                                <div class="item">
                                    <img src="<?= base_url('/')?>/Waterwise/img/features/13.png" alt="Quick Action Image 13">
                                    <div class="carousel-caption-item">
                                        <h3>Quick Actions</h3>
                                        <p>Fast access to frequently used functionalities.</p>
                                    </div>
                                </div>
                                <div class="item">
                                    <img src="<?= base_url('/')?>/Waterwise/img/features/14.png" alt="Quick Action Image 14">
                                    <div class="carousel-caption-item">
                                        <h3>Quick Actions</h3>
                                        <p>Direct links to essential operations.</p>
                                    </div>
                                </div>
                                <div class="item">
                                    <img src="<?= base_url('/')?>/Waterwise/img/features/15.png" alt="Quick Action Image 15">
                                    <div class="carousel-caption-item">
                                        <h3>Quick Actions</h3>
                                        <p>Streamlined administrative controls.</p>
                                    </div>
                                </div>
                                <div class="item">
                                    <img src="<?= base_url('/')?>/Waterwise/img/features/16.png" alt="Quick Action Image 16">
                                    <div class="carousel-caption-item">
                                        <h3>Quick Actions</h3>
                                        <p>More examples of quick access tools.</p>
                                    </div>
                                </div>
                                <div class="item">
                                    <img src="<?= base_url('/')?>/Waterwise/img/features/17.png" alt="Quick Action Image 17">
                                    <div class="carousel-caption-item">
                                        <h3>Quick Actions</h3>
                                        <p>Final view of quick action options.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <section id="user-overview-carousel-section" class="section-padding">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="section-title text-center wow animated fadeInDown">
                                <h2>User Overview</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 wow animated fadeInUp">
                            <div id="user-overview-carousel" class="owl-carousel owl-theme">
                                <div class="item">
                                    <img src="<?= base_url('/')?>/Waterwise/img/features/19.png" alt="User Overview Image 19">
                                    <div class="carousel-caption-item">
                                        <h3>User Overview</h3>
                                        <p>Comprehensive list or summary of users.</p>
                                    </div>
                                </div>
                                <div class="item">
                                    <img src="<?= base_url('/')?>/Waterwise/img/features/20.png" alt="User Overview Image 20">
                                    <div class="carousel-caption-item">
                                        <h3>User Overview</h3>
                                        <p>Detailed user profiles or data points.</p>
                                    </div>
                                </div>
                                <div class="item">
                                    <img src="<?= base_url('/')?>/Waterwise/img/features/21.png" alt="User Overview Image 21">
                                    <div class="carousel-caption-item">
                                        <h3>User Overview</h3>
                                        <p>User activity logs or statistics.</p>
                                    </div>
                                </div>
                                <div class="item">
                                    <img src="<?= base_url('/')?>/Waterwise/img/features/22.png" alt="User Overview Image 22">
                                    <div class="carousel-caption-item">
                                        <h3>User Overview</h3>
                                        <p>User account management tools.</p>
                                    </div>
                                </div>
                                <div class="item">
                                    <img src="<?= base_url('/')?>/Waterwise/img/features/23.png" alt="User Overview Image 23">
                                    <div class="carousel-caption-item">
                                        <h3>User Overview</h3>
                                        <p>Data visualization related to users.</p>
                                    </div>
                                </div>
                                <div class="item">
                                    <img src="<?= base_url('/')?>/Waterwise/img/features/24.png" alt="User Overview Image 24">
                                    <div class="carousel-caption-item">
                                        <h3>User Overview</h3>
                                        <p>User segmentation or filtering options.</p>
                                    </div>
                                </div>
                                <div class="item">
                                    <img src="<?= base_url('/')?>/Waterwise/img/features/25.png" alt="User Overview Image 25">
                                    <div class="carousel-caption-item">
                                        <h3>User Overview</h3>
                                        <p>User communication tools.</p>
                                    </div>
                                </div>
                                <div class="item">
                                    <img src="<?= base_url('/')?>/Waterwise/img/features/26.png" alt="User Overview Image 26">
                                    <div class="carousel-caption-item">
                                        <h3>User Overview</h3>
                                        <p>User permissions or roles management.</p>
                                    </div>
                                </div>
                                <div class="item">
                                    <img src="<?= base_url('/')?>/Waterwise/img/features/27.png" alt="User Overview Image 27">
                                    <div class="carousel-caption-item">
                                        <h3>User Overview</h3>
                                        <p>User support or ticketing integration.</p>
                                    </div>
                                </div>
                                <div class="item">
                                    <img src="<?= base_url('/')?>/Waterwise/img/features/28.png" alt="User Overview Image 28">
                                    <div class="carousel-caption-item">
                                        <h3>User Overview</h3>
                                        <p>Final screen of user overview section.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <section id="leaderboard-carousel-section" class="section-padding">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="section-title text-center wow animated fadeInDown">
                                <h2>Leaderboard</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 wow animated fadeInUp">
                            <div id="leaderboard-carousel" class="owl-carousel owl-theme">
                                <div class="item">
                                    <img src="<?= base_url('/')?>/Waterwise/img/features/29.png" alt="Leaderboard Image 29">
                                    <div class="carousel-caption-item">
                                        <h3>Leaderboard</h3>
                                        <p>Shows top rankings and user positions.</p>
                                    </div>
                                </div>
                                <div class="item">
                                    <img src="<?= base_url('/')?>/Waterwise/img/features/30.png" alt="Leaderboard Image 30">
                                    <div class="carousel-caption-item">
                                        <h3>Leaderboard</h3>
                                        <p>Detailed view of eco-points and XP rankings.</p>
                                    </div>
                                </div>
                                <div class="item">
                                    <img src="<?= base_url('/')?>/Waterwise/img/features/31.png" alt="Leaderboard Image 31">
                                    <div class="carousel-caption-item">
                                        <h3>Leaderboard</h3>
                                        <p>Visual representation of user progress.</p>
                                    </div>
                                </div>
                                <div class="item">
                                    <img src="<?= base_url('/')?>/Waterwise/img/features/32.png" alt="Leaderboard Image 32">
                                    <div class="carousel-caption-item">
                                        <h3>Leaderboard</h3>
                                        <p>Final view of the leaderboard features.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <section id="quest-carousel-section" class="section-padding">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="section-title text-center wow animated fadeInDown">
                                <h2>Quest Section</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 wow animated fadeInUp">
                            <div id="quest-carousel" class="owl-carousel owl-theme">
                                <div class="item">
                                    <img src="<?= base_url('/')?>/Waterwise/img/features/33.png" alt="Quest Image 33">
                                    <div class="carousel-caption-item">
                                        <h3>Quest Section</h3>
                                        <p>Overview of available quests.</p>
                                    </div>
                                </div>
                                <div class="item">
                                    <img src="<?= base_url('/')?>/Waterwise/img/features/34.png" alt="Quest Image 34">
                                    <div class="carousel-caption-item">
                                        <h3>Quest Section</h3>
                                        <p>Details of quest completion and rewards.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <section id="achievement-carousel-section" class="section-padding">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="section-title text-center wow animated fadeInDown">
                                <h2>Achievements</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 wow animated fadeInUp">
                            <div id="achievement-carousel" class="owl-carousel owl-theme">
                                <div class="item">
                                    <img src="<?= base_url('/')?>/Waterwise/img/features/35.png" alt="Achievement Image 35">
                                    <div class="carousel-caption-item">
                                        <h3>Achievements</h3>
                                        <p>Tracks unlocked/locked achievements and progress.</p>
                                    </div>
                                </div>
                                <div class="item">
                                    <img src="<?= base_url('/')?>/Waterwise/img/features/36.png" alt="Achievement Image 36">
                                    <div class="carousel-caption-item">
                                        <h3>Achievements</h3>
                                        <p>Displays points earned from achievements.</p>
                                    </div>
                                </div>
                                <div class="item">
                                    <img src="<?= base_url('/')?>/Waterwise/img/features/37.png" alt="Achievement Image 37">
                                    <div class="carousel-caption-item">
                                        <h3>Achievements</h3>
                                        <p>Shows category badges and their status.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <section id="reward-store-carousel-section" class="section-padding">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="section-title text-center wow animated fadeInDown">
                                <h2>Reward Store</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 wow animated fadeInUp">
                            <div id="reward-store-carousel" class="owl-carousel owl-theme">
                                <div class="item">
                                    <img src="<?= base_url('/')?>/Waterwise/img/features/38.png" alt="Reward Store Image 38">
                                    <div class="carousel-caption-item">
                                        <h3>Reward Store</h3>
                                        <p>Categories of rewards available for redemption.</p>
                                    </div>
                                </div>
                                <div class="item">
                                    <img src="<?= base_url('/')?>/Waterwise/img/features/39.png" alt="Reward Store Image 39">
                                    <div class="carousel-caption-item">
                                        <h3>Reward Store</h3>
                                        <p>Details of individual rewards and their eco-point cost.</p>
                                    </div>
                                </div>
                                <div class="item">
                                    <img src="<?= base_url('/')?>/Waterwise/img/features/40.png" alt="Reward Store Image 40">
                                    <div class="carousel-caption-item">
                                        <h3>Reward Store</h3>
                                        <p>Information on redemption status and requirements.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <section id="profile-carousel-section" class="section-padding">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="section-title text-center wow animated fadeInDown">
                                <h2>Profile Settings</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 wow animated fadeInUp">
                            <div id="profile-carousel" class="owl-carousel owl-theme">
                                <div class="item">
                                    <img src="<?= base_url('/')?>/Waterwise/img/features/41.png" alt="Profile Image 41">
                                    <div class="carousel-caption-item">
                                        <h3>Profile Settings</h3>
                                        <p>Options for changing profile picture and border.</p>
                                    </div>
                                </div>
                                <div class="item">
                                    <img src="<?= base_url('/')?>/Waterwise/img/features/42.png" alt="Profile Image 42">
                                    <div class="carousel-caption-item">
                                        <h3>Profile Settings</h3>
                                        <p>Interface for updating user password securely.</p>
                                    </div>
                                </div>
                                <div class="item">
                                    <img src="<?= base_url('/')?>/Waterwise/img/features/43.png" alt="Profile Image 43">
                                    <div class="carousel-caption-item">
                                        <h3>Profile Settings</h3>
                                        <p>Additional customization options for the profile.</p>
                                    </div>
                                </div>
                                <div class="item">
                                    <img src="<?= base_url('/')?>/Waterwise/img/features/44.png" alt="Profile Image 44">
                                    <div class="carousel-caption-item">
                                        <h3>Profile Settings</h3>
                                        <p>Profile data management features.</p>
                                    </div>
                                </div>
                                <div class="item">
                                    <img src="<?= base_url('/')?>/Waterwise/img/features/45.png" alt="Profile Image 45">
                                    <div class="carousel-caption-item">
                                        <h3>Profile Settings</h3>
                                        <p>Privacy settings and controls.</p>
                                    </div>
                                </div>
                                <div class="item">
                                    <img src="<?= base_url('/')?>/Waterwise/img/features/46.png" alt="Profile Image 46">
                                    <div class="carousel-caption-item">
                                        <h3>Profile Settings</h3>
                                        <p>Final view of profile customization options.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
                        
            <!-- ==================End Feature ================== -->
            
            <!-- ==================Start Service ================== -->
            <section id="our-services">
                <div class="container">
                    <div class="sec-title text-center wow animated fadeInDown">
                        <h2>Our Services</h2>
                        <p>The key features of our platform designed to help you conserve water.</p>
                    </div>

                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-xs-12 text-center wow animated zoomIn">
                            <div class="service-feature">
                                <div class="service-icon">
                                    <i class="fa fa-tachometer"></i>
                                </div>
                                <h3>Smart Usage Logging</h3>
                                <p>Users can manually record their daily or monthly water usage through a simple and guided form interface.</p>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 col-xs-12 text-center wow animated zoomIn" data-wow-delay="0.3s">
                            <div class="service-feature">
                                <div class="service-icon">
                                    <i class="fa fa-trophy"></i>
                                </div>
                                <h3>Gamified Rewards</h3>
                                <p>Earn EcoPoints, badges, and climb the leaderboard by consistently saving water and reaching conservation goals.</p>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 col-xs-12 text-center wow animated zoomIn" data-wow-delay="0.6s">
                            <div class="service-feature">
                                <div class="service-icon">
                                    <i class="fa fa-line-chart"></i>
                                </div>
                                <h3>Progress Analytics</h3>
                                <p>Track your water-saving habits with intuitive charts, monthly summaries, and personalized recommendations.</p>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 col-xs-12 text-center wow animated zoomIn" data-wow-delay="0.9s">
                            <div class="service-feature">
                                <div class="service-icon">
                                    <i class="fa fa-users"></i>
                                </div>
                                <h3>Community Leaderboard</h3>
                                <p>See how you rank among other users in your region, and get inspired by top water savers in the community.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- ==================End Service ================== -->
            
            
            <!-- ==================Start About ================== -->
            <section id="about"> <div class="container">
                    <div class="row">
                        <div class="col-md-6 wow animated fadeInLeft">
                            <div class="welcome-block">
                                <h3>Our Vision</h3>
                                <p>
                                    To create a world where water conservation is second nature, where every individual
                                    understands their role in preserving this precious resource, and where technology
                                    empowers sustainable living through engaging, gamified experiences.
                                </p>
                                <p>
                                    We envision communities worldwide united in their commitment to water stewardship,
                                    making conservation efforts both rewarding and impactful for future generations.
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 wow animated fadeInRight">
                            <div class="welcome-block">
                                <h3>Our Mission</h3>
                                <p>
                                    To revolutionize water conservation through innovative gamification, making sustainable
                                    practices accessible, enjoyable, and rewarding for users of all ages and backgrounds.
                                </p>
                                <p>
                                    We are committed to providing tools, education, and incentives that transform daily
                                    water usage habits, foster community engagement, and create measurable environmental
                                    impact through collective action.
                                </p>
                                <a href="<?= base_url('register') ?>" class="btn btn-blue btn-effect pull-right">Join the Movement</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- ==================End About ================== -->
            
            <!-- ==================Start Price ================== -->
            <section id="price">
                <div class="container">
                    <div class="row">
                        <div class="sec-title text-center wow animated fadeInDown">
                            <h2>Plans</h2>
                            <p>Choose a plan that fits your water-saving goals</p>
                        </div>

                        <div class="col-md-4 wow animated fadeInUp">
                            <div class="price-table text-center">
                                <span>Silver</span>
                                <div class="value">
                                    <span>RM</span>
                                    <span>0</span>
                                    <span>/month</span>
                                </div>
                                <ul>
                                    <li>Manual Water Logging</li>
                                    <li>Basic Usage History</li>
                                    <li>EcoPoints Accumulation</li>
                                    <li>Email Support</li>
                                    <li><a href="<?= base_url('register') ?>">Sign Up</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-4 wow animated fadeInUp" data-wow-delay="0.4s">
                            <div class="price-table featured text-center">
                                <span>Gold</span>
                                <div class="value">
                                    <span>RM</span>
                                    <span>19.99</span>
                                    <span>/month</span>
                                </div>
                                <ul>
                                    <li>All Silver Features</li>
                                    <li>Weekly Reports & Tips</li>
                                    <li>Access to Leaderboard</li>
                                    <li>Earn Achievement Badges</li>
                                    <li><a href="<?= base_url('register') ?>">Sign Up</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-4 wow animated fadeInUp" data-wow-delay="0.8s">
                            <div class="price-table text-center">
                                <span>Diamond(FUTURE)</span>
                                <div class="value">
                                    <span>RM</span>
                                    <span>49.99</span>
                                    <span>/month</span>
                                </div>
                                <ul>
                                    <li>All Gold Features</li>
                                    <li>Smart Usage Analytics</li>
                                    <li>Custom Goals & Alerts</li>
                                    <li>Priority Support</li>
                                    <li><a href="<?= base_url('register') ?>">Sign Up</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- ==================End Price ================== -->
            
            <!-- ==================Start Community ================== -->
            <section id="join-community">
                <div class="container">
                    <div class="sec-title text-center">
                        <h2 class="text-dark">Join Our Community</h2>
                        <p class="text-dark">Be part of the WaterWise journey: save water, earn rewards, and share your progress.</p>
                        <a href="<?= base_url('register') ?>" class="btn btn-blue btn-effect mt-4">Get Started Today!</a>
                    </div>
                </div>
            </section>
            <!-- ==================End Community ================== -->
            
            </main>
            
<?= $this->include('landing/footer') ?>