<script>
import axios from 'axios';
import TourCard from './TourCard.vue';
import Confirm from '../../modals/Confirm';
import TourModal from './TourModal.vue';

export default {
    components: { TourCard, TourModal },
    data() {
        return {
            filter: '',
            tours: [],
            tour: {},
            show: false,
            active: 0,
            deleted: 0,
        };
    },
    methods: {
        add() {
            this.tour = {}
            this.socialmedias = [{}]
            this.preview = 'src/cartel-placeholder.jpeg'
            this.files = [{ type: 'link' }]
            this.show = true
        },
        edit(item) {
            Object.assign(this.tour, item)
            this.show = true
        },
        destroy(item) {
            const confirm = new Confirm('¡Confirmar operación!', '¿Seguro que desea eliminar esta gira?')
            confirm.fire().then((result) => {
                axios.post('api/tours/' + item.id, { _method: 'delete' }, {
                    headers: {
                        'Authorization': `Bearer ${this.Utils.token()}`
                    }
                }).then((response) => {
                    for (let i in this.tours) {
                        if (this.tours[i].id == item.id) {
                            this.tours.splice(i, 1)
                            this.Utils.notify('Se ha eliminado correctamente la gira')
                            break
                        }
                    }
                })
            })
        },
        complete(item) {
            const confirm = new Confirm('¡Confirmar operación!', '¿Seguro que desea completar esta gira?')
            confirm.fire().then((result) => {
                axios.post('api/tour/noactive', { id: item.id }, {
                    headers: {
                        'Authorization': `Bearer ${this.Utils.token()}`
                    }
                }).then((response) => {
                    for (let i in this.tours) {
                        if (this.tours[i].id == item.id) {
                            // this.tours.splice(i, 1)
                            this.tours[i].active = 0;
                            this.Utils.notify('Se ha completado correctamente la gira')
                            break
                        }
                    }
                })
            })
        },
        send(e) {
            const data = new FormData(e.target)
            this.Utils.lock(e.target)
            data.append('_method', this.tour.id == undefined ? 'post' : 'put');
            axios.post(this.tour.id == undefined ? 'api/tours' : `api/tours/${this.tour.id}`, data, {
                headers: {
                    'Authorization': `Bearer ${this.Utils.token()}`
                }
            }).then((response) => {
                if (this.tour.id == undefined) {
                    this.tours.unshift(response.data.data)
                    this.Utils.notify('Se ha creado correctamente la gira')
                } else {
                    for (let i in this.tours) {
                        if (this.tours[i].id == this.tour.id) {
                            this.tours[i] = response.data.data
                            this.Utils.notify('Se han actualizado correctamente los datos de la gira')
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

    },
    created() {
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
                    class="font-bold bg-gradient-to-tr w-full from-app-secondary-300 to-app-secondary-800 text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black">
                    GIRAS</h1>

                <button @click="add"
                    class="px-2 py-1 text-white bg-gradient-to-tr from-app-primary-500 to-app-primary-700 rounded whitespace-nowrap"><i class="bi bi-plus"></i> Añadir</button>
            </div>
            <div class="flex w-full justify-end mt-1">
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                    <div class="form-check items-center" v-if="Utils.role() == 'user'">
                        <input required aria-label="Ver giras terminadas"
                            @change="(e) => deleted = e.target.checked ? 1 : 0" class="form-check-input me-0.5"
                            type="checkbox" />
                        <label class="form-check-label leading-4 text-sm text-center mt-1">
                            Ver giras eliminadas
                        </label>
                    </div>
                    <div class="form-check items-center">
                        <input required aria-label="Ver giras terminadas" @change="(e) => active = e.target.checked ? 1 : 0"
                            class="form-check-input me-0.5" type="checkbox" />
                        <label class="form-check-label leading-4 text-sm text-center mt-1">
                            Ver giras terminadas
                        </label>
                    </div>
                    <div class="block sm:hidden"></div>
                    <div class="flex items-center rounded border border-gray-200 px-2 me-2">
                        <i class="bi bi-funnel-fill text-gray-200"></i>
                        <input v-model="filter" type="text" placeholder="Escribe para filtrar"
                            class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-2 placeholder:text-gray-300">
                    </div>
                </div>
            </div>
            <div class="mt-4 grid sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-3 gap-3">
                <template v-for="item in tours">
                    <TourCard @edit="edit" @destroy="destroy" @complete="complete" :tour="item"
                        v-if="Utils.filter(['tourname', 'startdate', 'enddate', 'notes', 'agency.tradename', 'agency.taxname', 'artist.name', 'artist.lastname', 'artist.stagename'], item, filter) && (item.active == 1 || active == 1) && (item.deleted_at == null || deleted == 1)" />
                </template>
            </div>
        </div>
        <transition name="bounce" mode="out-in">
            <TourModal v-if="show" @close="show = false" @send="send" :tour="tour" />
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
