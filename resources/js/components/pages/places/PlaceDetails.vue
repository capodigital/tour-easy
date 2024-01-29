<script>
import CustomModal from '../../common/CustomModal.vue';
import DocumentsItem from '../../common/DocumentsItem.vue';

export default {
    components: { CustomModal, DocumentsItem },
    props: {
        place: Object,
    },
}
</script>
<template>
    <CustomModal @close="$emit('close')">
        <article @submit.prevent="(e) => $emit('send', e)"
            class="max-w-3xl rounded-2xl shadow-md shadow-gray-800 p-4 overflow-auto transition-all cursor-pointer">
            <h1
                class="font-bold bg-gradient-to-tr from-slate-200 text-center to-slate-500 text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black mb-2">
                DETALLES DEL LUGAR
            </h1>
            <div class="overflow-auto modal-content">
                <div class="relative pb-[300px]">
                    <div class="min-h-[6rem] p-3">
                        <h3 class="font-bold text-lg text-gray-100">{{ place.name }} ({{ place.typeplace.description }})
                        </h3>
                        <p class="text-gray-300 text-sm leading-4 pe-10">{{ place.manager }}</p>
                        <p class="text-xs text-gray-400">{{ place.notes }}</p>
                        <div class="flex items-center mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                                stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-phone me-2">
                                <path
                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                            </svg>
                            <div>
                                <p class="text-gray-200">Teléfonos</p>
                                <p class="text-gray-400 text-sm">{{ place.phone }} (Principal) - {{ place.extra_phone }}
                                    (Secundario)
                                </p>
                            </div>
                        </div>
                        <hr class="my-2 border-gray-500" />
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                                stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-mail me-2">
                                <rect width="20" height="16" x="2" y="4" rx="2" />
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                            </svg>
                            <div>
                                <p class="text-gray-200">Correo electrónico</p>
                                <p class="text-gray-400 text-sm">{{ place.email }}</p>
                            </div>
                        </div>
                        <hr class="my-2 border-gray-500" />
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                                stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-globe me-2">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20" />
                                <path d="M2 12h20" />
                            </svg>
                            <div>
                                <p class="text-gray-200">Ciudad</p>
                                <p class="text-gray-400 text-sm">{{ place.city.name }}</p>
                            </div>
                        </div>
                        <hr class="my-2 border-gray-500" />
                        <div class="flex items-center">
                            <div>
                                <p class="text-gray-200">Dirección</p>
                                <p class="text-gray-400 text-sm hover:underline"><a target="_blank"
                                        :href="place.google_id">{{
                                            place.address }}</a></p>
                            </div>
                        </div>
                        <hr class="my-2 border-gray-500" />
                        <DocumentsItem :documents="place.documents" />
                    </div>
                    <div class="absolute bottom-0 left-0 w-full h-[300px]">
                        <div style="width: 100%">
                            <iframe class="rounded-xl" width="100%" height="300" frameborder="0" scrolling="no"
                                marginheight="0" marginwidth="0"
                                :src="`https://maps.google.com/maps?width=100%25&amp;height=300&amp;hl=es&amp;q=${place.gis}+(Ejemplo)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed`"><a
                                    href="https://www.gps.ie/car-satnav-gps/">Sat Navs</a>
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-center">
                <button type="button" @click="$emit('close')"
                    class="mt-8 me-2 close overlay-button bg-gradient-to-tr from-slate-600 to-slate-700 text-white px-3 py-3 w-full rounded-xl rounded-tr">
                    Cerrar
                </button>
                <button type="button" @click="$emit('edit', place)"
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
