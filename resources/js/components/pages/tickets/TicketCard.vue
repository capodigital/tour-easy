<script>
import QRious from "qrious"
export default {
    props: {
        ticket: Object
    },
    methods: {
        download() {

        }
    },
    mounted() {
        new QRious({
            element: this.$el.querySelector('#qr'),
            value: window.location.origin + '/tickets/' + this.ticket.id
        });
    }
}
</script>
<template>
    <article
        class="rounded-lg shadow-md shadow-gray-500 p-0.5 transition-all hover:scale-[1.03] cursor-pointer relative pb-12">
        <!-- <div class="">
            <div class="min-h-[3.5rem]">
                <h3 class="font-bold text-gray-200 truncate">{{ ticket.name }} {{ ticket.lastname }} - {{ ticket.id }}</h3>
                <p class="text-gray-300 text-sm leading-4 pe-10">{{ ticket.email }}</p>
            </div>
            <p class="text-xs px-5 text-gray-400 max-h-[3rem] text-ellipsis overflow-hidden">{{ ticket.notes }}</p>
        </div> -->
        <div class="w-full flex bg-white rounded-t-lg">
            <div class="w-12 border-r border-r-black p-1 flex justify-center items-center">
                <div class="relative" style="writing-mode: vertical-lr;">
                    <p class="rotate-180 font-semibold text-center">ADMIT ONE</p>
                </div>
            </div>
            <div class="w-[calc(100%-3rem)] p-2 font-mono">
                <h1 class="text-center font-bold text-gray-800">
                    {{ ticket.itinerary.tour.artist.stagename }}
                </h1>
                <p class="text-center border-t border-b border-gray-800 py-1 truncate">
                    {{ ticket.itinerary.tour.tourname }}, {{ ticket.itinerary.citystart.name }}
                </p>
                <p class="leading-4 mt-2">Nombre: {{ ticket.name }} {{ ticket.lastname }}</p>
                <div class="flex mt-1 items-center">
                    <div class="w-1/2">
                        <p class="leading-4 mt-2">Fecha: {{ ticket.itinerary.startdate }}</p>
                        <canvas class="w-16 h-16 mt-2 mx-auto" id="qr"></canvas>
                    </div>
                    <div class="w-1/2">
                        <p class="leading-4 text-xs text-center max-h-[4rem] overflow-hidden text-ellipsis">{{ ticket.notes }}</p>
                        <p class="leading-4 mt-1 text-center">Hora del show: {{ ticket.itinerary.showtime }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex mt-4 absolute bottom-2 w-[calc(100%-1.5rem)] mx-2">
            <div class="flex w-full">
                <button title="Editar ticket" @click="$emit('edit', ticket)"
                    class="rounded-md border border-gray-400 w-7 h-7 me-1 flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none"
                        stroke="rgb(202, 138, 4)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-clipboard-edit">
                        <rect width="8" height="4" x="8" y="2" rx="1" ry="1" />
                        <path d="M10.42 12.61a2.1 2.1 0 1 1 2.97 2.97L7.95 21 4 22l.99-3.95 5.43-5.44Z" />
                        <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-5.5" />
                        <path d="M4 13.5V6a2 2 0 0 1 2-2h2" />
                    </svg>
                </button>
                <button title="Eliminar ticket" @click="$emit('destroy', ticket)"
                    class="rounded-md border border-gray-400 w-7 h-7 flex justify-center items-center me-1">
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
                <!-- <button title="Editar ticket" @click="download"
                    class="rounded-md border border-gray-400 w-7 h-7 me-1 flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none"
                        stroke="rgb(65, 91, 197)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-download">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                        <polyline points="7 10 12 15 17 10" />
                        <line x1="12" x2="12" y1="15" y2="3" />
                    </svg>
                </button> -->
            </div>
            <div class="flex">
                <button @click="$emit('show', ticket)"
                    class="bg-gradient-to-br overlay-button from-app-primary-500 to-app-primary-800 text-white px-3 h-7 rounded flex text-sm items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-eye me-1">
                        <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                    Detalles
                </button>
            </div>
        </div>
    </article>
</template>
<style scoped>
h1 {
    font-family: 'Archivo Black', sans-serif;
}

article {
    background: rgb(37, 44, 78);
}
</style>
