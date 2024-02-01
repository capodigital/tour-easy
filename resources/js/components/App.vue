<script>
import AppMenu from "./AppMenu.vue";
import AppNavbar from "./AppNavbar.vue";
import HomePage from "./pages/tours/HomePage.vue";
import TourDetails from "./pages/tours/details/TourDetails.vue";
import NotFound from "./NotFound.vue";
import LoginPage from "./pages/LoginPage.vue";
import axios from 'axios'
import AppSidebar from "./AppSidebar.vue";

export default {
    components: { AppNavbar, AppMenu, HomePage, TourDetails, NotFound, LoginPage, AppSidebar },
    data() {
        const separator = location.hash.lastIndexOf('/')
        const hash = separator > 0 ? location.hash.substring(0, separator) : location.hash
        const active = hash == "" ? "login" : hash.substring(1)
        return {
            pages: ["#home", "#details", "#artists", "#login", "#personal", "#tour", "#artist", "#calendar", "#day", "#agencies", "#places", "#tickets"],
            active: active,
            collapsed: false,
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
            if (this.active != "tour" && this.active != "artist")
                location.href = '#login'
        })

    },
    created() {
        this.init()
    }
};
</script>
<template>
    <template v-if="active == 'tour' || active == 'artist'">
        <transition name="carousel" mode="out-in">
            <component :is="active"> </component>
        </transition>
    </template>
    <template v-else-if="active != 'login'">
        <AppNavbar @collapse="(value) => collapsed = value" />
        <div class="flex">
            <AppSidebar :collapsed="collapsed" />
            <main :class="{ 'md:w-[calc(100vw-3.5rem)]': collapsed, 'md:w-10/12': !collapsed }" class="overflow-auto pb-12 w-full">
                <transition name="carousel" mode="out-in">
                    <component :is="active" :collapsed="collapsed"> </component>
                </transition>
            </main>
        </div>
        <AppMenu />
    </template>
    <template v-else>
        <transition name="carousel" mode="out-in">
            <component :is="active"> </component>
        </transition>
    </template>
</template>
<style scoped>
main {
    height: calc(100vh - 8rem);
    /*background: linear-gradient(138.52deg, rgba(38, 75, 80, 0.568) 0.44%, rgba(41, 36, 72, 0.452) 85.15%);*/
    background-color: white;
}

@media (min-width: 768px) {
    main {
        height: calc(100vh - 4rem);
    }
}
</style>
