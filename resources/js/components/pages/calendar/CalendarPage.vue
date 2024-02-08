<script>
import axios from 'axios'
import ActivityDetails from '../../common/ActivityDetails.vue';
import CalendarModal from './CalendarModal.vue';
import CalendarItem from './CalendarItem.vue';
export default {
    data() {
        const today = new Date();
        return {
            forms: [],
            types: [
                { id: 1, description: "Show" },
                { id: 2, description: "Actividad" },
                { id: 3, description: "Servicio" },
                { id: 4, description: "Transporte terrestre" },
                { id: 5, description: "Hotel" },
                { id: 6, description: "Avión" },
                { id: 7, description: "Tren" },
                { id: 8, description: "Transfer" }
            ],
            month: today.getMonth(),
            year: today.getFullYear(),
            date: today,
            activity: {},
            details: {},
            tours: [],
            daySelect: null,
            initial: 0,
            show: false,
            tour_id: 0,
            active: 0,
        };
    },
    methods: {
        update() {
            this.date.setMonth(this.month);
            this.date.setFullYear(this.year);
            this.init();
        },
        add(day) {
            const now = new Date()
            this.activity = {
                startdate: `${this.year}-${(Number(this.month) + 1).toString().padStart(2, '0')}-${day.toString().padStart(2, '0')} ${now.getHours()}:${now.getMinutes()}:${now.getSeconds()}`,
                typeitinerary_id: 1,
            };
            this.show = true;
        },
        send(e) {
            const data = new FormData(e.target);
            this.Utils.lock(e.target)
            axios.post('api/itineraries', data, {
                headers: {
                    'Authorization': `Bearer ${this.Utils.token()}`
                }
            }).then((response) => {
                const date = new Date(response.data.data.startdate);
                this.forms[date.getDate() + Number(this.initial) - 1].activities.push(this.getActivityData(response.data.data));
                this.Utils.notify('Se ha creado correctamente la actividad')
                this.show = false;
                this.Utils.unlock(e.target)
            }).catch((error) => {
                console.log(error)
                this.Utils.unlock(e.target)
                this.Utils.error(error.response)
            });
        },
        init() {
            const today = new Date(this.date.getFullYear(), this.date.getMonth(), this.date.getDate());
            axios.get("api/itineraries/" + (today.getMonth() + 1) + '/' + (today.getFullYear()), {
                headers: {
                    'Authorization': `Bearer ${this.Utils.token()}`
                }
            }).then((response) => {
                this.forms = [];
                today.setDate(1);
                for (let i = 1; i < today.getDay() + 1; i++) {
                    this.forms.push({
                        day: '',
                        out: true,
                    });
                }
                const initial = this.forms.length;
                this.initial = initial;
                today.setMonth(today.getMonth() + 1);
                today.setDate(0);
                for (let i = 1; i < today.getDate() + 1; i++) {
                    this.forms.push({
                        day: i,
                        activities: [],
                        color: 'text-black',
                    });
                }
                for (let item of response.data.data) {
                    const date = new Date(item.startdate);
                    this.forms[date.getDate() - 1 + initial].activities.push(this.getActivityData(item));
                }
                for (let i = 1; i < 8 - (today.getDay() + 1); i++) {
                    this.forms.push({
                        day: '',
                        out: true,
                    });
                }
            }).catch((error) => {
                console.log(error)
                this.Utils.error(error.response)
            });
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
            let date = '';
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
        timestamp(day) {
            const date = new Date(this.year, this.month, day);
            return date.valueOf();
        },
    },
    created() {
        this.init();
        axios.get('api/tours', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.tours = response.data.data;
        });
    },
    components: { ActivityDetails, CalendarModal, CalendarItem }
};
</script>
<template>
    <div class="w-full px-4 py-4 overflow-auto scroll" style="font-family: Roboto">
        <h1
            class="font-bold w-full bg-gradient-to-tr from-app-secondary-300 to-app-secondary-800 text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black mb-2">
            CALENDARIO DE ACTIVIDADES
        </h1>
        <div class="my-2">
            <div class="text-center sm:flex items-center">
                <label class="me-2">Filtrar: </label>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-2">
                    <select v-model="month" @change="update" class="rounded border border-gray-300 px-3 pe-8 py-1">
                        <option value="0">Enero</option>
                        <option value="1">Febrero</option>
                        <option value="2">Marzo</option>
                        <option value="3">Abril</option>
                        <option value="4">Mayo</option>
                        <option value="5">Junio</option>
                        <option value="6">Julio</option>
                        <option value="7">Agosto</option>
                        <option value="8">Septiembre</option>
                        <option value="9">Octubre</option>
                        <option value="10">Noviembre</option>
                        <option value="11">Diciembre</option>
                    </select>
                    <select v-model="year" @change="update" class="rounded border border-gray-300 pe-8 px-3 py-1">
                        <option :value="2000 + n" v-for="n in 24">
                            {{ 2000 + n }}
                        </option>
                    </select>
                    <select v-model="tour_id" class="rounded border border-gray-300 px-3 pe-8 py-1">
                        <option value="0">Todas las giras</option>
                        <template v-for="item in tours">
                            <option v-if="item.active == 1" :value="item.id">
                                {{ item.tourname }}
                            </option>
                        </template>
                    </select>
                </div>
                <!-- <div class="form-check items-center ms-1 flex">
                    <input required aria-label="Ver giras terminadas" @change="(e) => active = e.target.checked ? 1 : 0"
                        class="form-check-input me-0.5" type="checkbox" />
                    <label class="form-check-label leading-4 text-sm text-center">
                        Ver giras terminadas
                    </label>
                </div> -->
            </div>
        </div>
        <div class="overflow-x-auto scroll">
            <CalendarItem :today="date" :itineraries="forms" @update="update" @add="add" @year="(value) => year = value"
                @show="(item) => details = item" @month="(value) => month = value" />
        </div>
        <CalendarModal v-if="show" @send="send" @close="show = false" :activity="activity" />
        <!-- <ActivityDetails @close="details = {}" v-if="details.id != undefined" :activity="details" /> -->
    </div>
</template>
<style scoped>
tr>*:first-child {
    width: 1.5rem;
}

th {
    white-space: nowrap;
    cursor: pointer;
    color: #7e7e7e;
    text-align: left;
}

td,
th {
    border-bottom: solid 1px rgb(175, 175, 175);
    padding: 0.25rem;
}

h1 {
    font-family: 'Archivo Black', sans-serif;
}

form {
    max-height: calc(100vh - 7.5rem);
}
</style>
