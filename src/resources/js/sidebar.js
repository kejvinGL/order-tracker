const sidebarToggle = document.querySelector(".sidebar-toggle");

if (sidebarToggle) {
    const sidebarOverlay = document.querySelector(".sidebar-overlay");
    const sidebarMenu = document.querySelector(".sidebar-menu");
    const main = document.querySelector(".main");
    sidebarToggle.addEventListener("click", function (e) {
        e.preventDefault();
        main.classList.toggle("active");
        sidebarOverlay.classList.toggle("hidden");
        sidebarMenu.classList.toggle("-translate-x-full");
    });
    sidebarOverlay.addEventListener("click", function (e) {
        e.preventDefault();
        main.classList.add("active");
        sidebarOverlay.classList.add("hidden");
        sidebarMenu.classList.add("-translate-x-full");
    });

}
