<footer id="footer" class="footer">

  <div class="footer-content position-relative">
    <div class="container">
      <div class="row">

        <!-- Logotipas ir kontaktinė informacija -->
        <div class="col-lg-4 col-md-6">
          <div class="footer-info">
            <img src="assets/img/logo.png" alt="R.Rilskio Logo" class="img-fluid mb-3">
            <p>
              <strong>El. paštas:</strong> info@rilskis.lt<br>
              <strong>Telefonas:</strong> +37065743558<br>
              <strong>Individualios veiklos Nr.:</strong> 756076<br>
              <strong>PVM K.:</strong> LT100011129916<br>
              <strong>Vadovas:</strong> Ričardas Rilskis<br>
              <strong>Adresas:</strong> Jūros g. 20, Pajūralio km., Kvėdarnos sen., Šilalės rajonas
            </p>
          </div>
        </div><!-- End footer info column-->

        <!-- Naudingos nuorodos -->
        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Naudingos nuorodos</h4>
          <ul>
            <li><a href="index.php">Pagrindinis</a></li>
            <li><a href="apie.php">Apie mus</a></li>
            <li><a href="index.php#services">Paslaugos</a></li>
            <li><a href="index.php#projects">Darbai</a></li>
            <li><a href="index.php#testimonials">Atsiliepimai</a></li>
            <li><a href="kontaktai.php">Kontaktai</a></li>
          </ul>
        </div>
        <!-- End footer links column-->

        <!-- Socialiniai tinklai -->
        <!-- <div class="col-lg-4 col-md-6">
          <div class="social-links d-flex mt-3">
            <a href="#" class="d-flex align-items-center justify-content-center"><i class="bi bi-facebook"></i></a>
            <a href="#" class="d-flex align-items-center justify-content-center"><i class="bi bi-instagram"></i></a>
          </div>
        </div> -->
        <!-- End social links -->

      </div>
    </div>
  </div>

  <!-- Autorinės teisės -->
  <div class="footer-legal text-center position-relative">
    <div class="container">
      <div class="copyright">
        &copy; <strong><span>R.Rilskio Statyba</span></strong>. Visos teisės saugomos.
      </div>
    </div>
  </div>

</footer>
<!-- End Footer -->

<a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i
    class="bi bi-arrow-up-short"></i></a>

<div id="preloader"></div>

<!-- Vendor JS Files -->
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
<!-- <script src="assets/vendor/php-email-form/validate.js"></script> -->

<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    // Check if the URL contains a hash (#) from another page
    if (window.location.hash) {
      let target = document.querySelector(window.location.hash);
      if (target) {
        setTimeout(() => {
          target.scrollIntoView({ behavior: "smooth", block: "start" });
        }, 500); // Delay to ensure the page has loaded
      }
    }
  });
</script>

</body>

</html>
