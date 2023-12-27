<script>
export default {
    data() {
        return {
            password: '',
            confirm_password: '',
            same_password: true,
        }
    },
    methods: {
        comparePasswords() {
            if (this.confirm_password != '' && this.confirm_password != undefined) {
                if (this.password != this.confirm_password) {
                    this.same_password = false
                    console.log('n o son iguales')
                    return
                }
            }
            this.same_password = true
        }
    }
}
</script>
<template>
    <div class="w-full bg-white bg-opacity-90 h-screen absolute top-0 px-2 py-2 flex justify-center items-center">
        <div>
            <h1
                class="font-bold bg-gradient-to-tr from-slate-500 text-center to-black text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black mb-2">
                CAMBIAR CONTRASEÑA
            </h1>
            <form @submit.prevent="(e) => $emit('send', e.target)"
                class="bg-gradient-to-tr from-slate-700 via-black to-slate-950 rounded-3xl rounded-tr p-10 overflow-auto scroll">
                <div class="grid grid-cols-1 gap-x-2">
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Escriba su contraseña</label>
                        <div class="flex items-center mb-1 rounded border border-gray-300 px-2">
                            <i class="bi bi-key text-gray-100"></i>
                            <input required name="current_password" type="password" placeholder="Contraseña"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                        </div>
                    </div>
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Nueva contraseña</label>
                        <div class="flex items-center mb-1 rounded border border-gray-300 px-2">
                            <i class="bi bi-key text-gray-100"></i>
                            <input @input="comparePasswords" v-model="password" required name="password" type="password"
                                placeholder="Contraseña"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                        </div>
                    </div>
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Confirmar contraseña</label>
                        <div class="flex items-center mb-1 rounded border border-gray-300 px-2">
                            <i class="bi bi-key text-gray-100"></i>
                            <input @input="comparePasswords" v-model="confirm_password" required name="confirm_password"
                                type="password" placeholder="Confirmar contraseña"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                        </div>
                    </div>

                </div>
                <div class="flex justify-center">
                    <small v-if="!same_password" class="text-center text-gray-300 col-start-1 col-end-3 mt-1">Las
                        contraseñas no coinciden</small>
                </div>

                <div class="justify-center">
                    <button type="button" @click="$emit('close')"
                        class="mt-4 me-2 overlay-button bg-gradient-to-tr from-slate-100 to-slate-300 text-black px-3 py-3 w-full rounded-xl rounded-tr">
                        Cerrar
                    </button>
                    <button type="submit"
                        class="mt-2 overlay-button bg-gradient-to-tr from-slate-100 to-slate-300 text-black px-3 py-3 w-full rounded-xl rounded-tr">
                        Cambiar contraseña
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
<style scoped>
form {
    max-height: calc(100vh - 7.5rem);
}
</style>
