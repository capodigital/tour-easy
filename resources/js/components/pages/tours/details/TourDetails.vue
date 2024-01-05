<script>
import axios from 'axios'
import TourActivity from './TourActivity.vue';
import ActivityDetails from '../../../common/ActivityDetails.vue';
import AnimMixin from './AnimMixin';
import Confirm from '../../../modals/Confirm';
import ActivityModal from './ActivityModal.vue';
export default {
    mixins: [AnimMixin],
    data() {
        return {
            activities: [],
            tour: {
                artist: {}
            },
            details: null,
            activity: {},
            // tours: [],
            // contacts: [],
            // suppliers: [],
            // types: [],
            // countries: [],
            // start_cities: [],
            // end_cities: [],
            // places: [],
            show_images: false,
            images: [],
            show: false,
            uploading: false,
            preview: null
        };
    },
    components: { TourActivity, ActivityDetails, ActivityModal },
    methods: {
        // setCities(country, type) {
        //     axios.post('api/cities', { code: country }, {
        //         headers: {
        //             'Authorization': `Bearer ${this.Utils.token()}`
        //         }
        //     }).then((response) => {
        //         if (type == 'start') {
        //             this.start_cities = response.data;
        //         } else {
        //             this.end_cities = response.data;
        //         }
        //     });
        // },
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
            confirm.fire().then((result) => {
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
            if (activity.contact == null) {
                activity.contact = {
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
                    name = activity.name, description = `<b>Conductor: </b>${activity.contact.name}`,
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
                    name = `${activity.citystart.name} → ${activity.cityend.name}`, description = `<b>Conductor: </b>${activity.contact.name}`,
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
        remove(index) {
            const confirm = new Confirm('¡Confirmar operación!', '¿Seguro que desea eliminar esta imagen?')
            confirm.fire().then((result) => {
                axios.post('api/photos/' + this.images[index].id, { _method: 'delete' }, {
                    headers: {
                        'Authorization': `Bearer ${this.Utils.token()}`
                    }
                }).then((response) => {
                    this.images.splice(index, 1)
                    this.Utils.notify('Se eliminó la imagen correctamente');
                }).catch((error) => {
                    this.Utils.error(error.response)
                })
            })
        },
        updatePreview(e) {
            const files = e.target.files
            if (files && files.length) {
                this.preview = URL.createObjectURL(files[0])
            } else {
                this.preview = null
            }
        },
        saveImage(e) {
            const data = new FormData(e.target)
            this.uploading = true
            axios.post('api/photos', data, {
                headers: {
                    'Authorization': `Bearer ${this.Utils.token()}`
                }
            }).then((response) => {
                this.preview = null
                this.images.push(response.data.data)
                this.Utils.notify('Se subió la imagen correctamente')
                this.uploading = false
            }).catch((error) => {
                this.uploading = false
                this.Utils.error(error.response)
            })
        },
        openPicker() {
            if (this.preview == null) {
                this.$el.querySelector('#tour-image').click()
            }
        },
        sort(activities) {
            const sort = activities.sort((a, b) => {
                return new Date(a.startdate).valueOf() - new Date(b.startdate).valueOf()
                // return -1;
            })
            return sort
        }
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
        <!-- <div class="tour-images">
            <div class="stage bg-cover bg-no-repeat">

                <div class="absolute bottom-0 left-0 flex justify-center items-end z-30 w-full pb-3 md:pb-10">

                    <div class="text-center">
                        <h1
                            class="md:text-4xl font-bold bg-gradient-to-tr from-slate-100 to-slate-300 text-xl bg-clip-text text-transparent drop-shadow-md shadow-black">
                            {{ tour.tourname }}</h1>
                        <p class="text-2xl">{{ tour.artist.name }}</p>
                        <p class="text-lg">{{ tour.startdate }}----{{ tour.enddate }}</p>
                        <button @click="show_images = true"
                            class="rounded text-white text-sm z-50 border border-white px-2 py-1 hover:bg-white hover:text-black transition-all">Ver
                            imágenes</button>
                    </div>
                </div>
                <div class="hero">
                    <div class="hero__inner">
                        <div class="hero__cuboid hero__cuboid--1">
                            <div class="face face--front"><img src="src/statics/1.jpg" alt=""></div>
                            <div class="face face--back"><img src="src/statics/2.jpg" alt=""></div>
                            <div class="face face--left"><img src="src/statics/3.jpg" alt=""></div>
                            <div class="face face--right"><img src="src/statics/4.jpg" alt=""></div>
                            <div class="face face--top"></div>
                            <div class="face face--bottom"></div>
                        </div>
                        <div class="hero__cuboid hero__cuboid--2">
                            <div class="face face--front"><img src="src/statics/5.jpg" alt=""></div>
                            <div class="face face--back"><img src="src/statics/6.jpg" alt=""></div>
                            <div class="face face--left"><img src="src/statics/7.jpg" alt=""></div>
                            <div class="face face--right"><img src="src/statics/9.jpg" alt=""></div>
                            <div class="face face--top"></div>
                            <div class="face face--bottom"></div>
                        </div>
                        <div class="hero__cuboid hero__cuboid--3">
                            <div class="face face--front"><img src="src/statics/2.jpg" alt=""></div>
                            <div class="face face--back"><img src="src/statics/1.jpg" alt=""></div>
                            <div class="face face--left"><img src="src/statics/6.jpg" alt=""></div>
                            <div class="face face--right"><img src="src/statics/3.jpg" alt=""></div>
                            <div class="face face--top"></div>
                            <div class="face face--bottom"></div>
                        </div>
                        <div class="hero__cuboid hero__cuboid--4">
                            <div class="face face--front"><img src="src/statics/7.jpg" alt=""></div>
                            <div class="face face--back"><img src="src/statics/9.jpg" alt=""></div>
                            <div class="face face--left"><img src="src/statics/5.jpg" alt=""></div>
                            <div class="face face--right"><img src="src/statics/6.jpg" alt=""></div>
                            <div class="face face--top"></div>
                            <div class="face face--bottom"></div>
                        </div>
                    </div>
                </div>
                <div class="overlay"></div>
            </div>
        </div> -->
        <div class="ia-container">
            <figure>
                <img src="src/luis-fonsi/1.jpg" alt="image01" />
                <input type="radio" name="radio-set" checked="checked" />
                <figcaption><span>{{ tour.tourname }}</span></figcaption>

                <figure>
                    <img src="src/luis-fonsi/2.jpg" alt="image02" />
                    <input type="radio" name="radio-set" />
                    <figcaption><span>{{ tour.tourname }}</span></figcaption>

                    <figure>
                        <img src="src/luis-fonsi/3.jpg" alt="image03" />
                        <input type="radio" name="radio-set" />
                        <figcaption><span>{{ tour.tourname }}</span></figcaption>

                        <figure>
                            <img src="src/luis-fonsi/4.jpg" alt="image04" />
                            <input type="radio" name="radio-set" />
                            <figcaption><span>{{ tour.tourname }}</span></figcaption>

                            <figure>
                                <img src="src/luis-fonsi/5.jpg" alt="image05" />
                                <input type="radio" name="radio-set" />
                                <figcaption><span>{{ tour.tourname }}</span></figcaption>

                                <figure>
                                    <img src="src/luis-fonsi/6.jpg" alt="image06" />
                                    <input type="radio" name="radio-set" />
                                    <figcaption><span>{{ tour.tourname }}</span></figcaption>

                                    <figure>
                                        <img src="src/luis-fonsi/7.jpg" alt="image07" />
                                        <input type="radio" name="radio-set" />
                                        <figcaption><span>{{ tour.tourname }}</span></figcaption>

                                        <figure>
                                            <img src="src/luis-fonsi/8.jpg" alt="image08" />
                                            <input id="ia-selector-last" type="radio" name="radio-set" />
                                            <figcaption><span>{{ tour.tourname }}</span></figcaption>

                                            <figure>
                                                <img src="src/luis-fonsi/9.jpg" alt="image08" />
                                                <input id="ia-selector-last" type="radio" name="radio-set" />
                                                <figcaption><span>{{ tour.tourname }}</span></figcaption>

                                                <figure>
                                                    <img src="src/luis-fonsi/10.jpg" alt="image08" />
                                                    <input id="ia-selector-last" type="radio" name="radio-set" />
                                                    <figcaption><span>{{ tour.tourname }}</span></figcaption>

                                                    <figure>
                                                        <img src="src/luis-fonsi/11.jpg" alt="image08" />
                                                        <input id="ia-selector-last" type="radio" name="radio-set" />
                                                        <figcaption><span>{{ tour.tourname }}</span></figcaption>

                                                        <figure>
                                                            <img src="src/luis-fonsi/12.jpg" alt="image08" />
                                                            <input id="ia-selector-last" type="radio" name="radio-set" />
                                                            <figcaption><span>{{ tour.tourname }}</span></figcaption>

                                                            <figure>
                                                                <img src="src/luis-fonsi/13.jpg" alt="image08" />
                                                                <input id="ia-selector-last" type="radio" name="radio-set" />
                                                                <figcaption><span>{{ tour.tourname }}</span></figcaption>

                                                                <figure>
                                                                    <img src="src/luis-fonsi/14.jpg" alt="image08" />
                                                                    <input id="ia-selector-last" type="radio" name="radio-set" />
                                                                    <figcaption><span>{{ tour.tourname }}</span></figcaption>

                                                                    <figure>
                                                                        <img src="src/luis-fonsi/15.jpg" alt="image08" />
                                                                        <input id="ia-selector-last" type="radio" name="radio-set" />
                                                                        <figcaption><span>{{ tour.tourname }}</span></figcaption>

                                                                        <figure>
                                                                            <img src="src/luis-fonsi/16.jpg" alt="image08" />
                                                                            <input id="ia-selector-last" type="radio" name="radio-set" />
                                                                            <figcaption><span>{{ tour.tourname }}</span></figcaption>
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
        <div class="mt-4 grid sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-3 z-50 p-4">
            <TourActivity v-for="item in sort(activities)" @show="(item) => details = item" @edit="edit" @destroy="destroy"
                :activity="item" />
            <article @click="add" v-if="Utils.role() != 'artist'"
                class="border-2 border-gray-500 rounded-2xl cursor-pointer border-dashed min-h-[10rem] flex justify-center items-center">
                <i class="bi bi-plus text-6xl text-gray-500"></i>
            </article>
        </div>
        <transition name="bounce" mode="out-in">
            <div v-if="show_images"
                class="w-full bg-white bg-opacity-90 h-screen absolute left-0 top-0 px-2 py-2 flex justify-center items-center">
                <div class="images-modal overflow-auto scroll">
                    <div class="flex items-center">
                        <h1
                            class="font-bold bg-gradient-to-tr w-full  from-slate-500 text-center to-black text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black mb-2">
                            IMÁGENES DE LA GIRA
                        </h1>
                        <button @click="show_images = false"
                            class="bg-slate-800 text-white rounded px-2 py-1">Cerrar</button>
                    </div>

                    <div v-viewer="options" class="images md:grid">
                        <div class="relative" v-for="(image, index) in images">
                            <button @click="remove(index)"
                                class="absolute bg-transparent border-none z-50 focus:outline-none text-white top-1 right-1"><i
                                    class="bi bi-trash"></i></button>
                            <div class="image cursor-pointer h-56 bg-cover bg-center"
                                :style="{ 'background-image': `url(${image.url})` }" :key="index">
                                <img class="opacity-0" :src="image.url" :alt="`${tour.tourname} - ${index}`" />
                            </div>

                        </div>
                        <form @submit.prevent="saveImage">
                            <input type="file" @change="updatePreview" class="hidden" id="tour-image" name="image" />
                            <input type="hidden" name="tour_id" :value="tour.id" />
                            <div @click="openPicker" :class="{ 'border-2': preview == null }"
                                class="relative border-gray-500 h-full rounded cursor-pointer border-dashed min-h-[14rem] flex justify-center items-center">
                                <i v-if="preview == null" class="bi bi-plus text-6xl text-gray-500"></i>
                                <div class="h-56 w-full bg-cover" v-else :style="{ 'background-image': `url(${preview})` }">
                                    <button v-if="uploading != true" @click="preview = null"
                                        class="absolute bg-transparent border-none z-50 focus:outline-none text-white top-1 right-1"><i
                                            class="bi bi-trash"></i></button>
                                    <div
                                        class="absolute top-0 left-0 w-full h-full bg-black bg-opacity-50 flex items-center justify-center">
                                        <div v-if="uploading" class="spinner-border me-2" role="status"><span
                                                class="visually-hidden">Loading...</span></div>
                                        <button v-else class="text-white text-4xl opacity-75 hover:opacity-100"
                                            type="submit"><i class="bi bi-upload"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </transition>
        <transition name="bounce" mode="out-in">
            <ActivityModal @close="show = false" @send="send" :activity="activity" :tour="tour" v-if="show" />
        </transition>
        <transition name="bounce" mode="out-in">
            <ActivityDetails @close="details = null" v-if="details != null" :activity="details" />
        </transition>
    </section>
</template>
<style scoped>
h1 {
    font-family: 'Archivo Black', sans-serif;
}

.stage {
    background-image: url("/src/background.jpg");

    position: relative;
}

.stage::before {
    background-color: rgba(0, 0, 0, 0.712);
    content: " ";
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
}

form,
.images-modal {
    max-height: calc(100vh - 8rem);
}

.images {
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    grid-gap: 1px;
}

.ia-container {
	width: calc(100vw - 40px);
	margin: 20px auto;
	overflow: hidden;
	box-shadow: 1px 1px 4px rgba(0,0,0,0.08);
	border: 7px solid rgba(255,255,255,0.6);
}
.ia-container figure {
    position: absolute;
	top: 0;
	left: 50px; /* width of visible piece */
	width: 335px;
    height: 100%;
    box-shadow: 0 0 0 1px rgba(255,255,255,0.6);
    transition: all 0.3s ease-in-out;
}
.ia-container > figure {
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
	width: 50px; /* just cover visible part */
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
.ia-container input:checked{
	width: 5px;
	left: auto;
	right: 0px;
}
.ia-container input:checked ~ figure {
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
	top: 40%;
	margin-top: -30px;
	right: 20px;
	left: 20px;
	overflow: hidden;
	text-align: center;
	background: rgba(87, 73, 81, 0.3);
	line-height: 20px;
	font-size: 18px;
    opacity: 0;
	text-transform: uppercase;
	letter-spacing: 4px;
	font-weight: 700;
	padding: 20px;
	color: #fff;
	text-shadow: 1px 1px 1px rgba(0,0,0,0.1);
}
.ia-container input:checked + figcaption,
.ia-container input:checked:hover + figcaption{
	background: rgba(87, 73, 81, 0);
}
.ia-container input:checked + figcaption span {
    transition: all 0.4s ease-in-out 0.5s;
	opacity: 1;
	top: 50%;
}
.ia-container #ia-selector-last:checked + figcaption span {
	transition-delay: 0.3s;
}
.ia-container input:hover + figcaption {
	background: rgba(87, 73, 81, 0.03);
}
.ia-container input:checked ~ figure input{
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

	.ia-container input:checked ~ figure {
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

	.ia-container input:checked ~ figure {
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
