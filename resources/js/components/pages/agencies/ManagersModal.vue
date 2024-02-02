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
                MANAGERS DE LA AGENCIA
            </h1>
            <div class="overflow-auto modal-content">
                <div class="px-2">
                    <!-- <button v-if="Utils.role() == 'agency' && (Utils.manager() == null || Utils.manager() == 'null')"
                        type="button" @click="$emit('manageradd')"
                        class="float-right text-sm text-black rounded px-1 py-0.5 bg-gray-200">Añadir</button> -->
                    <label class="text-sm text-white font-semibold">Managers</label>
                    <div class="flex" v-for="user in agency.users">
                        <i class="person-fill-gear text-2xl text-white"></i>
                        <div class="w-9/12">
                            <p class="text-white">{{ user.name }}</p>
                            <p class="text-gray-300 text-sm">{{ user.email }}</p>
                        </div>
                        <div class="w-3/12 flex justify-end items-center">
                            <button v-if="Utils.role() == 'agency' || (Utils.manager() == user.id)"
                                @click="$emit('manageredit', user)"
                                class="rounded-md border border-gray-400 w-10 h-7 me-1 flex justify-center items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24"
                                    fill="none" stroke="rgb(202, 138, 4)" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-clipboard-edit">
                                    <rect width="8" height="4" x="8" y="2" rx="1" ry="1" />
                                    <path d="M10.42 12.61a2.1 2.1 0 1 1 2.97 2.97L7.95 21 4 22l.99-3.95 5.43-5.44Z" />
                                    <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-5.5" />
                                    <path d="M4 13.5V6a2 2 0 0 1 2-2h2" />
                                </svg>
                            </button>
                            <button
                                v-if="Utils.role() == 'agency' && (Utils.manager() == null || Utils.manager() == 'null')"
                                @click="$emit('managerdestroy', user)"
                                class="rounded-md border border-gray-400 w-10 h-7 me-1 flex justify-center items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24"
                                    fill="none" stroke="rgb(220, 38, 38)" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-trash-2">
                                    <path d="M3 6h18" />
                                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                    <line x1="10" x2="10" y1="11" y2="17" />
                                    <line x1="14" x2="14" y1="11" y2="17" />
                                </svg>
                            </button>
                            <button v-if="Utils.role() == 'agency' || (Utils.manager() == user.id)"
                                title="Cambiar contraseña del manager" @click="$emit('user_password', user.id)"
                                class="rounded-md border border-gray-400 w-10 h-7 me-1 flex justify-center items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24"
                                    fill="none" stroke="#415bc5" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-key-round">
                                    <path d="M2 18v3c0 .6.4 1 1 1h4v-3h3v-3h2l1.4-1.4a6.5 6.5 0 1 0-4-4Z" />
                                    <circle cx="16.5" cy="7.5" r=".5" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-center">
                <button type="button" @click="$emit('close')"
                    class="mt-8 me-2 close overlay-button bg-gradient-to-tr from-slate-600 to-slate-700 text-white px-3 py-3 w-full rounded-xl rounded-tr">
                    Cerrar
                </button>
                <button :disabled="!(Utils.role() == 'agency' && (Utils.manager() == null || Utils.manager() == 'null'))"
                    type="button" @click="$emit('manageradd')"
                    class="mt-8 overlay-button bg-gradient-to-tr disabled:opacity-40 from-app-primary-500 to-app-primary-700 text-white px-3 py-3 w-full rounded-xl rounded-tr">
                    Agregar
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
