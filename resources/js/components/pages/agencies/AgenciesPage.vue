<script>
import axios from 'axios'
import AgencyItem from './AgencyItem.vue';
export default {
    data() {
        return {
            agencies: [],
            agency: {},
            countries: [],
            cities: [],
            socialtypes: [
                { "id": "1", "name": "Facebook" },
                { "id": "2", "name": "Twitter" },
                { "id": "3", "name": "Instagram" },
                { "id": "4", "name": "Tiktok" },
                { "id": "5", "name": "Spotify" },
                { "id": "6", "name": "Youtube" },
                { "id": "7", "name": "AppleMusic" },
                { "id": "8", "name": "AmazonMusic" },
                { "id": "9", "name": "Tindal" },
                { "id": "10", "name": "Web" }
            ],
            socialmedias: [{}],
            files: [{ type: 'link' }],
            show: false,
        };
    },
    methods: {
        setCities(country) {
            axios.post('api/cities', { code: country }, {
                headers: {
                    'Authorization': `Bearer ${this.Utils.token()}`
                }
            }).then((response) => {
                this.cities = response.data;
            });
        },
        send(e) {
            const data = new FormData(e.target)
            data.append('_method', this.agency.id == undefined ? 'post' : 'put');
            axios.post(this.agency.id == undefined ? 'api/agencies' : `api/agencies/${this.agency.id}`, data, {
                headers: {
                    'Authorization': `Bearer ${this.Utils.token()}`
                }
            }).then((response) => {
                if (this.agency.id == undefined) {
                    this.agencies.unshift(response.data.data)
                    this.Utils.notify('Se ha creado correctamente la agencia')
                } else {
                    for (let i in this.agencies) {
                        if (this.agencies[i].id == this.agency.id) {
                            this.agencies[i] = response.data.data
                            this.Utils.notify('Se han actualizado correctamente los datos de la agencia')
                            break
                        }
                    }
                }
                this.agency = {}
                this.socialmedias = [{}]
                this.files = [{ type: 'link' }]
                this.show = false
            }).catch((error) => {
                this.Utils.error(error.response)
            })
        },
        add() {
            this.agency = {}
            this.socialmedias = [{}]
            this.files = [{ type: 'link' }]
            this.show = true
        },
        edit(item) {
            Object.assign(this.agency, item)
            this.socialmedias = this.agency.socialmedias
            this.files = []
            for (let document of this.agency.documents) {
                document.type = document.url == null ? 'local' : 'link'
                this.files.push(document)
            }
            this.show = true
        },
        destroy(item) {
            axios.post('api/agencies/' + item.id, { _method: 'delete' }, {
                headers: {
                    'Authorization': `Bearer ${this.Utils.token()}`
                }
            }).then((response) => {
                for (let i in this.agencies) {
                    if (this.agencies[i].id == item.id) {
                        this.agencies.splice(i, 1)
                        this.Utils.notify('Se ha eliminado correctamente la agencia')
                        break
                    }
                }
            }).catch((error) => {
                this.Utils.error(error.response)
            })
        },
        removeDocument(index) {
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
        },
    },
    created() {
        axios.get('api/agencies', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.agencies = response.data.data;
        }).catch((error) => {
            this.Utils.error(error.response);
        });
        axios.get('api/countries', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.countries = response.data.data;
            this.setCities(this.countries[0].code)
        }).catch((error) => {
            this.Utils.error(error.response)
        });
    },
    components: { AgencyItem }
}
</script>
<template>
    <section class="p-4">
        <div class="relative">
            <div class="flex">
                <h1
                    class="font-bold bg-gradient-to-tr w-full from-slate-500 to-black text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black">
                    AGENCIAS</h1>
                <button v-if="Utils.role() != 'artist'" @click="add"
                    class="px-2 py-1 text-white bg-gradient-to-tr from-slate-800 to-slate-950 rounded">Añadir</button>
            </div>
            <div class="mt-4 grid sm:grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-3">
                <AgencyItem @edit="edit" @destroy="destroy" :agency="item" v-for="item in agencies" />
            </div>
        </div>
        <div v-if="Utils.role() != 'artist'" :class="{ 'hidden': !show, 'flex': show }"
            class="w-full bg-white bg-opacity-90 left-0 h-screen md:h-auto absolute top-0 px-2 py-2 justify-center items-center">
            <div>
                <h1
                    class="font-bold bg-gradient-to-tr from-slate-500 text-center to-black text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black mb-2">
                    <template v-if="agency.id == undefined">
                        AÑADIR
                    </template>
                    <template v-else>
                        EDITAR
                    </template>
                </h1>
                <form @submit.prevent="send"
                    class="bg-gradient-to-tr from-slate-700 via-black to-slate-950 rounded-3xl rounded-tr p-10 overflow-auto scroll">
                    <div class="grid grid-cols-2 gap-x-2">
                        <div>
                            <label class="text-slate-200 text-xs font-semibold">Nombre de la agencia</label>
                            <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                <i class="bi bi-building text-gray-100"></i>
                                <input v-model="agency.taxname" name="taxname" type="text"
                                    placeholder="Nombre de la agencia"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                            </div>
                        </div>
                        <div>
                            <label class="text-slate-200 text-xs font-semibold">Nombre de la marca</label>
                            <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                <i class="bi bi-badge-tm text-gray-100"></i>
                                <input v-model="agency.tradename" name="tradename" type="text"
                                    placeholder="Nombre de la marca"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-x-2">
                        <div>
                            <label class="text-slate-200 text-xs font-semibold">Código fiscal</label>
                            <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                <i class="bi bi-upc-scan text-gray-100"></i>
                                <input v-model="agency.taxcode" name="taxcode" type="text" placeholder="Código fiscal"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                            </div>
                        </div>
                        <div>
                            <label class="text-slate-200 text-xs font-semibold">Dueño de la agencia</label>
                            <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                <i class="bi bi-person text-gray-100"></i>
                                <input v-model="agency.owner" name="owner" type="text" placeholder="Dueño de la agencia"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                            </div>
                        </div>
                    </div>
                    <div class="grid gap-x-2" :class="{ 'grid-cols-2': agency.id == undefined }">
                        <div>
                            <label class="text-slate-200 text-xs font-semibold">Correo electrónico</label>
                            <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                <i class="bi bi-envelope text-gray-100"></i>
                                <input v-model="agency.email" name="email" type="email" placeholder="Correo electrónico"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                            </div>
                        </div>
                        <div v-if="agency.id == undefined">
                            <label class="text-slate-200 text-xs font-semibold">Contraseña</label>
                            <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                <i class="bi bi-key text-gray-100"></i>
                                <input name="password" type="password" placeholder="Contraseña"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-x-2">
                        <div>
                            <label class="text-slate-200 text-xs font-semibold">Número de teléfono</label>
                            <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                <i class="bi bi-telephone text-gray-100"></i>
                                <input v-model="agency.phone" name="phone" type="tel" placeholder="Número de teléfono"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                            </div>
                        </div>
                        <div>
                            <label class="text-slate-200 text-xs font-semibold">Dirección</label>
                            <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                <i class="bi bi-map text-gray-100"></i>
                                <input v-model="agency.address" name="address" type="text" placeholder="Dirección"
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
                                <select @change="(e) => setCities(e.target.value)"
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
                                <select v-model="agency.city_id" @change="setCities" name="city_id"
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
                                    <select v-model="socialmedia.typeredes_id"
                                        :name="`socialmedias[${index}][typeredes_id]`"
                                        class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                        <option class="text-black" v-for="type in socialtypes" :value="type.id">{{ type.name
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
                                <div class="flex items-center rounded border border-gray-300 px-2"
                                    style="grid-column: span 2;">
                                    <template v-if="file.type == 'link'">
                                        <input v-if="file.id == undefined" :name="`urls[${index}]`" v-model="file.url"
                                            type="text" placeholder="Link"
                                            class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                        <input v-else v-model="file.url" type="text" placeholder="Link"
                                            class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3"
                                            readonly>
                                    </template>

                                    <template v-else>
                                        <input v-if="file.id != undefined" v-model="file.name" type="text"
                                            placeholder="Link"
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
                    <div class="flex justify-center">
                        <button type="button" @click="show = false"
                            class="mt-8 me-2 overlay-button bg-gradient-to-tr from-slate-100 to-slate-300 text-black px-3 py-3 w-full rounded-xl rounded-tr">
                            Cerrar
                        </button>
                        <button type="submit"
                            class="mt-8 overlay-button bg-gradient-to-tr from-slate-100 to-slate-300 text-black px-3 py-3 w-full rounded-xl rounded-tr">
                            <template v-if="agency.id == undefined">
                                Agregar
                            </template>
                            <template v-else>
                                Actualizar
                            </template>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</template>
<style scoped>
input:-webkit-autofill,
input:-webkit-autofill:hover,
input:-webkit-autofill:focus {
    -webkit-box-shadow: 0 0 0px 1000px rgb(5, 19, 43) inset;
}

input:-webkit-autofill {
    -webkit-text-fill-color: white
}

h1 {
    font-family: 'Archivo Black', sans-serif;
}

form {
    max-height: calc(100vh - 7.5rem);
}</style>
