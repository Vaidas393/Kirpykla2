<?php
include('config/db.php');

// Fetch only active categories
$categories = mysqli_query($con, "SELECT * FROM categories WHERE status = 'active' ORDER BY name");
?>

<header id="header" class="header d-flex align-items-center">
  <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

    <a href="index.php" class="logo d-flex align-items-center">
      <h1>VIP<span>.</span></h1>
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
