<script>
import DocumentsItem from '../common/DocumentsItem.vue';


export default {
    emits: ['update'],
    props: {
        supplier: Object,
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
    <article class="rounded-lg gradient-1 mb-1 border border-gray-700 w-full">
        <div class="flex items-center w-full">
            <div class="p-2 w-full flex items-center">
                <i class="bi bi-building text-3xl text-white me-2"></i>
                <div class="w-full">
                    <div class="float-right">
                        <small class="text-xs text-gray-400">
                            {{ supplier.agency.tradename }}
                        </small>
                        <div class="flex w-full justify-end">
                            <button title="Editar proveedor" @click="$emit('edit', supplier)"
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
                            <button title="Eliminar proveedor" @click="$emit('destroy', supplier)"
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
                    </div>

                    <h3 class="text-gray-200">{{ supplier.tradename }}</h3>
                    <p class="text-gray-400 text-sm">{{ supplier.email }}</p>
                </div>
            </div>
            <div class="text-end ms-2">
                <div>
                    <button type="button" @click="collapse = !collapse" :class="{ 'rotate-180': !collapse }"
                        class="text-white me-2 transition-transform"><i class="bi bi-chevron-down"></i></button>
                </div>

            </div>
        </div>
        <div class="w-full transition-all overflow-hidden px-4" :class="{ 'h-0 p-0': collapse, 'h-auto p-2': !collapse }">
            <p class="text-gray-400 text-xs mb-2">{{ supplier.notes }}</p>
            <div class="w-full transition-all overflow-hidden p-2">
                <div class="flex items-center my-1">
                    <i class="bi bi-file-person text-lg me-2 text-gray-200"></i>
                    <div>
                        <h3 class="text-gray-300">Manager</h3>
                        <p class="text-sm text-gray-400">{{ supplier.manager }} </p>
                        <a :href="'mailto:' + supplier.manager_email" class="text-sm text-gray-400">Correo: {{
                            supplier.manager_email }} </a>
                        <br />
                        <a :href="'tel:' + supplier.manager_phone" class="text-sm text-gray-400">Teléfono: {{
                            supplier.manager_phone }} </a>
                    </div>
                </div>
                <hr class="bg-gray-500 text-gray-500" />
                <div class="flex items-center my-1">
                    <i class="bi bi-cash-coin text-lg me-2 text-gray-200"></i>
                    <div>
                        <h3 class="text-gray-300">Información fiscal</h3>
                        <p class="text-sm text-gray-400">{{ supplier.taxname }} ({{ supplier.taxcode }})</p>
                    </div>
                </div>
                <hr class="bg-gray-500 text-gray-500" />
                <div class="flex items-center my-1">
                    <i class="bi bi-credit-card text-lg me-2 text-gray-200"></i>
                    <div>
                        <h3 class="text-gray-300">Datos de pago</h3>
                        <p class="text-sm text-gray-400">{{ supplier.paydata }}</p>
                    </div>
                </div>
                <hr class="bg-gray-500 text-gray-500" />
                <div class="flex items-center my-1">
                    <i class="bi bi-geo-alt text-lg me-2 text-gray-200"></i>
                    <div>
                        <h3 class="text-gray-300">Ciudad</h3>
                        <p class="text-sm text-gray-400">{{ supplier.city.name }} </p>
                    </div>
                </div>
                <hr class="bg-gray-500 text-gray-500" />
                <div class="flex items-center my-1">
                    <i class="bi bi-pin-map text-lg me-2 text-gray-200"></i>
                    <div>
                        <h3 class="text-gray-300">Dirección</h3>
                        <p class="text-sm text-gray-400">{{ supplier.address }} </p>
                    </div>
                </div>
                <hr class="bg-gray-500 text-gray-500" />
                <a :href="'tel:' + supplier.phone" class="flex items-center my-1">
                    <i class="bi bi-telephone text-lg me-2 text-gray-200"></i>
                    <div>
                        <h3 class="text-gray-300">Número de teléfono principal</h3>
                        <p class="text-sm text-gray-400">{{ supplier.phone }}</p>
                    </div>
                </a>
                <hr class="bg-gray-500 text-gray-500" />
                <a :href="'tel:' + supplier.extra_phone" class="flex items-center my-1">
                    <i class="bi bi-telephone text-lg me-2 text-gray-200"></i>
                    <div>
                        <h3 class="text-gray-300">Número de teléfono secundario</h3>
                        <p class="text-sm text-gray-400">{{ supplier.extra_phone }}</p>
                    </div>
                </a>
                <hr class="bg-gray-500 text-gray-500" />
                <div class="flex items-center my-1">
                    <i class="bi bi-passport text-lg me-2 text-gray-200"></i>
                    <div>
                        <h3 class="text-gray-300">Contacto</h3>
                        <p class="text-sm text-gray-400">{{ supplier.contact }}</p>
                        <a :href="'mailto:' + supplier.contact_email" class="text-sm text-gray-400">Correo: {{
                            supplier.contact_email }} </a>
                        <br />
                        <a :href="'tel:' + supplier.contact_phone" class="text-sm text-gray-400">Teléfono: {{
                            supplier.contact_phone }} </a>
                    </div>
                </div>
                <hr class="my-2 border-gray-500" />
                <div class="mt-3 grid grid-cols-4 md:grid-cols-8 lg:grid-cols-12">
                    <a v-for="socialmedia in supplier.socialmedias" :href="socialmedia.url" target="_blank"
                        class="px-2 rounded-md flex justify-center text-whiteitems-center me-1">
                        <img :src="socialmedia.typesocialmedia.logo.replace('http://localhost/', '')" class="" />
                    </a>
                </div>
                <hr class="my-2 border-gray-500" />
                <div class="px-2">
                    <DocumentsItem :documents="supplier.documents" />
                </div>
            </div>
        </div>
    </article>
</template>
