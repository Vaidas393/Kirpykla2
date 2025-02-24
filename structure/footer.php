<?php
$contactQuery = mysqli_query($con, "SELECT * FROM contact_info LIMIT 1");
$contact = mysqli_fetch_assoc($contactQuery);
?>

<footer id="footer" class="footer" >
    <div class="footer-content position-relative">
        <div class="container">
            <div class="row">

                <!-- Contact Information -->
                <div class="col-lg-4 col-md-6">
                    <div class="footer-info">
                        <p>
                            <strong>El. paštas:</strong> <?= htmlspecialchars($contact['email']); ?><br>
                            <strong>Telefonas:</strong> <?= htmlspecialchars($contact['phone']); ?><br>
                            <strong>Adresas:</strong> <?= htmlspecialchars($contact['address']); ?><br>
                        </p>
                    </div>
                </div><!-- End footer info column -->

                <!-- Navigation Links -->
                <!-- End footer links column -->

                <!-- Google Maps -->
            </div>
        </div>
    </div>
</footer>
<!-- End Footer -->

<a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<div id="preloader"></div>

<!-- Vendor JS Files -->
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>

<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    if (window.location.hash) {
      let target = document.querySelector(window.location.hash);
      if (target) {
        setTimeout(() => {
          target.scrollIntoView({ behavior: "smooth", block: "start" });
        }, 500);
      }
    }
  });
</script>

</body>
</html>
