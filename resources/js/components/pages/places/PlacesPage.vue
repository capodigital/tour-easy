<script>
import axios from 'axios';
import PlaceItem from './PlaceItem.vue';

export default {
    components: { PlaceItem },
    data() {
        return {
            filter: '',
            places: [],
            place: {},
            agencies: [],
            types: [],
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
            countries: [],
            country_id: 'AF',
            cities: [],
            socialmedias: [{}],
            files: [{ type: 'link' }],
            show: false
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
        add() {
            this.place = {}
            this.socialmedias = [{}]
            this.files = [{ type: 'link' }]
            this.show = true
        },
        edit(item) {
            this.country_id = item.city.country.code
            this.setCities(item.city.country.code)
            Object.assign(this.place, item)
            this.socialmedias = this.place.socialmedias
            this.files = []
            for (let document of this.place.documents) {
                document.type = document.url == null ? 'local' : 'link'
                this.files.push(document)
            }
            this.preview = item.tourcartel
            this.show = true
        },
        destroy(item) {
            axios.post('api/places/' + item.id, { _method: 'delete' }, {
                headers: {
                    'Authorization': `Bearer ${this.Utils.token()}`
                }
            }).then((response) => {
                for (let i in this.places) {
                    if (this.places[i].id == item.id) {
                        this.places.splice(i, 1)
                        this.Utils.notify('Se ha eliminado correctamente el lugar')
                        break
                    }
                }
            }).catch((error) => {
                this.Utils.error(error.response)
            })
        },
        send(e) {
            const data = new FormData(e.target)
            this.Utils.lock(e.target)
            data.append('_method', this.place.id == undefined ? 'post' : 'put');
            axios.post(this.place.id == undefined ? 'api/places' : `api/places/${this.place.id}`, data, {
                headers: {
                    'Authorization': `Bearer ${this.Utils.token()}`
                }
            }).then((response) => {
                if (this.place.id == undefined) {
                    this.places.unshift(response.data.data)
                    this.Utils.notify('Se ha creado correctamente el lugar')
                } else {
                    for (let i in this.places) {
                        if (this.places[i].id == this.place.id) {
                            this.places[i] = response.data.data
                            this.Utils.notify('Se han actualizado correctamente los datos del lugar')
                            break
                        }
                    }
                }
                this.place = {}
                this.socialmedias = [{}]
                this.files = [{ type: 'link' }]
                this.show = false
                this.Utils.unlock(e.target)
            }).catch((error) => {
                this.Utils.unlock(e.target)
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
        }
    },
    mounted() {
        axios.get('api/countries', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.countries = response.data.data;
            this.setCities(this.countries[0].code)
        }).catch((error) => {
            this.Utils.error(error.response)
        })
        axios.get('api/places', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.places = response.data.data
        }).catch((error) => {
            this.Utils.error(error.response)
        })
        axios.get('api/agencies', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.agencies = response.data.data
        }).catch((error) => {
            this.Utils.error(error.response)
        })
        axios.get('api/typeplaces', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.types = response.data.data
        }).catch((error) => {
            this.Utils.error(error.response)
        })

    }
}
</script>
<template>
    <section class="p-4">
        <div class="relative">
            <div class="flex">
                <h1
                    class="font-bold bg-gradient-to-tr w-full from-slate-500 to-black text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black">
                    LUGARES</h1>
                <div></div>
                <div class="flex items-center rounded border border-gray-400 px-2 me-2">
                    <i class="bi bi-funnel-fill text-gray-400"></i>
                    <input v-model="filter" type="text" placeholder="Escribe para filtrar"
                        class="bg-transparent w-full text-gray-700 text-sm border-none focus:outline-none px-3 py-2">
                </div>
                <button @click="add"
                    class="px-2 py-1 text-white bg-gradient-to-tr from-slate-800 to-slate-950 rounded">Añadir</button>
            </div>
            <div class="mt-4 grid sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-3 gap-3">
                <template v-for="item in places">
                    <PlaceItem @edit="edit" @destroy="destroy" :place="item" v-if="Utils.filter(['name', 'email', 'phone', 'extra_phone', 'address', 'manager', 'notes', 'agency.tradename', 'agency.taxname', 'city.name', 'typeplace.description'], item, filter)" />
                </template>
            </div>
        </div>
        <transition name="bounce" mode="out-in">
            <div v-if="show"
                class="w-full bg-white bg-opacity-90 left-0 h-screen md:h-auto absolute top-0 px-2 py-2 flex justify-center items-center">
                <div>
                    <h1
                        class="font-bold bg-gradient-to-tr from-slate-500 text-center to-black text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black mb-2">
                        <template v-if="place.id == undefined">
                            AÑADIR
                        </template>
                        <template v-else>
                            EDITAR
                        </template>
                    </h1>
                    <form @submit.prevent="send"
                        class="bg-gradient-to-tr from-slate-700 via-black to-slate-950 rounded-3xl rounded-tr p-10 overflow-auto scroll">
                        <div v-if="Utils.role() != 'agency' && place.id == undefined">
                            <label class="text-slate-200 text-xs font-semibold">Agencia</label>
                            <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                <select v-model="place.agency_id" name="agency_id"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                    <option class="text-black" v-for="item in agencies" :value="item.id">{{
                                        item.taxname
                                    }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-x-2">
                            <div>
                                <label class="text-slate-200 text-xs font-semibold">Nombre del lugar</label>
                                <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                    <i class="bi bi-globe text-gray-100"></i>
                                    <input v-model="place.name" name="name" type="text" placeholder="Nombre del lugar"
                                        class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                </div>
                            </div>
                            <div>
                                <label class="text-slate-200 text-xs font-semibold">Manager</label>
                                <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                    <i class="bi bi-person text-gray-100"></i>
                                    <input v-model="place.manager" name="manager" type="text" placeholder="Manager"
                                        class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-x-2">
                            <div>
                                <label class="text-slate-200 text-xs font-semibold">Teléfono principal</label>
                                <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                    <i class="bi bi-telephone text-gray-100"></i>
                                    <input v-model="place.phone" name="phone" type="tel" placeholder="Teléfono principal"
                                        class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                </div>
                            </div>
                            <div>
                                <label class="text-slate-200 text-xs font-semibold">Teléfono secundario</label>
                                <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                    <i class="bi bi-telephone text-gray-100"></i>
                                    <input v-model="place.extra_phone" name="extra_phone" type="tel"
                                        placeholder="Teléfono secundario"
                                        class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-x-2">
                            <div>
                                <label class="text-slate-200 text-xs font-semibold">Correo electrónico</label>
                                <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                    <i class="bi bi-envelope text-gray-100"></i>
                                    <input v-model="place.email" name="email" type="email" placeholder="Correo electrónico"
                                        class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                </div>
                            </div>
                            <div>
                                <label class="text-slate-200 text-xs font-semibold">Tipo de lugar</label>
                                <div class="flex items-center rounded border border-gray-300 px-2">
                                    <select v-model="place.typeplace_id" name="typeplace_id"
                                        class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                        <option class="text-black" v-for="type in types" :value="type.id">{{
                                            type.description
                                        }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-x-2">
                            <div>
                                <label class="text-slate-200 text-xs font-semibold">Link de Google Maps</label>
                                <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                    <i class="bi bi-telephone text-gray-100"></i>
                                    <input v-model="place.google_id" name="google_id" type="text"
                                        placeholder="Link de Google Maps"
                                        class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                </div>
                            </div>
                            <div>
                                <label class="text-slate-200 text-xs font-semibold">Coordenadas</label>
                                <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                    <i class="bi bi-telephone text-gray-100"></i>
                                    <input v-model="place.gis" name="gis" type="text" placeholder="Coordenadas"
                                        class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-x-2">
                            <div>
                                <label class="text-slate-200 text-xs font-semibold">País</label>
                                <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                    <i class="bi bi-globe text-gray-100"></i>
                                    <select v-model="country_id" @change="(e) => setCities(e.target.value)"
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
                                    <select v-model="place.city_id" name="city_id"
                                        class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                        <option class="text-black" v-for="city in cities" :value="city.id">{{ city.name }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="text-slate-200 text-xs font-semibold">Dirección</label>
                            <div class="flex items-center mb-3 rounded border border-gray-300 px-1 py-1">
                                <textarea rows="3" v-model="place.address" name="address" placeholder="Dirección"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-1 py-1"></textarea>
                            </div>
                        </div>
                        <div>
                            <label class="text-slate-200 text-xs font-semibold">Datos adicionales</label>
                            <div class="flex items-center mb-3 rounded border border-gray-300 px-1 py-1">
                                <textarea rows="3" v-model="place.notes" name="notes" placeholder="Datos adicionales"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-1 py-1"></textarea>
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
                                        <input v-model="socialmedia.description"
                                            :name="`socialmedias[${index}][description]`" type="text"
                                            placeholder="Descripción"
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
                                <template v-if="place.id == undefined">
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
        </transition>
    </section>
</template>
<style scoped>
h1 {
    font-family: 'Archivo Black', sans-serif;
}

form,
.container {
    max-height: calc(100vh - 7.5rem);
}
</style>
