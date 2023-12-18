<script>
import axios from 'axios';
import TourCard from '../TourCard.vue';

export default {
    components: { TourCard },
    data() {
        return {
            tours: [],
            tour: {},
            artists: [],
            agencies: [],
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
            preview: 'src/cartel-placeholder.jpeg',
            show: false
        };
    },
    methods: {
        add() {
            this.tour = {}
            this.socialmedias = [{}]
            this.files = [{ type: 'link' }]
            this.show = true
        },
        edit(item) {
            Object.assign(this.tour, item)
            this.socialmedias = this.tour.socialmedias
            this.files = []
            for (let document of this.tour.documents) {
                document.type = document.url == null ? 'local' : 'link'
                this.files.push(document)
            }
            this.preview = item.tourcartel
            this.show = true
        },
        destroy(item) {
            axios.post('api/tours/' + item.id, { _method: 'delete' }).then((response) => {
                console.log(response)
            })
        },
        send(e) {
            const data = new FormData(e.target)
            data.append('_method', this.tour.id == undefined ? 'post' : 'put');
            axios.post(this.tour.id == undefined ? 'api/tours' : `api/tours/${this.tour.id}`, data).then((response) => {
                console.log(response)
            })
        },
        updatePreview(e) {
            const files = e.target.files
            if (files && files.length) {
                this.preview = URL.createObjectURL(files[0])
            } else {
                this.preview = 'src/user_4.jpg'
            }
        }
    },
    mounted() {
        axios.get('api/tours', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.tours = response.data.data
        })
        axios.get('api/agencies', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.agencies = response.data.data
        })
        axios.get('api/artists', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.artists = response.data.data
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
                    GIRAS ACTIVAS</h1>
                <button @click="add"
                    class="px-2 py-1 text-white bg-gradient-to-tr from-slate-800 to-slate-950 rounded z-50">Añadir</button>
            </div>
            <div class="mt-4 grid sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-3">
                <TourCard  @edit="edit" @destroy="destroy" :tour="tour" v-for="tour in tours" />
            </div>
        </div>
        <div :class="{ hidden: !show }"
            class="w-full bg-white bg-opacity-90 h-screen md:h-auto absolute top-0 px-2 py-2 flex justify-center items-center">
            <div>
                <h1
                    class="font-bold bg-gradient-to-tr from-slate-500 text-center to-black text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black mb-2">
                    <template v-if="tour.id == undefined">
                        AÑADIR
                    </template>
                    <template v-else>
                        EDITAR
                    </template>
                </h1>
                <form @submit.prevent="send"
                    class="bg-gradient-to-tr from-slate-700 via-black to-slate-950 rounded-3xl rounded-tr p-10 overflow-auto scroll">
                    <input @change="updatePreview" type="file" class="hidden" name="tourcartel"
                        :required="tour.id == undefined" />
                    <label class="text-slate-200 text-xs font-semibold">Cartel de la gira</label>
                    <img @click="$el.querySelector('[type=file]').click()" id="preview" :src="preview"
                        class="rounded mb-4 w-full h-auto cursor-pointer" />
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Nombre de la gira</label>
                        <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                            <i class="bi bi-envelope text-gray-100"></i>
                            <input v-model="tour.tourname" name="tourname" type="text" placeholder="Nombre de la gira"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                        </div>
                    </div>
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Descripción</label>
                        <div class="flex items-center mb-3 rounded border border-gray-300 px-1 py-1">
                            <textarea rows="3" v-model="tour.notes" name="notes" placeholder="Datos adicionales"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-1 py-1"></textarea>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-x-2">
                        <div>
                            <label class="text-slate-200 text-xs font-semibold">Agencia</label>
                            <div class="flex items-center rounded border border-gray-300 px-2">
                                <select v-model="tour.agency_id" name="agency_id"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                    <option class="text-black" v-for="agency in agencies" :value="agency.id">{{
                                        agency.taxname
                                    }}</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="text-slate-200 text-xs font-semibold">Artista</label>
                            <div class="flex items-center rounded border border-gray-300 px-2">
                                <select v-model="tour.artist_id" name="artist_id"
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
                            <label class="text-slate-200 text-xs font-semibold">Fecha de inicio</label>
                            <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                <i class="bi bi-calendar-day text-gray-100"></i>
                                <input v-model="tour.startdate" name="startdate" type="date" placeholder="Fecha de inicio"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-[0.65rem]">
                            </div>
                        </div>
                        <div>
                            <label class="text-slate-200 text-xs font-semibold">Fecha de fin</label>
                            <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                <i class="bi bi-calendar-day text-gray-100"></i>
                                <input v-model="tour.enddate" name="enddate" type="date" placeholder="Fecha de fin"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                            </div>
                        </div>
                    </div>
                    <label class="text-slate-200 text-xs font-semibold">Listas de reproducción</label>
                    <div class="grid grid-cols-2 gap-x-2">
                        <div>
                            <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                <i class="bi bi-spotify text-gray-100"></i>
                                <input v-model="tour.spotify_list" name="spotify_list" type="text" placeholder="Spotify"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                <i class="bi bi-youtube text-gray-100"></i>
                                <input v-model="tour.youtube_list" name="youtube_list" type="text" placeholder="Youtube"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-[0.65rem]">
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

                                    <button type="button" class="text-white"><i class="bi bi-trash"></i></button>
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
                            <template v-if="tour.id == undefined">
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
h1 {
    font-family: 'Archivo Black', sans-serif;
}

form,
.container {
    max-height: calc(100vh - 7.5rem);
}
</style>
