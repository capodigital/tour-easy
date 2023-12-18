<script>
import axios from 'axios'
import PersonalItem from '../PersonalItem.vue'

export default {
    data() {
        return {
            contacts: [],
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
            documents: new FormData(),
        };
    },
    methods: {
        setCities(country) {
            axios.post('api/cities', { code: country }).then((response) => {
                this.cities = response.data;
            });
        },
        add(file) {
            // const exist = this.documents.get('documents');
            // this.documents.append('documents', [...exist, file.files[0]]);
        },
        send(e) {
            const data = new FormData(e.target)
            data.append('notify', 0);
            data.append('documents', this.documents.get('documents'))
            axios.post('api/contacts', data).then((response) => {
                console.log(response)
            })
        }
    },
    created() {
        axios.get('api/contacts').then((response) => {
            this.contacts = response.data.data;
        });
        axios.get('api/countries').then((response) => {
            this.countries = response.data.data;
            this.setCities(this.countries[0].code)
        });
        axios.get('src/languages.json').then((response) => {
            this.languages = response.data;
        });
    },
    mounted() {
        // this.documents = this.$el.querySelector('.invisible')
    },
    components: { PersonalItem }
}
</script>
<template>
    <div class="flex justify-center py-1">
        <div class="w-full md:w-2/3 px-2">
            <div class="flex justify-center">
                <div>
                    <h1
                        class="font-bold bg-gradient-to-tr from-slate-500 to-black text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black mb-2">
                        PERSONAL DE LA AGENCIA
                    </h1>
                    <PersonalItem v-for="contact in contacts" :contact="contact" />
                </div>
            </div>
        </div>
        <div class="hidden md:block md:w-1/3 px-2">
            <h1 class="text-center text-2xl mb-4 text-gray-700 font-semibold">Añadir</h1>
            <form @submit.prevent="send"
                class="bg-gradient-to-tr from-slate-700 via-black to-slate-950 rounded-3xl rounded-tr p-10">
                <div class="grid grid-cols-2 gap-x-2">
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Nombre(s)</label>
                        <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                            <i class="bi bi-person text-gray-100"></i>
                            <input name="name" type="text" placeholder="Nombre(s)"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                        </div>
                    </div>
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Apellidos</label>
                        <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                            <i class="bi bi-person text-gray-100"></i>
                            <input name="lastname" type="text" placeholder="Apellidos"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-x-2">
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Correo electrónico</label>
                        <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                            <i class="bi bi-envelope text-gray-100"></i>
                            <input name="email" type="email" placeholder="Correo electrónico"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                        </div>
                    </div>
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Fecha de nacimiento</label>
                        <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                            <i class="bi bi-calendar-day text-gray-100"></i>
                            <input name="birthday" type="date" placeholder="Fecha de nacimiento"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-[0.65rem]">
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-x-2">
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Teléfono principal</label>
                        <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                            <i class="bi bi-telephone text-gray-100"></i>
                            <input name="phone" type="tel" placeholder="Teléfono principal"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                        </div>
                    </div>
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Teléfono secundario</label>
                        <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                            <i class="bi bi-telephone text-gray-100"></i>
                            <input name="extra_phone" type="tel" placeholder="Teléfono secundario"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-x-2">
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Profesión</label>
                        <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                            <i class="bi bi-person-vcard text-gray-100"></i>
                            <select name="typecontact_id"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                <option class="text-black" v-for="type in types" :value="type.id">{{ type.description }}</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Idioma</label>
                        <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                            <i class="bi bi-translate text-gray-100"></i>
                            <select name="lang"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                <option class="text-black" v-for="language in languages" :value="language.name">{{ language.name }}</option>
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
                                <option class="text-black" v-for="country in countries" :value="country.code">{{ country.name }}</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Ciudad</label>
                        <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                            <i class="bi bi-globe-americas text-gray-100"></i>
                            <select @change="setCities" name="city_id"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                <option class="text-black" v-for="city in cities" :value="city.id">{{ city.name }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="text-slate-200 text-xs font-semibold">Datos adicionales</label>
                    <div class="flex items-center mb-3 rounded border border-gray-300 px-1 py-1">
                        <textarea name="notes" placeholder="Datos adicionales"
                            class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-1 py-1"></textarea>
                    </div>
                </div>
                <div>
                    <label class="text-slate-200 text-xs font-semibold">Posición</label>
                    <div class="flex items-center mb-3 rounded border border-gray-300 px-1 py-1">
                        <textarea name="position" placeholder="Posición"
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
                                <select :name="`socialmedias[${index}][typeredes_id]`"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                    <option class="text-black" v-for="type in socialtypes" :value="type.id">{{ type.name }}</option>
                                </select>
                            </div>
                            <div class="flex items-center rounded border border-gray-300 px-2">
                                <input :name="`socialmedias[${index}][url]`" type="text" placeholder="Link"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                            </div>
                            <div class="flex items-center rounded border border-gray-300 px-2">
                                <input :name="`socialmedias[${index}][description]`" type="text" placeholder="Descripción"
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
                                    <option class="text-black" value="document">Local</option>
                                </select>
                            </div>
                            <div class="flex items-center rounded border border-gray-300 px-2" style="grid-column: span 2;">
                                <input :name="`urls[${index}]`" v-model="file.link" v-if="file.type == 'link'" type="text" placeholder="Link"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                <input @change="(e) => add(e.target)" :name="`documents[${index}]`" v-else type="file"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                            </div>
                        </template>
                    </div>
                </div>
                <button type="submit"
                    class="mt-8 overlay-button bg-gradient-to-tr from-slate-100 to-slate-300 text-black px-3 py-3 w-full rounded-xl rounded-tr">Agregar</button>
            </form>
        </div>
    </div>
</template>
<style scoped>
h1 {
    font-family: 'Archivo Black', sans-serif;
}
</style>
