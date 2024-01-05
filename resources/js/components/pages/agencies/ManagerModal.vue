<script>
import CustomModal from '../../common/CustomModal.vue';
import axios from 'axios';

export default {
    components: { CustomModal },
    props: {
        user: Object,
    },
    created() {

    },
}
</script>
<template>
    <CustomModal @close="$emit('close')">
        <form @submit.prevent="(e) => $emit('send', e)"
            class="bg-gradient-to-tr from-slate-700 to-slate-950 rounded-2xl shadow-md shadow-gray-500 p-4 overflow-auto transition-all cursor-pointer">
            <input type="hidden" :value="Utils.user().id" name="agency_id" />
            <h1
                class="font-bold bg-gradient-to-tr from-slate-200 text-center to-slate-500 text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black mb-2">
                <template v-if="user.id == undefined">
                    AÑADIR MANAGER
                </template>
                <template v-else>
                    EDITAR MANAGER
                </template>
            </h1>
            <div class="overflow-auto modal-content">
                <div>
                    <label class="text-slate-200 text-xs font-semibold">Nombre(s) y apellidos</label>
                    <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                        <i class="bi bi-person text-gray-100"></i>
                        <input required v-model="user.name" name="name" type="text" placeholder="Nombre(s) y apellidos"
                            class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                    </div>
                </div>
                <div>
                    <label class="text-slate-200 text-xs font-semibold">Correo electrónico</label>
                    <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                        <i class="bi bi-envelope text-gray-100"></i>
                        <input required v-model="user.email" name="email" type="email" placeholder="Correo electrónico"
                            class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                    </div>
                </div>
                <template v-if="user.id == undefined">
                    <div>
                        <label required class="text-slate-200 text-xs font-semibold">Contraseña</label>
                        <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                            <i class="bi bi-key text-gray-100"></i>
                            <input name="password" type="password" placeholder="Contraseña"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                        </div>
                    </div>
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Confirmar contraseña</label>
                        <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                            <i class="bi bi-key text-gray-100"></i>
                            <input required name="confirm_password" type="password" placeholder="Confirmar contraseña"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                        </div>
                    </div>
                </template>
            </div>
            <div class="flex justify-center">
                <button type="button" @click="$emit('close')"
                    class="mt-8 me-2 close overlay-button bg-gradient-to-tr from-slate-100 to-slate-300 text-black px-3 py-3 w-full rounded-xl rounded-tr">
                    Cerrar
                </button>
                <button type="submit"
                    class="mt-8 overlay-button bg-gradient-to-tr from-slate-100 to-slate-300 text-black px-3 py-3 w-full rounded-xl rounded-tr">
                    <template v-if="user.id == undefined">
                        Agregar
                    </template>
                    <template v-else>
                        Actualizar
                    </template>
                </button>
            </div>
        </form>
    </CustomModal>
</template>
