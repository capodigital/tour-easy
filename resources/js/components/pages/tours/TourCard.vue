<script>
export default {
    props: {
        tour: Object
    }
}
</script>
<template>
    <div class="bg-white rounded-2xl shadow-md shadow-gray-500 p-3 transition-all hover:scale-105 cursor-pointer">
        <div class="">
            <img class="rounded-full h-10 w-10 float-right shadow-md shadow-gray-400"
                :src="tour.tourcartel.replace('http://localhost/', '')" />
            <div class="min-h-[6rem]">
                <h3 class="font-bold text-lg text-gray-900">{{ tour.artist.name }}</h3>
                <p class="text-gray-500 text-sm leading-4 pe-10">{{ tour.tourname }}</p>
            </div>

            <div class="flex justify-around text-xs mt-2">
                <div class="flex rounded bg-gray-300 p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="#6b7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-calendar-plus">
                        <path d="M21 13V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h8" />
                        <line x1="16" x2="16" y1="2" y2="6" />
                        <line x1="8" x2="8" y1="2" y2="6" />
                        <line x1="3" x2="21" y1="10" y2="10" />
                        <line x1="19" x2="19" y1="16" y2="22" />
                        <line x1="16" x2="22" y1="19" y2="19" />
                    </svg>
                    <p class="ms-1 text-gray-700">{{ tour.startdate }}</p>
                </div>
                <div class="flex rounded bg-gray-300 p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="#6b7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-calendar-check-2">
                        <path d="M21 14V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h8" />
                        <line x1="16" x2="16" y1="2" y2="6" />
                        <line x1="8" x2="8" y1="2" y2="6" />
                        <line x1="3" x2="21" y1="10" y2="10" />
                        <path d="m16 20 2 2 4-4" />
                    </svg>
                    <p class="ms-1 text-gray-700">{{ tour.enddate }}</p>
                </div>
            </div>
        </div>
        <div class="flex mt-4">
            <div class="flex w-full">
                <a :href="'#tour/' + tour.id"
                    :class="{ 'border-gray-400': tour.favorite == undefined, 'border-red-600': tour.favorite }"
                    class="rounded-lg border  w-7 h-7 me-1 flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-qr-code">
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
                <button title="Editar gira" v-if="Utils.role() != 'artist'" @click="$emit('edit', tour)"
                    class="rounded-lg border border-gray-400 w-7 h-7 me-1 flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-clipboard-edit">
                        <rect width="8" height="4" x="8" y="2" rx="1" ry="1" />
                        <path d="M10.42 12.61a2.1 2.1 0 1 1 2.97 2.97L7.95 21 4 22l.99-3.95 5.43-5.44Z" />
                        <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-5.5" />
                        <path d="M4 13.5V6a2 2 0 0 1 2-2h2" />
                    </svg>
                </button>
                <button title="Eliminar gira" v-if="Utils.role() != 'artist'" @click="$emit('destroy', tour)"
                    class="rounded-lg border border-gray-400 w-7 h-7 flex justify-center items-center me-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-trash-2">
                        <path d="M3 6h18" />
                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                        <line x1="10" x2="10" y1="11" y2="17" />
                        <line x1="14" x2="14" y1="11" y2="17" />
                    </svg>
                </button>
                <button title="Completar gira" v-if="Utils.role() != 'artist' && tour.active" @click="$emit('complete', tour)"
                    class="rounded-lg border border-gray-400 w-7 h-7 flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-check-square">
                        <path d="m9 11 3 3L22 4" />
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" />
                    </svg>
                </button>
            </div>
            <div class="flex">
                <a :href="'#details/' + tour.id"
                    class="bg-gradient-to-br overlay-button from-slate-800 to-black text-white px-3 h-7 rounded-lg flex text-sm items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-eye me-1">
                        <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                    Detalles
                </a>
            </div>
    </div>
</div></template>
<style scoped>h3,
p {
    font-family: 'Roboto', sans-serif;
}</style>
