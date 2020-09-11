require("./bootstrap");
require("../../node_modules/@fortawesome/fontawesome-free/js/all");
require("../../node_modules/echarts/dist/echarts.min");
require("../../node_modules/@chartisan/echarts/dist/chartisan_echarts");

(function($) {
    "use strict";

    var path = window.location.href;
    $("#layoutSidenav_nav .sb-sidenav a.nav-link").each(function() {
        if (this.href === path) {
            $(this).addClass("active");
        }
    });

    $("#sidebarToggle").on("click", function(e) {
        e.preventDefault();
        $("body").toggleClass("sb-sidenav-toggled");
    });
})(jQuery);

import LogoutButton from "./components/LogoutButton";

const logoutButton = new LogoutButton(document);

const r = Math.random() * 127,
    g = Math.random() * 127 + 128,
    b = Math.random() * 127 + 128,
    chart = new Chartisan({
        el: "#chart",
        url: document.getElementById("chart").dataset.url,
        hooks: new ChartisanHooks()
            .colors([
                `rgb(${r}, ${g}, ${b})`,
                `rgb(${255 - r}, ${255 - g}, ${255 - b})`
            ])
            .title("Number of users")
            .tooltip()
            .datasets(["bar", "line"])
    });
