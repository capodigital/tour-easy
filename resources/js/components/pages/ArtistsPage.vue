<script>
import axios from 'axios'
import ArtistsItem from '../ArtistsItem.vue'
export default {
    data() {
        return {
            artists: [],
            artist: {},
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
            socialmedias: [{}],
            files: [{ type: 'link' }],
            preview: 'src/user_4.jpg',
            show: false
        };
    },
    methods: {
        add() {
            this.artist = {}
            this.socialmedias = [{}]
            this.files = [{ type: 'link' }]
            this.show = true
        },
        edit(item) {
            Object.assign(this.artist, item)
            this.socialmedias = this.artist.socialmedias
            this.files = []
            for (let document of this.artist.documents) {
                document.type = document.url == null ? 'local' : 'link'
                this.files.push(document)
            }
            this.preview = item.image
            this.show = true
        },
        destroy(item) {
            axios.post('api/artists/' + item.id, { _method: 'delete' }).then((response) => {
                console.log(response)
            })
        },
        send(e) {
            const data = new FormData(e.target)
            data.append('_method', this.artist.id == undefined ? 'post' : 'put');
            axios.post(this.artist.id == undefined ? 'api/artists' : `api/artists/${this.artist.id}`, data).then((response) => {
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
    created() {
        axios.post('api/artists/agency', {
            id: this.Utils.user().id
        }, {
            headers: {
                Authorization: `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.artists = response.data;
        });

    },
    components: { ArtistsItem }
}
</script>
<template>
    <div>
        <div class="flex mb-1 p-2">
            <h1
                class="font-bold w-full bg-gradient-to-tr from-slate-500 to-black text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black mb-2">
                ARTISTAS DE LA AGENCIA
            </h1>
            <button @click="add"
                class="bg-gradient-to-tr from-slate-800 to-slate-950 text-white px-2 py-1 rounded">Añadir</button>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4 p-3">
            <ArtistsItem @edit="edit" @destroy="destroy" :artist="artist" v-for="artist in artists.data" />
        </div>
        <div :class="{ hidden: !show }"
            class="w-full bg-white bg-opacity-90 h-screen md:h-auto absolute top-0 px-2 py-2 flex justify-center items-center">
            <div>
                <h1
                    class="font-bold bg-gradient-to-tr from-slate-500 text-center to-black text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black mb-2">
                    <template v-if="artist.id == undefined">
                        AÑADIR
                    </template>
                    <template v-else>
                        EDITAR
                    </template>
                </h1>
                <form @submit.prevent="send"
                    class="bg-gradient-to-tr from-slate-700 via-black to-slate-950 rounded-3xl rounded-tr p-10 overflow-auto scroll">
                    <input @change="updatePreview" type="file" class="hidden" name="image" :required="artist.id == undefined" />
                    <div class="grid grid-cols-2 gap-2">
                        <img @click="$el.querySelector('[type=file]').click()" id="preview" :src="preview"
                            class="rounded-full w-52 h-52 cursor-pointer" />

                        <div class="grid grid-cols-1 gap-x-2">
                            <div>
                                <label class="text-slate-200 text-xs font-semibold">Nombre(s)</label>
                                <div class="flex items-center mb-1 rounded border border-gray-300 px-2">
                                    <i class="bi bi-person text-gray-100"></i>
                                    <input v-model="artist.name" name="name" type="text" placeholder="Nombre(s)"
                                        class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                </div>
                            </div>
                            <div>
                                <label class="text-slate-200 text-xs font-semibold">Apellidos</label>
                                <div class="flex items-center mb-1 rounded border border-gray-300 px-2">
                                    <i class="bi bi-person text-gray-100"></i>
                                    <input v-model="artist.lastname" name="lastname" type="text" placeholder="Apellidos"
                                        class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                </div>
                            </div>
                            <div>
                                <label class="text-slate-200 text-xs font-semibold">Nombre artístico</label>
                                <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                    <i class="bi bi-mic-fill text-gray-100"></i>
                                    <input v-model="artist.stagename" name="stagename" type="text"
                                        placeholder="Nombre artístico"
                                        class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-x-2">
                        <div>
                            <label class="text-slate-200 text-xs font-semibold">Correo electrónico</label>
                            <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                <i class="bi bi-envelope text-gray-100"></i>
                                <input v-model="artist.email" name="email" type="email" placeholder="Correo electrónico"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                            </div>
                        </div>
                        <div>
                            <label class="text-slate-200 text-xs font-semibold">Fecha de nacimiento</label>
                            <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                <i class="bi bi-calendar-day text-gray-100"></i>
                                <input v-model="artist.birthday" name="birthday" type="date"
                                    placeholder="Fecha de nacimiento"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-[0.65rem]">
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-x-2" v-if="artist.id == undefined">
                        <div>
                            <label class="text-slate-200 text-xs font-semibold">Contraseña</label>
                            <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                <i class="bi bi-envelope text-gray-100"></i>
                                <input name="password" type="password" placeholder="Contraseña"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                            </div>
                        </div>
                        <div>
                            <label class="text-slate-200 text-xs font-semibold">Contraseña</label>
                            <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                <i class="bi bi-envelope text-gray-100"></i>
                                <input name="confirm_password" type="password" placeholder="Confirmar contraseña"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Datos adicionales</label>
                        <div class="flex items-center mb-3 rounded border border-gray-300 px-1 py-1">
                            <textarea v-model="artist.notes" name="notes" placeholder="Datos adicionales"
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
                            class="mt-8 me-2 overlay-button bg-gradient-to-tr from-slate-100 to-slate-300 text-black px-3 py-3 w-full rounded-xl rounded-tr">
                            Cerrar
                        </button>
                        <button type="submit"
                            class="mt-8 overlay-button bg-gradient-to-tr from-slate-100 to-slate-300 text-black px-3 py-3 w-full rounded-xl rounded-tr">
                            <template v-if="artist.id == undefined">
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
    max-height: calc(100vh - 7.5rem);
}
</style>
