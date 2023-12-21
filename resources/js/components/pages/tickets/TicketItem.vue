<script>
import ActivityIcon from '../../common/ActivityIcon.vue';

export default {
    props: {
        ticket: Object
    },
    components: { ActivityIcon }
}
</script>
<template>
    <div class="bg-white rounded-2xl shadow-md shadow-gray-500 transition-all hover:scale-105 cursor-pointer">
        <div class="">
            <div class="flex float-right p-3">
                <button @click="$emit('edit', ticket)"
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
                <button @click="$emit('destroy', ticket)"
                    class="rounded-lg border border-gray-400 w-7 h-7 flex justify-center items-center">
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
            </div>

            <div class="min-h-[6rem] p-3">
                <h3 class="font-bold text-lg text-gray-900 leading-5">{{ ticket.name }} {{ ticket.lastname }} - {{ ticket.id }}</h3>
                <p class="text-gray-500 text-sm leading-4 mt-1 pe-10">{{ ticket.email }}</p>
                <p class="text-xs text-gray-500 mt-2">{{ ticket.notes }}</p>
                <div class="flex items-center mt-2">
                    <ActivityIcon :activity="ticket.itinerary" size="20" stroke="#000" />
                    <div class="ms-2">
                        <p class="text-gray-800">Actividad</p>
                        <p class="text-gray-500 text-sm">{{ ticket.itinerary.name }} ({{ ticket.itinerary.tour.tourname }})</p>
                    </div>
                </div>
                <hr class="my-2 border-gray-500" />
                <div class="flex items-center mt-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-circle-dollar-sign me-2">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8" />
                        <path d="M12 18V6" />
                    </svg>
                    <div>
                        <p class="text-gray-800">Monto total</p>
                        <p class="text-gray-500 text-sm">{{ ticket.chain }} - {{ ticket.amount }}</p>
                    </div>
                </div>
                <hr class="my-2 border-gray-500" />
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-wallet me-2">
                        <path d="M21 12V7H5a2 2 0 0 1 0-4h14v4" />
                        <path d="M3 5v14a2 2 0 0 0 2 2h16v-5" />
                        <path d="M18 12a2 2 0 0 0 0 4h4v-4Z" />
                    </svg>
                    <div>
                        <p class="text-gray-800">Billetera electrónica</p>
                        <p class="text-gray-500 text-sm">{{ ticket.wallet }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
