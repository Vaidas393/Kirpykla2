<?php  include('structure/head.php') ?>
<?php  include('structure/header.php') ?>

<main id="main">

  <!-- ======= Breadcrumbs ======= -->
  <div class="breadcrumbs d-flex align-items-center">
    <div class="container position-relative d-flex flex-column align-items-center" data-aos="fade">

      <h2>Apie mus</h2>
      <ol>
        <li><a href="index.php">Pagrindinis</a></li>
        <li>Apie mus</li>
      </ol>

    </div>
  </div><!-- End Breadcrumbs -->

  <!-- ======= About Section ======= -->
  <?php

  // Fetch dynamic About section data
  $aboutQuery = mysqli_query($con, "SELECT * FROM about_section LIMIT 1");
  $aboutData = mysqli_fetch_assoc($aboutQuery);
  $background_image = $aboutData ? $aboutData['background_image'] : ' ';
  $main_title       = $aboutData ? $aboutData['main_title'] : ' ';
  $story_heading    = $aboutData ? $aboutData['story_heading'] : ' ';
  $story_subtitle   = $aboutData ? $aboutData['story_subtitle'] : ' ';
  $description      = $aboutData ? $aboutData['description'] : ' ';
  $additional_paragraph = $aboutData ? $aboutData['additional_paragraph'] : ' ';
  $video_link       = $aboutData ? $aboutData['video_link'] : ' ';

  // Fetch dynamic list items
  $listQuery = mysqli_query($con, "SELECT list_item FROM about_list_items WHERE about_section_id = " . ($aboutData ? $aboutData['id'] : 0));
  $listItems = [];
  while ($row = mysqli_fetch_assoc($listQuery)) {
      $listItems[] = $row['list_item'];
  }
  ?>

  <section id="about" class="about">
    <div class="container" data-aos="fade-up">
      <div class="row position-relative">
        <!-- About image as background -->
        <div class="col-lg-7 about-img" style="background-image: url(<?= 'uploads/'.htmlspecialchars($background_image); ?>);"></div>
        <div class="col-lg-7">
          <h2><?= htmlspecialchars($main_title); ?></h2>
          <div class="our-story">
            <h4><?= htmlspecialchars($story_heading); ?></h4>
            <h3><?= htmlspecialchars($story_subtitle); ?></h3>
            <p><?= htmlspecialchars($description); ?></p>
            <?php if (!empty($listItems)): ?>
            <ul>
              <?php foreach($listItems as $item): ?>
                <li><i class="bi bi-check-circle"></i> <span><?= htmlspecialchars($item); ?></span></li>
              <?php endforeach; ?>
            </ul>
            <?php endif; ?>
            <p><?= htmlspecialchars($additional_paragraph); ?></p>

            <?php if (!empty($video_link)): ?>
              <div class="watch-video d-flex align-items-center position-relative">
                <i class="bi bi-play-circle"></i>
                <?php
                  $embedVideo = $video_link;
                  if (strpos($video_link, 'youtube.com') !== false) {
                      parse_str(parse_url($video_link, PHP_URL_QUERY), $queryVars);
                      if (isset($queryVars['v'])) {
                          $embedVideo = "https://www.youtube.com/embed/" . $queryVars['v'];
                      }
                  } elseif (strpos($video_link, 'drive.google.com') !== false) {
                      if (preg_match('/\/d\/([a-zA-Z0-9_-]+)/', $video_link, $matches)) {
                          $embedVideo = "https://drive.google.com/file/d/" . $matches[1] . "/preview";
                      }
                  }
                ?>
                <a href="<?= htmlspecialchars($embedVideo); ?>" class="glightbox stretched-link">Žiūrėti video</a>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- ======= Our Team Section ======= -->
  <?php
  // Fetch team section settings
  $sectionQuery = mysqli_query($con, "SELECT * FROM team_section LIMIT 1");
  $sectionData = mysqli_fetch_assoc($sectionQuery);
  $sectionTitle = $sectionData ? $sectionData['section_title'] : 'Mūsų Komanda';
  $sectionDescription = $sectionData ? $sectionData['section_description'] : ' ';

  // Fetch team members
  $memberQuery = "SELECT * FROM team_members ORDER BY created_at DESC";
  $memberResult = mysqli_query($con, $memberQuery);
  $teamMembers = mysqli_fetch_all($memberResult, MYSQLI_ASSOC);
  ?>

  <section id="team" class="team">
    <div class="container" data-aos="fade-up">
      <div class="section-header">
        <h2><?= htmlspecialchars($sectionTitle); ?></h2>
        <p><?= htmlspecialchars($sectionDescription); ?></p>
      </div>
      <div class="row gy-5">
        <?php foreach ($teamMembers as $member): ?>
        <div class="col-lg-4 col-md-6 member" data-aos="fade-up" data-aos-delay="100">
          <div class="member-img">
            <?php if (!empty($member['image'])): ?>
              <img src="uploads/<?= htmlspecialchars($member['image']); ?>" class="img-fluid" alt="<?= htmlspecialchars($member['name']); ?>">
            <?php else: ?>
              <img src="assets/img/team/default.jpg" class="img-fluid" alt="<?= htmlspecialchars($member['name']); ?>">
            <?php endif; ?>
            <div class="social">
              <?php if (!empty($member['facebook'])): ?>
                <a href="<?= htmlspecialchars($member['facebook']); ?>" target="_blank"><i class="bi bi-facebook"></i></a>
              <?php endif; ?>
              <?php if (!empty($member['instagram'])): ?>
                <a href="<?= htmlspecialchars($member['instagram']); ?>" target="_blank"><i class="bi bi-instagram"></i></a>
              <?php endif; ?>
            </div>
          </div>
          <div class="member-info text-center">
            <h4><?= htmlspecialchars($member['name']); ?></h4>
            <span><?= htmlspecialchars($member['role']); ?></span>
            <p><?= htmlspecialchars($member['description']); ?></p>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

</main><!-- End #main -->

<?php  include('structure/footer.php') ?>
