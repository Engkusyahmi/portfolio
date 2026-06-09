</main>

<!-- Footer -->
<footer id="footer">
    <div class="container">
        <div class="footer-content">
            <div class="row">
                <div class="col-md-4">
                    <h4 style="color: white; margin-bottom: 20px;">WaterWise</h4>
                    <p style="color: rgba(255,255,255,0.8); line-height: 1.6;">
                        Join the water conservation revolution through gamification. 
                        Every drop counts, every action matters, every user makes a difference.
                    </p>
                </div>
                <div class="col-md-4">
                    <h4 style="color: white; margin-bottom: 20px;">Quick Links</h4>
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin-bottom: 8px;"><a href="<?= base_url('/') ?>" style="color: rgba(255,255,255,0.8); text-decoration: none;">Home</a></li>
                        <li style="margin-bottom: 8px;"><a href="<?= base_url('/user/quest') ?>" style="color: rgba(255,255,255,0.8); text-decoration: none;">Quests</a></li>
                        <li style="margin-bottom: 8px;"><a href="<?= base_url('/user/achievement') ?>" style="color: rgba(255,255,255,0.8); text-decoration: none;">Achievements</a></li>
                        <li style="margin-bottom: 8px;"><a href="<?= base_url('/user/rewardstore') ?>" style="color: rgba(255,255,255,0.8); text-decoration: none;">Rewards</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h4 style="color: white; margin-bottom: 20px;">Contact</h4>
                    <p style="color: rgba(255,255,255,0.8); line-height: 1.6;">
                        <i class="fa fa-envelope"></i> support@waterwise.com<br>
                        <i class="fa fa-phone"></i> +1 (555) 123-4567<br>
                        <i class="fa fa-map-marker"></i> 123 Water St, Conservation City
                    </p>
                </div>
            </div>
            <hr style="border-color: rgba(255,255,255,0.2); margin: 30px 0 20px;">
            <div class="text-center">
                <p style="color: rgba(255,255,255,0.6); margin: 0;">
                    &copy; 2025 WaterWise. Designed by <a href="#" style="color: var(--accent-blue);">Engku Syahmi</a>
                </p>
            </div>
        </div>
    </div>
</footer>

<!-- Scripts -->
<script src="<?= base_url('Waterwise/js/jquery-1.11.1.min.js') ?>"></script>
<script src="<?= base_url('Waterwise/js/bootstrap.min.js') ?>"></script>
<script src="<?= base_url('Waterwise/js/jquery.singlePageNav.min.js') ?>"></script>
<script src="<?= base_url('Waterwise/js/jquery.fancybox.pack.js') ?>"></script>
<script src="<?= base_url('Waterwise/js/owl.carousel.min.js') ?>"></script>
<script src="<?= base_url('Waterwise/js/jquery.easing.min.js') ?>"></script>
<script src="<?= base_url('Waterwise/js/jquery.slitslider.js') ?>"></script>
<script src="<?= base_url('Waterwise/js/jquery.ba-cond.min.js') ?>"></script>
<script src="<?= base_url('Waterwise/js/wow.min.js') ?>"></script>
<script src="<?= base_url('Waterwise/js/main.js') ?>"></script>

<!-- Bootstrap 5 for better dropdowns -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    // Preloader
    $(window).on('load', function() {
        $('#preloader').fadeOut('slow');
    });
    
    // Header background on scroll
    $(window).scroll(function() {
        if ($(this).scrollTop() > 100) {
            $('#navigation').addClass('animated-header');
        } else {
            $('#navigation').removeClass('animated-header');
        }
    });
    
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Smooth scrolling for anchor links
    $('a[href*="#"]:not([href="#"])').click(function() {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                $('html, body').animate({
                    scrollTop: target.offset().top - 70
                }, 1000);
                return false;
            }
        }
    });
});
</script>

</body>
</html>