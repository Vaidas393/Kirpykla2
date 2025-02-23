document.addEventListener("DOMContentLoaded", function () {
    const sidebarToggle = document.querySelector("#sidebarToggle");

    if (sidebarToggle) {
        sidebarToggle.addEventListener("click", function (event) {
            event.preventDefault();
            document.body.classList.toggle("sb-sidenav-toggled");
            localStorage.setItem("sb|sidebar-toggle", document.body.classList.contains("sb-sidenav-toggled"));
        });
    }

    // Fetch subcategories dynamically based on selected category
    const categoryDropdown = document.querySelector("#category_id");
    const subcategoryDropdown = document.querySelector("#subcategory_id");

    if (categoryDropdown && subcategoryDropdown) {
        categoryDropdown.addEventListener("change", function () {
            const categoryId = this.value;

            if (categoryId) {
                fetch(`fetchSubcategories.php?category_id=${categoryId}`)
                    .then(response => response.json())
                    .then(data => {
                        subcategoryDropdown.innerHTML = '<option value="">-- Select Subcategory --</option>';
                        data.forEach(subcategory => {
                            subcategoryDropdown.innerHTML += `<option value="${subcategory.id}">${subcategory.name}</option>`;
                        });
                    })
                    .catch(error => console.error("Error fetching subcategories:", error));
            } else {
                subcategoryDropdown.innerHTML = '<option value="">-- Select Subcategory --</option>';
            }
        });
    }
});
