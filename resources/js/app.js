/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

import Sidebar from "./components/SideBar";
import LogoutButton from "./components/LogoutButton";

window.addEventListener("DOMContentLoaded", () => {
    const sidebar = new Sidebar(document);

    const logoutButton = new LogoutButton(document);
});
