class Sidebar {
    constructor(d) {
        this.button = d.getElementById("sidebarBtn");
        this.bar = d.getElementById("sidebar");

        this.button.addEventListener("click", () => {
            this.toggle();
        });
    }

    toggle() {
        this.bar.classList.toggle("side-bar-toggle");
    }
}

export default Sidebar;
