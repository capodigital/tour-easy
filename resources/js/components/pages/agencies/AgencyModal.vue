<script>
import CustomModal from '../../common/CustomModal.vue';
import Confirm from "../../modals/Confirm"
import axios from 'axios';

export default {
    components: { CustomModal },
    props: {
        agency: Object,
    },
    data() {
        return {
            countries: [],
            cities: [],
            socialtypes: [],
            socialmedias: [{}],
            country_id: 'AF',
            files: [{ type: 'link' }],
            preview: 'src/user_placeholder.png',
        }
    },
    methods: {
        updatePreview(e) {
            const files = e.target.files
            if (files && files.length) {
                this.preview = URL.createObjectURL(files[0])
            } else {
                this.preview = 'src/user_placeholder.png'
            }
        },
        removeDocument(index) {
            const confirm = new Confirm('¡Confirmar operación!', '¿Seguro que desea eliminar este documento?')
            confirm.fire().then((result) => {
                if (this.files[index].id == undefined) {
                    this.files.splice(index, 1)
                } else {
                    axios.post('api/documents/' + this.files[index].id, { _method: 'delete' }, {
                        headers: {
                            'Authorization': `Bearer ${this.Utils.token()}`
                        }
                    }).then(() => {
                        this.files.splice(index, 1)
                        this.Utils.notify('Se ha eliminado correctamente el documento del servidor')
                    })
                }
            })
        },
        setCities(country) {
            axios.post('api/cities', { code: country }, {
                headers: {
                    'Authorization': `Bearer ${this.Utils.token()}`
                }
            }).then((response) => {
                this.cities = response.data;
            });
        },
    },
    created() {
        if (this.agency.id != undefined) {
            this.socialmedias = this.agency.socialmedias
            this.files = []
            for (let document of this.agency.documents) {
                document.type = document.url == null ? 'local' : 'link'
                this.files.push(document)
            }
            this.preview = this.agency.image.replace('http://localhost/', '')
        }
        axios.get('api/typeredes', {
            headers: {
                Authorization: `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.socialtypes = response.data.data;
        });
        axios.get('api/countries', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.countries = response.data.data;
            if (this.agency.id != undefined) {
                this.country_id = this.agency.city.country_id
                this.setCities(this.country_id)
            } else {
                this.setCities(this.countries[0].code)
            }
        }).catch((error) => {
            this.Utils.error(error.response)
        });
    },
}
</script>
<template>
    <CustomModal @close="$emit('close')">
        <form @submit.prevent="(e) => $emit('send', e)"
            class="rounded-3xl rounded-tr p-10 overflow-auto scroll">
            <h1
                class="font-bold bg-gradient-to-tr from-slate-500 text-center to-black text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black mb-2">
                <template v-if="agency.id == undefined">
                    AÑADIR AGENCIA
                </template>
                <template v-else>
                    EDITAR AGENCIA
                </template>
            </h1>
            <div class="overflow-auto modal-content">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                    <div class="flex items-center justify-center">
                        <input @change="updatePreview" type="file" class="opacity-5 w-1 h-1" name="image"
                            :required="agency.id == undefined" />
                        <div class="text-center">
                            <img @click="$el.querySelector('[type=file]').click()" id="preview" :src="preview"
                                class="rounded-lg w-64 h-64 cursor-pointer mb-3" />
                            <label v-if="preview == 'src/image-placeholder.jpg'"
                                class="text-center text-gray-300 mt-2 mx-auto">Imagen obligatoria</label>
                        </div>
                    </div>
                    <div>
                        <div class="grid grid-cols-1 gap-x-2">
                            <div>
                                <label class="text-slate-200 text-xs font-semibold">Nombre de la agencia</label>
                                <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                    <i class="bi bi-building text-gray-100"></i>
                                    <input required v-model="agency.taxname" name="taxname" type="text"
                                        placeholder="Nombre de la agencia"
                                        class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                </div>
                            </div>
                            <div>
                                <label class="text-slate-200 text-xs font-semibold">Nombre de la marca</label>
                                <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                    <i class="bi bi-badge-tm text-gray-100"></i>
                                    <input required v-model="agency.tradename" name="tradename" type="text"
                                        placeholder="Nombre de la marca"
                                        class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-x-2">
                            <div>
                                <label class="text-slate-200 text-xs font-semibold">Código fiscal</label>
                                <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                    <i class="bi bi-upc-scan text-gray-100"></i>
                                    <input required v-model="agency.taxcode" name="taxcode" type="text"
                                        placeholder="Código fiscal"
                                        class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                </div>
                            </div>
                            <div>
                                <label class="text-slate-200 text-xs font-semibold">Dueño de la agencia</label>
                                <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                    <i class="bi bi-person text-gray-100"></i>
                                    <input required v-model="agency.owner" name="owner" type="text"
                                        placeholder="Dueño de la agencia"
                                        class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid gap-x-2" :class="{ 'grid-cols-2': agency.id == undefined }">
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Correo electrónico</label>
                        <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                            <i class="bi bi-envelope text-gray-100"></i>
                            <input required v-model="agency.email" name="email" type="email"
                                placeholder="Correo electrónico"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                        </div>
                    </div>
                    <div v-if="agency.id == undefined">
                        <label class="text-slate-200 text-xs font-semibold">Contraseña</label>
                        <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                            <i class="bi bi-key text-gray-100"></i>
                            <input required name="password" type="password" placeholder="Contraseña"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-x-2">
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Número de teléfono</label>
                        <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                            <i class="bi bi-telephone text-gray-100"></i>
                            <input required v-model="agency.phone" name="phone" type="tel" placeholder="Número de teléfono"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                        </div>
                    </div>
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Dirección</label>
                        <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                            <i class="bi bi-map text-gray-100"></i>
                            <input required v-model="agency.address" name="address" type="text" placeholder="Dirección"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                        </div>
                    </div>
                </div>
                <div>
                    <label class="text-slate-200 text-xs font-semibold">Descripción</label>
                    <div class="flex items-center mb-3 rounded border border-gray-300 px-1 py-1">
                        <textarea rows="3" v-model="agency.notes" name="notes" placeholder="Datos adicionales"
                            class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-1 py-1"></textarea>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-x-2">
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">País</label>
                        <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                            <i class="bi bi-globe text-gray-100"></i>
                            <select required v-model="country_id" @change="(e) => setCities(e.target.value)"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                <option class="text-black" v-for="country in countries" :value="country.code">{{
                                    country.name }}</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Ciudad</label>
                        <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                            <i class="bi bi-globe-americas text-gray-100"></i>
                            <select required v-model="agency.city_id" @change="setCities" name="city_id"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                <option class="text-black" v-for="city in cities" :value="city.id">{{ city.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div>
                    <button @click="socialmedias.push({})"
                        class="px-2 py-0.5 float-right rounded text-sm text-gray-300 border border-gray-300"
                        type="button">Añadir</button>
                    <label class="text-slate-200 text-xs font-semibold">Redes sociales</label>
                    <div class="mt-1 grid grid-cols-3 gap-2">
                        <template v-for="(socialmedia, index) in socialmedias">
                            <div class="flex items-center rounded border border-gray-300 px-2">
                                <select v-model="socialmedia.typeredes_id" :name="`socialmedias[${index}][typeredes_id]`"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                    <option class="text-black" v-for="type in socialtypes" :value="type.id">{{
                                        type.name
                                    }}</option>
                                </select>
                            </div>
                            <div class="flex items-center rounded border border-gray-300 px-2">
                                <input v-model="socialmedia.url" :name="`socialmedias[${index}][url]`" type="text"
                                    placeholder="Link"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                            </div>
                            <div class="flex items-center rounded border border-gray-300 px-2">
                                <input v-model="socialmedia.description" :name="`socialmedias[${index}][description]`"
                                    type="text" placeholder="Descripción"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                <button @click="socialmedias.splice(index, 1)" type="button" class="text-white"><i
                                        class="bi bi-trash"></i></button>
                            </div>
                        </template>
                    </div>
                </div>
                <div class="mt-2">
                    <button @click="files.push({ type: 'link' })"
                        class="px-2 py-0.5 float-right rounded text-sm text-gray-300 border border-gray-300"
                        type="button">Añadir</button>
                    <label class="text-slate-200 text-xs font-semibold">Documentos</label>
                    <div class="mt-1 grid grid-cols-3 gap-2">
                        <template v-for="(file, index) in files">
                            <div class="flex items-center rounded border border-gray-300 px-2">
                                <select v-model="file.type"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                    <option class="text-black" value="link">Google Drive</option>
                                    <option class="text-black" value="local">Local</option>
                                </select>
                            </div>
                            <div class="flex items-center rounded border border-gray-300 px-2" style="grid-column: span 2;">
                                <template v-if="file.type == 'link'">
                                    <input v-if="file.id == undefined" :name="`urls[${index}]`" v-model="file.url"
                                        type="text" placeholder="Link"
                                        class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                    <input v-else v-model="file.url" type="text" placeholder="Link"
                                        class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3"
                                        readonly>
                                </template>

                                <template v-else>
                                    <input v-if="file.id != undefined" v-model="file.name" type="text" placeholder="Link"
                                        class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3"
                                        readonly>
                                    <input v-else :name="`documents[${index}]`" type="file"
                                        class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                </template>
                                <button @click="removeDocument(index)" type="button" class="text-white"><i
                                        class="bi bi-trash"></i></button>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
            <div class="flex justify-center">
                <button type="button" @click="$emit('close')"
                    class="mt-8 me-2 close overlay-button bg-gradient-to-tr from-slate-600 to-slate-700 text-white px-3 py-3 w-full rounded-xl rounded-tr">
                    Cerrar
                </button>
                <button type="submit"
                    class="mt-8 overlay-button bg-gradient-to-tr from-app-primary-500 to-app-primary-700 text-white px-3 py-3 w-full rounded-xl rounded-tr">
                    <template v-if="agency.id == undefined">
                        Agregar
                    </template>
                    <template v-else>
                        Actualizar
                    </template>
                </button>
            </div>
        </form>
    </CustomModal>
</template>
<style scoped>
form {
    background: linear-gradient(138.52deg, rgb(81, 44, 44) -1.32%, rgb(37, 44, 78) 85.77%);
}
</style>
