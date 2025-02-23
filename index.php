<?php  include('structure/head.php') ?>
<?php  include('structure/header.php') ?>

<section id="hero" class="hero">

   <?php $title1 = "Kirpykla"; ?>  <!-- Dynamically setting title for the first carousel item -->

   <div id="hero-carousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">

       <div class="carousel-inner">
           <div class="carousel-item active" style="background-image: url(assets/img/hero-carousel/hero-carousel-1.jpg)">
               <div class="info d-flex align-items-center">
                   <div class="container">
                       <div class="row justify-content-center">
                           <div class="col-lg-6 text-center">
                               <h2 data-aos="fade-down"><?= htmlspecialchars($title1); ?> <span>VIP Grožio Studija</span></h2>
                               <p data-aos="fade-up">Profesionalūs kirpimai, skutimo ir stilizavimo paslaugos.</p>
                               <a data-aos="fade-up" data-aos-delay="200" href="https://app.simplymeet.me/vipstudija?is_widget=1&view=compact" target="blank" class="btn-get-started">Rezervuoti</a>
                           </div>
                       </div>
                   </div>
               </div>
           </div>

           <div class="carousel-item" style="background-image: url(assets/img/hero-carousel/hero-carousel-2.jpg)">
               <div class="info d-flex align-items-center">
                   <div class="container">
                       <div class="row justify-content-center">
                           <div class="col-lg-6 text-center">
                               <h2 data-aos="fade-down">Kirpykla <span>VIP Grožio Studija</span></h2>
                               <p data-aos="fade-up">Madingos šukuosenos ir kruopštus plaukų priežiūros paslaugos.</p>
                               <a data-aos="fade-up" data-aos-delay="200" href="https://app.simplymeet.me/vipstudija?is_widget=1&view=compact" target="blank" class="btn-get-started">Rezervuoti</a>
                           </div>
                       </div>
                   </div>
               </div>
           </div>

           <div class="carousel-item" style="background-image: url(assets/img/hero-carousel/hero-carousel-5.jpg)">
               <div class="info d-flex align-items-center">
                   <div class="container">
                       <div class="row justify-content-center">
                           <div class="col-lg-6 text-center">
                               <h2 data-aos="fade-down">Kirpykla <span>VIP Grožio Studija</span></h2>
                               <p data-aos="fade-up">Visapusiška priežiūra vyrams ir moterims.</p>
                               <a data-aos="fade-up" data-aos-delay="200" href="https://app.simplymeet.me/vipstudija?is_widget=1&view=compact" target="blank" class="btn-get-started">Rezervuoti</a>
                           </div>
                       </div>
                   </div>
               </div>
           </div>

       </div>

       <!-- Carousel Controls -->
       <a class="carousel-control-prev" href="#hero-carousel" role="button" data-bs-slide="prev">
           <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
       </a>

       <a class="carousel-control-next" href="#hero-carousel" role


 <!-- End Hero Section -->



  <!-- ======= Hero Section ======= -->
  <!-- End Hero Section -->

  <main id="main">

    <!-- End Apie mus Section -->

    <!-- ======= Services Section ======= -->
    <section id="services" class="services section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h2>Mūsų Paslaugos</h2>
          <p>Teikiame platų kirpyklos paslaugų spektrą – nuo kirpimų ir skutimo iki plaukų priežiūros ir stiliaus konsultacijų.</p>
        </div>

        <div class="row gy-4">

          <!-- Paslauga 1 -->
          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="service-item position-relative" style="background-image: url('assets/img/services/service-1.jpg'); background-size: cover; background-position: center;">
              <div class="service-content">
                <div class="icon">
                  <i class="fa-solid fa-cut"></i>
                </div>
                <h3>Kirpimai vyrams ir moterims</h3>
                <ul>
                  <li>Kirpimai pagal individualius poreikius</li>
                  <li>Stilingi plaukų kirpimai</li>
                  <li>Plaukų kirpimas su mašinėle</li>
                </ul>
                <a href="kirpimas.php" class="readmore stretched-link">Plačiau <i class="bi bi-arrow-right"></i></a>
              </div>
            </div>
          </div><!-- End Service Item -->

          <!-- Paslauga 2 -->
          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="service-item position-relative" style="background-image: url('assets/img/services/service-2.jpg'); background-size: cover; background-position: center;">
              <div class="service-content">
                <div class="icon">
                  <i class="fa-solid fa-cut"></i>
                </div>
                <h3>Skutimas</h3>
                <ul>
                  <li>Tradicinis skutimas</li>
                  <li>Skutimas karštuoju rankšluosčiu</li>
                  <li>Vyrų skutimas su peiliu</li>
                </ul>
                <a href="kirpimas.php" class="readmore stretched-link">Plačiau <i class="bi bi-arrow-right"></i></a>
              </div>
            </div>
          </div><!-- End Service Item -->

          <!-- Paslauga 3 -->
          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
            <div class="service-item position-relative" style="background-image: url('assets/img/services/service-3.jpg'); background-size: cover; background-position: center;">
              <div class="service-content">
                <div class="icon">
                  <i class="fa-solid fa-spa"></i>
                </div>
                <h3>Plaukų priežiūra</h3>
                <ul>
                  <li>Plaukų drėkinimas ir maitinančios procedūros</li>
                  <li>Plaukų stiprinimo ir regeneracijos paslaugos</li>
                  <li>Plaukų atstatymo procedūros</li>
                </ul>
                <a href="kirpimas.php" class="readmore stretched-link">Plačiau <i class="bi bi-arrow-right"></i></a>
              </div>
            </div>
          </div><!-- End Service Item -->

          <!-- Paslauga 4 -->
          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
            <div class="service-item position-relative" style="background-image: url('assets/img/services/service-4.jpg'); background-size: cover; background-position: center;">
              <div class="service-content">
                <div class="icon">
                  <i class="fa-solid fa-cut"></i>
                </div>
                <h3>Barzdos priežiūra</h3>
                <ul>
                  <li>Barzdos kirpimas ir formavimas</li>
                  <li>Barzdos valymas ir modeliavimas</li>
                  <li>Barzdos stiprinimo ir maitinimo procedūros</li>
                </ul>
                <a href="kirpimas.php" class="readmore stretched-link">Plačiau <i class="bi bi-arrow-right"></i></a>
              </div>
            </div>
          </div><!-- End Service Item -->

          <!-- Paslauga 5 -->
          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
            <div class="service-item position-relative" style="background-image: url('assets/img/services/service-5.jpg'); background-size: cover; background-position: center;">
              <div class="service-content">
                <div class="icon">
                  <i class="fa-solid fa-hand-sparkles"></i>
                </div>
                <h3>Rankų ir nagų priežiūra</h3>
                <ul>
                  <li>Manikiūras ir pedikiūras</li>
                  <li>Rankų ir nagų priežiūros procedūros</li>
                  <li>Nagų lakavimas</li>
                </ul>
                <a href="kirpimas.php" class="readmore stretched-link">Plačiau <i class="bi bi-arrow-right"></i></a>
              </div>
            </div>
          </div><!-- End Service Item -->

          <!-- Paslauga 6 -->
          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
            <div class="service-item position-relative" style="background-image: url('assets/img/services/service-6.jpg'); background-size: cover; background-position: center;">
              <div class="service-content">
                <div class="icon">
                  <i class="fa-solid fa-tint"></i>
                </div>
                <h3>Plaukų dažymas</h3>
                <ul>
                  <li>Plaukų dažymas pagal individualius poreikius</li>
                  <li>Dažymas natūraliais dažais</li>
                  <li>Plaukų šviesinimas ir tonavimas</li>
                </ul>
                <a href="kirpimas.php" class="readmore stretched-link">Plačiau <i class="bi bi-arrow-right"></i></a>
              </div>
            </div>
          </div><!-- End Service Item -->

        </div>

      </div>
    </section><!-- End Services Section -->

    <!-- ======= Alt Services Section ======= -->


    <!-- ======= Our Projects Section ======= -->
    <section id="projects" class="projects">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h2>Mūsų Projektai</h2>
          <p>Atlikti darbai, kuriuos įgyvendinome su aukščiausios kokybės paslaugomis ir profesionalia komanda.</p>
        </div>

        <div class="portfolio-isotope" data-portfolio-filter="*" data-portfolio-layout="masonry" data-portfolio-sort="original-order">

          <ul class="portfolio-flters" data-aos="fade-up" data-aos-delay="100">
            <li data-filter="*" class="filter-active">Visi</li>
            <li data-filter=".filter-latest">Naujausias</li>
            <li data-filter=".filter-haircut">Kirpimai</li>
            <li data-filter=".filter-shaving">Skutimas</li>
            <li data-filter=".filter-beard">Barzdos priežiūra</li>
          </ul><!-- End Projects Filters -->

          <div class="row gy-4 portfolio-container" data-aos="fade-up" data-aos-delay="200">

            <!-- Naujausias projektas 1 -->
            <div class="col-lg-4 col-md-6 portfolio-item filter-latest">
              <div class="portfolio-content h-100">
                <img src="assets/img/projects/latest-1.jpg" class="img-fluid" alt="Naujausias projektas 1">
                <div class="portfolio-info">
                  <h4>Modernus vyrų kirpimas</h4>
                  <p>Stilingas ir energingas kirpimas, atitinkantis šiuolaikines madas.</p>
                  <a href="assets/img/projects/latest-1.jpg" title="Naujausias projektas 1" data-gallery="portfolio-gallery-latest" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                </div>
              </div>
            </div>

            <!-- Naujausias projektas 2 -->
            <div class="col-lg-4 col-md-6 portfolio-item filter-latest">
              <div class="portfolio-content h-100">
                <img src="assets/img/projects/latest-2.jpg" class="img-fluid" alt="Naujausias projektas 2">
                <div class="portfolio-info">
                  <h4>Barzdos formavimas ir kirpimas</h4>
                  <p>Profesionalus barzdos kirpimas ir formavimas pagal individualų stilių.</p>
                  <a href="assets/img/projects/latest-2.jpg" title="Naujausias projektas 2" data-gallery="portfolio-gallery-latest" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                </div>
              </div>
            </div>

            <!-- Naujausias projektas 3 -->
            <div class="col-lg-4 col-md-6 portfolio-item filter-latest">
              <div class="portfolio-content h-100">
                <img src="assets/img/projects/latest-3.jpg" class="img-fluid" alt="Naujausias projektas 3">
                <div class="portfolio-info">
                  <h4>Tradicinis skutimas su peiliu</h4>
                  <p>Rankų darbo skutimas naudojant aukščiausios kokybės priemones ir tradicinį peilį.</p>
                  <a href="assets/img/projects/latest-3.jpg" title="Naujausias projektas 3" data-gallery="portfolio-gallery-latest" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                </div>
              </div>
            </div>

            <!-- Kirpimo projektas 1 -->
            <div class="col-lg-4 col-md-6 portfolio-item filter-haircut">
              <div class="portfolio-content h-100">
                <img src="assets/img/projects/haircut-1.jpg" class="img-fluid" alt="Kirpimo projektas 1">
                <div class="portfolio-info">
                  <h4>Šiuolaikinis plaukų kirpimas</h4>
                  <p>Plaukų kirpimas, atitinkantis modernią stilistiką ir klientų poreikius.</p>
                  <a href="assets/img/projects/haircut-1.jpg" title="Kirpimo projektas 1" data-gallery="portfolio-gallery-haircut" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                </div>
              </div>
            </div><!-- End Project Item -->

            <!-- Kirpimo projektas 2 -->
            <div class="col-lg-4 col-md-6 portfolio-item filter-haircut">
              <div class="portfolio-content h-100">
                <img src="assets/img/projects/haircut-2.jpg" class="img-fluid" alt="Kirpimo projektas 2">
                <div class="portfolio-info">
                  <h4>Vyrų kirpimas su stilizavimu</h4>
                  <p>Kirpimas ir stiliaus formavimas, siekiant išryškinti asmeninį įvaizdį.</p>
                  <a href="assets/img/projects/haircut-2.jpg" title="Kirpimo projektas 2" data-gallery="portfolio-gallery-haircut" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                </div>
              </div>
            </div><!-- End Project Item -->

            <!-- Skutimo projektas 1 -->
            <div class="col-lg-4 col-md-6 portfolio-item filter-shaving">
              <div class="portfolio-content h-100">
                <img src="assets/img/projects/shaving-1.jpg" class="img-fluid" alt="Skutimo projektas 1">
                <div class="portfolio-info">
                  <h4>Karštas skutimas su rankšluosčiu</h4>
                  <p>Tradiciškas skutimas su šiltu rankšluosčiu ir peiliu, siekiant užtikrinti sklandų ir kokybišką rezultatą.</p>
                  <a href="assets/img/projects/shaving-1.jpg" title="Skutimo projektas 1" data-gallery="portfolio-gallery-shaving" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                </div>
              </div>
            </div><!-- End Project Item -->

            <!-- Skutimo projektas 2 -->
            <div class="col-lg-4 col-md-6 portfolio-item filter-shaving">
              <div class="portfolio-content h-100">
                <img src="assets/img/projects/shaving-2.jpg" class="img-fluid" alt="Skutimo projektas 2">
                <div class="portfolio-info">
                  <h4>Švelnus skutimas su aliejumi</h4>
                  <p>Patogus ir švelnus skutimas naudojant natūralius aliejus ir produktus, užtikrinant geriausią odos priežiūrą.</p>
                  <a href="assets/img/projects/shaving-2.jpg" title="Skutimo projektas 2" data-gallery="portfolio-gallery-shaving" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                </div>
              </div>
            </div><!-- End Project Item -->

            <!-- Barzdos priežiūros projektas 1 -->
            <div class="col-lg-4 col-md-6 portfolio-item filter-beard">
              <div class="portfolio-content h-100">
                <img src="assets/img/projects/beard-1.jpg" class="img-fluid" alt="Barzdos priežiūros projektas 1">
                <div class="portfolio-info">
                  <h4>Barzdos formavimas</h4>
                  <p>Profesionalus barzdos formavimas, siekiant pasiekti tobulą ir švarų įvaizdį.</p>
                  <a href="assets/img/projects/beard-1.jpg" title="Barzdos priežiūros projektas 1" data-gallery="portfolio-gallery-beard" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                </div>
              </div>
            </div><!-- End Project Item -->

            <!-- Barzdos priežiūros projektas 2 -->
            <div class="col-lg-4 col-md-6 portfolio-item filter-beard">
              <div class="portfolio-content h-100">
                <img src="assets/img/projects/beard-2.jpg" class="img-fluid" alt="Barzdos priežiūros projektas 2">
                <div class="portfolio-info">
                  <h4>Barzdos priežiūra ir stilizavimas</h4>
                  <p>Barzdos priežiūra ir stilizavimas naudojant natūralius produktus, užtikrinant aukščiausią kokybę.</p>
                  <a href="assets/img/projects/beard-2.jpg" title="Barzdos priežiūros projektas 2" data-gallery="portfolio-gallery-beard" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                </div>
              </div>
            </div><!-- End Project Item -->

          </div><!-- End Projects Container -->

        </div>

      </div>
    </section><!-- End Our Projects Section -->

    <!-- ======= Testimonials Section ======= -->
    <section id="testimonials" class="testimonials section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h2>Atsiliepimai</h2>
          <p>Mūsų klientai vertina aukštą paslaugų kokybę, profesionalumą ir dėmesį detalėms. Štai keletas jų atsiliepimų.</p>
        </div>

        <div class="slides-2 swiper">
          <div class="swiper-wrapper">

            <div class="swiper-slide">
              <div class="testimonial-wrap">
                <div class="testimonial-item">
                  <img src="assets/img/testimonials/testimonials-1.jpg" class="testimonial-img" alt="">
                  <h3>Saulius Gudmanas</h3>
                  <h4>Vyras</h4>
                  <div class="stars">
                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                        class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                  </div>
                  <p>
                    <i class="bi bi-quote quote-icon-left"></i>
                    Puikus kirpimas ir barzdos formavimas! Ačiū, kad išpildėte mano norus ir suteikėte šviežias idėjas.
                    <i class="bi bi-quote quote-icon-right"></i>
                  </p>
                </div>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-wrap">
                <div class="testimonial-item">
                  <img src="assets/img/testimonials/testimonials-2.jpg" class="testimonial-img" alt="">
                  <h3>Sandra Vilson</h3>
                  <h4>Klientė</h4>
                  <div class="stars">
                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                        class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                  </div>
                  <p>
                    <i class="bi bi-quote quote-icon-left"></i>
                    Labai patiko plaukų kirpimas! Profesionalus požiūris ir malonus aptarnavimas. Tikrai sugrįšiu.
                    <i class="bi bi-quote quote-icon-right"></i>
                  </p>
                </div>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-wrap">
                <div class="testimonial-item">
                  <img src="assets/img/testimonials/testimonials-3.jpg" class="testimonial-img" alt="">
                  <h3>Jonas Karlis</h3>
                  <h4>Klientas</h4>
                  <div class="stars">
                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                        class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                  </div>
                  <p>
                    <i class="bi bi-quote quote-icon-left"></i>
                    Nuostabi kirpykla, profesionalus požiūris ir aukščiausios kokybės paslaugos! Ačiū už puikų kirpimą.
                    <i class="bi bi-quote quote-icon-right"></i>
                  </p>
                </div>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-wrap">
                <div class="testimonial-item">
                  <img src="assets/img/testimonials/testimonials-4.jpg" class="testimonial-img" alt="">
                  <h3>Matas Brendonas</h3>
                  <h4>Klientas</h4>
                  <div class="stars">
                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                        class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                  </div>
                  <p>
                    <i class="bi bi-quote quote-icon-left"></i>
                    Puikus aptarnavimas ir stilingi kirpimai! Labai rekomenduoju šią kirpyklą.
                    <i class="bi bi-quote quote-icon-right"></i>
                  </p>
                </div>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-wrap">
                <div class="testimonial-item">
                  <img src="assets/img/testimonials/testimonials-5.jpg" class="testimonial-img" alt="">
                  <h3>Jonas Larseonas</h3>
                  <h4>Klientas</h4>
                  <div class="stars">
                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                        class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                  </div>
                  <p>
                    <i class="bi bi-quote quote-icon-left"></i>
                    Barzdos priežiūra buvo tikrai nuostabi. Jaučiuosi atsinaujinęs ir pasitikintis savimi!
                    <i class="bi bi-quote quote-icon-right"></i>
                  </p>
                </div>
              </div>
            </div><!-- End testimonial item -->

          </div>
          <div class="swiper-pagination"></div>
        </div>

      </div>
    </section><!-- End Testimonials Section -->

    <!-- ======= Pradėkite Dabar Sekcija ======= -->
    <section id="get-started" class="get-started section-bg">
      <div class="container">
        <div class="row justify-content-between gy-4">

          <div class="col-lg-6 d-flex align-items-center" data-aos="fade-up">
            <div class="content">
              <h3>Pradėkite savo grožio kelionę su mumis jau šiandien!</h3>
              <p>Mes esame pasirengę suteikti jums aukščiausios kokybės grožio paslaugas – nuo kirpimo iki odos priežiūros. Dirbame greitai, kokybiškai ir atsakingai, kad pasiektume geriausią rezultatą.</p>
              <p>Nepriklausomai nuo to, ar norite pasikeisti savo įvaizdį, ar tiesiog atsipalaiduoti ir pasilepinti – mūsų profesionalų komanda visada pasiruošusi padėti. Susisiekite su mumis ir gaukite individualų pasiūlymą.</p>
            </div>
          </div>

          <div class="col-lg-5" data-aos="fade">
            <form action="forms/quote.php" method="post" class="php-email-form needs-validation" novalidate>
              <h3>Gaukite pasiūlymą</h3>
              <p>Pateikite užklausą ir mes susisieksime su jumis kuo greičiau.</p>
              <div class="row gy-3">

                <!-- Name Input -->
                <div class="col-md-12">
                  <input type="text" name="name" class="form-control" placeholder="Vardas" required>
                  <div class="invalid-feedback">
                    Prašome įvesti savo vardą.
                  </div>
                </div>

                <!-- Email Input -->
                <div class="col-md-12">
                  <input type="email" class="form-control" name="email" placeholder="El. paštas" required pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$">
                  <div class="invalid-feedback">
                    Prašome įvesti galiojantį el. paštą (pavyzdžiui, email@domain.com).
                  </div>
                </div>

                <!-- Phone Input -->
                <div class="col-md-12">
                  <input type="text" class="form-control" name="phone" placeholder="Telefonas" required>
                  <div class="invalid-feedback">
                    Prašome įvesti telefono numerį.
                  </div>
                </div>

                <!-- Message Textarea -->
                <div class="col-md-12">
                  <textarea class="form-control" name="message" rows="6" placeholder="Jūsų žinutė" required></textarea>
                  <div class="invalid-feedback">
                    Prašome įvesti savo žinutę.
                  </div>
                </div>

                <!-- Success/Error Messages -->
                <div class="col-md-12 text-center">
                  <div class="loading">Siunčiama...</div>
                  <div class="error-message"></div>
                  <div class="sent-message">Jūsų užklausa buvo sėkmingai išsiųsta. Ačiū!</div>

                  <button type="submit">Gauti pasiūlymą</button>
                </div>
                <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
                    <div class="alert alert-success">Jūsų žinutė buvo išsiųsta sėkmingai!</div>
                <?php elseif (isset($_GET['status']) && $_GET['status'] == 'error'): ?>
                    <div class="alert alert-danger">Įvyko klaida siunčiant jūsų žinutę.</div>
                <?php endif; ?>

                <?php if (isset($_GET['errors'])): ?>
                    <div class="alert alert-danger">
                        <?php echo htmlspecialchars(urldecode($_GET['errors'])); ?>
                    </div>
                <?php endif; ?>

              </div>
            </form>
          </div><!-- End Quote Form -->

        </div>

      </div>
    </section>
    <script>
    (() => {
      'use strict';

      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      const forms = document.querySelectorAll('.needs-validation');

      // Loop over them and prevent submission if there are invalid fields
      Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
          // If the form is invalid, prevent submission
          if (!form.checkValidity()) {
            event.preventDefault(); // Prevent form submission
            event.stopPropagation(); // Stop further event propagation

            // Add Bootstrap validation feedback class to show feedback messages
            form.classList.add('was-validated');
          } else {
            // Form is valid
            form.classList.add('was-validated');
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
  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php  include('structure/footer.php') ?>
