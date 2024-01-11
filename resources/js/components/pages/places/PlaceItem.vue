<script>
import DocumentsItem from '../../common/DocumentsItem.vue';

export default {
    props: {
        place: Object
    },
    components: { DocumentsItem }
}
</script>
<template>
    <div class="bg-white max-w-[calc(100vw-2rem)] rounded-2xl shadow-md shadow-gray-500 transition-all hover:scale-105 cursor-pointer relative pb-[300px]">
        <div class="">
            <div class="flex float-right p-3">
                <button title="Editar lugar" @click="$emit('edit', place)"
                    class="rounded-lg border border-gray-400 w-7 h-7 me-1 flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-clipboard-edit">
                        <rect width="8" height="4" x="8" y="2" rx="1" ry="1" />
                        <path d="M10.42 12.61a2.1 2.1 0 1 1 2.97 2.97L7.95 21 4 22l.99-3.95 5.43-5.44Z" />
                        <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-5.5" />
                        <path d="M4 13.5V6a2 2 0 0 1 2-2h2" />
                    </svg>
                </button>
                <button title="Eliminar lugar" @click="$emit('destroy', place)"
                    class="rounded-lg border border-gray-400 w-7 h-7 flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-trash-2">
                        <path d="M3 6h18" />
                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                        <line x1="10" x2="10" y1="11" y2="17" />
                        <line x1="14" x2="14" y1="11" y2="17" />
                    </svg>
                </button>
            </div>

            <div class="min-h-[6rem] p-3">
                <h3 class="font-bold text-lg text-gray-900">{{ place.name }} ({{ place.typeplace.description }})</h3>
                <p class="text-gray-500 text-sm leading-4 pe-10">{{ place.manager }}</p>
                <p class="text-xs text-gray-500">{{ place.notes }}</p>
                <div class="flex items-center mt-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-phone me-2">
                        <path
                            d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                    </svg>
                    <div>
                        <p class="text-gray-800">Teléfonos</p>
                        <p class="text-gray-500 text-sm">{{ place.phone }} (Principal) - {{ place.extra_phone }}
                            (Secundario)
                        </p>
                    </div>
                </div>
                <hr class="my-2 border-gray-500" />
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-mail me-2">
                        <rect width="20" height="16" x="2" y="4" rx="2" />
                        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                    </svg>
                    <div>
                        <p class="text-gray-800">Correo electrónico</p>
                        <p class="text-gray-500 text-sm">{{ place.email }}</p>
                    </div>
                </div>
                <hr class="my-2 border-gray-500" />
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-globe me-2">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20" />
                        <path d="M2 12h20" />
                    </svg>
                    <div>
                        <p class="text-gray-800">Ciudad</p>
                        <p class="text-gray-500 text-sm">{{ place.city.name }}</p>
                    </div>
                </div>
                <hr class="my-2 border-gray-500" />
                <div class="flex items-center">
                    <div>
                        <p class="text-gray-800">Dirección</p>
                        <p class="text-gray-500 text-sm hover:underline"><a target="_blank" :href="place.google_id">{{
                            place.address }}</a></p>
                    </div>
                </div>
                <hr class="my-2 border-gray-500" />
                <DocumentsItem dark="true" :documents="place.documents" />
            </div>
            <div class="absolute bottom-0 left-0 w-full h-[300px]">
                <div style="width: 100%">
                    <iframe class="rounded-b-2xl" width="100%" height="300" frameborder="0" scrolling="no" marginheight="0"
                        marginwidth="0"
                        :src="`https://maps.google.com/maps?width=100%25&amp;height=300&amp;hl=es&amp;q=${place.gis}+(Ejemplo)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed`"><a
                            href="https://www.gps.ie/car-satnav-gps/">Sat Navs</a>
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</template>
