<script>
import AppMenu from "./AppMenu.vue";
import AppNavbar from "./AppNavbar.vue";
import HomePage from "./pages/HomePage.vue";
import TourDetails from "./pages/TourDetails.vue";
export default {
    components: { AppNavbar, AppMenu, HomePage, TourDetails },
};
</script>
<template>
    <AppNavbar />
    <main class="scroll overflow-auto">
        <TourDetails />
    </main>
    <!-- <AppNavbar />
    <main class="scroll overflow-auto">
        <HomePage />
    </main> -->
    <AppMenu />
</template>
<style scoped>
main {
    height: calc(100vh - 8rem);
}
</style>
