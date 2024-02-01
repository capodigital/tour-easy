<script>
export default {
    props: {
        tour: Object
    }
}
</script>
<template>
    <article
        class="bg-white rounded-lg shadow-md shadow-gray-500 p-3 transition-all hover:scale-[1.03] cursor-pointer relative pb-12">
        <div class="">
            <img class="rounded-full h-10 w-10 float-right shadow-md shadow-gray-400"
                :src="tour.tourcartel.replace('http://localhost/', '')" />
            <div class="min-h-[3.5rem]">
                <h3 class="font-bold text-lg text-gray-900">{{ tour.artist.name }}</h3>
                <p class="text-gray-800 text-sm leading-4 pe-10">{{ tour.tourname }}</p>
            </div>
            <p class="text-xs text-gray-700">{{ tour.notes }}</p>
            <div class="flex justify-around text-xs mt-2">
                <div class="flex rounded bg-app-primary-600 py-1 px-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none"
                        stroke="rgb(204, 212, 249)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-calendar-plus">
                        <path d="M21 13V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h8" />
                        <line x1="16" x2="16" y1="2" y2="6" />
                        <line x1="8" x2="8" y1="2" y2="6" />
                        <line x1="3" x2="21" y1="10" y2="10" />
                        <line x1="19" x2="19" y1="16" y2="22" />
                        <line x1="16" x2="22" y1="19" y2="19" />
                    </svg>
                    <p class="ms-1 text-app-primary-100">Desde: {{ tour.startdate }}</p>
                </div>
                <div class="flex rounded bg-app-primary-600 py-1 px-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none"
                        stroke="rgb(204, 212, 249)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-calendar-check-2">
                        <path d="M21 14V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h8" />
                        <line x1="16" x2="16" y1="2" y2="6" />
                        <line x1="8" x2="8" y1="2" y2="6" />
                        <line x1="3" x2="21" y1="10" y2="10" />
                        <path d="m16 20 2 2 4-4" />
                    </svg>
                    <p class="ms-1 text-app-primary-100">Hasta: {{ tour.enddate }}</p>
                </div>
            </div>
        </div>
        <div class="flex mt-4 absolute bottom-2 w-[calc(100%-1.5rem)]">
            <div class="flex w-full">
                <a :href="'#tour/' + tour.id"
                    class="rounded-md border border-gray-700 w-7 h-7 me-1 flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none"
                        stroke="rgb(65, 91, 197)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
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
                    class="rounded-md border border-gray-700 w-7 h-7 me-1 flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none"
                        stroke="rgb(202, 138, 4)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-clipboard-edit">
                        <rect width="8" height="4" x="8" y="2" rx="1" ry="1" />
                        <path d="M10.42 12.61a2.1 2.1 0 1 1 2.97 2.97L7.95 21 4 22l.99-3.95 5.43-5.44Z" />
                        <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-5.5" />
                        <path d="M4 13.5V6a2 2 0 0 1 2-2h2" />
                    </svg>
                </button>
                <button title="Eliminar gira" v-if="Utils.role() != 'artist' && tour.itineraries_count == 0"
                    @click="$emit('destroy', tour)"
                    class="rounded-md border border-gray-700 w-7 h-7 flex justify-center items-center me-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none"
                        stroke="rgb(220, 38, 38)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-trash-2">
                        <path d="M3 6h18" />
                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                        <line x1="10" x2="10" y1="11" y2="17" />
                        <line x1="14" x2="14" y1="11" y2="17" />
                    </svg>
                </button>
                <button title="Completar gira" v-if="Utils.role() != 'artist' && tour.active"
                    @click="$emit('complete', tour)"
                    class="rounded-md border border-gray-700 w-7 h-7 flex justify-center items-center me-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none"
                        stroke="rgb(22, 163, 74)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-check-square">
                        <path d="m9 11 3 3L22 4" />
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" />
                    </svg>
                </button>
                <button title="Imprimir detalles de la gira" @click="$emit('show', tour)"
                    class="rounded-md border border-gray-700 w-7 h-7 flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none"
                        stroke="rgb(65, 91, 197)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-printer">
                        <polyline points="6 9 6 2 18 2 18 9" />
                        <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2" />
                        <rect width="12" height="8" x="6" y="14" />
                    </svg>
                </button>
            </div>
            <div class="flex">
                <a :href="'#details/' + tour.id"
                    class="bg-gradient-to-br overlay-button from-app-primary-500 to-app-primary-800 text-white px-3 h-7 rounded flex text-sm items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none"
                        stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-eye me-1">
                        <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                    Detalles
                </a>
            </div>
        </div>
    </article>
</template>
<style scoped>
h3,
p {
    font-family: 'Roboto', sans-serif;
}

article {
    background: linear-gradient(138.52deg, rgba(38, 75, 80, 0.568) 0.44%, rgba(41, 36, 72, 0.452) 85.15%);
}
</style>
