<script>
import AppMenu from "./AppMenu.vue";
import AppNavbar from "./AppNavbar.vue";
import HomePage from "./pages/HomePage.vue";
import TourDetails from "./pages/TourDetails.vue";
import NotFound from "./NotFound.vue";

export default {
    components: { AppNavbar, AppMenu, HomePage, TourDetails, NotFound },
    data() {
        const hash = window.location.hash
        const active = hash == "" ? "home" : hash.substring(1)
        return {
            pages: ["#home", "#details"],
            active: active,
        }
    },
    methods: {
        /**
         * Mostrar el componente seleccionado si existe o mostrar información en pantalla si el componente no existe
         * @param {String} componentLink: Link del componente a mostrar
         */
        showComponent(componentLink) {
            if (componentLink == "") {
                this.active = "home"
            } else {
                if (this.isComponentExist(componentLink)) {
                    this.active = componentLink.substring(1)
                } else {
                    this.active = "NotFound"
                }
            }
        },
        /**
         * Retorna true si el componente existe o false si no existe
         * @param {String} name: Nombre del componente
         * @return {Boolean}: <code>true</code> si el componente existe o <code>false</code> si no existe
         */
        isComponentExist(name) {
            return this.pages.find((page) => {
                console.log(page);
                if (page == name) return true
            })
        },
    },
    mounted() {
        const hash = window.location.hash
        window.onhashchange = () => {
            this.showComponent(window.location.hash)
        }
        if (hash != "") {
            const exist = this.pages.find((page) => {
                if (page == hash) return true
            })
            if (!exist) this.active = "NotFound"
        }

    },
};
</script>
<template>
    <AppNavbar />
    <main class="scroll overflow-auto">
        <transition name="bounce" mode="out-in">
            <!-- <keep-alive> -->
            <component :is="active"> </component>
            <!-- </keep-alive> -->
        </transition>
        <!-- <TourDetails /> -->
        <!-- <HomePage /> -->
    </main>
    <AppMenu />
</template>
<style scoped>
main {
    height: calc(100vh - 8rem);
}
</style>
