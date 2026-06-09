 <!-- ==================Start Footer ================== -->
            <footer id="footer">
                <div class="container">
                    <div class="row text-center"> <!-- The text-center here is good for the row, but we're also adding it directly to footer-content -->
                        <div class="footer-content">
                            <p>Copyright &copy; 2025 Design and Developed By EngkuSyahmi</p>
                            
                        </div>
                    </div>
                </div>
            </footer>
            <!-- ==================End Footer ================== -->
            
        <script src="<?= base_url('/')?>/Waterwise/js/jquery-1.11.1.min.js"></script>
        <script src="<?= base_url('/')?>/Waterwise/js/bootstrap.min.js"></script>
        <script src="<?= base_url('/')?>/Waterwise/js/jquery.singlePageNav.min.js"></script>
        <script src="<?= base_url('/')?>/Waterwise/js/jquery.fancybox.pack.js"></script>
        <script src="<?= base_url('/')?>/Waterwise/js/owl.carousel.min.js"></script>
        <script src="<?= base_url('/')?>/Waterwise/js/jquery.easing.min.js"></script>
        <script src="<?= base_url('/')?>/Waterwise/js/jquery.slitslider.js"></script>
        <script src="<?= base_url('/')?>/Waterwise/js/jquery.ba-cond.min.js"></script>
        <script src="<?= base_url('/')?>/Waterwise/js/wow.min.js"></script>
        <script src="<?= base_url('/')?>/Waterwise/js/main.js"></script>

<script>
  $(document).ready(function(){
    // Initialize Admin Dashboard Carousel
    $("#admin-dashboard-carousel").owlCarousel({
      items: 3,
      loop: true,
      margin: 20,
      nav: true,
      dots: true,
      autoplay: true,
      autoplayTimeout: 5000,
      autoplayHoverPause: true,
      responsive: {
        0: { items: 1 },
        600: { items: 2 },
        1000: { items: 3 }
      }
    });

    // Initialize Edit Admin Carousel
    $("#edit-admin-carousel").owlCarousel({
      items: 3,
      loop: true,
      margin: 20,
      nav: true,
      dots: true,
      autoplay: true,
      autoplayTimeout: 5000,
      autoplayHoverPause: true,
      responsive: {
        0: { items: 1 },
        600: { items: 2 },
        1000: { items: 3 }
      }
    });

    // Initialize Quick Action Carousel
    $("#quick-action-carousel").owlCarousel({
      items: 3,
      loop: true,
      margin: 20,
      nav: true,
      dots: true,
      autoplay: true,
      autoplayTimeout: 5000,
      autoplayHoverPause: true,
      responsive: {
        0: { items: 1 },
        600: { items: 2 },
        1000: { items: 3 }
      }
    });

    // Initialize User Overview Carousel
    $("#user-overview-carousel").owlCarousel({
      items: 3,
      loop: true,
      margin: 20,
      nav: true,
      dots: true,
      autoplay: true,
      autoplayTimeout: 5000,
      autoplayHoverPause: true,
      responsive: {
        0: { items: 1 },
        600: { items: 2 },
        1000: { items: 3 }
      }
    });

    // Initialize Leaderboard Carousel
    $("#leaderboard-carousel").owlCarousel({
      items: 3,
      loop: true,
      margin: 20,
      nav: true,
      dots: true,
      autoplay: true,
      autoplayTimeout: 5000,
      autoplayHoverPause: true,
      responsive: {
        0: { items: 1 },
        600: { items: 2 },
        1000: { items: 3 }
      }
    });

    // Initialize Quest Carousel
    $("#quest-carousel").owlCarousel({
      items: 2,
      loop: true,
      margin: 20,
      nav: true,
      dots: true,
      autoplay: true,
      autoplayTimeout: 5000,
      autoplayHoverPause: true,
      responsive: {
        0: { items: 1 },
        600: { items: 2 },
        1000: { items: 2 }
      }
    });

    // Initialize Achievement Carousel
    $("#achievement-carousel").owlCarousel({
      items: 3,
      loop: true,
      margin: 20,
      nav: true,
      dots: true,
      autoplay: true,
      autoplayTimeout: 5000,
      autoplayHoverPause: true,
      responsive: {
        0: { items: 1 },
        600: { items: 2 },
        1000: { items: 3 }
      }
    });

    // Initialize Reward Store Carousel
    $("#reward-store-carousel").owlCarousel({
      items: 3,
      loop: true,
      margin: 20,
      nav: true,
      dots: true,
      autoplay: true,
      autoplayTimeout: 5000,
      autoplayHoverPause: true,
      responsive: {
        0: { items: 1 },
        600: { items: 2 },
        1000: { items: 3 }
      }
    });

    // Initialize Profile Carousel
    $("#profile-carousel").owlCarousel({
      items: 3,
      loop: true,
      margin: 20,
      nav: true,
      dots: true,
      autoplay: true,
      autoplayTimeout: 5000,
      autoplayHoverPause: true,
      responsive: {
        0: { items: 1 },
        600: { items: 2 },
        1000: { items: 3 }
      }
    });
  });
</script>
</html>