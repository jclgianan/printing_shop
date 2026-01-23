// require('./bootstrap');

//custom confirm
import Swal from "sweetalert2";
window.Swal = Swal;

document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("registerModal");
    const signupButton = document.querySelector(".signup-btn");

    if (modal && signupButton) {
        signupButton.addEventListener("click", (event) => {
            event.preventDefault();
            modal.classList.add("active");
        });

        modal.addEventListener("click", (event) => {
            if (
                event.target === modal ||
                event.target.classList.contains("close")
            ) {
                modal.classList.remove("active");
            }
        });
    }
});

// Make sure modal close button works after error messages
document.addEventListener("DOMContentLoaded", function () {
    const closeBtn = document.querySelector("#registerModal .close");
    const modal = document.getElementById("registerModal");

    if (closeBtn && modal) {
        closeBtn.addEventListener("click", function () {
            modal.style.display = "none";
        });
    }
});

document.addEventListener("DOMContentLoaded", () => {
    // Select the table
    const table = document.querySelector(".my-table");

    // Check if the table exists before proceeding
    if (!table) return;

    // Add a click listener to the entire table
    table.addEventListener("click", (event) => {
        // Find the closest table row (tr) ancestor of the clicked element
        const row = event.target.closest("tr");

        // Ensure we clicked within a row and not the header
        if (row && row.parentElement.tagName === "TBODY") {
            // 1. Deselect any previously selected rows in this table
            table.querySelectorAll("tr.is-selected").forEach((selectedRow) => {
                selectedRow.classList.remove("is-selected");
            });

            // 2. Select the clicked row
            row.classList.add("is-selected");

            // OPTIONAL: Do something else here (e.g., store the ID of the selected item)
            // console.log('Selected row ID:', row.dataset.itemId);
        }
    });
});

// DATE
document.addEventListener("DOMContentLoaded", (event) => {
    // 1. Get the current date object
    const today = new Date();

    // 2. Format the date to YYYY-MM-DD string
    // Pad the month and day with a leading zero if they are single digits (e.g., 5 becomes 05)

    // Get year
    const year = today.getFullYear();

    // Get month (0-indexed, so add 1) and pad it
    const month = String(today.getMonth() + 1).padStart(2, "0");

    // Get day and pad it
    const day = String(today.getDate()).padStart(2, "0");

    // Combine them into the required format
    const formattedDate = `${year}-${month}-${day}`;

    // 3. Find the date input element
    const dateInput = document.getElementById("todayDate");

    // 4. Set the value
    if (dateInput) {
        dateInput.value = formattedDate;
    }
});

// FLASH MESSAGE AUTO DISMISS
window.addEventListener("DOMContentLoaded", (event) => {
    const flash = document.getElementById("flash-success");
    if (flash) {
        setTimeout(() => {
            flash.style.transition = "opacity 0.3s ease";
            flash.style.opacity = "0";
            setTimeout(() => flash.remove(), 500); // remove from DOM after fade
        }, 1000); // 3000ms = 3 seconds
    }
});

document.addEventListener("click", function (event) {
    const button = event.target.closest(".confirm-delete");
    if (button) {
        event.preventDefault();

        const form = button.closest("form");

        Swal.fire({
            title: "Are you absolutely sure?",
            text: `This action cannot be undone.`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            cancelButtonText: "No",
            confirmButtonText: "Yes",
            customClass: {
                container: "pop-up-container",
                popup: "pop-up-confirm",
                title: "pop-up-confirm-title",
                htmlContainer: "pop-up-confirm-text",
                confirmButton: "btn-danger",
                cancelButton: "btn-normal",
                icon: "pop-up-icon",
            },
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            } else {
            }
        });
    }
});

//clock

document.addEventListener("DOMContentLoaded", () => {
    const clockElement = document.getElementById("clock");
    const dateElement = document.getElementById("date");

    if (!clockElement) return;

    function updateClock() {
        const now = new Date();

        const phTime = now.toLocaleTimeString("en-US", {
            timeZone: "Asia/Manila",
            hour: "2-digit",
            minute: "2-digit",
            second: "2-digit",
            hour12: true,
        });
        clockElement.textContent = phTime;

        if (dateElement) {
            const options = {
                weekday: "short",
                year: "numeric",
                month: "long",
                day: "numeric",
            };
            dateElement.textContent = now.toLocaleDateString(
                undefined,
                options
            );
        }
    }

    updateClock();
    setInterval(updateClock, 1000);
});

// ====== Sidebar Never Refresh using AJAX ==========

// Submenu toggle functionality with state persistence
document.addEventListener("DOMContentLoaded", () => {
    // Restore submenu states from memory
    const openSubmenus = JSON.parse(
        sessionStorage.getItem("openSubmenus") || "[]"
    );
    openSubmenus.forEach((submenuId) => {
        const submenu = document.getElementById(submenuId);
        if (submenu) {
            submenu.classList.add("open");
        }
    });

    // Auto-open submenu if current route matches any submenu item
    const currentRoute = "{{ request()->route()->getName() }}";
    if (
        currentRoute.startsWith("printing") ||
        currentRoute.startsWith("repair")
    ) {
        document.getElementById("tickets-submenu")?.classList.add("open");
    }
    if (currentRoute === "add-new-user" || currentRoute === "activity.logs") {
        document.getElementById("settings-submenu")?.classList.add("open");
    }

    // Toggle functionality
    document.querySelectorAll(".submenu-toggle").forEach((toggle) => {
        toggle.addEventListener("click", () => {
            const parent = toggle.closest(".has-submenu");
            parent.classList.toggle("open");

            // Save state
            const openMenus = Array.from(
                document.querySelectorAll(".has-submenu.open")
            )
                .map((menu) => menu.id)
                .filter((id) => id);
            sessionStorage.setItem("openSubmenus", JSON.stringify(openMenus));
        });
    });
});
