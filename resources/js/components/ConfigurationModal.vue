<script>
import CustomModal from './common/CustomModal.vue';
import Confirm from './modals/Confirm';
import axios from 'axios';

export default {
    components: { CustomModal },
    data() {
        return {
            groups: [],
            socialmedias: [],
            editItem: {},
        }
    },
    methods: {
        edit(group) {
            Object.assign(this.editItem, group);
        },
        send() {
            const data = new FormData()
            data.append('name', this.editItem.name);
            data.append('_method', this.editItem.id == undefined ? 'post' : 'put');
            axios.post(this.editItem.id == undefined ? 'api/groups' : `api/groups/${this.editItem.id}`, data, {
                headers: {
                    'Authorization': `Bearer ${this.Utils.token()}`
                }
            }).then((response) => {
                if (this.editItem.id == undefined) {
                    this.groups.push(response.data.data)
                    this.Utils.notify('Se ha creado correctamente el grupo')
                } else {
                    for (let i in this.groups) {
                        if (this.groups[i].id == this.editItem.id) {
                            this.groups[i] = response.data.data
                            this.Utils.notify('Se han actualizado correctamente los datos del grupo')
                            break
                        }
                    }
                }
                this.editItem = {}
            }).catch((error) => {
                this.Utils.error(error.response)
            })
        },
        destroy(index) {
            const confirm = new Confirm('¡Confirmar operación!', '¿Seguro que desea eliminar este grupo?')
            confirm.fire().then((result) => {
                axios.post('api/groups/' + this.groups[index].id, { _method: 'delete' }, {
                    headers: {
                        'Authorization': `Bearer ${this.Utils.token()}`
                    }
                }).then((response) => {
                    this.groups.splice(index, 1)
                    this.Utils.notify('Se ha eliminado correctamente el grupo')
                }).catch((error) => {
                    this.Utils.error(error.response)
                })
            })
        }
    },
    created() {
        axios.get('api/groups', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.groups = response.data.data;
        }).catch((error) => {
            this.Utils.error(error.response)
        });
        axios.get('api/typesocialmedia', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.socialmedias = response.data.data;
        }).catch((error) => {
            this.Utils.error(error.response)
        });
    }
}
</script>
<template>
    <CustomModal @close="$emit('close')">
        <form @submit.prevent="(e) => $emit('send', e)"
            class="gradient-2 rounded-2xl shadow-md shadow-gray-500 p-4 overflow-auto transition-all cursor-pointer">
            <h1
                class="font-bold bg-gradient-to-tr from-slate-200 text-center to-slate-500 text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black mb-2">
                CONFIGURACIÓN
            </h1>
            <div class="overflow-auto modal-content">
                <h5 class="text-center text-gray-200 text-lg">Grupos</h5>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-3 z-50 p-4">
                    <article v-for="(group, index) in groups"
                        class="border-2 border-gray-500 rounded-lg cursor-pointer p-2">
                        <div>
                            <h3 v-if="editItem.id != group.id" class="font-bold text-md text-gray-200 mb-2 text-center">{{
                                group.name }}</h3>
                            <div v-else class="mb-1">
                                <div class="flex items-center rounded border border-gray-300 px-2">
                                    <input required v-model="editItem.name" name="name" type="text" placeholder="Nombre"
                                        class="bg-transparent w-[5rem] text-gray-300 text-sm border-none focus:outline-none px-1 py-1">
                                </div>
                            </div>
                            <div v-if="editItem.id != group.id" class="flex justify-center w-full">
                                <button type="button" title="Editar gira" v-if="Utils.role() != 'artist'"
                                    @click="edit(group)"
                                    class="rounded-md border border-gray-300 w-7 h-7 me-1 flex justify-center items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24"
                                        fill="none" stroke="rgb(202, 138, 4)" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-clipboard-edit">
                                        <rect width="8" height="4" x="8" y="2" rx="1" ry="1" />
                                        <path d="M10.42 12.61a2.1 2.1 0 1 1 2.97 2.97L7.95 21 4 22l.99-3.95 5.43-5.44Z" />
                                        <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-5.5" />
                                        <path d="M4 13.5V6a2 2 0 0 1 2-2h2" />
                                    </svg>
                                </button>
                                <button type="button" title="Eliminar gira" v-if="Utils.role() != 'artist'"
                                    @click="destroy(index)"
                                    class="rounded-md border border-gray-300 w-7 h-7 flex justify-center items-center me-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24"
                                        fill="none" stroke="rgb(220, 38, 38)" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-trash-2">
                                        <path d="M3 6h18" />
                                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                        <line x1="10" x2="10" y1="11" y2="17" />
                                        <line x1="14" x2="14" y1="11" y2="17" />
                                    </svg>
                                </button>
                            </div>
                            <div v-else class="flex justify-center w-full">
                                <button type="button" title="Eliminar gira" v-if="Utils.role() != 'artist'" @click="send"
                                    class="rounded-md border border-gray-300 w-7 h-7 flex justify-center items-center me-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24"
                                        fill="none" stroke="rgb(22, 163, 74)" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-save">
                                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                                        <polyline points="17 21 17 13 7 13 7 21" />
                                        <polyline points="7 3 7 8 15 8" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </article>
                    <article @click="editItem.adding = true" v-if="Utils.role() != 'artist' && editItem.adding == undefined"
                        class="border-2 border-gray-500 rounded-lg cursor-pointer border-dashed min-h-[5rem] flex justify-center items-center">
                        <i class="bi bi-plus text-6xl text-gray-500"></i>
                    </article>
                    <article v-else class="border-2 border-gray-500 rounded-lg cursor-pointer p-2">
                        <div>
                            <div class="mb-1">
                                <div class="flex items-center rounded border border-gray-300 px-2">
                                    <input required v-model="editItem.name" name="name" type="text" placeholder="Nombre"
                                        class="bg-transparent w-[5rem] text-gray-300 text-sm border-none focus:outline-none px-1 py-1">
                                </div>
                            </div>
                            <div class="flex justify-center w-full">
                                <button type="button" title="Eliminar gira" v-if="Utils.role() != 'artist'" @click="send"
                                    class="rounded-md border border-gray-300 w-7 h-7 flex justify-center items-center me-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24"
                                        fill="none" stroke="rgb(22, 163, 74)" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-save">
                                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                                        <polyline points="17 21 17 13 7 13 7 21" />
                                        <polyline points="7 3 7 8 15 8" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </article>
                </div>
                <h5 class="text-center text-gray-200 text-lg">Redes sociales</h5>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-3 z-50 p-4">
                    <article v-for="(type, index) in socialmedias"
                        class="border-2 border-gray-500 rounded-lg cursor-pointer p-2 relative">
                        <img class="rounded w-full" :src="type.logo.replace('http://localhost', '')" />
                        <a class="absolute bottom-2 text-center text-gray-300 w-[calc(100%-1rem)]" :href="'https://' + type.url">{{ type.name }}</a>
                    </article>
                </div>
            </div>
            <div class="flex justify-center">
                <button type="button" @click="$emit('close')"
                    class="mt-8 me-2 close overlay-button bg-gradient-to-tr from-gray-600 to-gray-700 text-white px-3 py-3 w-full rounded-xl rounded-tr">
                    Cerrar
                </button>
            </div>
        </form>
    </CustomModal>
</template>
