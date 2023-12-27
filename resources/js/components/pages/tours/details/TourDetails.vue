<script>
import axios from 'axios'
import TourActivity from './TourActivity.vue';
import ActivityDetails from '../../../common/ActivityDetails.vue';
import AnimMixin from './AnimMixin';
import Confirm from '../../../modals/Confirm';
export default {
    mixins: [AnimMixin],
    data() {
        return {
            activities: [],
            tour: {
                artist: {}
            },
            details: null,
            activity: {},
            tours: [],
            contacts: [],
            suppliers: [],
            types: [],
            countries: [],
            start_cities: [],
            end_cities: [],
            places: [],
            show_images: false,
            images: [],
            show: false,
            uploading: false,
            preview: null
        };
    },
    components: { TourActivity, ActivityDetails },
    methods: {
        setCities(country, type) {
            axios.post('api/cities', { code: country }, {
                headers: {
                    'Authorization': `Bearer ${this.Utils.token()}`
                }
            }).then((response) => {
                if(type == 'start') {
                    this.start_cities = response.data;
                } else {
                    this.end_cities = response.data;
                }
            });
        },
        add() {
            this.activity = { tour_id: this.tour.id }
            this.show = true
        },
        edit(item) {
            Object.assign(this.activity, item)
            console.log(this.activity)
            if(item.citystart != null) {
                this.setCities(item.citystart.country.code, 'start')
            }
            if(item.cityend != null) {
                this.setCities(item.cityend.country.code, 'end')
            }
            this.show = true
        },
        destroy(item) {
            const confirm = new Confirm('¡Confirmar operación!', '¿Seguro que desea eliminar esta actividad?')
            confirm.fire().then((result) => {
                axios.post('api/itineraries/' + item.id, { _method: 'delete' }, {
                    headers: {
                        'Authorization': `Bearer ${this.Utils.token()}`
                    }
                }).then(() => {
                    for (let i in this.activities) {
                        if (this.activities[i].id == item.id) {
                            this.Utils.notify('Se eliminó la actividad correctamente');
                            this.activities.splice(i, 1)
                            break
                        }
                    }
                }).catch((error) => {
                    this.Utils.error(error.response)
                })
            })
        },
        send(e) {
            const data = new FormData(e.target)
            this.Utils.lock(e.target)
            data.append('_method', this.activity.id == undefined ? 'post' : 'put');
            axios.post(this.activity.id == undefined ? 'api/itineraries' : `api/itineraries/${this.activity.id}`, data, {
                headers: {
                    'Authorization': `Bearer ${this.Utils.token()}`
                }
            }).then((response) => {
                const item = response.data.data
                if (item.place == null) {
                    item.place = {
                        name: '',
                    }
                }
                if (this.activity.id == undefined) {
                    this.Utils.notify('Se ha creado la actividad correctamente');
                    this.activities.push(this.getActivityData(response.data.data))
                } else {
                    for (let i in this.activities) {
                        if (this.activities[i].id == this.activity.id) {
                            this.activities[i] = this.getActivityData(response.data.data)
                            this.Utils.notify('Se ha actualizado la actividad correctamente')
                            break
                        }
                    }
                }
                this.activity = { tour_id: this.tour.id }
                this.show = false
                this.Utils.unlock(e.target)
            }).catch((error) => {
                this.Utils.unlock(e.target)
                this.Utils.error(error.response)
            })
        },
        getActivityData(activity) {
            let name = '', description = '', type = activity.typeitinerary_id, start = activity.startdate, end = activity.enddate, complete = ''
            if (new Date(start) > new Date()) {
                complete = 'No completado'
            } else {
                if (new Date() < new Date(end)) {
                    complete = 'En progreso'
                } else {
                    complete = 'Completado'
                }
            }
            let date = '';
            switch (Number(activity.typeitinerary_id)) {
                case 1:
                    name = activity.name, description = `<b>Prueba de sonidos: </b>${activity.showcheck}.<br /><b>Puertas abiertas: </b>${activity.showtime}.<br /><b>Lugar: </b>${activity.place.name}`,
                        date = `<br />${start}`;
                    break;
                case 2:
                    name = activity.name, description = `<b>Lugar: </b>${activity.place.name}`,
                        date = `<br />${start}`;
                    break;
                case 3:
                    name = activity.name, description = `<b>Lugar: </b>${activity.place.name}`,
                        date = `<br />${start}`;
                    break;
                case 5:
                    name = activity.name, description = `<b>Lugar: </b>${activity.place.name}`,
                        date = `<br /><div class="flex flex-col items-center"><div>${start}</div><div>${activity.enddate}</div></div>`;
                    break;
                case 4:
                    name = activity.name, description = `<b>Conductor: </b>${activity.contact.name}`,
                        date = `<br />${start}`;
                    break;
                case 6:
                    name = `${activity.citystart.name} → ${activity.cityend.name}`, description = `<b>Aerolinea: </b>${activity.place.name}`,
                        date = `<br /><div class="flex flex-col items-center"><div>${start}</div><div>${activity.enddate}</div></div>`;
                    break;
                case 7:
                    name = `${activity.citystart.name} → ${activity.cityend.name}`, description = `<b>Ferroviaria: </b>${activity.place.name}`,
                        date = `<br /><div class="flex flex-col items-center"><div>${start}</div><div>${activity.enddate}</div></div>`;
                    break;
                case 8:
                    name = `${activity.citystart.name} → ${activity.cityend.name}`, description = `<b>Transporte: </b>${activity.contact.name}.<br /><b>Conductor: </b>${activity.place.name}`,
                        date = `<br /><div class="flex flex-col items-center"><div>${start}</div><div>${activity.enddate}</div></div>`;
                    break;
            }
            const item = activity
            item.name = name
            item.type = type
            item.description = description
            item.date = date
            item.start = start
            item.complete = complete
            return item
        },
        contact(contact) {
            switch (this.activity.typeitinerary_id) {
                case 1:
                    return contact.typecontact_id == 3 || contact.typecontact_id == 2
                case 4:
                case 6:
                case 7:
                case 8:
                    return contact.typecontact_id == 4
                default:
                    return false
            }
        },
        place(place) {
            switch (this.activity.typeitinerary_id) {
                case 1:
                case 2:
                case 3:
                    return place.typeplace_id == 1
                case 5:
                    return place.typeplace_id == 2
                case 6:
                    return place.typeplace_id == 3
                case 7:
                    return place.typeplace_id == 4
                default:
                    return false
            }
        },
        remove(index) {
            const confirm = new Confirm('¡Confirmar operación!', '¿Seguro que desea eliminar esta imagen?')
            confirm.fire().then((result) => {
                axios.post('api/photos/' + this.images[index].id, { _method: 'delete' }, {
                    headers: {
                        'Authorization': `Bearer ${this.Utils.token()}`
                    }
                }).then((response) => {
                    this.images.splice(index, 1)
                    this.Utils.notify('Se eliminó la imagen correctamente');
                }).catch((error) => {
                    this.Utils.error(error.response)
                })
            })
        },
        updatePreview(e) {
            const files = e.target.files
            if (files && files.length) {
                this.preview = URL.createObjectURL(files[0])
            } else {
                this.preview = null
            }
        },
        saveImage(e) {
            const data = new FormData(e.target)
            this.uploading = true
            axios.post('api/photos', data, {
                headers: {
                    'Authorization': `Bearer ${this.Utils.token()}`
                }
            }).then((response) => {
                this.preview = null
                this.images.push(response.data.data)
                this.Utils.notify('Se subió la imagen correctamente')
                this.uploading = false
            }).catch((error) => {
                this.uploading = false
                this.Utils.error(error.response)
            })
        },
        openPicker() {
            if (this.preview == null) {
                this.$el.querySelector('#tour-image').click()
            }
        }
    },
    created() {
        const id = location.hash.substring(location.hash.lastIndexOf('/') + 1)
        axios.post('api/itineraries/tour', { id: id }, {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            for (let activity of response.data.data) {
                this.activities.push(this.getActivityData(activity))
            }
        })
        axios.post('api/photos/tour', { id: id }, {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.images = response.data.data
        })
        axios.post('api/tour', { id: id }, {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.tour = response.data.data;
        })
        axios.get('api/tours', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.tours = response.data.data;
        })
        axios.get('api/typeitineraries', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.types = response.data.data;
        })
        axios.get('api/contacts', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.contacts = response.data.data;
        })
        axios.get('api/countries', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.countries = response.data.data;
            this.setCities(this.countries[0].code, 'start')
            this.setCities(this.countries[0].code, 'end')
        })
        axios.get('api/places', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.places = response.data.data;
        })
        axios.get('api/suppliers', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.suppliers = response.data.data;
        })
    },
}
</script>
<template>
    <section>
        <div class="tour-images">
            <div class="stage bg-cover bg-no-repeat">

                <div class="absolute bottom-0 left-0 flex justify-center items-end z-30 w-full pb-3 md:pb-10">

                    <div class="text-center">
                        <h1
                            class="md:text-4xl font-bold bg-gradient-to-tr from-slate-100 to-slate-300 text-xl bg-clip-text text-transparent drop-shadow-md shadow-black">
                            {{ tour.tourname }}</h1>
                        <p class="text-2xl">{{ tour.artist.name }}</p>
                        <p class="text-lg">{{ tour.startdate }}----{{ tour.enddate }}</p>
                        <button @click="show_images = true"
                            class="rounded text-white text-sm z-50 border border-white px-2 py-1 hover:bg-white hover:text-black transition-all">Ver
                            imágenes</button>
                    </div>
                </div>
                <div class="hero">
                    <div class="hero__inner">
                        <div class="hero__cuboid hero__cuboid--1">
                            <div class="face face--front"><img src="src/statics/1.jpg" alt=""></div>
                            <div class="face face--back"><img src="src/statics/2.jpg" alt=""></div>
                            <div class="face face--left"><img src="src/statics/3.jpg" alt=""></div>
                            <div class="face face--right"><img src="src/statics/4.jpg" alt=""></div>
                            <div class="face face--top"></div>
                            <div class="face face--bottom"></div>
                        </div>
                        <div class="hero__cuboid hero__cuboid--2">
                            <div class="face face--front"><img src="src/statics/5.jpg" alt=""></div>
                            <div class="face face--back"><img src="src/statics/6.jpg" alt=""></div>
                            <div class="face face--left"><img src="src/statics/7.jpg" alt=""></div>
                            <div class="face face--right"><img src="src/statics/9.jpg" alt=""></div>
                            <div class="face face--top"></div>
                            <div class="face face--bottom"></div>
                        </div>
                        <div class="hero__cuboid hero__cuboid--3">
                            <div class="face face--front"><img src="src/statics/2.jpg" alt=""></div>
                            <div class="face face--back"><img src="src/statics/1.jpg" alt=""></div>
                            <div class="face face--left"><img src="src/statics/6.jpg" alt=""></div>
                            <div class="face face--right"><img src="src/statics/3.jpg" alt=""></div>
                            <div class="face face--top"></div>
                            <div class="face face--bottom"></div>
                        </div>
                        <div class="hero__cuboid hero__cuboid--4">
                            <div class="face face--front"><img src="src/statics/7.jpg" alt=""></div>
                            <div class="face face--back"><img src="src/statics/9.jpg" alt=""></div>
                            <div class="face face--left"><img src="src/statics/5.jpg" alt=""></div>
                            <div class="face face--right"><img src="src/statics/6.jpg" alt=""></div>
                            <div class="face face--top"></div>
                            <div class="face face--bottom"></div>
                        </div>
                    </div>
                </div>
                <div class="overlay"></div>
            </div>
        </div>
        <div class="mt-4 grid sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-3 z-50 p-4">
            <TourActivity v-for="item in activities" @show="(item) => details = item" @edit="edit" @destroy="destroy"
                :activity="item" />
            <article @click="add" v-if="Utils.role() != 'artist'"
                class="border-2 border-gray-500 rounded-2xl cursor-pointer border-dashed min-h-[10rem] flex justify-center items-center">
                <i class="bi bi-plus text-6xl text-gray-500"></i>
            </article>
        </div>
        <transition name="bounce" mode="out-in">
            <div v-if="show_images"
                class="w-full bg-white bg-opacity-90 h-screen absolute left-0 top-0 px-2 py-2 flex justify-center items-center">
                <div class="images-modal overflow-auto scroll">
                    <div class="flex items-center">
                        <h1
                            class="font-bold bg-gradient-to-tr w-full  from-slate-500 text-center to-black text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black mb-2">
                            IMÁGENES DE LA GIRA
                        </h1>
                        <button @click="show_images = false"
                            class="bg-slate-800 text-white rounded px-2 py-1">Cerrar</button>
                    </div>

                    <div v-viewer="options" class="images md:grid">
                        <div class="relative" v-for="(image, index) in images">
                            <button @click="remove(index)"
                                class="absolute bg-transparent border-none z-50 focus:outline-none text-white top-1 right-1"><i
                                    class="bi bi-trash"></i></button>
                            <div class="image cursor-pointer h-56 bg-cover bg-center"
                                :style="{ 'background-image': `url(${image.url})` }" :key="index">
                                <img class="opacity-0" :src="image.url" :alt="`${tour.tourname} - ${index}`" />
                            </div>

                        </div>
                        <form @submit.prevent="saveImage">
                            <input type="file" @change="updatePreview" class="hidden" id="tour-image" name="image" />
                            <input type="hidden" name="tour_id" :value="tour.id" />
                            <div @click="openPicker" :class="{ 'border-2': preview == null }"
                                class="relative border-gray-500 h-full rounded cursor-pointer border-dashed min-h-[14rem] flex justify-center items-center">
                                <i v-if="preview == null" class="bi bi-plus text-6xl text-gray-500"></i>
                                <div class="h-56 w-full bg-cover" v-else :style="{ 'background-image': `url(${preview})` }">
                                    <button v-if="uploading != true" @click="preview = null"
                                        class="absolute bg-transparent border-none z-50 focus:outline-none text-white top-1 right-1"><i
                                            class="bi bi-trash"></i></button>
                                    <div
                                        class="absolute top-0 left-0 w-full h-full bg-black bg-opacity-50 flex items-center justify-center">
                                        <div v-if="uploading" class="spinner-border me-2" role="status"><span
                                                class="visually-hidden">Loading...</span></div>
                                        <button v-else class="text-white text-4xl opacity-75 hover:opacity-100"
                                            type="submit"><i class="bi bi-upload"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </transition>
        <transition name="bounce" mode="out-in">
            <div v-if="show"
                class="w-full bg-white bg-opacity-90 h-screen md:h-auto absolute left-0 top-0 px-2 py-2 flex justify-center items-center">
                <div>
                    <h1
                        class="font-bold bg-gradient-to-tr from-slate-500 text-center to-black text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black mb-2">
                        <template v-if="activity.id == undefined">
                            AÑADIR
                        </template>
                        <template v-else>
                            EDITAR
                        </template>
                    </h1>
                    <form @submit.prevent="send"
                        class="bg-gradient-to-tr from-slate-700 via-black to-slate-950 rounded-3xl rounded-tr p-10 overflow-auto scroll">
                        <div class="grid grid-cols-2 gap-x-2 mb-3">
                            <div :class="{ hidden: tour.id != undefined }">
                                <label class="text-slate-200 text-xs font-semibold">Gira</label>
                                <div class="flex items-center rounded border border-gray-300 px-2">
                                    <select required :value="tour.id" name="tour_id"
                                        class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                        <option class="text-black" v-for="item in tours" :value="item.id">{{
                                            item.tourname
                                        }}</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label class="text-slate-200 text-xs font-semibold">Tipo de actividad</label>
                                <div class="flex items-center rounded border border-gray-300 px-2">
                                    <select required v-model="activity.typeitinerary_id" name="typeitinerary_id"
                                        class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                        <option class="text-black" v-for="type in types" :value="type.id">{{
                                            type.description
                                        }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="text-slate-200 text-xs font-semibold">Nombre</label>
                            <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                <i class="bi bi-envelope text-gray-100"></i>
                                <input required v-model="activity.name" name="name" type="text"
                                    placeholder="Nombre de la actividad"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                            </div>
                        </div>
                        <div>
                            <label class="text-slate-200 text-xs font-semibold">Descripción</label>
                            <div class="flex items-center mb-3 rounded border border-gray-300 px-1 py-1">
                                <textarea required rows="3" v-model="activity.notes" name="notes"
                                    placeholder="Datos adicionales"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-1 py-1"></textarea>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-x-2 my-3" v-if="activity.typeitinerary_id == 1">
                            <div>
                                <label class="text-slate-200 text-xs font-semibold">Prueba de sonido</label>
                                <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                    <i class="bi bi-calendar-day text-gray-100"></i>
                                    <input required v-model="activity.showcheck" name="showcheck" type="time"
                                        class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-[0.65rem]">
                                </div>
                            </div>
                            <div>
                                <label class="text-slate-200 text-xs font-semibold">Inicio del show</label>
                                <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                    <i class="bi bi-calendar-day text-gray-100"></i>
                                    <input required v-model="activity.showtime" name="showtime" type="time"
                                        class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-x-2">
                            <div>
                                <label class="text-slate-200 text-xs font-semibold">Fecha de inicio</label>
                                <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                    <i class="bi bi-calendar-day text-gray-100"></i>
                                    <input required v-model="activity.startdate" name="startdate" type="date"
                                        placeholder="Fecha de inicio"
                                        class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-[0.65rem]">
                                </div>
                            </div>
                            <div>
                                <label class="text-slate-200 text-xs font-semibold">Fecha de fin</label>
                                <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                    <i class="bi bi-calendar-day text-gray-100"></i>
                                    <input required v-model="activity.enddate" name="enddate" type="date"
                                        placeholder="Fecha de fin"
                                        class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                </div>
                            </div>
                        </div>
                        <label class="text-slate-200 text-xs font-semibold">Ciudad <template
                                v-if="[4, 6, 7, 8].includes(Number(activity.typeitinerary_id))"> de salida</template></label>
                        <div class="grid grid-cols-2 gap-x-2">
                            <div>
                                <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                    <i class="bi bi-globe text-gray-100"></i>
                                    <select required @change="(e) => setCities(e.target.value, 'start')"
                                        class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                        <option class="text-black" v-for="country in countries" :value="country.code">{{
                                            country.name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                    <i class="bi bi-globe-americas text-gray-100"></i>
                                    <select required v-model="activity.city_start_id" name="city_start_id"
                                        class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                        <option class="text-black" v-for="city in start_cities" :value="city.id">{{ city.name }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <template v-if="[6, 7, 8].includes(Number(activity.typeitinerary_id))">
                            <label class="text-slate-200 text-xs font-semibold">Ciudad de destino</label>
                            <div class="grid grid-cols-2 gap-x-2">
                                <div>
                                    <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                        <i class="bi bi-globe text-gray-100"></i>
                                        <select required @change="(e) => setCities(e.target.value, 'end')"
                                            class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                            <option class="text-black" v-for="country in countries" :value="country.code">{{
                                                country.name }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                        <i class="bi bi-globe-americas text-gray-100"></i>
                                        <select required v-model="activity.city_destination_id" name="city_destination_id"
                                            class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                            <option class="text-black" v-for="city in end_cities" :value="city.id">{{ city.name
                                            }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <div class="grid grid-cols-2 gap-x-2">
                            <div v-if="[1, 4, 6, 7, 8].includes(Number(activity.typeitinerary_id))">
                                <label class="text-slate-200 text-xs font-semibold">Contacto</label>
                                <div class="flex items-center rounded border border-gray-300 px-2">
                                    <select required v-model="activity.contact_id" name="contact_id"
                                        class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                        <template v-for="item in contacts">
                                            <option v-if="contact(item)" class="text-black" :value="item.id">{{
                                                item.name
                                            }}</option>
                                        </template>
                                    </select>
                                </div>
                            </div>
                            <div v-if="[1, 2, 3, 5, 6, 7].includes(Number(activity.typeitinerary_id))">
                                <label class="text-slate-200 text-xs font-semibold">Lugar</label>
                                <div class="flex items-center rounded border border-gray-300 px-2">
                                    <select required v-model="activity.place_id" name="place_id"
                                        class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                        <template v-for="item in places">
                                            <option v-if="place(item)" class="text-black" :value="item.id">{{
                                                item.name
                                            }}</option>
                                        </template>
                                    </select>
                                </div>
                            </div>
                            <!-- <div v-if="activity.typeitinerary_id == 5">
                                <label class="text-slate-200 text-xs font-semibold">Hotel</label>
                                <div class="flex items-center rounded border border-gray-300 px-2">
                                    <select required v-model="activity.supplier_id" name="supplier_id"
                                        class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                        <option class="text-black" v-for="item in suppliers" :value="item.id">{{
                                            item.company_name
                                        }}</option>
                                    </select>
                                </div>
                            </div> -->
                        </div>

                        <div class="flex justify-center">
                            <button type="button" @click="show = false"
                                class="mt-8 me-2 overlay-button bg-gradient-to-tr from-slate-100 to-slate-300 text-black px-3 py-3 w-full rounded-xl rounded-tr">
                                Cerrar
                            </button>
                            <button type="submit"
                                class="mt-8 overlay-button bg-gradient-to-tr from-slate-100 to-slate-300 text-black px-3 py-3 w-full rounded-xl rounded-tr">
                                <template v-if="activity.id == undefined">
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
        <transition name="bounce" mode="out-in">
            <ActivityDetails @close="details = null" v-if="details != null" :activity="details" />
        </transition>
    </section>
</template>
<style scoped>
h1 {
    font-family: 'Archivo Black', sans-serif;
}

.stage {
    background-image: url("/src/background.jpg");

    position: relative;
}

.stage::before {
    background-color: rgba(0, 0, 0, 0.712);
    content: " ";
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
}

form,
.images-modal {
    max-height: calc(100vh - 8rem);
}

.images {
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    grid-gap: 1px;
}
</style>
