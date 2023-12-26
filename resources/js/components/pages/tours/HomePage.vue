<script>
import axios from 'axios';
import TourCard from './TourCard.vue';
import Confirm from '../../modals/Confirm';

export default {
    components: { TourCard },
    data() {
        return {
            filter: '',
            tours: [],
            tour: {},
            artists: [],
            agencies: [],
            socialmedias: [{}],
            files: [{ type: 'link' }],
            preview: 'src/cartel-placeholder.jpeg',
            show: false,
            active: 0,
        };
    },
    methods: {
        add() {
            this.tour = {}
            this.socialmedias = [{}]
            this.preview = 'src/cartel-placeholder.jpeg'
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
            this.preview = item.tourcartel.replace('http://localhost/', '')
            this.show = true
        },
        destroy(item) {
            const confirm = new Confirm('¡Confirmar operación!', '¿Seguro que desea eliminar esta gira?')
            confirm.fire().then((result) => {
                axios.post('api/tours/' + item.id, { _method: 'delete' }, {
                    headers: {
                        'Authorization': `Bearer ${this.Utils.token()}`
                    }
                }).then((response) => {
                    for (let i in this.tours) {
                        if (this.tours[i].id == item.id) {
                            this.tours.splice(i, 1)
                            this.Utils.notify('Se ha eliminado correctamente la gira')
                            break
                        }
                    }
                })
            })
        },
        complete(item) {
            const confirm = new Confirm('¡Confirmar operación!', '¿Seguro que desea completar esta gira?')
            confirm.fire().then((result) => {
                axios.post('api/tour/noactive', { id: item.id }, {
                    headers: {
                        'Authorization': `Bearer ${this.Utils.token()}`
                    }
                }).then((response) => {
                    for (let i in this.tours) {
                        if (this.tours[i].id == item.id) {
                            // this.tours.splice(i, 1)
                            this.tours[i].active = 0;
                            this.Utils.notify('Se ha completado correctamente la gira')
                            break
                        }
                    }
                })
            })
        },
        send(e) {
            const data = new FormData(e.target)
            this.Utils.lock(e.target)
            data.append('_method', this.tour.id == undefined ? 'post' : 'put');
            axios.post(this.tour.id == undefined ? 'api/tours' : `api/tours/${this.tour.id}`, data, {
                headers: {
                    'Authorization': `Bearer ${this.Utils.token()}`
                }
            }).then((response) => {
                if (this.tour.id == undefined) {
                    this.tours.unshift(response.data.data)
                    this.Utils.notify('Se ha creado correctamente la gira')
                } else {
                    for (let i in this.tours) {
                        if (this.tours[i].id == this.tour.id) {
                            this.tours[i] = response.data.data
                            this.Utils.notify('Se han actualizado correctamente los datos de la gira')
                            break
                        }
                    }
                }
                this.tour = {}
                this.socialmedias = [{}]
                this.files = [{ type: 'link' }]
                this.show = false
                this.Utils.unlock(e.target)
            }).catch((error) => {
                this.Utils.unlock(e.target)
                this.Utils.error(error.response)
            })
        },
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
        axios.get('api/tours', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.tours = response.data.data
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
    }
}
</script>
<template>
    <section class="p-4">
        <div class="relative">
            <div class="flex">
                <h1
                    class="font-bold bg-gradient-to-tr w-full from-slate-500 to-black text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black">
                    GIRAS</h1>
                <div class="form-check items-center">
                    <input required aria-label="Ver giras terminadas" @change="(e) => active = e.target.checked ? 1 : 0"
                        class="form-check-input me-0.5" type="checkbox" />
                    <label class="form-check-label leading-4 text-sm text-center">
                        Ver giras terminadas
                    </label>
                </div>
                <div class="flex items-center rounded border border-gray-400 px-2 me-2">
                    <i class="bi bi-funnel-fill text-gray-400"></i>
                    <input v-model="filter" type="text" placeholder="Escribe para filtrar"
                        class="bg-transparent w-full text-gray-700 text-sm border-none focus:outline-none px-3 py-2">
                </div>
                <button @click="add"
                    class="px-2 py-1 text-white bg-gradient-to-tr from-slate-800 to-slate-950 rounded">Añadir</button>
            </div>
            <div class="mt-4 grid sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-3">
                <template v-for="item in tours">
                    <TourCard @edit="edit" @destroy="destroy" @complete="complete" :tour="item"
                        v-if="Utils.filter(['tourname', 'startdate', 'enddate', 'notes', 'agency.tradename', 'agency.taxname', 'artist.name', 'artist.lastname', 'artist.stagename'], item, filter) && (item.active == 1 || active == 1)" />
                </template>
            </div>
        </div>
        <transition name="bounce" mode="out-in">
            <div v-if="show"
                class="w-full bg-white bg-opacity-90 h-screen md:h-auto absolute left-0 top-0 px-2 py-2 flex justify-center items-center">
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
                        <input @change="updatePreview" type="file" class="opacity-5 w-1 h-1" name="tourcartel"
                            :required="tour.id == undefined" />
                        <label class="text-slate-200 text-xs font-semibold">Cartel de la gira</label>
                        <div class="text-center relative">
                            <div @click="$el.querySelector('[type=file]').click()"
                                :style="{ 'background': `url(${preview})` }"
                                class="w-full h-[15rem] cursor-pointer bg-cover bg-center rounded z-50">
                            </div>
                            <label v-if="preview == 'src/cartel-placeholder.jpeg'"
                                class="text-center text-gray-300 mt-2 mx-auto">Imagen obligatoria</label>
                        </div>
                        <div>
                            <label class="text-slate-200 text-xs font-semibold">Nombre de la gira</label>
                            <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                <i class="bi bi-envelope text-gray-100"></i>
                                <input required v-model="tour.tourname" name="tourname" type="text"
                                    placeholder="Nombre de la gira"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                            </div>
                        </div>
                        <div>
                            <label class="text-slate-200 text-xs font-semibold">Descripción</label>
                            <div class="flex items-center mb-3 rounded border border-gray-300 px-1 py-1">
                                <textarea required rows="3" v-model="tour.notes" name="notes"
                                    placeholder="Datos adicionales"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-1 py-1"></textarea>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-x-2">
                            <div v-if="Utils.role() == 'user' && tour.id == undefined">
                                <label class="text-slate-200 text-xs font-semibold">Agencia</label>
                                <div class="flex items-center rounded border border-gray-300 px-2">
                                    <select required v-model="tour.agency_id" name="agency_id"
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
                                <label class="text-slate-200 text-xs font-semibold">Fecha de inicio</label>
                                <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                    <i class="bi bi-calendar-day text-gray-100"></i>
                                    <input required v-model="tour.startdate" name="startdate" type="date"
                                        placeholder="Fecha de inicio"
                                        class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-[0.65rem]">
                                </div>
                            </div>
                            <div>
                                <label class="text-slate-200 text-xs font-semibold">Fecha de fin</label>
                                <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                    <i class="bi bi-calendar-day text-gray-100"></i>
                                    <input required v-model="tour.enddate" name="enddate" type="date"
                                        placeholder="Fecha de fin"
                                        class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                </div>
                            </div>
                        </div>
                        <label class="text-slate-200 text-xs font-semibold">Listas de reproducción</label>
                        <div class="grid grid-cols-2 gap-x-2">
                            <div>
                                <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                    <i class="bi bi-spotify text-gray-100"></i>
                                    <input required v-model="tour.spotify_list" name="spotify_list" type="text"
                                        placeholder="Spotify"
                                        class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                </div>
                            </div>
                            <div>
                                <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                    <i class="bi bi-youtube text-gray-100"></i>
                                    <input required v-model="tour.youtube_list" name="youtube_list" type="text"
                                        placeholder="Youtube"
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
