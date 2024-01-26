<script>
import axios from 'axios';
import PlaceItem from './PlaceItem.vue';
import Confirm from '../../modals/Confirm';
import PlaceModal from './PlaceModal.vue';
import PlaceCard from './PlaceCard.vue';
import PlaceDetails from './PlaceDetails.vue';

export default {
    components: { PlaceItem, PlaceModal, PlaceCard, PlaceDetails },
    data() {
        return {
            filter: '',
            places: [],
            details: null,
            place: {},
            show: false
        };
    },
    methods: {
        add() {
            this.place = {}
            this.show = true
        },
        edit(item) {
            this.details = null
            Object.assign(this.place, item)
            this.show = true
        },
        destroy(item) {
            const confirm = new Confirm('¡Confirmar operación!', '¿Seguro que desea eliminar este lugar?')
            confirm.fire().then((result) => {
                axios.post('api/places/' + item.id, { _method: 'delete' }, {
                    headers: {
                        'Authorization': `Bearer ${this.Utils.token()}`
                    }
                }).then((response) => {
                    for (let i in this.places) {
                        if (this.places[i].id == item.id) {
                            this.places.splice(i, 1)
                            this.Utils.notify('Se ha eliminado correctamente el lugar')
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
            data.append('_method', this.place.id == undefined ? 'post' : 'put');
            axios.post(this.place.id == undefined ? 'api/places' : `api/places/${this.place.id}`, data, {
                headers: {
                    'Authorization': `Bearer ${this.Utils.token()}`
                }
            }).then((response) => {
                if (this.place.id == undefined) {
                    this.places.unshift(response.data.data)
                    this.Utils.notify('Se ha creado correctamente el lugar')
                } else {
                    for (let i in this.places) {
                        if (this.places[i].id == this.place.id) {
                            this.places[i] = response.data.data
                            this.Utils.notify('Se han actualizado correctamente los datos del lugar')
                            break
                        }
                    }
                }
                this.place = {}
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
    mounted() {
        axios.get('api/places', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.places = response.data.data
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
                    LUGARES</h1>
                <div></div>
                <div class="flex items-center rounded border border-gray-400 px-2 me-2">
                    <i class="bi bi-funnel-fill text-gray-400"></i>
                    <input v-model="filter" type="text" placeholder="Escribe para filtrar"
                        class="bg-transparent w-full text-gray-700 text-sm border-none focus:outline-none px-3 py-2">
                </div>
                <button @click="add"
                    class="px-2 py-1 text-white bg-gradient-to-tr from-slate-800 to-slate-950 rounded">Añadir</button>
            </div>
            <div class="mt-4 grid sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-3 gap-3">
                <template v-for="item in places">
                    <PlaceCard @edit="edit" @destroy="destroy" @show="details = item" :place="item"
                        v-if="Utils.filter(['name', 'email', 'phone', 'extra_phone', 'address', 'manager', 'notes', 'agency.tradename', 'agency.taxname', 'city.name', 'typeplace.description'], item, filter)" />
                </template>
            </div>
        </div>
        <PlaceDetails v-if="details != null" @close="details = null" :place="details" @edit="edit" />
        <PlaceModal v-if="show" :place="place" @send="send" @close="show = false" />
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
