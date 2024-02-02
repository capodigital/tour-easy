<script>
import CustomModal from '../../common/CustomModal.vue';
import Confirm from '../../modals/Confirm';
import axios from 'axios';

export default {
    components: { CustomModal },
    props: {
        person: Object,
    },
    data() {
        return {
            agencies: [],
            countries: [],
            //cities: [],
            country_id: 'AF',
            languages: [],
            socialmedias: [{}],
            files: [{ type: 'link' }],
        }
    },
    methods: {
        /*setCities(country) {
            axios.post('api/cities', { code: country }, {
                headers: {
                    'Authorization': `Bearer ${this.Utils.token()}`
                }
            }).then((response) => {
                this.cities = response.data;
            });
        },*/
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
        }
    },
    created() {
        if (this.person.id != undefined) {
            this.country_id = this.person.country_id
            this.socialmedias = this.person.socialmedias
            this.files = []
            for (let document of this.person.documents) {
                document.type = document.url == null ? 'local' : 'link'
                this.files.push(document)
            }
        } else {
            this.socialmedias = [{}]
            this.files = [{ type: 'link' }]
        }
        axios.get('api/agencies', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.agencies = response.data.data;
        }).catch((error) => {
            this.Utils.error(error.response)
        });
        axios.get('api/countries', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.countries = response.data.data;
            // this.setCities(this.countries[0].code)
        }).catch((error) => {
            this.Utils.error(error.response)
        });
        axios.get('api/typecontacts', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.types = response.data.data;
        }).catch((error) => {
            this.Utils.error(error.response)
        });
        axios.get('api/typesocialmedias', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.socialtypes = response.data.data;
        }).catch((error) => {
            this.Utils.error(error.response)
        });
        axios.get('src/languages.json', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.languages = response.data;
        }).catch((error) => {
            this.Utils.error(error.response)
        });
    },
}
</script>
<template>
    <CustomModal @close="$emit('close')">
        <form @submit.prevent="(e) => $emit('send', e)"
            class="rounded-2xl shadow-md shadow-gray-800 p-4 overflow-auto transition-all cursor-pointer">
            <input type="hidden" :value="Utils.user().id" name="agency_id" />
            <h1
                class="font-bold bg-gradient-to-tr from-slate-200 text-center to-slate-500 text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black mb-2">
                <template v-if="person.id == undefined">
                    AÑADIR PERSONA
                </template>
                <template v-else>
                    EDITAR PERSONA
                </template>
            </h1>
            <div class="overflow-auto modal-content">
                <div v-if="Utils.role() != 'agency' && person.id == undefined">
                    <label class="text-slate-200 text-xs font-semibold">Agencia</label>
                    <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                        <select required v-model="person.agency_id" name="agency_id"
                            class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                            <option class="text-black" v-for="item in agencies" :value="item.id">{{
                                item.taxname
                            }}</option>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-x-2">
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Nombre(s)</label>
                        <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                            <i class="bi bi-person text-gray-100"></i>
                            <input required v-model="person.name" name="name" type="text" placeholder="Nombre(s)"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                        </div>
                    </div>
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Apellidos</label>
                        <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                            <i class="bi bi-person text-gray-100"></i>
                            <input required v-model="person.lastname" name="lastname" type="text" placeholder="Apellidos"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-x-2">
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Correo electrónico</label>
                        <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                            <i class="bi bi-envelope text-gray-100"></i>
                            <input required v-model="person.email" name="email" type="email"
                                placeholder="Correo electrónico"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                        </div>
                    </div>
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Fecha de nacimiento</label>
                        <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                            <i class="bi bi-calendar-day text-gray-100"></i>
                            <input required v-model="person.birthday" name="birthday" type="date"
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
                            <input required v-model="person.phone" name="phone" type="tel" placeholder="Teléfono principal"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                        </div>
                    </div>
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Teléfono secundario</label>
                        <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                            <i class="bi bi-telephone text-gray-100"></i>
                            <input v-model="person.extra_phone" name="extra_phone" type="tel"
                                placeholder="Teléfono secundario"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-x-2">
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Número de pasaporte</label>
                        <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                            <i class="bi bi-passport text-gray-100"></i>
                            <input required v-model="person.passport" name="passport" type="num"
                                placeholder="Número de pasaporte"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                        </div>
                    </div>
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Fecha de expiración del pasaporte</label>
                        <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                            <i class="bi bi-calendar-date text-gray-100"></i>
                            <input v-model="person.passport_expiry" name="passport_expiry" type="date"
                                placeholder="Fecha de expiración"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-x-2">
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Profesión</label>
                        <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                            <i class="bi bi-person-vcard text-gray-100"></i>
                            <select required v-model="person.typecontact_id" name="typecontact_id"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                <option class="text-black" v-for="type in types" :value="type.id">{{
                                    type.description }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Idioma</label>
                        <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                            <i class="bi bi-translate text-gray-100"></i>
                            <select required v-model="person.lang" name="lang"
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
                        <label class="text-slate-200 text-xs font-semibold">Método de notificación</label>
                        <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                            <i class="bi bi-bell text-gray-100"></i>
                            <select required v-model="person.notify_type" name="notify_type"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                <option class="text-black" value="WhatsApp">WhatsApp</option>
                                <option class="text-black" value="Telegram">Telegram</option>
                                <option class="text-black" value="Correo">Correo</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Grupo</label>
                        <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                            <i class="bi bi-collection text-gray-100"></i>
                            <select required v-model="person.group" name="group"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                <option class="text-black" value="PartyA">Party A</option>
                                <option class="text-black" value="PartyB">Party B</option>
                                <option class="text-black" value="PartyC">Party C</option>
                                <option class="text-black" value="VIP">VIP</option>

                            </select>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-x-2">
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Nacionalidad</label>
                        <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                            <i class="bi bi-globe text-gray-100"></i>
                            <select name="country_id" required v-model="country_id"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                <option class="text-black" v-for="country in countries" :value="country.id">{{
                                    country.name }}</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div>
                    <label class="text-slate-200 text-xs font-semibold">Datos adicionales</label>
                    <div class="flex items-center mb-3 rounded border border-gray-300 px-1 py-1">
                        <textarea v-model="person.notes" name="notes" placeholder="Datos adicionales"
                            class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-1 py-1"></textarea>
                    </div>
                </div>
                <div>
                    <label class="text-slate-200 text-xs font-semibold">Posición</label>
                    <div class="flex items-center mb-3 rounded border border-gray-300 px-1 py-1">
                        <textarea name="position" v-model="person.position" placeholder="Posición"
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
                                <select v-model="socialmedia.typesocialmedia_id"
                                    :name="`socialmedias[${index}][typesocialmedia_id]`"
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
                    <template v-if="person.id == undefined">
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
