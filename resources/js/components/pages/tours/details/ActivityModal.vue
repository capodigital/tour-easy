<script>
import CustomModal from '../../../common/CustomModal.vue';
import axios from 'axios';

export default {
    components: { CustomModal },
    props: {
        activity: Object,
        tour: Object,
    },
    data() {
        return {
            tours: [],
            contacts: [],
            suppliers: [],
            types: [],
            countries: [],
            start_cities: [],
            end_cities: [],
            places: [],
            country_start: 'AF',
            country_end: 'AF',
        }
    },
    methods: {
        setCities(country, type) {
            axios.post('api/cities', { code: country }, {
                headers: {
                    'Authorization': `Bearer ${this.Utils.token()}`
                }
            }).then((response) => {
                if (type == 'start') {
                    this.country_start = country
                    this.start_cities = response.data;
                } else {
                    this.country_end = country
                    this.end_cities = response.data;
                }
            });
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
    },
    created() {
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
            if (this.activity.citystart != null) {
                this.setCities(this.activity.citystart.country.code, 'start')
            } else {
                this.setCities(this.countries[0].code, 'start')
            }
            if (this.activity.cityend != null) {
                this.setCities(this.activity.cityend.country.code, 'end')
            } else {

                this.setCities(this.countries[0].code, 'end')
            }

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
    <CustomModal @close="$emit('close')">
        <form @submit.prevent="(e) => $emit('send', e)"
            class="bg-gradient-to-tr from-slate-700 via-black to-slate-950 rounded-3xl rounded-tr p-5">
            <h1
                class="font-bold bg-gradient-to-tr from-slate-500 text-center to-black text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black mb-2">
                <template v-if="activity.id == undefined">
                    AÑADIR ACTIVIDAD
                </template>
                <template v-else>
                    EDITAR ACTIVIDAD
                </template>
            </h1>
            <div class="overflow-auto modal-content">
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
                        <input required v-model="activity.name" name="name" type="text" placeholder="Nombre de la actividad"
                            class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                    </div>
                </div>
                <div>
                    <label class="text-slate-200 text-xs font-semibold">Descripción</label>
                    <div class="flex items-center mb-3 rounded border border-gray-300 px-1 py-1">
                        <textarea required rows="3" v-model="activity.notes" name="notes" placeholder="Datos adicionales"
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
                            <input required v-model="activity.enddate" name="enddate" type="date" placeholder="Fecha de fin"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-x-2">
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">País</label>
                        <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                            <i class="bi bi-globe text-gray-100"></i>
                            <select required v-model="country_start" @change="(e) => setCities(e.target.value, 'start')"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                <option class="text-black" v-for="country in countries" :value="country.code">{{
                                    country.name }}</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Ciudad <template
                                v-if="[4, 6, 7, 8].includes(Number(activity.typeitinerary_id))"> de
                                salida</template></label>
                        <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                            <i class="bi bi-globe-americas text-gray-100"></i>
                            <select required v-model="activity.city_start_id" name="city_start_id"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                <option class="text-black" v-for="city in start_cities" :value="city.id">{{
                                    city.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <template v-if="[6, 7, 8].includes(Number(activity.typeitinerary_id))">
                    <div class="grid grid-cols-2 gap-x-2">
                        <div>
                            <label class="text-slate-200 text-xs font-semibold">País</label>
                            <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                <i class="bi bi-globe text-gray-100"></i>
                                <select required v-model="country_end" @change="(e) => setCities(e.target.value, 'end')"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                    <option class="text-black" v-for="country in countries" :value="country.code">{{
                                        country.name }}</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="text-slate-200 text-xs font-semibold">Ciudad de destino</label>
                            <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                <i class="bi bi-globe-americas text-gray-100"></i>
                                <select required v-model="activity.city_destination_id" name="city_destination_id"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                    <option class="text-black" v-for="city in end_cities" :value="city.id">{{
                                        city.name
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
                </div>
            </div>
            <div class="flex justify-center">
                <button type="button" @click="$emit('close')"
                    class="mt-8 me-2 close overlay-button bg-gradient-to-tr from-slate-100 to-slate-300 text-black px-3 py-3 w-full rounded-xl rounded-tr">
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
    </CustomModal>
</template>
