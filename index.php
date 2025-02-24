<?php  include('structure/head.php') ?>
<?php  include('structure/header.php') ?>

  <section id="hero" class="hero">

   <?php
   $slides = mysqli_query($con, "SELECT * FROM hero_carousel ORDER BY id DESC");
   if (!$slides) {
       die("Query Failed: " . mysqli_error($con)); // Check if the query runs properly
   }

   ?>
   <div id="hero-carousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
     <?php foreach ($slides as $index => $item): ?>

     <div class="carousel-item <?php echo ($index === 0) ? 'active' : ''; ?>" style="background-image: url(<?= 'uploads/'. htmlspecialchars($item['image']) ?>);">
       <div class="info d-flex align-items-center">
         <div class="container">
           <div class="row justify-content-center">
             <div class="col-lg-6 text-center">
               <h2 data-aos="fade-down"><?= htmlspecialchars($item['title']) ?>  <span><?= htmlspecialchars($item['span_text']) ?></span></h2>
               <p data-aos="fade-up"><?= htmlspecialchars($item['description']) ?></p>
               <a data-aos="fade-up" data-aos-delay="200" href="<?= htmlspecialchars($item['button_link']) ?>" target="blank" class="btn-get-started"><?= htmlspecialchars($item['button_text']) ?></a>
             </div>
           </div>
         </div>
       </div>
     </div>
   <?php endforeach; ?>


     <a class="carousel-control-prev" href="#hero-carousel" role="button" data-bs-slide="prev">
       <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
     </a>

     <a class="carousel-control-next" href="#hero-carousel" role="button" data-bs-slide="next">
       <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
     </a>

   </div>

 </section>
 <!-- End Hero Section -->

  <!-- ======= Hero Section ======= -->
  <!-- End Hero Section -->

  <main id="main">

    <!-- End Apie mus Section -->
    <?php

    // Fetch the service section description (only one row needed)
    $section_query = "SELECT section_description, section_title FROM services WHERE section_description != '' LIMIT 1";
    $section_result = mysqli_query($con, $section_query);
    $section_data = mysqli_fetch_assoc($section_result);
    $section_description = $section_data['section_description'] ?? "Mūsų Paslaugos";
    $section_title = $section_data['section_title'] ?? "Paslaugos";

    // Fetch all services
    $query = "SELECT * FROM services ORDER BY id DESC";
    $services_result = mysqli_query($con, $query);
    $services = mysqli_fetch_all($services_result, MYSQLI_ASSOC);
    ?>

    <!-- ======= Services Section ======= -->
    <section id="services" class="services section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h2><?= htmlspecialchars($section_title) ?></h2>
          <p><?= htmlspecialchars($section_description) ?></p>
        </div>

        <div class="row gy-4">

          <?php foreach ($services as $service): ?>
          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="service-item position-relative" style="background-size: cover; background-position: center; background:">
              <div class="service-content">
                <div class="icon">
                  <i class="fa-solid <?= htmlspecialchars($service['icon']) ?>"></i>
                </div>
                <h3><?= htmlspecialchars($service['name']) ?></h3>
                <ul>
                    <?php
                    $lines = explode("\n", $service['description']);
                    foreach ($lines as $line): ?>
                        <li><?= htmlspecialchars($line) ?></li>
                    <?php endforeach; ?>
                </ul>
                <!-- <a href="kirpimas.php" class="readmore stretched-link">Plačiau <i class="bi bi-arrow-right"></i></a> -->
              </div>
            </div>
          </div><!-- End Service Item -->
        <?php endforeach; ?>


        </div>

      </div>
    </section><!-- End Services Section -->

    <!-- ======= Alt Services Section ======= -->


    <!-- ======= Our Projects Section ======= -->
    <?php
    $sectionQuery = mysqli_query($con, "SELECT section_title, section_description FROM project_section LIMIT 1");
    $sectionData = mysqli_fetch_assoc($sectionQuery);
    $sectionTitle = $sectionData ? $sectionData['section_title'] : "Projektai";
    $sectionDescription = $sectionData ? $sectionData['section_description'] : "Naujausi projektai";

    // Fetch dynamic categories and convert to an array
    $cat_query  = "SELECT * FROM project_categories ORDER BY name";
    $cat_result = mysqli_query($con, $cat_query);
    $categories = mysqli_fetch_all($cat_result, MYSQLI_ASSOC);

    // Fetch projects with their category name
    $query       = "SELECT p.*, pc.name as category_name
                    FROM projects p
                    LEFT JOIN project_categories pc ON p.category_id = pc.id
                    ORDER BY p.created_at DESC";
    $proj_result = mysqli_query($con, $query);
    $projects    = mysqli_fetch_all($proj_result, MYSQLI_ASSOC);

    /*
    Helper function to create a slug from a category name.
    For example: "Remodeling" becomes "remodeling", "Design Services" becomes "design-services".
    */
    function slugify($text) {
        $text = strtolower($text);
        $text = preg_replace('/\s+/', '-', $text); // Replace spaces with hyphens
        $text = preg_replace('/[^a-z0-9\-]/', '', $text); // Remove non-alphanumeric/hyphen characters
        return $text;
    }
    ?>

    <!-- CSS: Set fixed height of 350px for both images and videos -->

    <section id="projects" class="projects">
      <div class="container" data-aos="fade-up">
        <div class="section-header">
          <h2><?= htmlspecialchars($sectionTitle); ?></h2>
          <p><?= htmlspecialchars($sectionDescription); ?></p>
        </div>
        <div class="portfolio-isotope" data-portfolio-filter="*" data-portfolio-layout="masonry" data-portfolio-sort="original-order">

          <!-- Category Filters -->
          <ul class="portfolio-flters" data-aos="fade-up" data-aos-delay="100">
            <li data-filter="*" class="filter-active">Visi</li>
            <?php foreach ($categories as $cat): ?>
                <?php $slug = slugify($cat['name']); ?>
                <li data-filter=".filter-<?php echo $slug; ?>"><?php echo htmlspecialchars($cat['name']); ?></li>
            <?php endforeach; ?>
          </ul><!-- End Projects Filters -->

          <!-- Projects Container -->
          <div class="row gy-4 portfolio-container" data-aos="fade-up" data-aos-delay="200">
            <?php foreach ($projects as $project): ?>
                <?php
                    // Determine category slug; if none, use "uncategorized"
                    $slug = !empty($project['category_name']) ? slugify($project['category_name']) : 'uncategorized';

                    // Default to image display
                    $displayType = 'image';
                    $imgSrc = "";
                    $videoEmbed = "";

                    if (!empty($project['thumbnail'])) {
                        $imgSrc = "uploads/" . $project['thumbnail'];
                    } elseif (!empty($project['full_image'])) {
                        $imgSrc = "uploads/" . $project['full_image'];
                    } else {
                        // No images provided; check for a video link.
                        $link_query = "SELECT * FROM project_links WHERE project_id = " . $project['id'] . " LIMIT 1";
                        $link_result = mysqli_query($con, $link_query);
                        $link = mysqli_fetch_assoc($link_result);
                        if ($link) {
                            if ($link['link_type'] == 'youtube') {
                                // Extract video id from YouTube URL
                                parse_str(parse_url($link['link'], PHP_URL_QUERY), $queryVars);
                                if (isset($queryVars['v'])) {
                                    $videoId = $queryVars['v'];
                                } else {
                                    // For shortened youtu.be links
                                    $path = parse_url($link['link'], PHP_URL_PATH);
                                    $videoId = trim($path, '/');
                                }
                                $videoEmbed = "https://www.youtube.com/embed/" . $videoId . "?autoplay=0";
                            } elseif ($link['link_type'] == 'google_drive') {
                                // Extract file id from Google Drive URL using regex
                                if (preg_match('/\/d\/([a-zA-Z0-9_-]+)/', $link['link'], $matches)) {
                                    $driveId = $matches[1];
                                    $videoEmbed = "https://drive.google.com/file/d/" . $driveId . "/preview";
                                }
                            }
                            if (!empty($videoEmbed)) {
                                $displayType = 'video';
                            } else {
                                $imgSrc = "assets/img/default-project.jpg";
                            }
                        } else {
                            $imgSrc = "assets/img/default-project.jpg";
                        }
                    }
                ?>
                <div class="col-lg-4 col-md-6 portfolio-item filter-<?php echo $slug; ?>">
                  <div class="portfolio-content h-100">
                    <?php if ($displayType == 'image'): ?>
                        <div class="portfolio-media">
                          <img src="<?php echo $imgSrc; ?>" class="img-fluid" alt="<?php echo htmlspecialchars($project['title']); ?>">
                          <!-- Info overlay remains over images -->
                          <div class="portfolio-info">
                            <h4><?php echo htmlspecialchars($project['title']); ?></h4>
                            <p><?php echo htmlspecialchars($project['description']); ?></p>
                            <?php if (!empty($project['full_image'])): ?>
                              <a href="uploads/<?php echo $project['full_image']; ?>" title="<?php echo htmlspecialchars($project['title']); ?>" data-gallery="portfolio-gallery-<?php echo $slug; ?>" class="glightbox preview-link">
                                <i class="bi bi-zoom-in"></i>
                              </a>
                            <?php endif; ?>
                          </div>
                        </div>
                    <?php else: ?>
                        <!-- For videos, display only the video container without an overlay -->
                        <div class="portfolio-video">
                          <iframe src="<?php echo $videoEmbed; ?>" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    <?php endif; ?>
                  </div>
                </div><!-- End Projects Item -->
            <?php endforeach; ?>
          </div><!-- End Projects Container -->

        </div>
      </div>
    </section><!-- End Our Projects Section -->




    <!-- ======= Testimonials Section ======= -->
    <?php
    $test_query = "SELECT * FROM testimonials ORDER BY created_at DESC";
    $test_result = mysqli_query($con, $test_query);
    $testimonials = mysqli_fetch_all($test_result, MYSQLI_ASSOC);
    ?>

    <section id="testimonials" class="testimonials section-bg">
      <div class="container" data-aos="fade-up">
        <?php
          // Optional: If you want to manage the section title/description dynamically,
          // you can store those in a dedicated table as shown for projects.
          // For now, we'll use static values or defaults.
          $sectionQuery = mysqli_query($con, "SELECT section_title, section_description FROM testimonial_section LIMIT 1");
          $sectionData = mysqli_fetch_assoc($sectionQuery);
          $sectionTitle = $sectionData ? $sectionData['section_title'] : "Atsiliepimai";
          $sectionDescription = $sectionData ? $sectionData['section_description'] : "Mūsų klientai vertina aukštą paslaugų kokybę, profesionalumą ir dėmesį detalėms. Štai keletas jų atsiliepimų.";
        ?>
        <div class="section-header">
          <h2><?= htmlspecialchars($sectionTitle); ?></h2>
          <p><?= htmlspecialchars($sectionDescription); ?></p>
        </div>

        <div class="slides-2 swiper">
          <div class="swiper-wrapper">
            <?php foreach ($testimonials as $testimonial): ?>
              <div class="swiper-slide">
                <div class="testimonial-wrap">
                  <div class="testimonial-item">
                    <img src="uploads/<?= htmlspecialchars($testimonial['image']); ?>" class="testimonial-img" alt="<?= htmlspecialchars($testimonial['name']); ?>">
                    <h3><?= htmlspecialchars($testimonial['name']); ?></h3>
                    <h4><?= htmlspecialchars($testimonial['designation']); ?></h4>
                    <div class="stars">
                      <?php for($i=0; $i < $testimonial['rating']; $i++): ?>
                        <i class="bi bi-star-fill"></i>
                      <?php endfor; ?>
                    </div>
                    <p>
                      <i class="bi bi-quote quote-icon-left"></i>
                      <?= htmlspecialchars($testimonial['content']); ?>
                      <i class="bi bi-quote quote-icon-right"></i>
                    </p>
                  </div>
                </div>
              </div><!-- End testimonial item -->
            <?php endforeach; ?>
          </div>
          <div class="swiper-pagination"></div>
        </div>
      </div>
    </section><!-- End Testimonials Section -->

    <!-- ======= Pradėkite Dabar Sekcija ======= -->
  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php  include('structure/footer.php') ?>
