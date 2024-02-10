<script>
import CustomModal from '../../../common/CustomModal.vue';
import axios from 'axios';
import FlyItineraryForm from '../../../itinerary/forms/FlyItineraryForm.vue';
import TransferItineraryForm from '../../../itinerary/forms/TransferItineraryForm.vue';
import BusItineraryForm from '../../../itinerary/forms/BusItineraryForm.vue';
import TrainItineraryForm from '../../../itinerary/forms/TrainItineraryForm.vue';
import ShowItineraryForm from '../../../itinerary/forms/ShowItineraryForm.vue';
import ActivityItineraryForm from '../../../itinerary/forms/ActivityItineraryForm.vue';

export default {
    components: { CustomModal, FlyItineraryForm, TransferItineraryForm, BusItineraryForm, TrainItineraryForm, ShowItineraryForm, ActivityItineraryForm },
    props: {
        activity: Object,
        tour: Object,
    },
    data() {
        return {
            tours: [],
            persons_1: [],
            persons_2: [],
            suppliers: [],
            types: [],
            countries: [],
            start_cities: [],
            end_cities: [],
            places: [],
            outoftour: false,
            _startdate: '',
            _enddate: '',
            _starttime: '',
            _endtime: '',
        }
    },
    methods: {
        setCities({ code, type }) {
            axios.post('api/cities', { code: code }, {
                headers: {
                    'Authorization': `Bearer ${this.Utils.token()}`
                }
            }).then((response) => {
                if (type == 'start') {
                    this.activity._country_start = code
                    this.start_cities = response.data
                } else {
                    this.activity._country_end = code
                    this.end_cities = response.data
                }
            });
        },
    },
    created() {
        this.activity.typeitinerary_id = 1
        if (this.activity.startdate != null) {
            const date = new Date(this.activity.startdate)
            this._startdate = `${date.getFullYear()}-${(date.getMonth() + 1).toString().padStart(2, '0')}-${date.getDate().toString().padStart(2, '0')}`
            this._starttime = `${date.getHours().toString().padStart(2, '0')}:${date.getMinutes().toString().padStart(2, '0')}`
        }
        if (this.activity.enddate != null) {
            const date = new Date(this.activity.enddate)
            this._enddate = `${date.getFullYear()}-${(date.getMonth() + 1).toString().padStart(2, '0')}-${date.getDate().toString().padStart(2, '0')}`
            this._endtime = `${date.getHours().toString().padStart(2, '0')}:${date.getMinutes().toString().padStart(2, '0')}`
        }
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
        this.countries = this.tour.countries;
        if (this.activity.citystart != null) {
            this.activity._outoftour = this.activity.outoftour == 1;
            this.activity._country_start = this.activity.citystart.country_id
            this.setCities({ code: this.activity.citystart.country.code, type: 'start' })
        }
        if (this.activity.cityend != null) {
            this.activity._country_end = this.activity.cityend.country_id
            this.setCities({ code: this.activity.cityend.country_id, type: 'end' })
        }
        if (this.countries.length > 0) {
            if (this.activity.citystart == null) {
                this.setCities({ code: this.countries[0].code, type: 'start' })
            }
            if (this.activity.cityend == null) {
                this.setCities({ code: this.countries[0].code, type: 'end' })
            }
        } else {
            axios.get('api/countries', {
                headers: {
                    'Authorization': `Bearer ${this.Utils.token()}`
                }
            }).then((response) => {
                this.countries = response.data.data;
                if (this.activity.citystart == null) {
                    this.setCities({ code: this.countries[0].code, type: 'start' })
                }
                if (this.activity.cityend == null) {
                    this.setCities({ code: this.countries[0].code, type: 'end' })
                }
            })
        }

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
        <form @submit.prevent="(e) => $emit('send', e)" class="gradient-2 rounded-3xl rounded-tr p-5">
            <h1
                class="font-bold bg-gradient-to-tr from-app-primary-500 text-center to-app-primary-700 text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black mb-2">
                <template v-if="activity.id == undefined">
                    AÑADIR ITINERARIO
                </template>
                <template v-else>
                    EDITAR ITINERARIO
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
                        <label class="text-slate-200 text-xs font-semibold">Tipo de itinerario</label>
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
                <FlyItineraryForm @updatecities="setCities" :tour="tour" :activity="activity" :suppliers="suppliers"
                    :startdate="_startdate" :starttime="_starttime" :enddate="_enddate" :endtime="_endtime"
                    :countries="countries" :start_cities="start_cities" :end_cities="end_cities" :persons_1="persons_1"
                    :persons_2="persons_2" v-if="activity.typeitinerary_id == 1 || activity.typeitinerary_id == 2" />
                <TransferItineraryForm @updatecities="setCities" :tour="tour" :activity="activity" :suppliers="suppliers"
                    :places="places" :startdate="_startdate" :starttime="_starttime" :enddate="_enddate" :endtime="_endtime"
                    :countries="countries" :start_cities="start_cities" :end_cities="end_cities" :persons_1="persons_1"
                    :persons_2="persons_2" v-else-if="activity.typeitinerary_id == 3" />
                <BusItineraryForm @updatecities="setCities" :tour="tour" :activity="activity" :suppliers="suppliers"
                    :startdate="_startdate" :starttime="_starttime" :enddate="_enddate" :endtime="_endtime"
                    :countries="countries" :start_cities="start_cities" :end_cities="end_cities" :persons_1="persons_1"
                    :persons_2="persons_2" v-else-if="activity.typeitinerary_id == 4" />
                <TrainItineraryForm @updatecities="setCities" :tour="tour" :activity="activity" :suppliers="suppliers"
                    :startdate="_startdate" :starttime="_starttime" :enddate="_enddate" :endtime="_endtime"
                    :countries="countries" :start_cities="start_cities" :end_cities="end_cities" :persons_1="persons_1"
                    :persons_2="persons_2" v-else-if="activity.typeitinerary_id == 5" />
                <ShowItineraryForm @updatecities="setCities" :tour="tour" :activity="activity" :places="places"
                    :startdate="_startdate" :starttime="_starttime" :enddate="_enddate" :endtime="_endtime"
                    :countries="countries" :start_cities="start_cities" :end_cities="end_cities" :persons_1="persons_1"
                    :persons_2="persons_2" v-else-if="activity.typeitinerary_id == 7" />
                <ActivityItineraryForm @updatecities="setCities" :tour="tour" :activity="activity" :suppliers="suppliers"
                    :startdate="_startdate" :starttime="_starttime" :enddate="_enddate" :endtime="_endtime"
                    :countries="countries" :start_cities="start_cities" :end_cities="end_cities" :persons_1="persons_1"
                    :persons_2="persons_2" v-else-if="activity.typeitinerary_id == 8 || activity.typeitinerary_id == 9" />
            </div>
            <div class="flex justify-center">
                <button type="button" @click="$emit('close')"
                    class="mt-8 me-2 close overlay-button bg-gradient-to-tr from-gray-600 to-gray-700 text-white px-3 py-3 w-full rounded-xl rounded-tr">
                    Cerrar
                </button>
                <button type="submit"
                    class="mt-8 overlay-button bg-gradient-to-tr from-app-primary-500 to-app-primary-700 text-white px-3 py-3 w-full rounded-xl rounded-tr">
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
