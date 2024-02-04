// import './bootstrap';
// if (localStorage.theme != "light" && (localStorage.theme === "dark" || (!("theme" in localStorage) && window.matchMedia("(prefers-color-scheme: dark)").matches))) {
//     document.documentElement.classList.add("dark")
// } else {
//     document.documentElement.classList.remove("dark")
// }
document.documentElement.classList.remove("dark");
import "bootstrap-icons/font/bootstrap-icons.css";
import "viewerjs/dist/viewer.css";
import "../css/landing.css";

import { createApp } from "vue";
import mitt from "mitt";
import Utils from "./Utils";
import LandingPage from "./components/LandingPage.vue";

const app = createApp(LandingPage);
app.config.globalProperties.Utils = Utils;
/** Implementar bus de eventos */
const emitter = mitt();
app.config.globalProperties.emitter = emitter;
app.mount("#app");
