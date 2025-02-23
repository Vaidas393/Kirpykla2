<?php
// Fetch site settings
$result = mysqli_query($con, "SELECT * FROM site_settings LIMIT 1");
$site_settings = mysqli_fetch_assoc($result);

// Fetch only active categories
$categories = mysqli_query($con, "SELECT * FROM categories WHERE status = 'active' ORDER BY name");
?>

<header id="header" class="header d-flex align-items-center">
  <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

    <a href="index.php" class="logo d-flex align-items-center">
        <?php if (!empty($site_settings['logo']) && file_exists("uploads/" . $site_settings['logo'])): ?>
            <img src="uploads/<?= htmlspecialchars($site_settings['logo']) ?>" alt="Logo">
        <?php else: ?>
            <h1>
                <?= htmlspecialchars($site_settings['logo_text']) ?>
                <?php if (!empty($site_settings['span_text'])): ?>
                    <span><?= htmlspecialchars($site_settings['span_text']) ?></span>
                <?php endif; ?>
            </h1>
        <?php endif; ?>
    </a>

    <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
    <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>
    <nav id="navbar" class="navbar">
      <ul>
        <li><a href="index.php">Pagrindinis</a></li>
        <li><a href="apie.php">Apie mus</a></li>
        <li><a href="index.php#services">Paslaugos</a></li>
        <li><a href="index.php#projects">Darbai</a></li>
        <li><a href="index.php#testimonials">Atsiliepimai</a></li>
        <li class="dropdown">
          <a href="#"><span>Blogas</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
          <ul>
            <li><a href="blog.php">Visi</a></li> <!-- Link to all blog posts -->
            <?php while ($category = mysqli_fetch_assoc($categories)) { ?>
              <li class="dropdown">
                <a href="blog.php?category=<?= $category['id'] ?>"><span><?= htmlspecialchars($category['name']) ?></span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
                <ul>
                  <?php
                  // Fetch only active subcategories
                  $subcategories = mysqli_query($con, "SELECT * FROM subcategories WHERE category_id = " . $category['id'] . " AND status = 'active' ORDER BY name");
                  while ($subcategory = mysqli_fetch_assoc($subcategories)) { ?>
                    <li><a href="blog.php?subcategory=<?= $subcategory['id'] ?>"><?= htmlspecialchars($subcategory['name']) ?></a></li>
                  <?php } ?>
                </ul>
              </li>
            <?php } ?>
          </ul>
        </li>

        <li><a href="kontaktai.php">Kontaktai</a></li>
      </ul>
    </nav>
  </div>
</header>
