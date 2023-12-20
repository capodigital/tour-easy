<script>
export default {
    props: {
        artist: Object
    },
    methods: {
        tags(tags) {
            return tags.split(',')
        }
    }
}
</script>
<template>
    <article class="shadow-md shadow-gray-500 rounded-md">
        <div class="relative h-80 w-full bg-cover bg-center rounded-t-md"
            :style="{ 'background': `url(${artist.image.replace('http://localhost/', '')})` }">
            <!-- <img :src="artist.image.replace('http://localhost/', '')" /> -->
            <div
                class="w-full h-24 bg-gradient-to-t from-black to-transparent absolute bottom-0 flex justify-center items-end pb-3">
                <h2 class="text-center text-white text-xl font-semibold">{{ artist.name }} {{ artist.lastname }}</h2>
            </div>
        </div>
        <div class="p-2 flex justify-between">
            <p class="text-sm text-white"><span class="font-bold">Nombre artístico: </span>{{ artist.stagename }}</p>
            <p class="text-sm text-white"><span class="font-bold">Correo: </span>{{ artist.email }}</p>
        </div>
        <div class="p-2 flex justify-between">
            <p class="text-sm text-white"><span class="font-bold">Fecha de nacimiento: </span>{{ artist.birthday }}</p>
        </div>

        <div class="p-2">
            <p class="text-sm text-white">Redes sociales</p>

            <div class="mt-3 grid grid-cols-6">
                <a v-for="socialmedia in artist.socialmedias" :href="socialmedia.url" target="_blank"
                    class="px-3 rounded-md flex justify-center text-whiteitems-center me-1">
                    <img :src="socialmedia.typered.logo.replace('http://localhost/', '')" class="" />
                </a>
            </div>
        </div>
        <div class="p-2">
            <p class="text-sm text-white">Géneros</p>


           <div class="flex justify-start gap-2 p-2">
            <div v-for="tag in artist.tags" class="rounded-md border text-whiteitems-center p-2 text-white">
                {{ tag }}
            </div>
           </div>

        </div>
        <div class="px-2 pb-3 grid grid-cols-2 gap-2">
            <button type="button" @click="$emit('edit', artist)"
                class="mt-0 text-sm me-2 overlay-button bg-gradient-to-tr from-slate-100 to-slate-300 text-black px-3 py-3 w-full rounded-xl rounded-tr">
                <i class="bi bi-pencil-square"></i> Editar
            </button>
            <button type="button" @click="$emit('destroy', artist)"
                class="mt-0 text-sm me-2 overlay-button bg-gradient-to-tr from-slate-100 to-slate-300 text-black px-3 py-3 w-full rounded-xl rounded-tr">
                <i class="bi bi-trash"></i> Eliminar
            </button>
        </div>
    </article>
</template>
<style scoped>
article {
    background-color: rgb(52, 52, 52);
}
</style>
