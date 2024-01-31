<script>
import DocumentsItem from '../../common/DocumentsItem.vue';

export default {
    props: {
        person: Object,
    },
    data() {
        return {
            collapse: true,
        };
    },
    components: { DocumentsItem }
}
</script>
<template>
    <article class="bg-gradient-to-tr max-w-[calc(100vw-1rem)] overflow-hidden rounded-lg from-slate-800 via-slate-900 to-slate-950 mb-2">
        <div class="flex items-center w-full">
            <div class="p-2 w-full">
                <span class="float-right text-sm text-gray-400">{{ person.typecontact.description }}</span>
                <h2 class="font-semibold text-white mb-1">{{ person.name }}
                </h2>
                <div v-if="Utils.role() != 'artist'" class="flex">
                    <button @click="$emit('edit', person)"
                        class="rounded text-sm border hover:bg-white hover:text-black transition-all border-gray-100 text-gray-100 px-2 py-1 me-1"><i
                            class="bi bi-pencil-square"></i> Editar</button>
                    <button @click="$emit('destroy', person)"
                        class="rounded text-sm border hover:bg-white hover:text-black transition-all border-gray-100 text-gray-100 px-2 py-1"><i
                            class="bi bi-trash"></i> Eliminar</button>
                </div>
            </div>
            <div class="text-end px-2">
                <button @click="collapse = !collapse" :class="{ 'rotate-180': !collapse }"
                    class="text-white me-2 transition-transform"><i class="bi bi-chevron-down"></i></button>
            </div>
        </div>
        <div class="w-full transition-all overflow-hidden" :class="{ 'h-0 p-0': collapse, 'h-auto p-2': !collapse }">
            <p class="text-gray-300 text-sm mb-2"><i class="bi bi-geo-alt"></i> Nacionalidad: {{ person.country.name }}</p>
            <p class="text-gray-300 text-sm mb-2"><i class="bi bi-calendar-day"></i> Fecha de nacimiento: {{
                person.birthday }}</p>
            <p class="text-gray-300 text-sm mb-2"><i class="bi bi-envelope"></i> Correo electrónico:
                {{ person.email }}</p>
            <p class="text-gray-300 text-sm mb-2"><i class="bi bi-telephone"></i> Número de teléfono principal:
                {{ person.phone }}</p>
            <p class="text-gray-300 text-sm mb-2"><i class="bi bi-telephone"></i> Número de teléfono secundario:
                {{ person.extra_phone }}</p>
            <p class="text-gray-300 text-sm mb-2"><i class="bi bi-translate"></i> Idioma: {{ person.lang }}</p>
            <p class="text-gray-300 text-sm mb-2">{{ person.notes }}</p>
            <div class="mt-3 grid grid-cols-6">
                <a v-for="socialmedia in person.socialmedias" :href="socialmedia.url" target="_blank"
                    class="px-2 rounded-md flex justify-center text-whiteitems-center me-1">
                    <img :src="socialmedia.typered.logo.replace('http://localhost/', '')" class="" />
                </a>
            </div>
            <DocumentsItem :documents="person.documents" />
        </div>
</article></template>
