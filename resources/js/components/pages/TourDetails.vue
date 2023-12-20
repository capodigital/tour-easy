<script>
import TourActivity from '../TourActivity.vue';
import ActivityDetails from './ActivityDetails.vue';
import AnimMixin from './AnimMixin';
import axios from 'axios'
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
            cities: [],
            places: [],
            show: false,
        };
    },
    components: { TourActivity, ActivityDetails },
    methods: {
        setCities(country) {
            axios.post('api/cities', { code: country },{headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }}).then((response) => {
                this.cities = response.data;
            });
        },
        add() {
            this.activity = { tour_id: this.tour.id }
            this.show = true
        },
        edit(item) {
            Object.assign(this.activity, item)
            this.show = true
        },
        destroy(item) {
            axios.post('api/itineraries/' + item.id, { _method: 'delete' }).then((response) => {
                for (let i in this.activities) {
                    if (this.activities[i].id == item.id) {
                        this.activities.splice(i, 1)
                        break
                    }
                }
            })
        },
        send(e) {
            const data = new FormData(e.target)
            data.append('_method', this.activity.id == undefined ? 'post' : 'put');
            axios.post(this.activity.id == undefined ? 'api/itineraries' : `api/itineraries/${this.activity.id}`, data).then((response) => {
                if (this.activity.id == undefined) {
                    this.activities.push(this.getActivityData(response.data.data))
                } else {
                    for (let i in this.activities) {
                        if (this.activities[i].id == this.activity.id) {
                            this.activities[i] = this.getActivityData(response.data.data)
                            break
                        }
                    }
                }
                this.activity = { tour_id: this.tour.id }
                this.show = false
            })
        },
        getActivityData(activity) {
            let name = '', description = '', type = activity.typeitinerary_id, start = activity.startdate
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
                    name = activity.name, description = `<b>Proveedor: </b>${activity.supplier.company_name}.<br /><b>Lugar: </b>${activity.place.name}`,
                        date = `<br /><div class="flex flex-col items-center"><div>${start}</div><div>${activity.enddate}</div></div>`;
                    break;
                case 4:
                    name = `<b>Lugar: </b>`, description = `<b>Conductor: </b>${activity.carrier}`,
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
            return item
        }
    },
    created() {
        const id = location.hash.substring(location.hash.lastIndexOf('/') + 1)
        axios.post('api/itineraries/tour', { id: id },{headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }}).then((response) => {
            for (let activity of response.data.data) {
                console.log(activity)
                this.activities.push(this.getActivityData(activity))
            }
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
            this.setCities(this.countries[0].code)
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
                    </div>
                </div>
                <div class="hero">
                    <div class="hero__inner">
                        <div class="hero__cuboid hero__cuboid--1">
                            <div class="face face--front"><img src="src/statics/1.jpg" alt=""></div>
                            <div class="face face--back"><img src="src/statics/2.jpg" alt=""></div>
                            <div class="face face--left"><img src="src/statics/3.jpeg" alt=""></div>
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
            <TourActivity v-for="item in activities" @show="(item) => details = item" @edit="edit" @destroy="destroy" :activity="item" />
            <article @click="add"
                class="border-2 border-gray-500 rounded-2xl cursor-pointer border-dashed min-h-[10rem] flex justify-center items-center">
                <i class="bi bi-plus text-6xl text-gray-500"></i>
            </article>
        </div>
        <div v-if="show"
            class="w-full bg-white bg-opacity-90 h-screen md:h-auto absolute top-0 px-2 py-2 flex justify-center items-center">
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
                                <select :value="tour.id" name="tour_id"
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
                                <select v-model="activity.typeitinerary_id" name="typeitinerary_id"
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
                            <input v-model="activity.name" name="name" type="text" placeholder="Nombre de la actividad"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                        </div>
                    </div>
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Descripción</label>
                        <div class="flex items-center mb-3 rounded border border-gray-300 px-1 py-1">
                            <textarea rows="3" v-model="activity.notes" name="notes" placeholder="Datos adicionales"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-1 py-1"></textarea>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-x-2 my-3" v-if="activity.typeitinerary_id == 1">
                        <div>
                            <label class="text-slate-200 text-xs font-semibold">Prueba de sonido</label>
                            <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                <i class="bi bi-calendar-day text-gray-100"></i>
                                <input v-model="activity.showcheck" name="showcheck" type="time"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-[0.65rem]">
                            </div>
                        </div>
                        <div>
                            <label class="text-slate-200 text-xs font-semibold">Inicio del show</label>
                            <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                <i class="bi bi-calendar-day text-gray-100"></i>
                                <input v-model="activity.showtime" name="showtime" type="time"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-x-2">
                        <div>
                            <label class="text-slate-200 text-xs font-semibold">Fecha de inicio</label>
                            <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                <i class="bi bi-calendar-day text-gray-100"></i>
                                <input v-model="activity.startdate" name="startdate" type="date"
                                    placeholder="Fecha de inicio"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-[0.65rem]">
                            </div>
                        </div>
                        <div>
                            <label class="text-slate-200 text-xs font-semibold">Fecha de fin</label>
                            <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                <i class="bi bi-calendar-day text-gray-100"></i>
                                <input v-model="activity.enddate" name="enddate" type="date" placeholder="Fecha de fin"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                            </div>
                        </div>
                    </div>
                    <label class="text-slate-200 text-xs font-semibold">Ciudad de salida</label>
                    <div class="grid grid-cols-2 gap-x-2">
                        <div>
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
                            <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                <i class="bi bi-globe-americas text-gray-100"></i>
                                <select v-model="activity.city_start_id" name="city_start_id"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                    <option class="text-black" v-for="city in cities" :value="city.id">{{ city.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <label class="text-slate-200 text-xs font-semibold">Ciudad de destino</label>
                    <div class="grid grid-cols-2 gap-x-2">
                        <div>
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
                            <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                <i class="bi bi-globe-americas text-gray-100"></i>
                                <select v-model="activity.city_destination_id" name="city_destination_id"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                    <option class="text-black" v-for="city in cities" :value="city.id">{{ city.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-x-2">
                        <div>
                            <label class="text-slate-200 text-xs font-semibold">Contacto</label>
                            <div class="flex items-center rounded border border-gray-300 px-2">
                                <select v-model="activity.contact_id" name="contact_id"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                    <option class="text-black" v-for="contact in contacts" :value="contact.id">{{
                                        contact.name
                                    }}</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="text-slate-200 text-xs font-semibold">Lugar</label>
                            <div class="flex items-center rounded border border-gray-300 px-2">
                                <select v-model="activity.place_id" name="place_id"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                    <option class="text-black" v-for="place in places" :value="place.id">{{
                                        place.name
                                    }}</option>
                                </select>
                            </div>
                        </div>
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
        <ActivityDetails @close="details = null" v-if="details != null" :activity="details" />
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

form {
    max-height: calc(100vh - 7.5rem);
}
</style>
