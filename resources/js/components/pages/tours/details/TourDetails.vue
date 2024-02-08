<script>
import axios from 'axios'
import TourActivity from './TourActivity.vue';
import ActivityDetails from '../../../common/ActivityDetails.vue';
import Confirm from '../../../modals/Confirm';
import ActivityModal from './ActivityModal.vue';
import ImageModal from './ImageModal.vue';
export default {
    data() {
        return {
            activities: [],
            tour: {
                artist: {}
            },
            images: [],
            details: null,
            activity: {},
            show_images: false,
            show: false,
        };
    },
    components: { TourActivity, ActivityDetails, ActivityModal, ImageModal },
    methods: {
        add() {
            this.activity = { tour_id: this.tour.id }
            this.show = true
        },
        edit(item) {
            Object.assign(this.activity, item)
            this.show = true
        },
        destroy(item) {
            const confirm = new Confirm('¡Confirmar operación!', '¿Seguro que desea eliminar esta actividad?')
            confirm.fire().then(() => {
                axios.post('api/itineraries/' + item.id, { _method: 'delete' }, {
                    headers: {
                        'Authorization': `Bearer ${this.Utils.token()}`
                    }
                }).then(() => {
                    for (let i in this.activities) {
                        if (this.activities[i].id == item.id) {
                            this.Utils.notify('Se eliminó la actividad correctamente');
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
                    this.Utils.notify('Se ha creado la actividad correctamente');
                    this.activities.push(this.getActivityData(response.data.data))
                } else {
                    for (let i in this.activities) {
                        if (this.activities[i].id == this.activity.id) {
                            this.activities[i] = this.getActivityData(response.data.data)
                            this.Utils.notify('Se ha actualizado la actividad correctamente')
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
        getActivityData(activity) {
            let name = '', description = '', type = activity.typeitinerary_id, start = activity.startdate, end = activity.enddate, complete = ''
            if (new Date(start) > new Date()) {
                complete = 'No completado'
            } else {
                if (new Date() < new Date(end)) {
                    complete = 'En progreso'
                } else {
                    complete = 'Completado'
                }
            }
            if (activity.person == null) {
                activity.person = {
                    id: 0,
                    name: 'Contacto eliminado'
                }
            }
            if (activity.place == null) {
                activity.place = {
                    id: 0,
                    name: 'Lugar eliminado'
                }
            }
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
                    name = activity.name, description = `<b>Lugar: </b>${activity.place.name}`,
                        date = `<br /><div class="flex flex-col items-center"><div>${start}</div><div>${activity.enddate}</div></div>`;
                    break;
                case 4:
                    name = activity.name, description = `<b>Conductor: </b>${activity.person.name}`,
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
                    name = `${activity.citystart.name} → ${activity.cityend.name}`, description = `<b>Conductor: </b>${activity.person.name}`,
                        date = `<br /><div class="flex flex-col items-center"><div>${start}</div><div>${activity.enddate}</div></div>`;
                    break;
            }
            const item = activity
            item.name = name
            item.type = type
            item.description = description
            item.date = date
            item.start = start
            item.complete = complete
            return item
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
                this.activities.push(this.getActivityData(activity))
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
        <div class="ia-container">
            <figure>
                <img :src="images.length > 0 ? images[0].url : 'src/image-placeholder.jpg'" />
                <input type="radio" name="radio-set" checked="checked" />
                <figcaption><span>
                        <p class="text-xs md:text-md">{{ tour.tourname }}</p>
                        <p class="text-xs mt-2">{{ tour.artist.stagename }}</p>
                        <p class="text-xs mt-2">{{ tour.startdate }} - {{ tour.enddate }}</p>
                    </span></figcaption>

                <figure>
                    <img :src="images.length > 1 ? images[1].url : 'src/image-placeholder.jpg'" />
                    <input type="radio" name="radio-set" />
                    <figcaption><span>
                            <p class="text-xs md:text-md">{{ tour.tourname }}</p>
                            <p class="text-xs mt-2">{{ tour.artist.stagename }}</p>
                            <p class="text-xs mt-2">{{ tour.startdate }} - {{ tour.enddate }}</p>
                        </span></figcaption>

                    <figure>
                        <img :src="images.length > 2 ? images[2].url : 'src/image-placeholder.jpg'" />
                        <input type="radio" name="radio-set" />
                        <figcaption><span>
                                <p class="text-xs md:text-md">{{ tour.tourname }}</p>
                                <p class="text-xs mt-2">{{ tour.artist.stagename }}</p>
                                <p class="text-xs mt-2">{{ tour.startdate }} - {{ tour.enddate }}</p>
                            </span></figcaption>

                        <figure>
                            <img :src="images.length > 3 ? images[3].url : 'src/image-placeholder.jpg'" />
                            <input type="radio" name="radio-set" />
                            <figcaption><span>
                                    <p class="text-xs md:text-md">{{ tour.tourname }}</p>
                                    <p class="text-xs mt-2">{{ tour.artist.stagename }}</p>
                                    <p class="text-xs mt-2">{{ tour.startdate }} - {{ tour.enddate }}</p>
                                </span></figcaption>

                            <figure>
                                <img :src="images.length > 4 ? images[4].url : 'src/image-placeholder.jpg'" />
                                <input type="radio" name="radio-set" />
                                <figcaption><span>
                                        <p class="text-xs md:text-md">{{ tour.tourname }}</p>
                                        <p class="text-xs mt-2">{{ tour.artist.stagename }}</p>
                                        <p class="text-xs mt-2">{{ tour.startdate }} - {{ tour.enddate }}</p>
                                    </span></figcaption>

                                <figure>
                                    <img :src="images.length > 5 ? images[5].url : 'src/image-placeholder.jpg'" />
                                    <input type="radio" name="radio-set" />
                                    <figcaption><span>
                                            <p class="text-xs md:text-md">{{ tour.tourname }}</p>
                                            <p class="text-xs mt-2">{{ tour.artist.stagename }}</p>
                                            <p class="text-xs mt-2">{{ tour.startdate }} - {{ tour.enddate }}</p>
                                        </span></figcaption>

                                    <figure>
                                        <img :src="images.length > 6 ? images[6].url : 'src/image-placeholder.jpg'" />
                                        <input type="radio" name="radio-set" />
                                        <figcaption><span>
                                                <p class="text-xs md:text-md">{{ tour.tourname }}</p>
                                                <p class="text-xs mt-2">{{ tour.artist.stagename }}</p>
                                                <p class="text-xs mt-2">{{ tour.startdate }} - {{ tour.enddate }}</p>
                                            </span></figcaption>

                                        <figure>
                                            <img :src="images.length > 7 ? images[7].url : 'src/image-placeholder.jpg'" />
                                            <input id="ia-selector-last" type="radio" name="radio-set" />
                                            <figcaption><span>
                                                    <p class="text-xs md:text-md">{{ tour.tourname }}</p>
                                                    <p class="text-xs mt-2">{{ tour.artist.stagename }}</p>
                                                    <p class="text-xs mt-2">{{ tour.startdate }} - {{ tour.enddate }}</p>
                                                </span></figcaption>

                                            <figure>
                                                <img
                                                    :src="images.length > 8 ? images[8].url : 'src/image-placeholder.jpg'" />
                                                <input id="ia-selector-last" type="radio" name="radio-set" />
                                                <figcaption><span>
                                                        <p class="text-xs md:text-md">{{ tour.tourname }}</p>
                                                        <p class="text-xs mt-2">{{ tour.artist.stagename }}</p>
                                                        <p class="text-xs mt-2">{{ tour.startdate }} - {{ tour.enddate }}
                                                        </p>
                                                    </span></figcaption>

                                                <figure>
                                                    <img
                                                        :src="images.length > 9 ? images[9].url : 'src/image-placeholder.jpg'" />
                                                    <input id="ia-selector-last" type="radio" name="radio-set" />
                                                    <figcaption><span>
                                                            <p class="text-xs md:text-md">{{ tour.tourname }}</p>
                                                            <p class="text-xs mt-2">{{ tour.artist.stagename }}</p>
                                                            <p class="text-xs mt-2">{{ tour.startdate }} - {{ tour.enddate
                                                            }}</p>
                                                        </span></figcaption>

                                                    <figure>
                                                        <img
                                                            :src="images.length > 10 ? images[10].url : 'src/image-placeholder.jpg'" />
                                                        <input id="ia-selector-last" type="radio" name="radio-set" />
                                                        <figcaption><span>
                                                                <p class="text-xs md:text-md">{{ tour.tourname }}</p>
                                                                <p class="text-xs mt-2">{{ tour.artist.stagename }}</p>
                                                                <p class="text-xs mt-2">{{ tour.startdate }} - {{
                                                                    tour.enddate }}</p>
                                                            </span></figcaption>

                                                        <figure>
                                                            <img
                                                                :src="images.length > 11 ? images[11].url : 'src/image-placeholder.jpg'" />
                                                            <input id="ia-selector-last" type="radio" name="radio-set" />
                                                            <figcaption><span>
                                                                    <p class="text-xs md:text-md">{{ tour.tourname }}</p>
                                                                    <p class="text-xs mt-2">{{ tour.artist.stagename }}</p>
                                                                    <p class="text-xs mt-2">{{ tour.startdate }} - {{
                                                                        tour.enddate }}</p>
                                                                </span></figcaption>

                                                            <figure>
                                                                <img
                                                                    :src="images.length > 12 ? images[12].url : 'src/image-placeholder.jpg'" />
                                                                <input id="ia-selector-last" type="radio"
                                                                    name="radio-set" />
                                                                <figcaption><span>
                                                                        <p class="text-xs md:text-md">{{ tour.tourname }}
                                                                        </p>
                                                                        <p class="text-xs mt-2">{{ tour.artist.stagename }}
                                                                        </p>
                                                                        <p class="text-xs mt-2">{{ tour.startdate }} - {{
                                                                            tour.enddate }}</p>
                                                                    </span></figcaption>

                                                                <figure>
                                                                    <img
                                                                        :src="images.length > 13 ? images[13].url : 'src/image-placeholder.jpg'" />
                                                                    <input id="ia-selector-last" type="radio"
                                                                        name="radio-set" />
                                                                    <figcaption><span>{{ tour.tourname }}</span>
                                                                    </figcaption>

                                                                    <figure>
                                                                        <img
                                                                            :src="images.length > 14 ? images[14].url : 'src/image-placeholder.jpg'" />
                                                                        <input id="ia-selector-last" type="radio"
                                                                            name="radio-set" />
                                                                        <figcaption><span>{{ tour.tourname }}</span>
                                                                        </figcaption>

                                                                        <figure>
                                                                            <img
                                                                                :src="images.length > 15 ? images[15].url : 'src/image-placeholder.jpg'" />
                                                                            <input id="ia-selector-last" type="radio"
                                                                                name="radio-set" />
                                                                            <figcaption><span>{{ tour.tourname }}</span>
                                                                            </figcaption>

                                                                            <figure>
                                                                                <img
                                                                                    :src="images.length > 16 ? images[16].url : 'src/image-placeholder.jpg'" />
                                                                                <input id="ia-selector-last" type="radio"
                                                                                    name="radio-set" />
                                                                                <figcaption><span>{{ tour.tourname }}</span>
                                                                                </figcaption>

                                                                                <figure>
                                                                                    <img
                                                                                        :src="images.length > 17 ? images[17].url : 'src/image-placeholder.jpg'" />
                                                                                    <input id="ia-selector-last"
                                                                                        type="radio" name="radio-set" />
                                                                                    <figcaption><span>{{ tour.tourname
                                                                                    }}</span>
                                                                                    </figcaption>
                                                                                </figure>
                                                                            </figure>
                                                                        </figure>
                                                                    </figure>
                                                                </figure>
                                                            </figure>
                                                        </figure>
                                                    </figure>
                                                </figure>
                                            </figure>
                                        </figure>

                                    </figure>

                                </figure>

                            </figure>

                        </figure>

                    </figure>

                </figure>

            </figure>

        </div>
        <div class="flex px-2">
            <h1
                class="font-bold bg-gradient-to-tr w-full from-app-secondary-500 to-app-secondary-800 text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black">
                ACTIVIDADES</h1>
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
            <article @click="add" v-if="Utils.role() != 'artist'"
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



.ia-container {
    /*width: calc(100vw - 40px);*/
    margin: 20px auto;
    overflow: hidden;
    box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.08);
    border: 7px solid rgba(255, 255, 255, 0.6);
}

.ia-container figure {
    position: absolute;
    top: 0;
    left: 50px;
    /* width of visible piece */
    width: 335px;
    height: 100%;
    box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.6);
    transition: all 0.3s ease-in-out;
}

.ia-container>figure {
    position: relative;
    left: 0 !important;
}

.ia-container img {
    display: block;
    width: 100%;
    height: 100%;
}

.ia-container input {
    position: absolute;
    top: 0;
    left: 0;
    width: 50px;
    /* just cover visible part */
    height: 100%;
    cursor: pointer;
    border: 0;
    padding: 0;
    opacity: 0;
    z-index: 100;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
}

.ia-container input:checked {
    width: 5px;
    left: auto;
    right: 0px;
}

.ia-container input:checked~figure {
    left: 335px;
    transition: all 0.7s ease-in-out;
}

.ia-container figcaption {
    width: 100%;
    height: 100%;
    background: rgba(87, 73, 81, 0.1);
    position: absolute;
    top: 0px;
    transition: all 0.2s linear;
}

.ia-container figcaption span {
    position: absolute;
    top: 10%;
    margin-top: -30px;
    right: 20px;
    left: 20px;
    overflow: hidden;
    text-align: center;
    background: rgba(87, 73, 81, 0.4);
    line-height: 20px;
    font-size: 18px;
    opacity: 0;
    text-transform: uppercase;
    letter-spacing: 4px;
    font-weight: 700;
    padding: 20px;
    color: #fff;
    text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.1);
}

.ia-container input:checked+figcaption,
.ia-container input:checked:hover+figcaption {
    background: rgba(87, 73, 81, 0);
}

.ia-container input:checked+figcaption span {
    transition: all 0.4s ease-in-out 0.5s;
    opacity: 1;
    top: 40%;
}

.ia-container #ia-selector-last:checked+figcaption span {
    transition-delay: 0.3s;
}

.ia-container input:hover+figcaption {
    background: rgba(87, 73, 81, 0.03);
}

.ia-container input:checked~figure input {
    z-index: 1;
}

@media screen and (max-width: 720px) {
    .ia-container {
        width: 540px;
    }

    .ia-container figure {
        left: 40px;
        width: 260px;
    }

    .ia-container input {
        width: 40px;
    }

    .ia-container input:checked~figure {
        left: 260px;
    }

    .ia-container figcaption span {
        font-size: 16px;
    }
}

@media screen and (max-width: 520px) {
    .ia-container {
        width: 320px;
    }

    .ia-container figure {
        left: 20px;
        width: 180px;
    }

    .ia-container input {
        width: 20px;
    }

    .ia-container input:checked~figure {
        left: 180px;
    }

    .ia-container figcaption span {
        font-size: 12px;
        letter-spacing: 2px;
        padding: 10px;
        margin-top: -20px;
    }

}
</style>
