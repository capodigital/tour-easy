<script>
export default {
    data() {
        return {
            active: 0,
        }
    },
    methods: {
        update() {
            const separator = location.hash.lastIndexOf('/')
            const hash = separator > 0 ? location.hash.substring(0, separator) : location.hash
            switch (hash) {
                case '#home':
                    this.active = 0;
                    break;
                case '#artists':
                    this.active = 2;
                    break;
                case '#personal':
                    this.active = 6;
                    break;
                case '#calendar':
                    this.active = 1;
                    break;
                case '#agencies':
                    this.active = 3;
                    break;
                case '#tickets':
                    this.active = 4;
                    break;
                case '#places':
                    this.active = 5;
                    break;
            }
        }
    },
    created() {
        window.onhashchange = () => {
            this.update()
        }
        this.update()
    }
}
</script>
<template>
    <aside class="hidden md:block w-2/12 h-[calc(100vh-4rem)] shadow-lg shadow-gray-600 bg-white relative">
        <!-- <div @click="home" class="px-2 cursor-pointer flex items-center">
            <img src="src/logo.svg" class="h-12 w-12 me-2" />
            <div>
                <p class="m-0 leading-3 font-semibold">MAD MUSIC</p>
                <small class="m-0 leading-3">Tour Planner</small>
            </div>
        </div> -->
        <div class="ps-3">
            <a class="transition-all py-3 flex items-center hover:bg-gradient-to-r hover:from-transparent hover:via-[#ffffff66] hover:to-transparent" @click="active = 0" href="#home"
                :class="{ 'text-gray-400': active != 0, 'text-white': active == 0 }">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    :stroke="active == 0 ? '#fff' : 'rgb(209, 213, 219)'" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="lucide lucide-home">
                    <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                    <polyline points="9 22 9 12 15 12 15 22" />
                </svg>
                <p class="ms-2 mt-0.5">Inicio</p>
            </a>
            <a class="transition-all py-3 flex items-center hover:bg-gradient-to-r hover:from-transparent hover:via-[#ffffff66] hover:to-transparent" @click="active = 1" href="#calendar"
                :class="{ 'text-gray-400': active != 1, 'text-white': active == 1 }">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    :stroke="active == -2 ? '#fff' : 'rgb(209, 213, 219)'" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="lucide lucide-calendar-check">
                    <rect width="18" height="18" x="3" y="4" rx="2" ry="2" />
                    <line x1="16" x2="16" y1="2" y2="6" />
                    <line x1="8" x2="8" y1="2" y2="6" />
                    <line x1="3" x2="21" y1="10" y2="10" />
                    <path d="m9 16 2 2 4-4" />
                </svg>
                <p class="ms-2 mt-0.5">Calendario</p>
            </a>
            <a class="transition-all py-3 flex items-center hover:bg-gradient-to-r hover:from-transparent hover:via-[#ffffff66] hover:to-transparent" @click="active = 2" href="#artists"
                :class="{ 'text-gray-400': active != 2, 'text-white': active == 2 }">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    :stroke="active == -1 ? '#fff' : 'rgb(209, 213, 219)'" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="lucide lucide-mic">
                    <path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3Z" />
                    <path d="M19 10v2a7 7 0 0 1-14 0v-2" />
                    <line x1="12" x2="12" y1="19" y2="22" />
                </svg>
                <p class="ms-2 mt-0.5">Artistas</p>
            </a>
            <a class="transition-all py-3 flex items-center hover:bg-gradient-to-r hover:from-transparent hover:via-[#ffffff66] hover:to-transparent" @click="active = 3" href="#agencies"
                :class="{ 'text-gray-400': active != 3, 'text-white': active == 3 }">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    :stroke="active == 2 ? '#fff' : 'rgb(209, 213, 219)'" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="lucide lucide-building">
                    <rect width="16" height="20" x="4" y="2" rx="2" ry="2" />
                    <path d="M9 22v-4h6v4" />
                    <path d="M8 6h.01" />
                    <path d="M16 6h.01" />
                    <path d="M12 6h.01" />
                    <path d="M12 10h.01" />
                    <path d="M12 14h.01" />
                    <path d="M16 10h.01" />
                    <path d="M16 14h.01" />
                    <path d="M8 10h.01" />
                    <path d="M8 14h.01" />
                </svg>
                <p class="ms-2 mt-0.5">Agencias</p>
            </a>
            <a class="transition-all py-3 flex items-center hover:bg-gradient-to-r hover:from-transparent hover:via-[#ffffff66] hover:to-transparent" @click="active = 4" href="#tickets"
                :class="{ 'text-gray-400': active != 4, 'text-white': active == 4 }">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    :stroke="active == 1 ? '#fff' : 'rgb(209, 213, 219)'" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-ticket">
                    <path
                        d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z" />
                    <path d="M13 5v2" />
                    <path d="M13 17v2" />
                    <path d="M13 11v2" />
                </svg>
                <p class="ms-2 mt-0.5">Tickets</p>
            </a>
            <a v-if="Utils.role() != 'artist'" class="transition-all py-3 flex items-center hover:bg-gradient-to-r hover:from-transparent hover:via-[#ffffff66] hover:to-transparent" @click="active = 5"
                href="#places" :class="{ 'text-gray-400': active != 5, 'text-white': active == 5 }">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    :stroke="active == -3 ? '#fff' : 'rgb(209, 213, 219)'" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="lucide lucide-land-plot">
                    <path d="m12 8 6-3-6-3v10" />
                    <path d="m8 11.99-5.5 3.14a1 1 0 0 0 0 1.74l8.5 4.86a2 2 0 0 0 2 0l8.5-4.86a1 1 0 0 0 0-1.74L16 12" />
                    <path d="m6.49 12.85 11.02 6.3" />
                    <path d="M17.51 12.85 6.5 19.15" />
                </svg>
                <p class="ms-2 mt-0.5">Lugares</p>
            </a>
            <a v-if="Utils.role() != 'artist'" class="transition-all py-3 flex items-center hover:bg-gradient-to-r hover:from-transparent hover:via-[#ffffff66] hover:to-transparent" @click="active = 6"
                href="#personal" :class="{ 'text-gray-400': active != 6, 'text-white': active == 6 }">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    :stroke="active == 3 ? '#fff' : 'rgb(209, 213, 219)'" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="lucide lucide-users">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
                <p class="ms-2 mt-0.5">Personal</p>
            </a>
        </div>
        <div class="active-box w-10 h-full transition-all"
            :style="{ 'top': 'calc(' + active * 3.15 + 'rem)' }">
        </div>
    </aside>
</template>
<style scoped>
.active-box {
    position: absolute;
    left: -2.45rem;
    top: 0;

}

.active-box::before {
    content: " ";
    background-color: #6580f0;
    width: 3rem;
    height: 3rem;
    border-radius: 100%;
    position: absolute;

}

aside {
    background: linear-gradient(138.52deg, rgb(38, 75, 80) 0.44%, rgb(41, 36, 72) 85.15%);
}
</style>
