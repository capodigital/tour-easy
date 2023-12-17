<script>
export default {
    data() {
        return {
            collapse: true
        }
    }
}
</script>
<template>
    <article class="bg-gradient-to-tr rounded-lg from-slate-800 via-slate-900 to-slate-950 mb-2">
        <div class="flex items-center w-full">
            <div class="p-2 w-11/12 flex items-center">
                <div class="me-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-hotel">
                        <path d="M18 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2Z" />
                        <path d="m9 16 .348-.24c1.465-1.013 3.84-1.013 5.304 0L15 16" />
                        <path d="M8 7h.01" />
                        <path d="M16 7h.01" />
                        <path d="M12 7h.01" />
                        <path d="M12 11h.01" />
                        <path d="M16 11h.01" />
                        <path d="M8 11h.01" />
                        <path d="M10 22v-6.5m4 0V22" />
                    </svg>
                </div>
                <div>
                    <small class="float-right text-xs text-gray-400">08:50AM</small>
                    <h3 class="text-gray-200 font-semibold">Marlin Square → Sala de conciertos</h3>
                    <p class="text-white text-sm">Fugiat id minim enim veniam cillum quis sunt non eiusmod do.</p>
                </div>
            </div>
            <button @click="collapse = !collapse" :class="{ 'rotate-180': !collapse }"
                class="text-white me-2 w-1/12 transition-transform"><i class="bi bi-chevron-down"></i></button>
        </div>
        <div class="w-full transition-all overflow-hidden px-4" :class="{ 'h-0 p-0': collapse, 'h-auto p-2': !collapse }">
            <p class="text-white flex">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-hotel me-2">
                    <path d="M18 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2Z" />
                    <path d="m9 16 .348-.24c1.465-1.013 3.84-1.013 5.304 0L15 16" />
                    <path d="M8 7h.01" />
                    <path d="M16 7h.01" />
                    <path d="M12 7h.01" />
                    <path d="M12 11h.01" />
                    <path d="M16 11h.01" />
                    <path d="M8 11h.01" />
                    <path d="M10 22v-6.5m4 0V22" />
                </svg>
                Tipo de actividad: Transporte terrestre
            </p>
            <p class="text-white flex mt-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-calendar-clock me-2">
                    <path d="M21 7.5V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h3.5" />
                    <path d="M16 2v4" />
                    <path d="M8 2v4" />
                    <path d="M3 10h5" />
                    <path d="M17.5 17.5 16 16.25V14" />
                    <path d="M22 16a6 6 0 1 1-12 0 6 6 0 0 1 12 0Z" />
                </svg>
                Hora de inicio: 08:30AM
            </p>
            <p class="text-white flex mt-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-calendar-clock me-2">
                    <path d="M21 7.5V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h3.5" />
                    <path d="M16 2v4" />
                    <path d="M8 2v4" />
                    <path d="M3 10h5" />
                    <path d="M17.5 17.5 16 16.25V14" />
                    <path d="M22 16a6 6 0 1 1-12 0 6 6 0 0 1 12 0Z" />
                </svg>
                Hora de fin: 09:30AM
            </p>
        </div>
    </article>
</template>
