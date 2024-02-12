<script>
import axios from "axios"
import DocumentsItem from '../../common/DocumentsItem.vue';
import ActivityDetails from '../../common/ActivityDetails.vue';
import DayItem from '../day/DayItem.vue';
import ActivityIcon from '../../common/ActivityIcon.vue';
import CustomModal from '../../common/CustomModal.vue';
import ContactItem from '../contacts/ContactItem.vue';

export default {
    components: { CustomModal, ActivityIcon, ActivityDetails, DayItem, DocumentsItem, ContactItem },
    props: {
        tour: Object,
    },
    data() {
        return {
            itineraries: [],
        }
    },
    methods: {
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
        sort(activities) {
            const sort = activities.sort((a, b) => {
                return new Date(a.startdate).valueOf() - new Date(b.startdate).valueOf()
            })
            return sort
        },
        print() {
            const element = this.$el.querySelector(".modal-content")
            var w = element.offsetWidth;
            var h = element.offsetHeight;
            console.log(h)
            const jsPDF = new __WEBPACK_EXTERNAL_MODULE_jspdf__('L', 'px', [w, 2000])

            html2pdf(element, {
                margin: 1,
                filename: "tour.pdf",
                jsPDF: jsPDF,
            });
        }
    },
    created() {
        axios.post('api/itineraries/tour', { id: this.tour.id }, {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            for (let activity of response.data.data) {
                this.itineraries.push(this.getActivityData(activity))
            }
        })
    }
}
</script>
<template>
    <CustomModal @close="$emit('close')">
        <section @submit.prevent="(e) => $emit('send', e)"
            class="max-w-3xl rounded-2xl shadow-md shadow-gray-800 p-4 overflow-auto transition-all cursor-pointer">
            <h1
                class="font-bold bg-gradient-to-tr from-slate-200 text-center to-slate-500 text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black mb-2">
                {{ tour.tourname }}
            </h1>
            <div class="overflow-auto modal-content">
                <!-- <img class="w-full rounded" :src="tour.tourcartel.replace('http://localhost/', '')" /> -->
                <div class="mt-1">
                    <h3 class="font-bold text-lg text-gray-200 text-center">{{ tour.artist.name }}</h3>
                </div>
                <p class="text-xs text-gray-400">{{ tour.notes }}</p>
                <div class="flex justify-around text-xs mt-2">
                    <div class="flex rounded bg-app-primary-500 bg-opacity-40 py-1 px-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none"
                            stroke="rgb(204, 212, 249)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-calendar-plus">
                            <path d="M21 13V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h8" />
                            <line x1="16" x2="16" y1="2" y2="6" />
                            <line x1="8" x2="8" y1="2" y2="6" />
                            <line x1="3" x2="21" y1="10" y2="10" />
                            <line x1="19" x2="19" y1="16" y2="22" />
                            <line x1="16" x2="22" y1="19" y2="19" />
                        </svg>
                        <p class="ms-1 text-app-primary-100">Desde: {{ tour.startdate }}</p>
                    </div>
                    <div class="flex rounded bg-app-primary-500 bg-opacity-40 py-1 px-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none"
                            stroke="rgb(204, 212, 249)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-calendar-check-2">
                            <path d="M21 14V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h8" />
                            <line x1="16" x2="16" y1="2" y2="6" />
                            <line x1="8" x2="8" y1="2" y2="6" />
                            <line x1="3" x2="21" y1="10" y2="10" />
                            <path d="m16 20 2 2 4-4" />
                        </svg>
                        <p class="ms-1 text-app-primary-100">Hasta: {{ tour.enddate }}</p>
                    </div>
                </div>
                <div class="my-3">
                    <DayItem v-for="itinerary in itineraries" :activity="itinerary" :collapsed="false" />
                </div>
                <div class="p-2">
                    <p class="text-sm text-white">Contactos</p>
                    <ContactItem v-for="item in tour.persons" :person="item" :select="false" />
                </div>
                <div class="p-2">
                    <p class="text-sm text-white">Redes sociales</p>
                    <div class="mt-3 leading-3">
                        <a v-for="socialmedia in tour.socialmedias" :href="socialmedia.url" target="_blank"
                            class="text-gray-300 text-sm mb-0 leading-5">
                            <p><strong>{{ socialmedia.typesocialmedia.name }}:</strong> {{ socialmedia.url }}</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="flex justify-center">
                <button type="button" @click="$emit('close')"
                    class="mt-8 me-2 close overlay-button bg-gradient-to-tr from-slate-600 to-slate-700 text-white px-3 py-3 w-full rounded-xl rounded-tr">
                    Cerrar
                </button>
                <a target="_blank" :href="'/print/' + tour.id"
                    class="mt-8 overlay-button bg-gradient-to-tr text-center from-app-primary-500 to-app-primary-700 text-white px-3 py-3 w-full rounded-xl rounded-tr">
                    Imprimir
                </a>
            </div>
        </section>
    </CustomModal>
</template>
<style scoped>
section {
    background: linear-gradient(138.52deg, rgb(81, 44, 44) -1.32%, rgb(37, 44, 78) 85.77%);
}

.print {
    background-color: white;
}
</style>
