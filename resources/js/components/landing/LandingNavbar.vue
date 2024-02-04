<script>
export default {
    data() {
        return {
            collapse: true
        }
    }
}
</script>
<template>
    <div>
        <nav
            class="w-screen z-50 flex justify-between p-4 items-center lg:px-20 bg-white fixed top-0 left-0 overflow-hidden shadow-lg shadow-gray-200">
            <div class="flex items-center">
                <img src="src/logo.svg" class="h-10 w-10 me-2" />
                <div>
                    <h1 class="font-bold leading-4 mb-1">MAD MUSIC</h1>
                    <p class="text-sm text-gray-600 leading-3">Easy Tour</p>
                </div>
            </div>
            <div class="hidden md:flex">
                <a class="mx-2 transition-all font-semibold text-gray-700 hover:text-green-600" href="#Home">Home</a>
                <a class="mx-2 transition-all font-semibold text-gray-700 hover:text-green-600"
                    href="#Services">Services</a>
                <a class="mx-2 transition-all font-semibold text-gray-700 hover:text-green-600"
                    href="#Features">Features</a>
                <a class="mx-2 transition-all font-semibold text-gray-700 hover:text-green-600" href="#Plans">Plans</a>
                <a class="mx-2 transition-all font-semibold text-gray-700 hover:text-green-600" href="#Reviews">Reviews</a>
                <a class="mx-2 transition-all font-semibold text-gray-700 hover:text-green-600" href="#Team">Team</a>
                <a class="mx-2 transition-all font-semibold text-gray-700 hover:text-green-600" href="#Contact">Contact</a>
            </div>
            <div class="hidden md:block">
                <button
                    class="px-5 py-2 text-white bg-blue-600 hover:bg-blue-700 transition-all rounded border-none focus:outline-none">Iniciar
                    sesión</button>
            </div>
            <button @click="collapse = !collapse" class="md:hidden">
                <i class="bi bi-list"></i>
            </button>

        </nav>
        <div class="bg-white rounded-b transition-all duration-500 md:hidden overflow-hidden right-0 left-0 w-full fixed z-30"
            :class="{ 'top-16': !collapse, 'p-4': !collapse, 'top-[-30rem]': collapse, 'p-0': collapse }">
            <p class="my-3"><a class="transition-all font-semibold text-gray-700 hover:text-green-600" href="#Home">Home</a></p>
            <p class="my-3"><a class="transition-all font-semibold text-gray-700 hover:text-green-600" href="#Services">Services</a>
            </p>
            <p class="my-3"><a class="transition-all font-semibold text-gray-700 hover:text-green-600" href="#Features">Features</a>
            </p>
            <p class="my-3"><a class="transition-all font-semibold text-gray-700 hover:text-green-600" href="#Plans">Plans</a></p>
            <p class="my-3"><a class="transition-all font-semibold text-gray-700 hover:text-green-600" href="#Reviews">Reviews</a>
            </p>
            <p class="my-3"><a class="transition-all font-semibold text-gray-700 hover:text-green-600" href="#Team">Team</a></p>
            <p class="my-3"><a class="transition-all font-semibold text-gray-700 hover:text-green-600" href="#Contact">Contact</a>
            </p>
            <button
                class="px-5 py-2 text-white bg-blue-600 hover:bg-blue-700 transition-all rounded border-none focus:outline-none">Iniciar
                sesión</button>
        </div>
    </div>
</template>
<style scoped>
a {
    font-family: 'Nunito', sans-serif;
}
</style>
