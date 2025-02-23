<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <!-- Categories -->
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#categories" aria-expanded="false" aria-controls="categories">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Categories
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="categories" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="categoryAdd.php">Add Category</a>
                        <a class="nav-link" href="categoryView.php">View Categories</a>
                    </nav>
                </div>

                <!-- Subcategories -->
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#subcategories" aria-expanded="false" aria-controls="subcategories">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Subcategories
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="subcategories" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="subcategoryadd.php">Add Subcategory</a>
                        <a class="nav-link" href="subcategoryView.php">View Subcategories</a>
                    </nav>
                </div>

                <!-- Posts -->
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#posts" aria-expanded="false" aria-controls="posts">
                    <div class="sb-nav-link-icon"><i class="fas fa-newspaper"></i></div>
                    Posts
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="posts" aria-labelledby="headingThree" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="postAdd.php">Add Post</a>
                        <a class="nav-link" href="postView.php">View Posts</a>
                    </nav>
                </div>
            </div>
        </div>
    </nav>
</div>
