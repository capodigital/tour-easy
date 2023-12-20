// import './bootstrap';
// if (localStorage.theme != "light" && (localStorage.theme === "dark" || (!("theme" in localStorage) && window.matchMedia("(prefers-color-scheme: dark)").matches))) {
//     document.documentElement.classList.add("dark")
// } else {
//     document.documentElement.classList.remove("dark")
// }
document.documentElement.classList.remove("dark");
import "bootstrap-icons/font/bootstrap-icons.css";
import "viewerjs/dist/viewer.css";
import "../css/app.css";
import "../scss/app.scss";

import VueViewer from "v-viewer";
import { createApp } from "vue";
import mitt from "mitt";
import Utils from "./Utils";
import App from "./components/App.vue";
import LoginPage from "./components/pages/LoginPage.vue";

import HomePage from "./components/pages/tours/HomePage.vue";
import TourDetails from "./components/pages/tours/details/TourDetails.vue";
import ArtistsPage from "./components/pages/artists/ArtistsPage.vue";
import PersonalPage from "./components/pages/contacts/PersonalPage.vue";
import TourPage from "./components/pages/tours/TourPage.vue";
import CalendarPage from "./components/pages/calendar/CalendarPage.vue";
import DayPage from "./components/pages/day/DayPage.vue";

const app = createApp(App);
app.component("home", HomePage);
app.component("details", TourDetails);
app.component("artists", ArtistsPage);
app.component("login", LoginPage);
app.component("personal", PersonalPage);
app.component("tour", TourPage);
app.component("calendar", CalendarPage);
app.component("day", DayPage);
app.config.globalProperties.Utils = Utils;
app.use(VueViewer);
/** Implementar bus de eventos */
const emitter = mitt();
app.config.globalProperties.emitter = emitter;
app.mount("#app");
