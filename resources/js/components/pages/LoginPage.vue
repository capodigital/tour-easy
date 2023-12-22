<script>
import axios from 'axios'
export default {
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
                } else if (response.data.user.taxname != undefined) {
                    localStorage.setItem('username', response.data.user.taxname)
                    localStorage.setItem('user_role', 'agency')
                } else {
                    if (response.data.user.agency_id != null) {
                        localStorage.setItem('username', response.data.user.agency.taxname)
                        localStorage.setItem('user_role', 'agency')
                    } else {
                        localStorage.setItem('username', response.data.user.name)
                        localStorage.setItem('user_role', 'user')
                    }
                }
                this.$emit('login')
                location.href = '#home'
            }).catch((error) => {
                this.error = error.response.data.message
            })
        }
    }
}
</script>
<template>
    <main class="w-screen h-screen bg-gradient-to-tr from-gray-700 to-black flex justify-center items-center">
        <div class="z-50">
            <form @submit.prevent="login" class="bg-white rounded-3xl rounded-tr p-10">
                <h1 class="text-center text-2xl mb-4 text-gray-700 font-semibold">Iniciar sesión</h1>
                <label class="text-black text-xs font-bold">Correo electrónico</label>
                <div class="flex items-center mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-mail me-2">
                        <rect width="20" height="16" x="2" y="4" rx="2" />
                        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                    </svg>
                    <input name="email" type="email" placeholder="Correo electrónico"
                        class="bg-transparent w-full text-gray-500 text-sm border-none focus:outline-none px-3 py-3">
                </div>
                <label class="text-black text-xs font-bold">Contraseña</label>
                <div class="flex items-center mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
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
        </div>
    </main>
</template>
<style scoped>
main::before {
    content: " ";
    position: absolute;
    width: 100vw;
    height: 100vh;
    top: 0;
    left: 0;
    background-image: url("/src/pattern_1.png");
    opacity: .3;
}
</style>
