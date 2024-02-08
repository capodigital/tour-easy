<script>
import CustomModal from '../common/CustomModal.vue';
import axios from 'axios';

export default {
    components: { CustomModal },
    data() {
        return {
            error: null
        }
    },
    methods: {
        login(e) {
            this.error = null
            axios.post('api/user/login', new FormData(e.target)).then((response) => {
                localStorage.setItem('token', response.data.token)
                localStorage.setItem('user', JSON.stringify(response.data.user))
                if (response.data.user.stagename != undefined) {
                    localStorage.setItem('username', response.data.user.stagename)
                    localStorage.setItem('user_role', 'artist')
                    localStorage.setItem('manager', null)
                } else if (response.data.user.taxname != undefined) {
                    localStorage.setItem('username', response.data.user.taxname)
                    localStorage.setItem('user_role', 'agency')
                    localStorage.setItem('manager', null)
                } else {
                    if (response.data.user.agency_id != null) {
                        localStorage.setItem('username', response.data.user.agency.taxname)
                        localStorage.setItem('user_role', 'agency')
                        localStorage.setItem('manager', response.data.user.id)
                    } else {
                        localStorage.setItem('username', response.data.user.name)
                        localStorage.setItem('user_role', 'user')
                        localStorage.setItem('manager', null)
                    }
                }
                this.$emit('login')
                location.href = '/admin#home'
            }).catch((error) => {
                this.error = error.response.data.message
            })
        }
    }

}
</script>
<template>
    <CustomModal @close="$emit('close')">
        <form @submit.prevent="login" class="bg-white rounded-3xl rounded-tr p-10">
            <h1 class="text-center text-2xl mb-4 text-gray-700 font-semibold">Iniciar sesión</h1>
            <label class="text-black text-xs font-bold">Correo electrónico</label>
            <div class="flex items-center mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#000"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail me-2">
                    <rect width="20" height="16" x="2" y="4" rx="2" />
                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                </svg>
                <input name="email" type="email" placeholder="Correo electrónico"
                    class="bg-transparent w-full text-gray-500 text-sm border-none focus:outline-none px-3 py-3">
            </div>
            <label class="text-black text-xs font-bold">Contraseña</label>
            <div class="flex items-center mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#000"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-square-asterisk me-2">
                    <rect width="18" height="18" x="3" y="3" rx="2" />
                    <path d="M12 8v8" />
                    <path d="m8.5 14 7-4" />
                    <path d="m8.5 10 7 4" />
                </svg>
                <input name="password" type="password" placeholder="Contraseña"
                    class="bg-transparent w-full text-gray-500 text-sm border-none focus:outline-none px-3 py-3">
            </div>
            <p class="text-center text-red-600 text-xs" v-if="error != null">{{ error }}</p>
            <button type="submit"
                class="mt-8 overlay-button bg-gradient-to-tr from-slate-950 to-black text-white px-3 py-3 w-full rounded-xl rounded-tr">Iniciar
                sesión</button>
            <div class="mt-10 w-full flex justify-center">
                <a class="text-black font-bold text-xs text-center">He olvidado mi contraseña</a>
            </div>
        </form>
    </CustomModal>
</template>
<style scoped></style>
