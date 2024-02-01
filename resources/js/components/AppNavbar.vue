<script>
import axios from 'axios';

export default {
    data() {
        return {
            collapsed: false,
            profile: false,
        }
    },
    methods: {
        logout() {
            axios.post('api/logout', {}, {
                headers: {
                    'Authorization': `Bearer ${this.Utils.token()}`
                }
            }).then(() => {
                location.href = "#login"
            })
        },
        home() {
            location.href = '#home'
        },
        collapse() {
            this.collapsed = !this.collapsed
            this.$emit('collapse', this.collapsed)
        }
    }
}
</script>
<template>
    <nav class="w-screen h-16 flex justify-between items-center shadow-lg shadow-gray-300 bg-white">
        <div class="flex px-2">
            <button @click="collapse()" :class="{ 'rotate-180': collapsed }"
                class="z-50 transition-all text-gray-300 me-2 mt-2 hidden sm:block"><i class="bi bi-arrow-bar-left"></i></button>
            <div @click="home" class="px-2 cursor-pointer flex items-center">
                <img src="src/logo.svg" class="h-12 w-12" />
                <div class="hidden sm:block">
                    <h1 class="text-gray-50">MAD MUSIC</h1>
                    <p class=" text-sm text-gray-400">Tour planner</p>
                </div>
            </div>
        </div>
        <div class="relative p-2 text-center">
            <h1 v-if="Utils.role() != 'user'" class="text-lg text-gray-200 font-bold">{{ Utils.username() }}</h1>
        </div>
        <div class="flex items-center justify-end px-1">

            <div class="relative p-2 flex rounded">
                <img @click="profile = !profile" :src="Utils.role() == '' ? Utils.user().image : 'src/user_placeholder.png'"
                    class="rounded-full h-10 w-10 cursor-pointer me-2" />
                <span
                    class="w-4 h-4 flex items-center justify-center rounded-full bg-red-600 text-white absolute text-center text-xs font-semibold"
                    style="top: .2rem; right: .2rem">4</span>
            </div>
            <div :class="{ 'h-0': !profile, 'p-2': profile, 'p-0': !profile, 'h-auto': profile }"
                class="absolute transition-all overflow-hidden top-16 right-2 rounded shadow-lg shadow-gray-900 gradient-1 z-50">
                <p class="text-gray-300 text-sm text-center leading-3 mb-2 mt-1">{{ Utils.role() == 'agency' ? 'Agencia' :
                    'Administrador' }}</p>
                <p class="text-gray-400 text-xs text-center leading-3 mb-2 mt-1">{{ Utils.user().email }}</p>
                <button
                    class="me-2 hover:bg-gradient-to-r hover:from-transparent hover:via-[#ffffff66] hover:to-transparent w-full rounded p-2 transition-all flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-circle-user">
                        <circle cx="12" cy="12" r="10" />
                        <circle cx="12" cy="10" r="3" />
                        <path d="M7 20.662V19a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v1.662" />
                    </svg>
                    <p class="ms-2 text-gray-100 text-sm">Perfil</p>
                </button>
                <button
                    class="me-2 hover:bg-gradient-to-r hover:from-transparent hover:via-[#ffffff66] hover:to-transparent w-full rounded p-2 transition-all flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-settings">
                        <path
                            d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                    <p class="ms-2 text-gray-100 text-sm">Configuración</p>
                </button>
                <button @click="logout"
                    class="me-2 hover:bg-gradient-to-r hover:from-transparent hover:via-[#ffffff66] hover:to-transparent w-full rounded p-2 transition-all flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-log-out">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        <polyline points="16 17 21 12 16 7" />
                        <line x1="21" x2="9" y1="12" y2="12" />
                    </svg>
                    <p class="ms-2 text-gray-100 text-sm">Cerrar sesión</p>
                </button>
            </div>
        </div>
    </nav>
</template>
<style scoped>
h1 {
    font-family: 'Roboto', sans-serif;
}

nav {
    background: linear-gradient(138.52deg, rgb(38, 75, 80) 0.44%, rgb(41, 36, 72) 85.15%);
}
</style>
