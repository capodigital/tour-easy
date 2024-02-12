<script>
import axios from 'axios'
import TourActivity from './TourActivity.vue';
import ActivityDetails from '../../../common/ActivityDetails.vue';
import Confirm from '../../../modals/Confirm';
import ActivityModal from './ActivityModal.vue';
import ImageModal from './ImageModal.vue';
import PhotosDetails from './PhotosDetails.vue';
export default {
    data() {
        return {
            activities: [],
            tour: {
                artist: {}
            },
            images: [],
            details: null,
            activity: {
                persons_1: [],
                persons_2: [],
            },
            show_images: false,
            show: false,
        };
    },
    components: { TourActivity, ActivityDetails, ActivityModal, ImageModal, PhotosDetails },
    methods: {
        add() {
            this.activity = {
                tour_id: this.tour.id,
                persons_1: [],
                persons_2: [],
            }
            this.show = true
        },
        edit(item) {
            Object.assign(this.activity, item)
            this.show = true
        },
        destroy(item) {
            const confirm = new Confirm('¡Confirmar operación!', '¿Seguro que desea eliminar este itinerario?')
            confirm.fire().then(() => {
                axios.post('api/itineraries/' + item.id, { _method: 'delete' }, {
                    headers: {
                        'Authorization': `Bearer ${this.Utils.token()}`
                    }
                }).then(() => {
                    for (let i in this.activities) {
                        if (this.activities[i].id == item.id) {
                            this.Utils.notify('Se eliminó el itinerario correctamente');
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
                    this.Utils.notify('Se ha creado el itinerario correctamente');
                    this.activities.push(response.data.data)
                } else {
                    for (let i in this.activities) {
                        if (this.activities[i].id == this.activity.id) {
                            this.activities[i] = response.data.data
                            this.Utils.notify('Se ha actualizado el itinerario correctamente')
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
    },
    created() {
        const id = location.hash.substring(location.hash.lastIndexOf('/') + 1)
        axios.post('api/itineraries/tour', { id: id }, {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            for (let activity of response.data.data) {
                this.activities.push(activity)
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
    },
}
</script>
<template>
    <section>
        <PhotosDetails :tour="tour" :images="images" />
        <div class="flex px-2">
            <h1
                class="font-bold bg-gradient-to-tr w-full from-app-secondary-500 to-app-secondary-800 text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black">
                ITINERARIOS</h1>
            <div class="text-end">
                <button @click="show_images = true"
                    class="px-2 py-1 mb-1 text-white bg-gradient-to-tr from-app-primary-500 to-app-primary-700 text-sm rounded whitespace-nowrap">
                    <i class="bi bi-file-image"></i> Ver imágenes
                </button>
                <a :href="'#calendar/' + tour.id"
                    class="px-[1.09rem] py-1 text-white bg-gradient-to-tr from-app-primary-500 to-app-primary-700 text-sm rounded whitespace-nowrap">
                    <i class="bi bi-calendar-date"></i> Calendario
                </a>
            </div>
        </div>
        <div class="mt-4 grid sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-3 gap-3 z-50 p-4">
            <TourActivity v-for="item in Utils.sort(activities)" @show="(item) => details = item" @edit="edit"
                @destroy="destroy" :activity="item" />
            <article @click="add" v-if="Utils.role() != 'artist' && tour.id != undefined"
                class="border-2 border-gray-500 rounded-2xl cursor-pointer border-dashed min-h-[10rem] flex justify-center items-center">
                <i class="bi bi-plus text-6xl text-gray-500"></i>
            </article>
        </div>
        <ImageModal :tour="tour" v-if="show_images" @update="(items) => images = items" @close="show_images = false" />
        <ActivityModal @close="show = false" @send="send" :activity="activity" :tour="tour" v-if="show" />
        <ActivityDetails @close="details = null" v-if="details != null" :activity="details" />
    </section>
</template>
<style scoped>
h1 {
    font-family: 'Archivo Black', sans-serif;
}
</style>
