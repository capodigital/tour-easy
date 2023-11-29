<template>
    <section class="bg-gradient-to-tr from-slate-700 to-black h-full w-full relative flex justify-center items-center">
        <div class="text-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none"
                stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-link-2-off m-auto">
                <path d="M9 17H7A5 5 0 0 1 7 7" />
                <path d="M15 7h2a5 5 0 0 1 4 8" />
                <line x1="8" x2="12" y1="12" y2="12" />
                <line x1="2" x2="22" y1="2" y2="22" />
            </svg>
            <h1 class="mt-4 text-4xl font-bold bg-gradient-to-tr from-slate-300 to-gray-50 bg-clip-text text-transparent drop-shadow-md shadow-black">¡Lo has roto!</h1>
            <p class="text-white text-lg mt-2 mb-5">Vaya, no pudimos encontrar la página que buscas</p>
            <!-- <a href="#home" class="mt-6 text-white underline z-50">Volver a la página principal</a> -->
        </div>

    </section>
</template>
<style scoped>
section::after {
    content: " ";
    width: 100%;
    height: 100%;
    position: absolute;
    background-image: url(../../img/broken-glass.png);
    background-repeat: no-repeat;
    background-size: cover;
    background-position: -20rem -10rem;
}

h1 {
    font-family: 'Archivo Black', sans-serif;
}
</style>
