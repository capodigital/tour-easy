<script>
import CustomModal from '../../common/CustomModal.vue';
import DocumentsItem from '../../common/DocumentsItem.vue';

export default {
    components: { CustomModal, DocumentsItem },
    props: {
        artist: Object,
    },
}
</script>
<template>
    <CustomModal @close="$emit('close')">
        <article @submit.prevent="(e) => $emit('send', e)"
            class="max-w-3xl to-slate-950 rounded-lg shadow-md shadow-gray-800 p-4 overflow-auto transition-all cursor-pointer">
            <h1
                class="font-bold bg-gradient-to-tr from-slate-200 text-center to-slate-500 text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black mb-2">
                DETALLES DEL ARTISTA
            </h1>
            <div class="overflow-auto modal-content">
                <div class="relative h-80 w-full bg-cover bg-center rounded-t-md"
                    :style="{ 'background': `url(${artist.image.replace('http://localhost/', '')})` }">
                    <div
                        class="w-full h-24 bg-gradient-to-t from-black to-transparent absolute bottom-0 flex justify-center items-end pb-3">
                        <h2 class="text-center text-white text-xl font-semibold">{{ artist.name }} {{ artist.lastname }}
                        </h2>
                    </div>
                </div>
                <div class="p-2 grid grid-cols-2 gap-2">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-mic me-2">
                            <path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3Z" />
                            <path d="M19 10v2a7 7 0 0 1-14 0v-2" />
                            <line x1="12" x2="12" y1="19" y2="22" />
                        </svg>
                        <div>
                            <p class="text-gray-300  font-semibold">Nombre artístico</p>
                            <p class="text-gray-400 text-sm">{{ artist.stagename }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-mail me-2 w-[20px] h-[20px]">
                            <rect width="20" height="16" x="2" y="4" rx="2" />
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                        </svg>
                        <div>
                            <p class="text-gray-300 font-semibold">Correo electrónico</p>
                            <p class="text-gray-400 text-sm truncate max-w-[10rem]">{{ artist.email }}</p>
                        </div>
                    </div>
                </div>
                <div class="p-2 grid grid-cols-2 gap-2">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-calendar-check me-2">
                            <rect width="18" height="18" x="3" y="4" rx="2" ry="2" />
                            <line x1="16" x2="16" y1="2" y2="6" />
                            <line x1="8" x2="8" y1="2" y2="6" />
                            <line x1="3" x2="21" y1="10" y2="10" />
                            <path d="m9 16 2 2 4-4" />
                        </svg>
                        <div>
                            <p class="text-gray-300  font-semibold">Fecha de nacimiento</p>
                            <p class="text-gray-400 text-sm">{{ artist.birthday }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-building me-2">
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
                        <div>
                            <p class="text-gray-300 font-semibold">Agencia</p>
                            <p class="text-gray-400 text-sm">{{ artist.agency.taxname }}</p>
                        </div>
                    </div>
                </div>
                <p class="text-xs text-gray-400 px-2">{{ artist.notes }}</p>

                <div class="p-2">
                    <p class="text-sm text-white">Redes sociales</p>

                    <div class="mt-3 grid grid-cols-8">
                        <a v-for="socialmedia in artist.socialmedias" :href="socialmedia.url" target="_blank"
                            class="px-3 rounded-md flex justify-center text-whiteitems-center me-1">
                            <img :src="socialmedia.typered.logo.replace('http://localhost/', '')" class="" />
                        </a>
                    </div>
                </div>
                <div class="px-2">
                    <DocumentsItem :documents="artist.documents" />
                </div>
                <hr class="my-2 border-gray-500" />
                <div class="p-2">
                    <p class="text-sm text-white">Géneros</p>
                    <div class="justify-start p-2 whitespace-pre-wrap">
                        <div v-for="tag in artist.tags"
                            class="rounded-md inline-block me-2 border text-whiteitems-center px-2 py-1 text-sm text-white">
                            {{ tag }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-center">
                <button type="button" @click="$emit('close')"
                    class="mt-8 me-2 close overlay-button bg-gradient-to-tr from-slate-600 to-slate-700 text-white px-3 py-3 w-full rounded-xl rounded-tr">
                    Cerrar
                </button>
                <button type="button" @click="$emit('edit', artist)"
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
