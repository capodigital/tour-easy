<script>
export default {
    props: {
        artist: Object
    }
}
</script>
<template>
    <article class="rounded-lg shadow-md shadow-gray-500 p-3 transition-all hover:scale-[1.03] cursor-pointer relative pb-12">
        <div class="">
            <img class="rounded-full h-10 w-10 float-right shadow-md shadow-gray-400"
                :src="artist.image.replace('http://localhost/', '')" />
            <div class="min-h-[3.5rem]">
                <h3 class="font-bold text-lg text-gray-200">{{ artist.name }} {{ artist.lastname }}</h3>
                <p class="text-gray-300 text-sm leading-4 pe-10">{{ artist.stagename }}</p>
            </div>
            <p class="text-xs text-gray-400">{{ artist.notes }}</p>
        </div>
        <div class="flex mt-4 absolute bottom-2 w-[calc(100%-1.5rem)]">
            <div class="flex w-full">
                <button title="Editar artista" @click="$emit('edit', artist)"
                    class="rounded-md border border-gray-400 w-7 h-7 me-1 flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none"
                        stroke="rgb(202, 138, 4)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-clipboard-edit">
                        <rect width="8" height="4" x="8" y="2" rx="1" ry="1" />
                        <path d="M10.42 12.61a2.1 2.1 0 1 1 2.97 2.97L7.95 21 4 22l.99-3.95 5.43-5.44Z" />
                        <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-5.5" />
                        <path d="M4 13.5V6a2 2 0 0 1 2-2h2" />
                    </svg>
                </button>
                <button title="Eliminar artista" @click="$emit('destroy', artist)"
                    class="rounded-md border border-gray-400 w-7 h-7 flex justify-center items-center me-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none"
                        stroke="rgb(220, 38, 38)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-trash-2">
                        <path d="M3 6h18" />
                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                        <line x1="10" x2="10" y1="11" y2="17" />
                        <line x1="14" x2="14" y1="11" y2="17" />
                    </svg>
                </button>
            </div>
            <div class="flex">
                <button @click="$emit('show', artist)"
                    class="bg-gradient-to-br overlay-button from-app-primary-500 to-app-primary-800 text-white px-3 h-7 rounded flex text-sm items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-eye me-1">
                        <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                    Detalles
                </button>
            </div>
        </div>
    </article>
</template>
<style scoped>
h3,
p {
    font-family: 'Roboto', sans-serif;
}

article {
    background: rgb(81, 44, 44);
}
</style>
