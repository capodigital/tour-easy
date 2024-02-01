<script>
import CustomModal from '../../common/CustomModal.vue';
import axios from 'axios';

export default {
    components: { CustomModal },
    props: {
        tour: Object,
    },
    data() {
        return {
            artists: [],
            agencies: [],
            socialmedias: [{}],
            socialtypes: [],
            files: [{ type: 'link' }],
            preview: 'src/cartel-placeholder.jpeg',
        }
    },
    methods: {
        updatePreview(e) {
            const files = e.target.files
            if (files && files.length) {
                this.preview = URL.createObjectURL(files[0])
            } else {
                this.preview = 'src/cartel-placeholder.jpeg'
            }
        }
    },
    created() {
        if (this.tour.id != undefined) {
            this.socialmedias = this.tour.socialmedias
            this.files = []
            for (let document of this.tour.documents) {
                document.type = document.url == null ? 'local' : 'link'
                this.files.push(document)
            }
            this.preview = this.tour.tourcartel.replace('http://localhost/', '')
        }
        axios.get('api/agencies', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.agencies = response.data.data
        }).catch((error) => {
            this.Utils.error(error.response)
        })
        axios.get('api/artists', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.artists = response.data.data
        }).catch((error) => {
            this.Utils.error(error.response)
        })
        axios.get('api/typeredes', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.socialtypes = response.data.data
        }).catch((error) => {
            this.Utils.error(error.response)
        })
    },
}
</script>
<template>
    <CustomModal @close="$emit('close')">
        <form @submit.prevent="(e) => $emit('send', e)"
            class="bg-gradient-to-tr from-app-primary-100 via-white to-app-primary-200 rounded-3xl rounded-tr p-10 overflow-auto scroll">
            <h1
                class="font-bold bg-gradient-to-tr from-app-primary-500 text-center to-app-primary-900 text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black mb-2">
                <template v-if="tour.id == undefined">
                    AÑADIR
                </template>
                <template v-else>
                    EDITAR
                </template>
            </h1>
            <div class="overflow-auto modal-content">
                <input @change="updatePreview" type="file" class="opacity-5 w-1 h-1" name="tourcartel"
                    :required="tour.id == undefined" />
                <label class="text-gray-200 text-xs ">Cartel de la gira</label>
                <div class="text-center relative">
                    <div @click="$el.querySelector('[type=file]').click()" :style="{ 'background': `url(${preview})` }"
                        class="w-full h-[15rem] cursor-pointer bg-cover bg-center rounded z-50">
                    </div>
                    <label v-if="preview == 'src/cartel-placeholder.jpeg'"
                        class="text-center text-gray-600 mt-2 mx-auto">Imagen
                        obligatoria</label>
                </div>
                <div>
                    <label class="text-gray-200 text-xs ">Nombre de la gira</label>
                    <div class="flex items-center mb-3 rounded border border-app-primary-600 px-2">
                        <i class="bi bi-envelope text-app-primary-400"></i>
                        <input required v-model="tour.tourname" name="tourname" type="text" placeholder="Nombre de la gira"
                            class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                    </div>
                </div>
                <div>
                    <label class="text-gray-200 text-xs ">Descripción</label>
                    <div class="flex items-center mb-3 rounded border border-app-primary-600 px-1 py-1">
                        <textarea required rows="3" v-model="tour.notes" name="notes" placeholder="Datos adicionales"
                            class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-1 py-1"></textarea>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-x-2">
                    <div v-if="Utils.role() == 'user' && tour.id == undefined">
                        <label class="text-gray-200 text-xs ">Agencia</label>
                        <div class="flex items-center rounded border border-app-primary-600 px-2">
                            <select required v-model="tour.agency_id" name="agency_id"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                <option class="text-black" v-for="agency in agencies" :value="agency.id">{{
                                    agency.taxname
                                }}</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="text-gray-200 text-xs ">Artista</label>
                        <div class="flex items-center rounded border border-app-primary-600 px-2">
                            <select required v-model="tour.artist_id" name="artist_id"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                <option class="text-black" v-for="artist in artists" :value="artist.id">{{
                                    artist.stagename
                                }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-x-2 my-3">
                    <div>
                        <label class="text-gray-200 text-xs ">Fecha de inicio</label>
                        <div class="flex items-center mb-3 rounded border border-app-primary-600 px-2">
                            <i class="bi bi-calendar-day text-app-primary-400"></i>
                            <input required v-model="tour.startdate" name="startdate" type="date"
                                placeholder="Fecha de inicio"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-[0.65rem]">
                        </div>
                    </div>
                    <div>
                        <label class="text-gray-200 text-xs ">Fecha de fin</label>
                        <div class="flex items-center mb-3 rounded border border-app-primary-600 px-2">
                            <i class="bi bi-calendar-day text-app-primary-400"></i>
                            <input required v-model="tour.enddate" name="enddate" type="date" placeholder="Fecha de fin"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                        </div>
                    </div>
                </div>
                <label class="text-gray-200 text-xs ">Listas de reproducción</label>
                <div class="grid grid-cols-2 gap-x-2">
                    <div>
                        <div class="flex items-center mb-3 rounded border border-app-primary-600 px-2">
                            <i class="bi bi-spotify text-app-primary-400"></i>
                            <input required v-model="tour.spotify_list" name="spotify_list" type="text"
                                placeholder="Spotify"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center mb-3 rounded border border-app-primary-600 px-2">
                            <i class="bi bi-youtube text-app-primary-400"></i>
                            <input required v-model="tour.youtube_list" name="youtube_list" type="text"
                                placeholder="Youtube"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-[0.65rem]">
                        </div>
                    </div>
                </div>
                <div>
                    <button @click="socialmedias.push({})"
                        class="px-2 py-0.5 float-right rounded text-sm text-app-primary-400 border hover:bg-app-primary-800 hover:text-white transition-all border-app-primary-600"
                        type="button">Añadir</button>
                    <label class="text-gray-200 text-xs ">Redes sociales</label>
                    <div class="mt-1 grid grid-cols-3 gap-2">
                        <template v-for="(socialmedia, index) in socialmedias">
                            <div class="flex items-center rounded border border-app-primary-600 px-2">
                                <select v-model="socialmedia.typesocialmedia_id" :name="`socialmedias[${index}][typesocialmedia_id]`"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                    <option class="text-black" v-for="type in socialtypes" :value="type.id">{{
                                        type.name
                                    }}</option>
                                </select>
                            </div>
                            <div class="flex items-center rounded border border-app-primary-600 px-2">
                                <input v-model="socialmedia.url" :name="`socialmedias[${index}][url]`" type="text"
                                    placeholder="Link"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                            </div>
                            <div class="flex items-center rounded border border-app-primary-600 px-2">
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
                        class="px-2 py-0.5 float-right rounded text-sm text-app-primary-400 border hover:bg-app-primary-800 hover:text-white transition-all border-app-primary-600"
                        type="button">Añadir</button>
                    <label class="text-gray-200 text-xs ">Documentos</label>
                    <div class="mt-1 grid grid-cols-3 gap-2">
                        <template v-for="(file, index) in files">
                            <div class="flex items-center rounded border border-app-primary-600 px-2">
                                <select v-model="file.type"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                    <option class="text-black" value="link">Google Drive</option>
                                    <option class="text-black" value="local">Local</option>
                                </select>
                            </div>
                            <div class="flex items-center rounded border border-app-primary-600 px-2" style="grid-column: span 2;">
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

                                <button type="button" class="text-white"><i class="bi bi-trash"></i></button>
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
                    <template v-if="tour.id == undefined">
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
    background: linear-gradient(138.52deg, rgb(38, 75, 80) 0.44%, rgb(41, 36, 72) 85.15%) !important;
}
</style>
