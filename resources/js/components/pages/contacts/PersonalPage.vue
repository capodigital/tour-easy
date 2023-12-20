<script>
import axios from 'axios'
import PersonalItem from './PersonalItem.vue'

export default {
    data() {
        return {
            contacts: [],
            contact: {},
            types: [
                { "id": "1", "description": "Artista" },
                { "id": "2", "description": "Manager" },
                { "id": "3", "description": "Promotor" },
                { "id": "4", "description": "Chofer" },
                { "id": "5", "description": "Crew" },
                { "id": "6", "description": "Tech" }
            ],
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
            cities: [],
            languages: [],
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
        send(e) {
            const data = new FormData(e.target)
            data.append('notify', 0);
            data.append('_method', this.contact.id == undefined ? 'post' : 'put');
            axios.post(this.contact.id == undefined ? 'api/contacts' : `api/contacts/${this.contact.id}`, data, {
                headers: {
                    'Authorization': `Bearer ${this.Utils.token()}`
                }
            }).then((response) => {
                if (this.contact.id == undefined) {
                    this.contacts.unshift(response.data.data)
                } else {
                    for (let i in this.contacts) {
                        if (this.contacts[i].id == this.contact.id) {
                            this.contacts[i] = response.data.data
                            break
                        }
                    }
                }
                this.tour = {}
                this.socialmedias = [{}]
                this.files = [{ type: 'link' }]
                this.show = false
            })
        },
        add() {
            this.contact = {}
            this.socialmedias = [{}]
            this.files = [{ type: 'link' }]
            this.show = true
        },
        edit(item) {
            Object.assign(this.contact, item)
            this.socialmedias = this.contact.socialmedias
            this.files = []
            for (let document of this.contact.documents) {
                document.type = document.url == null ? 'local' : 'link'
                this.files.push(document)
            }
            this.show = true
        },
        destroy(item) {
            axios.post('api/contacts/' + item.id, { _method: 'delete' }, {
                headers: {
                    'Authorization': `Bearer ${this.Utils.token()}`
                }
            }).then((response) => {
                for (let i in this.contacts) {
                    if (this.contacts[i].id == item.id) {
                        this.contacts.splice(i, 1)
                        break
                    }
                }
            })
        }
    },
    created() {
        axios.get('api/contacts',{headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }}).then((response) => {
            this.contacts = response.data.data;
        });
        axios.get('api/countries',{headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }}).then((response) => {
            this.countries = response.data.data;
            this.setCities(this.countries[0].code)
        });
        axios.get('src/languages.json',{headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }}).then((response) => {
            this.languages = response.data;
        });
    },
    components: { PersonalItem }
}
</script>
<template>
    <div class="flex justify-center py-1">
        <div class="w-full md:w-2/3 px-2">
            <div class="flex justify-center">
                <div>
                    <div class="flex mb-1">
                        <h1
                            class="font-bold w-full bg-gradient-to-tr from-slate-500 to-black text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black mb-2">
                            PERSONAL DE LA AGENCIA
                        </h1>
                        <button @click="add"
                            class="float-right sm:hidden bg-gradient-to-tr from-slate-800 to-slate-950 text-white px-2 py-1 rounded">Añadir</button>
                    </div>
                    <div class="container overflow-auto scroll">
                        <PersonalItem @edit="edit" @destroy="destroy" v-for="contact in contacts" :contact="contact" />
                    </div>
                </div>
            </div>
        </div>
        <div :class="{ hidden: !show }"
            class="w-full bg-white bg-opacity-90 md:bg-transparent h-screen md:h-auto absolute md:relative top-0 md:block md:w-1/3 px-2 flex justify-center items-center">
            <div>
                <h1
                    class="font-bold bg-gradient-to-tr from-slate-500 text-center to-black text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black mb-2">
                    <template v-if="contact.id == undefined">
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
                            <label class="text-slate-200 text-xs font-semibold">Nombre(s)</label>
                            <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                <i class="bi bi-person text-gray-100"></i>
                                <input v-model="contact.name" name="name" type="text" placeholder="Nombre(s)"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                            </div>
                        </div>
                        <div>
                            <label class="text-slate-200 text-xs font-semibold">Apellidos</label>
                            <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                <i class="bi bi-person text-gray-100"></i>
                                <input v-model="contact.lastname" name="lastname" type="text" placeholder="Apellidos"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-x-2">
                        <div>
                            <label class="text-slate-200 text-xs font-semibold">Correo electrónico</label>
                            <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                <i class="bi bi-envelope text-gray-100"></i>
                                <input v-model="contact.email" name="email" type="email" placeholder="Correo electrónico"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                            </div>
                        </div>
                        <div>
                            <label class="text-slate-200 text-xs font-semibold">Fecha de nacimiento</label>
                            <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                <i class="bi bi-calendar-day text-gray-100"></i>
                                <input v-model="contact.birthday" name="birthday" type="date"
                                    placeholder="Fecha de nacimiento"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-[0.65rem]">
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-x-2">
                        <div>
                            <label class="text-slate-200 text-xs font-semibold">Teléfono principal</label>
                            <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                <i class="bi bi-telephone text-gray-100"></i>
                                <input v-model="contact.phone" name="phone" type="tel" placeholder="Teléfono principal"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                            </div>
                        </div>
                        <div>
                            <label class="text-slate-200 text-xs font-semibold">Teléfono secundario</label>
                            <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                <i class="bi bi-telephone text-gray-100"></i>
                                <input v-model="contact.extra_phone" name="extra_phone" type="tel"
                                    placeholder="Teléfono secundario"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-x-2">
                        <div>
                            <label class="text-slate-200 text-xs font-semibold">Profesión</label>
                            <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                <i class="bi bi-person-vcard text-gray-100"></i>
                                <select v-model="contact.typecontact_id" name="typecontact_id"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                    <option class="text-black" v-for="type in types" :value="type.id">{{ type.description }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="text-slate-200 text-xs font-semibold">Idioma</label>
                            <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                <i class="bi bi-translate text-gray-100"></i>
                                <select v-model="contact.lang" name="lang"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                    <option class="text-black" v-for="language in languages" :value="language.name">{{
                                        language.name }}
                                    </option>
                                </select>
                            </div>
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
                                <select v-model="contact.city_id" @change="setCities" name="city_id"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                    <option class="text-black" v-for="city in cities" :value="city.id">{{ city.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Datos adicionales</label>
                        <div class="flex items-center mb-3 rounded border border-gray-300 px-1 py-1">
                            <textarea v-model="contact.notes" name="notes" placeholder="Datos adicionales"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-1 py-1"></textarea>
                        </div>
                    </div>
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Posición</label>
                        <div class="flex items-center mb-3 rounded border border-gray-300 px-1 py-1">
                            <textarea name="position" v-model="contact.position" placeholder="Posición"
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

                                    <button type="button" class="text-white"><i class="bi bi-trash"></i></button>
                                </div>
                            </template>
                        </div>
                    </div>
                    <div class="flex justify-center">
                        <button type="button" @click="show = false"
                            class="mt-8 me-2 md:hidden overlay-button bg-gradient-to-tr from-slate-100 to-slate-300 text-black px-3 py-3 w-full rounded-xl rounded-tr">
                            Cerrar
                        </button>
                        <button type="submit"
                            class="mt-8 overlay-button bg-gradient-to-tr from-slate-100 to-slate-300 text-black px-3 py-3 w-full rounded-xl rounded-tr">
                            <template v-if="contact.id == undefined">
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
    </div>
</template>
<style scoped>
h1 {
    font-family: 'Archivo Black', sans-serif;
}

form,
.container {
    max-height: calc(100vh - 11.5rem);
}
</style>
