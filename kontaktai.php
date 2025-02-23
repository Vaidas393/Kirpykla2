<?php include('structure/head.php') ?>
<?php include('structure/header.php') ?>

<main id="main">

  <!-- ======= Puslapio navigacija ======= -->
  <div class="breadcrumbs d-flex align-items-center" style="background-image: url('assets/img/breadcrumbs-bg.jpg');">
    <div class="container position-relative d-flex flex-column align-items-center" data-aos="fade">
      <h2>Kontaktai</h2>
      <ol>
        <li><a href="index.php">Pagrindinis</a></li>
        <li>Kontaktai</li>
      </ol>
    </div>
  </div><!-- End Breadcrumbs -->

  <!-- ======= Kontaktų sekcija ======= -->
  <section id="contact" class="contact">
    <div class="container" data-aos="fade-up" data-aos-delay="100">

      <div class="row gy-4">
        <div class="col-lg-6">
          <div class="info-item d-flex flex-column justify-content-center align-items-center">
            <i class="bi bi-map"></i>
            <h3>Mūsų Adresas</h3>
            <p>VIP Grožio Studija, Jūros g. 20, Pajūralio km., Kvėdarnos sen., Šilalės rajonas</p>
          </div>
        </div><!-- End Info Item -->

        <div class="col-lg-3 col-md-6">
          <div class="info-item d-flex flex-column justify-content-center align-items-center">
            <i class="bi bi-envelope"></i>
            <h3>El. paštas</h3>
            <p>info@vipgroziostudija.lt</p>
          </div>
        </div><!-- End Info Item -->

        <div class="col-lg-3 col-md-6">
          <div class="info-item d-flex flex-column justify-content-center align-items-center">
            <i class="bi bi-telephone"></i>
            <h3>Telefonas</h3>
            <p>+370 657 43 558</p>
          </div>
        </div><!-- End Info Item -->

      </div>

      <div class="row gy-4 mt-1">

        <!-- Google Maps -->
        <div class="col-lg-6">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2285.8548557762157!2d22.079236876378546!3d55.51839309732843!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46e5dbb7d9d95b11%3A0x144f84e66e569b5e!2sJ%C5%ABros%20g.%2020%2C%20Paj%C5%ABralis%2C%2075221%20%C5%A0ilal%C4%97s%20r.%20sav.!5e0!3m2!1sen!2slt!4v1700000000000"
            frameborder="0" style="border:0; width: 100%; height: 384px;" allowfullscreen></iframe>
        </div><!-- End Google Maps -->

        <!-- Kontaktinė forma -->
        <div class="col-lg-6">
          <form action="forms/contact.php" method="post" role="form" class="php-email-form needs-validation" novalidate>
              <div class="row gy-4">
                  <!-- First Name Input -->
                  <div class="col-lg-6 form-group">
                      <input type="text" name="name" class="form-control" id="name" placeholder="Jūsų vardas" required minlength="3">
                      <div class="invalid-feedback">
                          Prašome įvesti savo vardą (bent 3 simboliai).
                      </div>
                  </div>

                  <!-- Email Input -->
                  <div class="col-lg-6 form-group">
                      <input type="email" class="form-control" name="email" id="email" placeholder="Jūsų el. paštas" required pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$">
                      <div class="invalid-feedback">
                          Prašome įvesti galiojantį el. paštą (pavyzdžiui, email@domain.com).
                      </div>
                  </div>
              </div>

              <!-- Subject Input -->
              <div class="form-group">
                  <input type="text" class="form-control" name="subject" id="subject" placeholder="Tema" required minlength="3">
                  <div class="invalid-feedback">
                      Prašome įvesti temą (bent 3 simboliai).
                  </div>
              </div>

              <!-- Message Textarea -->
              <div class="form-group">
                  <textarea class="form-control" name="message" rows="5" placeholder="Jūsų žinutė" required></textarea>
                  <div class="invalid-feedback">
                      Prašome įvesti savo žinutę.
                  </div>
              </div>

              <!-- Success/Error Messages -->
              <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
                  <div class="alert alert-success">Jūsų žinutė buvo sėkmingai išsiųsta!</div>
              <?php elseif (isset($_GET['status']) && $_GET['status'] == 'error'): ?>
                  <div class="alert alert-danger">Įvyko klaida siunčiant jūsų žinutę.</div>
              <?php endif; ?>

              <?php if (isset($_GET['errors'])): ?>
                  <div class="alert alert-danger">
                      <?php echo htmlspecialchars(urldecode($_GET['errors'])); ?>
                  </div>
              <?php endif; ?>

              <div class="text-center">
                  <button type="submit">Siųsti žinutę</button>
              </div>
          </form>
        </div>
        <script>
        (() => {
          'use strict';

          // Fetch all the forms we want to apply custom Bootstrap validation styles to
          const forms = document.querySelectorAll('.needs-validation');

          // Loop over them and prevent submission if there are invalid fields
          Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
              console.log('Form submission attempted'); // Debugging

              // If the form is invalid, prevent submission
              if (!form.checkValidity()) {
                console.log('Form is invalid, preventing submission'); // Debugging
                event.preventDefault(); // Prevent form submission
                event.stopPropagation(); // Stop propagation

                // Show Bootstrap validation feedback (if not shown already)
                form.classList.add('was-validated');
              } else {
                console.log('Form is valid, allowing submission'); // Debugging
              }
            }, false);

            // Live validation for individual inputs (optional)
            form.querySelectorAll("input, textarea").forEach((input) => {
              input.addEventListener('input', function() {
                if (input.checkValidity()) {
                  input.classList.remove('is-invalid');
                  input.classList.add('is-valid');
                } else {
                  input.classList.remove('is-valid');
                  input.classList.add('is-invalid');
                }
              });
            });
          });
        })();
        </script>
      </div>

    </div>
  </section><!-- End Contact Section -->

</main><!-- End #main -->

<?php include('structure/footer.php') ?>
