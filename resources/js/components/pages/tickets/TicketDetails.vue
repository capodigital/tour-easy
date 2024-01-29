<script>
import ActivityIcon from '../../common/ActivityIcon.vue';
import CustomModal from '../../common/CustomModal.vue';

export default {
    components: { CustomModal, ActivityIcon },
    props: {
        ticket: Object,
    },
}
</script>
<template>
    <CustomModal @close="$emit('close')">
        <article @submit.prevent="(e) => $emit('send', e)"
            class="max-w-3xl rounded-2xl shadow-md shadow-gray-800 p-4 overflow-auto transition-all cursor-pointer">
            <h1
                class="font-bold bg-gradient-to-tr from-slate-200 text-center to-slate-500 text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black mb-2">
                DETALLES DEL TICKET
            </h1>
            <div class="overflow-auto modal-content">
                <div class="min-h-[6rem] p-3">
                    <h3 class="font-bold text-lg text-gray-100 leading-5">{{ ticket.name }} {{ ticket.lastname }} - {{
                        ticket.id }}</h3>
                    <p class="text-gray-400 text-sm leading-4 mt-1 pe-10">{{ ticket.email }}</p>
                    <p class="text-xs text-gray-400 mt-2">{{ ticket.notes }}</p>
                    <div class="flex items-center mt-4">
                        <ActivityIcon :activity="ticket.itinerary" :size="20" stroke="#fff" />
                        <div class="ms-2">
                            <p class="text-gray-200">Actividad</p>
                            <p class="text-gray-400 text-sm">{{ ticket.itinerary.name }} ({{ ticket.itinerary.tour.tourname
                            }})</p>
                        </div>
                    </div>
                    <hr class="my-2 border-gray-500" />
                    <div class="flex items-center mt-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-circle-dollar-sign me-2">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8" />
                            <path d="M12 18V6" />
                        </svg>
                        <div>
                            <p class="text-gray-200">Monto total</p>
                            <p class="text-gray-400 text-sm">{{ ticket.chain }} - {{ ticket.amount }}</p>
                        </div>
                    </div>
                    <hr class="my-2 border-gray-500" />
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-wallet me-2">
                            <path d="M21 12V7H5a2 2 0 0 1 0-4h14v4" />
                            <path d="M3 5v14a2 2 0 0 0 2 2h16v-5" />
                            <path d="M18 12a2 2 0 0 0 0 4h4v-4Z" />
                        </svg>
                        <div>
                            <p class="text-gray-200">Billetera electrónica</p>
                            <p class="text-gray-400 text-sm">{{ ticket.wallet }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-center">
                <button type="button" @click="$emit('close')"
                    class="mt-8 me-2 close overlay-button bg-gradient-to-tr from-slate-600 to-slate-700 text-white px-3 py-3 w-full rounded-xl rounded-tr">
                    Cerrar
                </button>
                <button type="button" @click="$emit('edit', ticket)"
                    class="mt-8 overlay-button bg-gradient-to-tr from-app-primary-500 to-app-primary-700 text-white px-3 py-3 w-full rounded-xl rounded-tr">
                    Actualizar
                </button>
            </div>
        </article>
    </CustomModal>
</template>
<style scoped>
article {
    background: linear-gradient(138.52deg, rgb(81, 44, 44) -1.32%, rgb(37, 44, 78) 85.77%);
}
</style>
