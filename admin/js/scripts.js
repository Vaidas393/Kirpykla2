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

$(document).ready(function () {
    // Fetch Bootstrap Icons
    $.ajax({
        url: "https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css",
        success: function (css) {
            let iconSelect = $("#icon-picker");
            let matches = css.match(/\.bi-[a-z0-9-]+/g); // Find all Bootstrap icons

            if (matches) {
                matches.forEach(match => {
                    let iconClass = match.replace(".", ""); // Remove the dot
                    iconSelect.append(`<option value="${iconClass}">${iconClass.replace("bi-", "")}</option>`);
                });

                // Initialize Select2 with Icon Rendering
                iconSelect.select2({
                    templateResult: function (icon) {
                        if (!icon.id) return icon.text; // Return text if no icon selected
                        return $('<span><i class="bi ' + icon.id + '"></i> ' + icon.text + '</span>');
                    },
                    templateSelection: function (icon) {
                        if (!icon.id) return icon.text; // Return text if no icon selected
                        return $('<span><i class="bi ' + icon.id + '"></i> ' + icon.text + '</span>');
                    }
                });
            }
        },
        error: function () {
            console.error("Failed to load Bootstrap icons.");
        }
    });
});
