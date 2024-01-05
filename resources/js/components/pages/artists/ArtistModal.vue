<script>
import CustomModal from '../../common/CustomModal.vue';
import axios from 'axios';

export default {
    components: { CustomModal },
    props: {
        artist: Object,
    },
    data() {
        return {
            types: [],
            socialtypes: [],
            socialmedias: [{}],
            tags: [],
            files: [{ type: 'link' }],
            preview: 'src/user_placeholder.png',
            same_password: true,
            password_id: null,
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
        addTag(e) {
            if (e.key === "Enter") {
                e.preventDefault()
                this.tags.push(e.target.value)
                e.target.value = ''
            } else if (e.key == "Backspace") {
                if (e.target.value == '') {
                    this.tags.pop();
                }
            }
        },
        removeDocument(index) {
            const confirm = new Confirm('¡Confirmar operación!', '¿Seguro que desea eliminar este artista?')
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
        comparePasswords() {
            if (this.artist.confirm_password != '' && this.artist.confirm_password != undefined) {
                if (this.artist.password != this.artist.confirm_password) {
                    this.same_password = false
                    console.log('n o son iguales')
                    return
                }
            }
            this.same_password = true
        },
    },
    created() {
        if (this.artist.id != undefined) {
            this.socialmedias = this.artist.socialmedias
            this.files = []
            for (let document of this.artist.documents) {
                document.type = document.url == null ? 'local' : 'link'
                this.files.push(document)
            }
            this.tags = this.artist.tags
            this.preview = this.artist.image.replace('http://localhost/', '')
        }
        axios.get('api/agencies', {
            headers: {
                Authorization: `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.agencies = response.data.data;
        });
        axios.get('api/typeredes', {
            headers: {
                Authorization: `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.socialtypes = response.data.data;
        });
        axios.get('api/typecontacts', {
            headers: {
                Authorization: `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.types = response.data.data;
        });
    },
}
</script>
<template>
    <CustomModal @close="$emit('close')">
        <form @submit.prevent="(e) => $emit('send', e)"
            class="bg-gradient-to-tr from-slate-700 to-slate-950 rounded-2xl shadow-md shadow-gray-500 p-4 overflow-auto transition-all cursor-pointer">
            <h1
                class="font-bold bg-gradient-to-tr from-slate-200 text-center to-slate-500 text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black mb-2">
                <template v-if="artist.id == undefined">
                    AÑADIR ARTISTA
                </template>
                <template v-else>
                    EDITAR ARTISTA
                </template>
            </h1>
            <div class="overflow-auto modal-content">
                <div class="grid grid-cols-2 gap-2">
                    <div class="flex items-center justify-center">
                        <input @change="updatePreview" type="file" class="opacity-5 w-1 h-1" name="image"
                            :required="artist.id == undefined" />
                        <div class="text-center">
                            <img @click="$el.querySelector('[type=file]').click()" id="preview" :src="preview"
                                class="rounded-full w-52 h-52 cursor-pointer mb-3" />
                            <label v-if="preview == 'src/user_placeholder.png'"
                                class="text-center text-gray-300 mt-2 mx-auto">Imagen obligatoria</label>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-x-2">
                        <div v-if="Utils.role() != 'agency' && artist.id == undefined">
                            <label class="text-slate-200 text-xs font-semibold">Agencia</label>
                            <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                <select required v-model="artist.agency_id" name="agency_id"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                    <option class="text-black" v-for="item in agencies" :value="item.id">{{
                                        item.taxname
                                    }}</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="text-slate-200 text-xs font-semibold">Nombre(s)</label>
                            <div class="flex items-center mb-1 rounded border border-gray-300 px-2">
                                <i class="bi bi-person text-gray-100"></i>
                                <input required v-model="artist.name" name="name" type="text" placeholder="Nombre(s)"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                            </div>
                        </div>
                        <div>
                            <label class="text-slate-200 text-xs font-semibold">Apellidos</label>
                            <div class="flex items-center mb-1 rounded border border-gray-300 px-2">
                                <i class="bi bi-person text-gray-100"></i>
                                <input required v-model="artist.lastname" name="lastname" type="text"
                                    placeholder="Apellidos"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                            </div>
                        </div>
                        <div>
                            <label class="text-slate-200 text-xs font-semibold">Nombre artístico</label>
                            <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                <i class="bi bi-mic-fill text-gray-100"></i>
                                <input required v-model="artist.stagename" name="stagename" type="text"
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
                            <input required v-model="artist.email" name="email" type="email"
                                placeholder="Correo electrónico"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                        </div>
                    </div>
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Fecha de nacimiento</label>
                        <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                            <i class="bi bi-calendar-day text-gray-100"></i>
                            <input required v-model="artist.birthday" name="birthday" type="date"
                                placeholder="Fecha de nacimiento"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-[0.65rem]">
                        </div>
                    </div>
                </div>
                <div v-if="artist.id == undefined" class="grid grid-cols-2 gap-x-2">
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Contraseña</label>
                        <div class="flex items-center mb-1 rounded border border-gray-300 px-2">
                            <i class="bi bi-key text-gray-100"></i>
                            <input @input="comparePasswords" v-model="artist.password" required name="password"
                                type="password" placeholder="Contraseña"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                        </div>
                    </div>
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Confirmar Contraseña</label>
                        <div class="flex items-center mb-1 rounded border border-gray-300 px-2">
                            <i class="bi bi-key text-gray-100"></i>
                            <input @input="comparePasswords" v-model="artist.confirm_password" required
                                name="confirm_password" type="password" placeholder="Confirmar contraseña"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                        </div>
                    </div>
                    <small v-if="!same_password" class="text-center text-gray-300 col-start-1 col-end-3 mt-1">Las
                        contraseñas no coinciden</small>
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
                    <div class="mt-1 grid grid-cols-3 gap-2 mb-2">
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
                    <label class="text-slate-200 text-xs font-semibold mt-5">Etiquetas</label>
                    <div class="w-full mt-1 rounded border border-gray-300 p-2 whitespace-pre-wrap">
                        <span @click="tags.splice(index, 1)" v-for="(tag, index) in tags"
                            class="text-sm cursor-pointer me-1 text-black bg-gray-300 rounded px-2 py-1">{{ tag }}
                            <i class="bi bi-x"></i></span>
                        <input @keydown="addTag"
                            class="bg-transparent text-gray-300 focus:outline-none outline-none border-none" />
                    </div>
                </div>
                <input type="hidden" name="tags" :value="tags.join(', ')" />
            </div>
            <div class="flex justify-center">
                <button type="button" @click="$emit('close')"
                    class="mt-8 me-2 close overlay-button bg-gradient-to-tr from-slate-100 to-slate-300 text-black px-3 py-3 w-full rounded-xl rounded-tr">
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
    </CustomModal>
</template>
