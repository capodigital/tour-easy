<script>
import CustomModal from '../../common/CustomModal.vue';
import DocumentsItem from '../../common/DocumentsItem.vue';

export default {
    components: { CustomModal, DocumentsItem },
    props: {
        person: Object,
    },
}
</script>
<template>
    <CustomModal @close="$emit('close')">
        <article @submit.prevent="(e) => $emit('send', e)"
            class="max-w-3xl rounded-2xl shadow-md shadow-gray-800 p-4 overflow-auto transition-all cursor-pointer">
            <h1
                class="font-bold bg-gradient-to-tr from-slate-200 text-center to-slate-500 text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black mb-2">
                DETALLES DE LA PERSONA
            </h1>
            <div class="overflow-auto modal-content">
                <div class="flex items-center w-full">
                    <div class="p-2 w-full">
                        <span class="float-right text-sm text-gray-400">{{ person.typecontact.description }}</span>
                        <h2 class="font-semibold text-white mb-1">{{ person.name }}</h2>
                        <p class="text-gray-300 text-sm mb-2"><i class="bi bi-envelope"></i> Correo electrónico:
                            {{ person.email }}</p>
                    </div>
                </div>
                <p class="text-gray-400 text-xs mb-2">{{ person.notes }}</p>
                <div class="w-full transition-all overflow-hidden p-2">
                    <div class="flex items-center my-1">
                        <i class="bi bi-geo-alt text-lg me-2 text-gray-200"></i>
                        <div>
                            <h3 class="text-gray-300">Nacionalidad</h3>
                            <p class="text-sm text-gray-400">{{ person.country.name }} </p>
                        </div>
                    </div>
                    <hr class="bg-gray-500 text-gray-500" />
                    <div class="flex items-center my-1">
                        <i class="bi bi-calendar-day text-lg me-2 text-gray-200"></i>
                        <div>
                            <h3 class="text-gray-300">Fecha de nacimiento</h3>
                            <p class="text-sm text-gray-400">{{ person.birthday }}</p>
                        </div>
                    </div>
                    <hr class="bg-gray-500 text-gray-500" />
                    <div class="flex items-center my-1">
                        <i class="bi bi-telephone text-lg me-2 text-gray-200"></i>
                        <div>
                            <h3 class="text-gray-300">Número de teléfono principal</h3>
                            <p class="text-sm text-gray-400">{{ person.phone }}</p>
                        </div>
                    </div>
                    <hr class="bg-gray-500 text-gray-500" />
                    <div class="flex items-center my-1">
                        <i class="bi bi-telephone text-lg me-2 text-gray-200"></i>
                        <div>
                            <h3 class="text-gray-300">Número de teléfono secundario</h3>
                            <p class="text-sm text-gray-400">{{ person.extra_phone }}</p>
                        </div>
                    </div>
                    <hr class="bg-gray-500 text-gray-500" />
                    <div class="flex items-center my-1">
                        <i class="bi bi-passport text-lg me-2 text-gray-200"></i>
                        <div>
                            <h3 class="text-gray-300">Pasaporte</h3>
                            <p class="text-sm text-gray-400">{{ person.passport }} (Expira: {{ person.passport_expiry }})</p>
                        </div>
                    </div>
                    <hr class="bg-gray-500 text-gray-500" />
                    <div class="flex items-center my-1">
                        <i v-if="person.notify_type == 'WhatsApp'" class="bi bi-whatsapp text-lg me-2 text-gray-200"></i>
                        <i v-if="person.notify_type == 'Telegram'" class="bi bi-telegram text-lg me-2 text-gray-200"></i>
                        <i v-else class="bi bi-envelope text-lg me-2 text-gray-200"></i>
                        <div>
                            <h3 class="text-gray-300">Método de notificación</h3>
                            <p class="text-sm text-gray-400">{{ person.notify_type }}</p>
                        </div>
                    </div>
                    <hr class="bg-gray-500 text-gray-500" />
                    <div class="flex items-center my-1">
                        <i class="bi bi-telephone text-lg me-2 text-gray-200"></i>
                        <div>
                            <h3 class="text-gray-300">Grupo</h3>
                            <p class="text-sm text-gray-400">{{ person.group }}</p>
                        </div>
                    </div>
                    <hr class="bg-gray-500 text-gray-500" />
                    <div class="flex items-center my-1">
                        <i class="bi bi-translate text-lg me-2 text-gray-200"></i>
                        <div>
                            <h3 class="text-gray-300">Idioma</h3>
                            <p class="text-sm text-gray-400">{{ person.lang }}</p>
                        </div>
                    </div>
                    <div class="mt-3 grid grid-cols-8">
                        <a v-for="socialmedia in person.socialmedias" :href="socialmedia.url" target="_blank"
                            class="px-2 rounded-md flex justify-center text-whiteitems-center me-1">
                            <img :src="socialmedia.typesocialmedia.logo.replace('http://localhost/', '')" class="" />
                        </a>
                    </div>
                    <DocumentsItem :documents="person.documents" />
                </div>
            </div>
            <div class="flex justify-center">
                <button type="button" @click="$emit('close')"
                    class="mt-8 me-2 close overlay-button bg-gradient-to-tr from-slate-600 to-slate-700 text-white px-3 py-3 w-full rounded-xl rounded-tr">
                    Cerrar
                </button>
                <button type="button" @click="$emit('edit', person)"
                    class="mt-8 overlay-button bg-gradient-to-tr from-app-primary-500 to-app-primary-700 text-white px-3 py-3 w-full rounded-xl rounded-tr">
                    Actualizar
                </button>
            </div>
        </article>
    </CustomModal>
</template>
<style>
article {
    background: linear-gradient(138.52deg, rgb(81, 44, 44) -1.32%, rgb(37, 44, 78) 85.77%);
}
</style>
