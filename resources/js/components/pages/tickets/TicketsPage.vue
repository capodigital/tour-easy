<script>
import axios from 'axios';
import TicketItem from './TicketItem.vue';
import Confirm from '../../modals/Confirm';
import TicketModal from './TicketModal.vue';

export default {
    components: { TicketItem, TicketModal },
    data() {
        return {
            filter: '',
            tickets: [],
            tours: [],
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
            <TicketModal v-if="show" @close="show = false" @send="send" :ticket="ticket" />
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
