<script>
export default {
    data() {
        return {
            active: 0,
            pages: ["#home", "#artists"],
        }
    },
    methods: {
        update() {
            const hash = location.hash
            if (hash == "#home") {
                this.active = 0;
            } else if (hash == "#artists") {
                this.active = 1;
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
    <footer
        class="flex justify-center w-full h-16 z-30 items-end relative overflow-hidden transition-all rounded-t-2xl bg-white bg-opacity-50">
        <div class="flex pb-3">
            <a class="transition-all px-5" @click="active = -2" href="#calendar"
                :class="{ 'text-gray-500': active != -2, 'text-black': active == -2 }">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    :stroke="active == -2 ? '#000' : '#6b7280'" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="lucide lucide-calendar-check">
                    <rect width="18" height="18" x="3" y="4" rx="2" ry="2" />
                    <line x1="16" x2="16" y1="2" y2="6" />
                    <line x1="8" x2="8" y1="2" y2="6" />
                    <line x1="3" x2="21" y1="10" y2="10" />
                    <path d="m9 16 2 2 4-4" />
                </svg>
            </a>
            <a class="transition-all px-5" @click="active = -1" href="#tours"
                :class="{ 'text-gray-500': active != -1, 'text-black': active == -1 }">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    :stroke="active == -1 ? '#000' : '#6b7280'" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="lucide lucide-mic">
                    <path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3Z" />
                    <path d="M19 10v2a7 7 0 0 1-14 0v-2" />
                    <line x1="12" x2="12" y1="19" y2="22" />
                </svg>
            </a>
            <a class="transition-all px-5" @click="active = 0" href="#home"
                :class="{ 'text-gray-500': active != 0, 'text-black': active == 0 }">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    :stroke="active == 0 ? '#000' : '#6b7280'" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="lucide lucide-home">
                    <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                    <polyline points="9 22 9 12 15 12 15 22" />
                </svg>
            </a>
            <a class="transition-all px-5" @click="active = 1" href="#artists"
                :class="{ 'text-gray-500': active != 1, 'text-black': active == 1 }">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    :stroke="active == 1 ? '#000' : '#6b7280'" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="lucide lucide-users">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
            </a>
            <a class="transition-all px-5" @click="active = 2" href="#share"
                :class="{ 'text-gray-500': active != 2, 'text-black': active == 2 }">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    :stroke="active == 2 ? '#000' : '#6b7280'" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="lucide lucide-qr-code">
                    <rect width="5" height="5" x="3" y="3" rx="1" />
                    <rect width="5" height="5" x="16" y="3" rx="1" />
                    <rect width="5" height="5" x="3" y="16" rx="1" />
                    <path d="M21 16h-3a2 2 0 0 0-2 2v3" />
                    <path d="M21 21v.01" />
                    <path d="M12 7v3a2 2 0 0 1-2 2H7" />
                    <path d="M3 12h.01" />
                    <path d="M12 3h.01" />
                    <path d="M12 16v.01" />
                    <path d="M16 12h1" />
                    <path d="M21 12v.01" />
                    <path d="M12 21v-1" />
                </svg>
            </a>
        </div>
        <div class="active-box h-10 w-full transition-all"
            :style="{ 'left': 'calc(50vw - 1.5rem + ' + active * 4 + 'rem)' }">

        </div>
    </footer>
</template>
<style scoped>
footer {
    box-shadow: 0 0 0.9rem #7b7c81 !important;
}

.active-box {
    position: absolute;
    bottom: -2rem;
    left: calc(50vw);
}

.active-box::before {
    content: " ";
    background-color: black;
    width: 3rem;
    height: 3rem;
    border-radius: 100%;
    position: absolute;

}
</style>
