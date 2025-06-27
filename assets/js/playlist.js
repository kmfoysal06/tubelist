document.addEventListener("DOMContentLoaded", function() {
    const sidebarItems = document.querySelectorAll(".sidebar-item");
    const mainContent = document.querySelector(".tubelist-main-video");

    sidebarItems.forEach((item, index) => {
        item.addEventListener("click", function() {
            // Remove active class from all items
            sidebarItems.forEach((i) => (i.style.backgroundColor = ""));

            // Add active state to clicked item
            this.style.backgroundColor = "#f0f0f0";

            // Update main content
            const title = this.querySelector("h4").textContent;
            const videoId = this.getAttribute("data-video-id");
            const embeddUrl = `https://www.youtube.com/embed/${videoId}`;
            mainContent.innerHTML = `<iframe width="100%" height="100%" src="${embeddUrl}" frameborder="0" allowfullscreen></iframe>`;
        });

        // Add hover effect
        item.addEventListener("mouseenter", function() {
            if (this.style.backgroundColor !== "#f0f0f0") {
                this.style.backgroundColor = "#f8f8f8";
            }
        });

        item.addEventListener("mouseleave", function() {
            if (this.style.backgroundColor !== "#f0f0f0") {
                this.style.backgroundColor = "";
            }
        });
    });
});
