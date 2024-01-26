<script>
import axios from 'axios'
import PersonalItem from './PersonalItem.vue'
import Confirm from '../../modals/Confirm';
import ContactCard from './ContactCard.vue';

export default {
    data() {
        return {
            filter: '',
            persons: [],
            person: {},
            agencies: [],
            countries: [],
            cities: [],
            country_id: 'AF',
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
            this.Utils.lock(e.target)
            data.append('notify', 0);
            data.append('_method', this.person.id == undefined ? 'post' : 'put');
            axios.post(this.person.id == undefined ? 'api/persons' : `api/persons/${this.person.id}`, data, {
                headers: {
                    'Authorization': `Bearer ${this.Utils.token()}`
                }
            }).then((response) => {
                if (this.person.id == undefined) {
                    this.persons.unshift(response.data.data)
                    this.Utils.notify('Se ha creado correctamente el contacto')
                } else {
                    for (let i in this.persons) {
                        if (this.persons[i].id == this.person.id) {
                            this.persons[i] = response.data.data
                            this.Utils.notify('Se han actualizado correctamente los datos del contacto')
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
        add() {
            this.person = {}
            this.socialmedias = [{}]
            this.files = [{ type: 'link' }]
            this.show = true
        },
        edit(item) {
            this.country_id = item.city.country.code
            this.setCities(item.city.country.code)
            Object.assign(this.person, item)
            this.socialmedias = this.person.socialmedias
            this.files = []
            for (let document of this.person.documents) {
                document.type = document.url == null ? 'local' : 'link'
                this.files.push(document)
            }
            this.show = true
        },
        destroy(item) {
            const confirm = new Confirm('¡Confirmar operación!', '¿Seguro que desea eliminar este contacto?')
            confirm.fire().then((result) => {
                axios.post('api/persons/' + item.id, { _method: 'delete' }, {
                    headers: {
                        'Authorization': `Bearer ${this.Utils.token()}`
                    }
                }).then((response) => {
                    for (let i in this.persons) {
                        if (this.persons[i].id == item.id) {
                            this.persons.splice(i, 1)
                            this.Utils.notify('Se ha eliminado correctamente el contacto')
                            break
                        }
                    }
                    if(item.id == this.person.id) {
                        this.show = false
                    }
                }).catch((error) => {
                    this.Utils.error(error.response)
                })
            })
        },
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
        axios.get('api/persons', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.persons = response.data.data;
        }).catch((error) => {
            this.Utils.error(error.response)
        });
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
            this.setCities(this.countries[0].code)
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
        axios.get('api/typeredes', {
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
    components: { PersonalItem, ContactCard }
}
</script>
<template>
    <div class="flex justify-center py-1">
        <div class="w-full px-2">
            <div class="flex sm:justify-center">
                <div>
                    <div class="flex mb-1">
                        <h1
                            class="font-bold w-full bg-gradient-to-tr from-slate-500 to-black text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black mb-2">
                            PERSONAL
                        </h1>
                        <div class="flex items-center rounded border border-gray-400 px-2 me-2">
                            <i class="bi bi-funnel-fill text-gray-400"></i>
                            <input v-model="filter" type="text" placeholder="Escribe para filtrar"
                                class="bg-transparent w-full text-gray-700 text-sm border-none focus:outline-none px-3 py-2">
                        </div>
                        <button @click="add"
                            class="bg-gradient-to-tr from-slate-800 to-slate-950 text-white px-2 py-1 rounded">Añadir</button>
                    </div>
                    <div class="mt-4 grid sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-3 gap-3 overflow-auto">
                        <template v-for="item in contacts">
                            <ContactCard @edit="edit" @destroy="destroy" :contact="item"
                                v-if="Utils.filter(['name', 'lastname', 'lang', 'email', 'extra_phone', 'phone', 'position', 'notes', 'agency.tradename', 'agency.taxname', 'city.name', 'typecontact.description'], item, filter)" />
                        </template>
                    </div>
                </div>
            </div>
        </div>
        <!-- <transition name="bounce" mode="out-in">
            <div v-if="show"
                class="w-full bg-white z-[500] bg-opacity-90 md:bg-transparent h-screen md:h-auto absolute md:relative top-0 md:block md:w-1/3 px-2 flex justify-center items-center">
                <div>
                    <h1
                        class="font-bold bg-gradient-to-tr from-slate-500 text-center to-black text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black mb-2">
                        <template v-if="person.id == undefined">
                            AÑADIR
                        </template>
                        <template v-else>
                            EDITAR
                        </template>
                    </h1>
                    <form @submit.prevent="send"
                        class="bg-gradient-to-tr from-slate-700 via-black to-slate-950 rounded-3xl rounded-tr p-10 overflow-auto">
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
                                    <input required v-model="person.lastname" name="lastname" type="text"
                                        placeholder="Apellidos"
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
                                    <input required v-model="person.phone" name="phone" type="tel"
                                        placeholder="Teléfono principal"
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
                                <label class="text-slate-200 text-xs font-semibold">País</label>
                                <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                    <i class="bi bi-globe text-gray-100"></i>
                                    <select required v-model="country_id" @change="(e) => setCities(e.target.value)"
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
                                    <select required v-model="person.city_id" name="city_id"
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

                                        <button @click="removeDocument(index)" type="button" class="text-white"><i
                                                class="bi bi-trash"></i></button>
                                    </div>
                                </template>
                            </div>
                        </div>
                        <div class="flex justify-center">
                            <button type="button" @click="show = false"
                                class="mt-8 me-2 close overlay-button bg-gradient-to-tr from-slate-100 to-slate-300 text-black px-3 py-3 w-full rounded-xl rounded-tr">
                                Cerrar
                            </button>
                            <button type="submit"
                                class="mt-8 overlay-button bg-gradient-to-tr from-slate-100 to-slate-300 text-black px-3 py-3 w-full rounded-xl rounded-tr">
                                <template v-if="person.id == undefined">
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
        </transition> -->
    </div>
</template>
<style scoped>
h1 {
    font-family: 'Archivo Black', sans-serif;
}

form,
.container-ls {
    max-height: calc(100vh - 11.5rem);
}
</style>
