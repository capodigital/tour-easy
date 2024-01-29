<script>
import CustomModal from '../../common/CustomModal.vue';
import axios from 'axios';

export default {
    components: { CustomModal },
    props: {
        ticket: Object,
    },
    data() {
        return {
            currencies: [],
            itineraries: [],
            tours: [],
            tour_id: 1,
        }
    },
    methods: {
        setItineraries(id) {
            axios.post('api/itineraries/tour', { id: id }, {
                headers: {
                    'Authorization': `Bearer ${this.Utils.token()}`
                }
            }).then((response) => {
                this.itineraries = response.data.data
            })
        }
    },
    created() {
        axios.get('api/tours', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.tours = response.data.data
            if (this.ticket.id != undefined) {
                this.tour_id = this.ticket.itinerary.tour_id
                this.setItineraries(this.tour_id)
            } else {
                if (this.tours.length > 0)
                    this.setItineraries(this.tours[0].id)
            }
        }).catch((error) => {
            this.Utils.error(error.response)
        })
        axios.get('src/currencies.json', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.currencies = response.data
        }).catch((error) => {
            this.Utils.error(error.response)
        })
    },
}
</script>
<template>
    <CustomModal @close="$emit('close')">
        <form @submit.prevent="(e) => $emit('send', e)"
            class="gradient-2 rounded-2xl shadow-md shadow-gray-800 p-4 overflow-auto transition-all cursor-pointer">
            <input type="hidden" :value="Utils.user().id" name="agency_id" />
            <h1
                class="font-bold bg-gradient-to-tr from-slate-200 text-center to-slate-500 text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black mb-2">
                <template v-if="ticket.id == undefined">
                    AÑADIR TICKET
                </template>
                <template v-else>
                    EDITAR TICKET
                </template>
            </h1>
            <div class="overflow-auto modal-content">
                <div class="grid grid-cols-2 gap-x-2 mb-3">
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Gira</label>
                        <div class="flex items-center rounded border border-gray-300 px-2">
                            <select required @change="(e) => setItineraries(e.target.value)" v-model="tour_id"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                <option class="text-black" v-for="item in tours" :value="item.id">
                                    {{ item.tourname }} ({{ item.artist.stagename }})
                                </option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Itinerario</label>
                        <div class="flex items-center rounded border border-gray-300 px-2">
                            <select required v-model="ticket.itinerary_id" name="itinerary_id"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                <option class="text-black" v-for="itinerary in itineraries" :value="itinerary.id">
                                    {{ itinerary.startdate }} - {{ itinerary.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-x-2">
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Nombre(s)</label>
                        <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                            <i class="bi bi-person text-gray-100"></i>
                            <input required v-model="ticket.name" name="name" type="text" placeholder="Nombre(s)"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                        </div>
                    </div>
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Apellidos</label>
                        <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                            <i class="bi bi-person text-gray-100"></i>
                            <input required v-model="ticket.lastname" name="lastname" type="text" placeholder="Apellidos"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-x-2">
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Correo electrónico</label>
                        <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                            <i class="bi bi-envelope text-gray-100"></i>
                            <input required v-model="ticket.email" name="email" type="email"
                                placeholder="Correo electrónico"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                        </div>
                    </div>
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Billetera electrónica</label>
                        <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                            <i class="bi bi-wallet text-gray-100"></i>
                            <input required v-model="ticket.wallet" name="wallet" type="text"
                                placeholder="Billetera electrónica"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-x-2">
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Moneda</label>
                        <div class="flex items-center rounded border border-gray-300 px-2">
                            <select required v-model="ticket.chain" name="chain"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                <option class="text-black" v-for="currency in currencies"
                                    :value="`${currency.currency} (${currency.abbreviation})`">
                                    {{ currency.currency }} ({{ currency.abbreviation }})
                                </option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Monto total</label>
                        <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                            <i class="bi bi-cash text-gray-100"></i>
                            <input required v-model="ticket.amount" name="amount" type="number" placeholder="Monto total"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                        </div>
                    </div>
                </div>
                <div>
                    <label class="text-slate-200 text-xs font-semibold">Descripción</label>
                    <div class="flex items-center mb-3 rounded border border-gray-300 px-1 py-1">
                        <textarea rows="3" v-model="ticket.notes" name="notes" placeholder="Datos adicionales"
                            class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-1 py-1"></textarea>
                    </div>
                </div>
            </div>
            <div class="flex justify-center">
                <button type="button" @click="$emit('close')"
                    class="mt-8 me-2 close overlay-button bg-gradient-to-tr from-gray-600 to-gray-700 text-white px-3 py-3 w-full rounded-xl rounded-tr">
                    Cerrar
                </button>
                <button type="submit"
                    class="mt-8 overlay-button bg-gradient-to-tr from-app-primary-500 to-pp-primary-700 text-white px-3 py-3 w-full rounded-xl rounded-tr">
                    <template v-if="ticket.id == undefined">
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
