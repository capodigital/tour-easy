<script>
import axios from 'axios';

export default {
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
        }
    }
}
</script>
<template>
    <nav class="w-screen h-16 flex justify-between items-center shadow-lg shadow-gray-300 bg-white">
        <div @click="home" class="px-2 cursor-pointer flex items-center">
            <img src="src/logo.svg" class="h-12 w-12" />
            <div class="hidden sm:block">
                <h1 class="text-gray-50">MAD MUSIC</h1>
                <p class=" text-sm text-gray-400">Tour planner</p>
            </div>
        </div>
        <div class="relative p-2 text-center">
            <h1 v-if="Utils.role() != 'user'" class="text-lg text-slate-700 font-bold">{{ Utils.username() }}</h1>
        </div>
        <div class="flex items-center justify-end px-1">
            <button @click="logout" class="me-2 rounded hover:bg-slate-400 p-2 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-log-out">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                    <polyline points="16 17 21 12 16 7" />
                    <line x1="21" x2="9" y1="12" y2="12" />
                </svg>
            </button>
            <div
                class="relative p-2 group hover:bg-gradient-to-tr hover:from-slate-800 hover:to-slate-950 hover:bg-opacity-90 transition-all flex rounded">
                <div class="w-0 group-hover:w-52 transition-all overflow-hidden px-0 group-hover:px-2">
                    <h5 class="whitespace-nowrap font-bold text-slate-900 leading-5 text-end group-hover:text-white mt-1">
                        {{ Utils.user().name }}
                    </h5>
                    <p class="whitespace-nowrap text-slate-700 leading-4 text-sm text-end group-hover:text-gray-200 ">
                        {{ Utils.user().email }}
                    </p>
                </div>
                <img src="src/user_4.jpg" class="rounded-full h-10 w-10 cursor-pointer me-2" />
                <span
                    class="w-4 h-4 flex items-center justify-center rounded-full bg-red-600 text-white absolute text-center text-xs font-semibold"
                    style="top: .2rem; right: .2rem">4</span>
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
