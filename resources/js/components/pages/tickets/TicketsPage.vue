<script>
import axios from 'axios';
import TicketItem from './TicketItem.vue';
import Confirm from '../../modals/Confirm';

export default {
    components: { TicketItem },
    data() {
        return {
            filter: '',
            tickets: [],
            currencies: [],
            itineraries: [],
            tours: [],
            tour_id: 1,
            tour_filter: 0,
            ticket: {},
            show: false
        };
    },
    methods: {
        add() {
            this.ticket = {}
            this.show = true
        },
        edit(item) {
            this.tour_id = item.tour_id
            this.setItineraries(item.tour_id)
            Object.assign(this.ticket, item)
            this.show = true
        },
        destroy(item) {
            const confirm = new Confirm('¡Confirmar operación!', '¿Seguro que desea eliminar este ticket?')
            confirm.fire().then((result) => {
                axios.post('api/tickets/' + item.id, { _method: 'delete' }, {
                    headers: {
                        'Authorization': `Bearer ${this.Utils.token()}`
                    }
                }).then((response) => {
                    for (let i in this.tickets) {
                        if (this.tickets[i].id == item.id) {
                            this.tickets.splice(i, 1)
                            this.Utils.notify('Se ha eliminado correctamente el ticket')
                            break
                        }
                    }
                })
            })
        },
        send(e) {
            const data = new FormData(e.target)
            this.Utils.lock(e.target)
            data.append('_method', this.ticket.id == undefined ? 'post' : 'put');
            axios.post(this.ticket.id == undefined ? 'api/tickets' : `api/tickets/${this.ticket.id}`, data, {
                headers: {
                    'Authorization': `Bearer ${this.Utils.token()}`
                }
            }).then((response) => {
                if (this.ticket.id == undefined) {
                    this.tickets.unshift(response.data.data)
                    this.Utils.notify('Se ha creado correctamente el ticket')
                } else {
                    for (let i in this.tickets) {
                        if (this.tickets[i].id == this.ticket.id) {
                            this.tickets[i] = response.data.data
                            this.Utils.notify('Se han actualizado correctamente los datos del ticket')
                            break
                        }
                    }
                }
                this.ticket = {}
                this.show = false
                this.Utils.unlock(e.target)
            }).catch((error) => {
                this.Utils.unlock(e.target)
                this.Utils.error(error.response)
            })
        },
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
        axios.get('api/tickets', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.tickets = response.data.data
        }).catch((error) => {
            this.Utils.error(error.response)
        })
        axios.get('api/tours', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.tours = response.data.data
            if (this.tours.length > 0)
                this.setItineraries(this.tours[0].id)
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
    }
}
</script>
<template>
    <section class="p-4">
        <div class="relative">
            <div class="flex">
                <h1
                    class="font-bold bg-gradient-to-tr w-full from-slate-500 to-black text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black">
                    TICKETS</h1>
                <div>
                    <div class="flex items-center rounded border border-gray-400 px-2 me-2">
                        <i class="bi bi-funnel-fill text-gray-400"></i>
                        <input v-model="filter" type="text" placeholder="Escribe para filtrar"
                            class="bg-transparent w-full text-gray-700 text-sm border-none focus:outline-none px-3 py-2">
                    </div>

                </div>
                <div>
                    <button v-if="Utils.role() != 'artist'" @click="add"
                        class="px-2 py-1 text-white bg-gradient-to-tr from-slate-800 to-slate-950 rounded">Añadir</button>
                </div>
            </div>
            <div class="flex justify-end mt-1">
                <select v-model="tour_filter" class="rounded border border-gray-500 px-3 pe-8 py-1 mt-1">
                    <option value="0">Todas las giras</option>
                    <option v-for="item in tours" :value="item.id">
                        {{ item.tourname }}
                    </option>
                </select>
            </div>
            <div class="mt-4 grid sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-3">
                <template v-for="item in tickets">
                    <TicketItem @edit="edit" @destroy="destroy" :ticket="item"
                        v-if="Utils.filter(['name', 'lastname', 'email', 'wallet', 'chain', 'notes', 'itinerary.name'], item, filter) && (tour_filter == 0 || tour_filter == item.itinerary.tour_id)" />
                </template>
            </div>
        </div>
        <transition name="bounce" mode="out-in">
            <div v-if="show"
                class="w-full bg-white bg-opacity-90 h-screen md:h-auto absolute top-0 px-2 py-2 flex justify-center items-center">
                <div>
                    <h1
                        class="font-bold bg-gradient-to-tr from-slate-500 text-center to-black text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black mb-2">
                        <template v-if="ticket.id == undefined">
                            AÑADIR
                        </template>
                        <template v-else>
                            EDITAR
                        </template>
                    </h1>
                    <form @submit.prevent="send"
                        class="bg-gradient-to-tr from-slate-700 via-black to-slate-950 rounded-3xl rounded-tr p-10 overflow-auto scroll">
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
                                    <input required v-model="ticket.lastname" name="lastname" type="text"
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
                                    <input required v-model="ticket.amount" name="amount" type="text"
                                        placeholder="Monto total"
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
                        <div class="flex justify-center">
                            <button type="button" @click="show = false"
                                class="mt-8 me-2 overlay-button bg-gradient-to-tr from-slate-100 to-slate-300 text-black px-3 py-3 w-full rounded-xl rounded-tr">
                                Cerrar
                            </button>
                            <button type="submit"
                                class="mt-8 overlay-button bg-gradient-to-tr from-slate-100 to-slate-300 text-black px-3 py-3 w-full rounded-xl rounded-tr">
                                <template v-if="ticket.id == undefined">
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
    </section>
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
