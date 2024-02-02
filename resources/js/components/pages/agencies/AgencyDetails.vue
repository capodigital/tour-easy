<script>
import CustomModal from '../../common/CustomModal.vue';
import DocumentsItem from '../../common/DocumentsItem.vue';

export default {
    components: { CustomModal, DocumentsItem },
    props: {
        agency: Object,
    },
}
</script>
<template>
    <CustomModal @close="$emit('close')">
        <article @submit.prevent="(e) => $emit('send', e)"
            class="max-w-3xl rounded-md shadow-md shadow-gray-800 p-4 overflow-auto transition-all cursor-pointer">
            <h1
                class="font-bold bg-gradient-to-tr from-slate-200 text-center to-slate-500 text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black mb-2">
                DETALLES DE LA AGENCIA
            </h1>
            <div class="overflow-auto modal-content">
                <div class="relative h-80 w-full bg-cover bg-center rounded-t-md"
                    :style="{ 'background': `url(${agency.image.replace('http://localhost/', '')})` }">
                </div>
                <div class="float-right px-4">
                    <small class=" text-xs text-gray-400">{{ agency.taxcode }}</small>
                    <div class="flex mt-0.5">
                        <div v-if="Utils.role() != 'artist'" class="flex w-full justify-end">
                            <button title="Editar agencia" @click="$emit('edit', agency)"
                                class="rounded-lg border border-gray-400 w-7 h-7 me-1 flex justify-center items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-clipboard-edit">
                                    <rect width="8" height="4" x="8" y="2" rx="1" ry="1" />
                                    <path d="M10.42 12.61a2.1 2.1 0 1 1 2.97 2.97L7.95 21 4 22l.99-3.95 5.43-5.44Z" />
                                    <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-5.5" />
                                    <path d="M4 13.5V6a2 2 0 0 1 2-2h2" />
                                </svg>
                            </button>
                            <button title="Cambiar contraseña agencia"
                                v-if="Utils.role() == 'agency' && (Utils.manager() == null || Utils.manager() == 'null')"
                                @click="$emit('agency_password', agency.id)"
                                class="rounded-lg border border-gray-400 w-7 h-7 me-1 flex justify-center items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-key-round">
                                    <path d="M2 18v3c0 .6.4 1 1 1h4v-3h3v-3h2l1.4-1.4a6.5 6.5 0 1 0-4-4Z" />
                                    <circle cx="16.5" cy="7.5" r=".5" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="px-4">
                    <h3 class="font-bold text-lg text-gray-200">{{ agency.taxname }}</h3>
                    <p class="text-gray-500 text-sm leading-4 pe-10">{{ agency.tradename }}</p>
                </div>
                <div class="px-2">
                    <div class="grid grid-cols-1 gap-x-2 mt-4">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                                stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-user-round-check me-2">
                                <path d="M2 21a8 8 0 0 1 13.292-6" />
                                <circle cx="10" cy="8" r="5" />
                                <path d="m16 19 2 2 4-4" />
                            </svg>
                            <div>
                                <p class="text-white">Dueño de la agencia</p>
                                <p class="text-gray-400 text-sm">{{ agency.owner }}</p>
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
                                <p class="text-white">Correo electrónico</p>
                                <p class="text-gray-400 text-sm">{{ agency.email }}</p>
                            </div>
                        </div>
                    </div>
                    <hr class="my-2 border-gray-500" />
                    <div class="grid grid-cols-1 gap-x-2">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                                stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-map me-2">
                                <polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21" />
                                <line x1="9" x2="9" y1="3" y2="18" />
                                <line x1="15" x2="15" y1="6" y2="21" />
                            </svg>
                            <div>
                                <p class="text-white">Dirección</p>
                                <p class="text-gray-400 text-sm">{{ agency.address }}</p>
                            </div>
                        </div>
                        <hr class="my-2 border-gray-500" />
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                                stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-phone-call me-2">
                                <path
                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                                <path d="M14.05 2a9 9 0 0 1 8 7.94" />
                                <path d="M14.05 6A5 5 0 0 1 18 10" />
                            </svg>
                            <div>
                                <p class="text-white">Número de teléfono</p>
                                <p class="text-gray-400 text-sm">{{ agency.phone }}</p>
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
                                <p class="text-white">Ciudad</p>
                                <p class="text-gray-400 text-sm">{{ agency.city.name }}</p>
                            </div>
                        </div>
                    </div>
                    <hr class="my-2 border-gray-500" />

                    <div class="flex items-center mt-2">
                        <div>
                            <p class="text-white">Detalles adicionales</p>
                            <p class="text-gray-400 text-sm">{{ agency.notes }}</p>
                        </div>
                    </div>
                </div>
                <hr class="my-2 border-gray-500" />
                <div class="px-2">
                    <DocumentsItem :documents="agency.documents" />
                </div>
            </div>
            <div class="flex justify-center">
                <button type="button" @click="$emit('close')"
                    class="mt-8 me-2 close overlay-button bg-gradient-to-tr from-slate-600 to-slate-700 text-white px-3 py-3 w-full rounded-xl rounded-tr">
                    Cerrar
                </button>
                <button type="button" @click="$emit('edit', agency)"
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
