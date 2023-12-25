<script>
export default {
    props: {
        agency: Object,
    }
}
</script>
<template>
    <div
        class="bg-gradient-to-tr from-slate-700 to-slate-950 rounded-2xl shadow-md shadow-gray-500 p-4 transition-all hover:scale-105 cursor-pointer">
        <div class="">
            <div class="float-right">
                <small class=" text-xs text-gray-400">{{ agency.taxcode }}</small>
                <div class="flex mt-0.5">
                    <div v-if="Utils.role() != 'artist'" class="flex w-full justify-end">
                        <button @click="$emit('edit', agency)"
                            class="rounded-lg border border-gray-400 w-7 h-7 me-1 flex justify-center items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-clipboard-edit">
                                <rect width="8" height="4" x="8" y="2" rx="1" ry="1" />
                                <path d="M10.42 12.61a2.1 2.1 0 1 1 2.97 2.97L7.95 21 4 22l.99-3.95 5.43-5.44Z" />
                                <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-5.5" />
                                <path d="M4 13.5V6a2 2 0 0 1 2-2h2" />
                            </svg>
                        </button>
                        <button @click="$emit('destroy', agency)"
                            class="rounded-lg border border-gray-400 w-7 h-7 flex justify-center items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
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
            </div>
            <div class="">
                <h3 class="font-bold text-lg text-gray-200">{{ agency.taxname }}</h3>
                <p class="text-gray-500 text-sm leading-4 pe-10">{{ agency.tradename }}</p>
            </div>
            <div class="grid grid-cols-1 gap-x-2 mt-4">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-user-round-check me-2">
                        <path d="M2 21a8 8 0 0 1 13.292-6" />
                        <circle cx="10" cy="8" r="5" />
                        <path d="m16 19 2 2 4-4" />
                    </svg>
                    <div>
                        <p class="text-white">Dueño de la agencia</p>
                        <p class="text-gray-400 text-sm">{{ agency.owner }}</p>
                    </div>
                </div>
                <hr class="my-2 border-gray-500" />
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-mail me-2">
                        <rect width="20" height="16" x="2" y="4" rx="2" />
                        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                    </svg>
                    <div>
                        <p class="text-white">Correo electrónico</p>
                        <p class="text-gray-400 text-sm">{{ agency.email }}</p>
                    </div>
                </div>
            </div>
            <hr class="my-2 border-gray-500" />
            <div class="grid grid-cols-1 gap-x-2">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-map me-2">
                        <polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21" />
                        <line x1="9" x2="9" y1="3" y2="18" />
                        <line x1="15" x2="15" y1="6" y2="21" />
                    </svg>
                    <div>
                        <p class="text-white">Dirección</p>
                        <p class="text-gray-400 text-sm">{{ agency.address }}</p>
                    </div>
                </div>
                <hr class="my-2 border-gray-500" />
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-phone-call me-2">
                        <path
                            d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                        <path d="M14.05 2a9 9 0 0 1 8 7.94" />
                        <path d="M14.05 6A5 5 0 0 1 18 10" />
                    </svg>
                    <div>
                        <p class="text-white">Número de teléfono</p>
                        <p class="text-gray-400 text-sm">{{ agency.phone }}</p>
                    </div>
                </div>
                <hr class="my-2 border-gray-500" />
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-globe me-2">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20" />
                        <path d="M2 12h20" />
                    </svg>
                    <div>
                        <p class="text-white">Ciudad</p>
                        <p class="text-gray-400 text-sm">{{ agency.city.name }}</p>
                    </div>
                </div>
            </div>
            <hr class="my-2 border-gray-500" />
            <template v-if="Utils.role() == 'agency' && Utils.manager() == null">
                <button type="button" @click="$emit('manageradd')" class="float-right text-sm text-black rounded px-1 py-0.5 bg-gray-200">Añadir</button>
                <label class="text-sm text-white font-semibold">Managers</label>
                <div class="flex" v-for="user in agency.users">
                    <i class="person-fill-gear text-2xl text-white"></i>
                    <div class="w-9/12">
                        <p class="text-white">{{user.name}}</p>
                        <p class="text-gray-300 text-sm">{{user.email}}</p>
                    </div>
                    <div class="w-3/12 flex justify-end items-center">
                        <button @click="$emit('manageredit', user)"
                            class="rounded-lg border border-gray-400 w-7 h-7 me-1 flex justify-center items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-clipboard-edit">
                                <rect width="8" height="4" x="8" y="2" rx="1" ry="1" />
                                <path d="M10.42 12.61a2.1 2.1 0 1 1 2.97 2.97L7.95 21 4 22l.99-3.95 5.43-5.44Z" />
                                <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-5.5" />
                                <path d="M4 13.5V6a2 2 0 0 1 2-2h2" />
                            </svg>
                        </button>
                        <button @click="$emit('managerdestroy', user)"
                            class="rounded-lg border border-gray-400 w-7 h-7 flex justify-center items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
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
                <hr class="my-2 border-gray-500" />
            </template>
            <div class="flex items-center mt-2">
                <div>
                    <p class="text-white">Detalles adicionales</p>
                    <p class="text-gray-400 text-sm">{{ agency.notes }}</p>
                </div>
            </div>
    </div>

</div></template>
