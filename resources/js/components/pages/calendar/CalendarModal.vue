<script>
import FlyItineraryForm from '../../itinerary/forms/FlyItineraryForm.vue';
import TransferItineraryForm from '../../itinerary/forms/TransferItineraryForm.vue';
import BusItineraryForm from '../../itinerary/forms/BusItineraryForm.vue';
import TrainItineraryForm from '../../itinerary/forms/TrainItineraryForm.vue';
import ShowItineraryForm from '../../itinerary/forms/ShowItineraryForm.vue';
import ActivityItineraryForm from '../../itinerary/forms/ActivityItineraryForm.vue';
import HotelItineraryForm from '../../itinerary/forms/HotelItineraryForm.vue';
import CustomModal from '../../common/CustomModal.vue';
import axios from 'axios';

export default {
    components: { CustomModal, FlyItineraryForm, TransferItineraryForm, BusItineraryForm, TrainItineraryForm, ShowItineraryForm, ActivityItineraryForm, HotelItineraryForm },
    props: {
        activity: Object,
    },
    data() {
        return {
            tour: null,
            tour_id: null,
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
            _starttime: '',
            _enddate: '',
            _endtime: '',
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
                    this.start_cities = response.data;
                } else {
                    this.end_cities = response.data;
                }
            });
        },
        updateCountries() {
            for (const tour of this.tours) {
                if (tour.id == this.tour_id) {
                    this.tour = tour
                    this.countries = tour.countries;
                    if (this.countries.length > 0) {
                        this.setCities(this.countries[0].code, 'start')
                        this.setCities(this.countries[0].code, 'end')
                    } else {
                        axios.get('api/countries', {
                            headers: {
                                'Authorization': `Bearer ${this.Utils.token()}`
                            }
                        }).then((response) => {
                            this.countries = response.data.data;
                            this.setCities(this.countries[0].code, 'start')
                            this.setCities(this.countries[0].code, 'end')
                        })
                    }
                }
            }
        }
    },
    created() {
        if (this.activity.startdate != null) {
            const date = new Date(this.activity.startdate)
            this._startdate = `${date.getFullYear()}-${(date.getMonth() + 1).toString().padStart(2, '0')}-${date.getDate().toString().padStart(2, '0')}`
            this._starttime = `${date.getHours().toString().padStart(2, '0')}:${date.getMinutes().toString().padStart(2, '0')}`
        }
        axios.get('api/tours', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.tours = response.data.data;
        });
        axios.get('api/typeitineraries', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.types = response.data.data;
        })
        axios.get('api/places', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.places = response.data.data;
        });
        axios.get('api/suppliers', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.suppliers = response.data.data;
        });
    },
}
</script>
<template>
    <CustomModal @close="$emit('close')">
        <form @submit.prevent="(e) => $emit('send', e)"
            class="gradient-2 rounded-2xl shadow-md shadow-gray-500 p-4 overflow-auto transition-all cursor-pointer">
            <h1
                class="font-bold bg-gradient-to-tr from-slate-200 text-center to-slate-500 text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black mb-2">
                <template v-if="activity.id == undefined">
                    AÑADIR ITINERARIO
                </template>
                <template v-else>
                    EDITAR ITINERARIO
                </template>
            </h1>
            <div class="overflow-auto modal-content">
                <div class="grid grid-cols-2 gap-x-2 mb-3">
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Gira</label>
                        <div class="flex items-center rounded border border-gray-300 px-2">
                            <select @change="updateCountries" v-model="tour_id" required name="tour_id"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                <template v-for="item in tours">
                                    <option class="text-black" v-if="item.active == 1" :value="item.id">{{
                                        item.tourname
                                    }}</option>
                                </template>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Tipo de itinerario</label>
                        <div class="flex items-center rounded border border-gray-300 px-2">
                            <select required v-model="activity.typeitinerary_id" name="typeitinerary_id"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                <option class="text-black" v-for="item in types" :value="item.id">{{
                                    item.description
                                }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <template v-if="tour != null">
                    <FlyItineraryForm @updatecities="setCities" :tour="tour" :activity="activity" :suppliers="suppliers"
                        :startdate="_startdate" :starttime="_starttime" :enddate="_enddate" :endtime="_endtime"
                        :countries="countries" :start_cities="start_cities" :end_cities="end_cities" :persons_1="persons_1"
                        :persons_2="persons_2" v-if="activity.typeitinerary_id == 1 || activity.typeitinerary_id == 2" />
                    <TransferItineraryForm @updatecities="setCities" :tour="tour" :activity="activity"
                        :suppliers="suppliers" :places="places" :startdate="_startdate" :starttime="_starttime"
                        :enddate="_enddate" :endtime="_endtime" :countries="countries" :start_cities="start_cities"
                        :end_cities="end_cities" :persons_1="persons_1" :persons_2="persons_2"
                        v-else-if="activity.typeitinerary_id == 3" />
                    <BusItineraryForm @updatecities="setCities" :tour="tour" :activity="activity" :suppliers="suppliers"
                        :startdate="_startdate" :starttime="_starttime" :enddate="_enddate" :endtime="_endtime"
                        :countries="countries" :start_cities="start_cities" :end_cities="end_cities" :persons_1="persons_1"
                        :persons_2="persons_2" v-else-if="activity.typeitinerary_id == 4" />
                    <TrainItineraryForm @updatecities="setCities" :tour="tour" :activity="activity" :suppliers="suppliers"
                        :startdate="_startdate" :starttime="_starttime" :enddate="_enddate" :endtime="_endtime"
                        :countries="countries" :start_cities="start_cities" :end_cities="end_cities" :persons_1="persons_1"
                        :persons_2="persons_2" v-else-if="activity.typeitinerary_id == 5" />
                    <HotelItineraryForm @updatecities="setCities" :tour="tour" :activity="activity" :suppliers="suppliers"
                        :startdate="_startdate" :starttime="_starttime" :enddate="_enddate" :endtime="_endtime"
                        :countries="countries" :start_cities="start_cities" :end_cities="end_cities" :persons_1="persons_1"
                        :persons_2="persons_2" v-else-if="activity.typeitinerary_id == 6" />
                    <ShowItineraryForm @updatecities="setCities" :tour="tour" :activity="activity" :places="places"
                        :startdate="_startdate" :starttime="_starttime" :enddate="_enddate" :endtime="_endtime"
                        :countries="countries" :start_cities="start_cities" :end_cities="end_cities" :persons_1="persons_1"
                        :persons_2="persons_2" v-else-if="activity.typeitinerary_id == 7" />
                    <ActivityItineraryForm @updatecities="setCities" :tour="tour" :activity="activity"
                        :suppliers="suppliers" :startdate="_startdate" :starttime="_starttime" :enddate="_enddate"
                        :endtime="_endtime" :countries="countries" :start_cities="start_cities" :end_cities="end_cities"
                        :persons_1="persons_1" :persons_2="persons_2"
                        v-else-if="activity.typeitinerary_id == 8 || activity.typeitinerary_id == 9" />
                </template>
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
