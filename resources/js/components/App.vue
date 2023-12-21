<script>
import AppMenu from "./AppMenu.vue";
import AppNavbar from "./AppNavbar.vue";
import HomePage from "./pages/tours/HomePage.vue";
import TourDetails from "./pages/tours/details/TourDetails.vue";
import NotFound from "./NotFound.vue";
import LoginPage from "./pages/LoginPage.vue";
import axios from 'axios'

export default {
    components: { AppNavbar, AppMenu, HomePage, TourDetails, NotFound, LoginPage },
    data() {
        const separator = location.hash.lastIndexOf('/')
        const hash = separator > 0 ? location.hash.substring(0, separator) : location.hash
        const active = hash == "" ? "login" : hash.substring(1)
        return {
            pages: ["#home", "#details", "#artists", "#login", "#personal", "#tour", "#calendar", "#day", "#agencies"],
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
                if (page == name) return true
            })
        },
        init() {
            window.addEventListener('hashchange', (e) => {
                const separator = location.hash.lastIndexOf('/')
                const hash = separator > 0 ? location.hash.substring(0, separator) : location.hash
                this.showComponent(hash)
            })
        }
    },
    mounted() {
        const separator = location.hash.lastIndexOf('/')
        const hash = separator > 0 ? location.hash.substring(0, separator) : location.hash

        if (hash != "") {
            const exist = this.pages.find((page) => {
                if (page == hash) return true
            })
            if (!exist) this.active = "NotFound"
        }
        axios.get('api/user', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then(() => {
            // this.init()
        }).catch(() => {
            location.href = '#login'
        })

    },
    created() {
        this.init()
    }
};
</script>
<template>
    <template v-if="active == 'tour'">
        <transition name="bounce" mode="out-in">
            <component :is="active"> </component>
        </transition>
    </template>
    <template v-else-if="active != 'login'">
        <AppNavbar />
        <main class="scroll overflow-auto">
            <transition name="bounce" mode="out-in">
                <component :is="active"> </component>
            </transition>
        </main>
        <AppMenu />
    </template>
    <template v-else>
        <transition name="bounce" mode="out-in">
            <component :is="active"> </component>
        </transition>
    </template>
</template>
<style scoped>
main {
    height: calc(100vh - 8rem);
}
</style>
