<script>
import axios from 'axios'
import ActivityDetails from '../../common/ActivityDetails.vue';
export default {
    data() {
        const today = new Date();
        return {
            forms: [],
            types: [
                { "id": "1", "description": "Show" },
                { "id": "2", "description": "Actividad" },
                { "id": "3", "description": "Servicio" },
                { "id": "4", "description": "Transporte terrestre" },
                { "id": "5", "description": "Hotel" },
                { "id": "6", "description": "Avión" },
                { "id": "7", "description": "Tren" },
                { "id": "8", "description": "Transfer" }
            ],
            month: today.getMonth(),
            year: today.getFullYear(),
            date: today,
            activity: {},
            tour: {},
            tours: [],
            contacts: [],
            suppliers: [],
            types: [],
            countries: [],
            cities: [],
            places: [],
            daySelect: null,
            initial: 0,
            show: false,
        };
    },
    methods: {
        setCities(country) {
            axios.post('api/cities', { code: country }, {
                headers: {
                    'Authorization': `Bearer ${this.Utils.token()}`
                }
            }).then((response) => {
                this.cities = response.data;
            });
        },
        update() {
            this.date.setMonth(this.month);
            this.date.setFullYear(this.year);
            this.init();
        },
        add(day) {
            this.activity = {
                startdate: `${this.year}-${this.month + 1}-${day}`
            };
            this.show = true;
        },
        send(e) {
            const data = new FormData(e.target);
            axios.post('api/itineraries', data, {
                headers: {
                    'Authorization': `Bearer ${this.Utils.token()}`
                }
            }).then((response) => {
                const date = new Date(response.data.data.startdate);
                this.forms[date.getDate() - 1 + this.initial].activities.push(response.data.data);
                this.activity = { tour_id: this.tour.id };
                this.Utils.notify('Se ha creado correctamente la actividad')
                this.show = false;
            }).catch((error) => {
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
                for (let i = 1; i < today.getDay(); i++) {
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
                    this.forms[date.getDate() - 1 + initial].activities.push(item);
                }
                for (let i = 1; i < 8 - today.getDay(); i++) {
                    this.forms.push({
                        day: '',
                        out: true,
                    });
                }
            }).catch((error) => {
                this.Utils.error(error.response)
            });
        },
        timestamp(day) {
            const date = new Date(this.year, this.month, day);
            return date.valueOf();
        }
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
        axios.get('api/typeitineraries', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.types = response.data.data;
        });
        axios.get('api/contacts', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.contacts = response.data.data;
        });
        axios.get('api/countries', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.countries = response.data.data;
            this.setCities(this.countries[0].code);
        });
        axios.get('api/places', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.places = response.data.data;
        });
        axios.get('api/suppliers', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.suppliers = response.data.data;
        });
    },
    components: { ActivityDetails }
};
</script>
<template>
    <div class="w-full px-4 py-4 overflow-auto scroll" style="font-family: Roboto">
        <h1 class="font-bold text-gray-800 text-2xl">CALENDARIO DE ACTIVIDADES</h1>
        <div class="my-2">
            <div class="text-center flex items-center">
                <label class="me-2">Filtrar: </label>
                <select v-model="month" @change="update" class="rounded border border-gray-500 px-3 py-1 me-2 w-32">
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
                <select v-model="year" @change="update" class="rounded border border-gray-500 px-3 py-1 w-[5.5rem]">
                    <option :value="2000 + n" v-for="n in 23">
                        {{ 2000 + n }}
                    </option>
                </select>
            </div>
        </div>
        <div class="overflow-x-auto scroll">
            <div class="min-w-[50rem]">
                <div class="grid grid-cols-7 rounded-t">
                    <div
                        class="text-center font-bold text-lg p-2 border border-r-gray-300 bg-gradient-to-tr from-slate-800 to-slate-950 text-white">
                        D</div>
                    <div
                        class="text-center font-bold text-lg p-2 border border-r-gray-300 bg-gradient-to-tr from-slate-800 to-slate-950 text-white rounded-tl">
                        L
                    </div>
                    <div
                        class="text-center font-bold text-lg p-2 border border-r-gray-300 bg-gradient-to-tr from-slate-800 to-slate-950 text-white">
                        M</div>
                    <div
                        class="text-center font-bold text-lg p-2 border border-r-gray-300 bg-gradient-to-tr from-slate-800 to-slate-950 text-white">
                        M</div>
                    <div
                        class="text-center font-bold text-lg p-2 border border-r-gray-300 bg-gradient-to-tr from-slate-800 to-slate-950 text-white">
                        J</div>
                    <div
                        class="text-center font-bold text-lg p-2 border border-r-gray-300 bg-gradient-to-tr from-slate-800 to-slate-950 text-white">
                        V</div>
                    <div
                        class="text-center font-bold text-lg p-2 border bg-gradient-to-tr from-slate-800 to-slate-950 text-white rounded-tr">
                        S</div>
                </div>
                <div class="grid grid-cols-7 border border-black border-t-0 rounded-b">
                    <div class="border p-2 flex relative"
                        :class="{ 'border-r-black': index % 7 != 6, 'border-b-black': index < forms.length - 7, 'bg-gray-300': day.out != undefined }"
                        v-for="(day, index) in forms">
                        <template v-if="!day.out">
                            <a :href="'#day/' + timestamp(day.day)"
                                class="absolute right-0 top-1 rounded text-white text-sm bg-gradient-to-tr from-slate-800 to-slate-950 w-5 h-5 text-center me-1">
                                {{
                                    day.day }}</a>
                            <div class="w-full">
                                <div class="rounded">
                                    <!-- <p class="text-gray-400 text-center text-xs">Mañana</p> -->
                                    <template v-if="day.activities.length == 0">
                                        <div class="rounded bg-gray-600 text-white text-center text-xs py-1 px-2">No hay
                                            actividades</div>
                                    </template>
                                    <template v-else>
                                        <button @click="activity = item"
                                            class="block rounded text-white w-full bg-green-500 py-1 px-2 mb-0.5 text-xs truncate"
                                            v-for="item in day.activities">{{
                                                types[Number(item.typeitinerary_id) - 1].description }}</button>
                                    </template>
                                    <button v-if="Utils.role() != 'artist'" @click="add(day.day)"
                                        class="w-full py-0.5 text-center border mt-0.5 border-gray-400 text-gray-400 rounded flex justify-center items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                            fill="none" stroke="rgb(156, 163, 175)" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="lucide lucide-plus">
                                            <path d="M5 12h14" />
                                            <path d="M12 5v14" />
                                        </svg>
                                    </button>
                                </div>

                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="show"
            class="w-full bg-white bg-opacity-90 h-screen md:h-auto absolute top-0 px-2 py-2 flex justify-center items-center">
            <div>
                <h1
                    class="font-bold bg-gradient-to-tr from-slate-500 text-center to-black text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black mb-2">
                    <template v-if="activity.id == undefined">
                        AÑADIR
                    </template>
                    <template v-else>
                        EDITAR
                    </template>
                </h1>
                <form @submit.prevent="send"
                    class="bg-gradient-to-tr from-slate-700 via-black to-slate-950 rounded-3xl rounded-tr p-10 overflow-auto scroll">
                    <div class="grid grid-cols-2 gap-x-2 mb-3">
                        <div :class="{ hidden: tour.id != undefined }">
                            <label class="text-slate-200 text-xs font-semibold">Gira</label>
                            <div class="flex items-center rounded border border-gray-300 px-2">
                                <select name="tour_id"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                    <option class="text-black" v-for="item in tours" :value="item.id">{{
                                        item.tourname
                                    }}</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="text-slate-200 text-xs font-semibold">Tipo de actividad</label>
                            <div class="flex items-center rounded border border-gray-300 px-2">
                                <select v-model="activity.typeitinerary_id" name="typeitinerary_id"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                    <option class="text-black" v-for="type in types" :value="type.id">{{
                                        type.description
                                    }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Nombre</label>
                        <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                            <i class="bi bi-envelope text-gray-100"></i>
                            <input v-model="activity.name" name="name" type="text" placeholder="Nombre de la actividad"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                        </div>
                    </div>
                    <div>
                        <label class="text-slate-200 text-xs font-semibold">Descripción</label>
                        <div class="flex items-center mb-3 rounded border border-gray-300 px-1 py-1">
                            <textarea rows="3" v-model="activity.notes" name="notes" placeholder="Datos adicionales"
                                class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-1 py-1"></textarea>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-x-2 my-3" v-if="activity.typeitinerary_id == 1">
                        <div>
                            <label class="text-slate-200 text-xs font-semibold">Prueba de sonido</label>
                            <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                <i class="bi bi-calendar-day text-gray-100"></i>
                                <input v-model="activity.showcheck" name="showcheck" type="time"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-[0.65rem]">
                            </div>
                        </div>
                        <div>
                            <label class="text-slate-200 text-xs font-semibold">Inicio del show</label>
                            <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                <i class="bi bi-calendar-day text-gray-100"></i>
                                <input v-model="activity.showtime" name="showtime" type="time"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-x-2">
                        <div>
                            <label class="text-slate-200 text-xs font-semibold">Fecha de inicio</label>
                            <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                <i class="bi bi-calendar-day text-gray-100"></i>
                                <input v-model="activity.startdate" name="startdate" type="date"
                                    placeholder="Fecha de inicio"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-[0.65rem]">
                            </div>
                        </div>
                        <div>
                            <label class="text-slate-200 text-xs font-semibold">Fecha de fin</label>
                            <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                <i class="bi bi-calendar-day text-gray-100"></i>
                                <input v-model="activity.enddate" name="enddate" type="date" placeholder="Fecha de fin"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                            </div>
                        </div>
                    </div>
                    <label class="text-slate-200 text-xs font-semibold">Ciudad de salida</label>
                    <div class="grid grid-cols-2 gap-x-2">
                        <div>
                            <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                <i class="bi bi-globe text-gray-100"></i>
                                <select @change="(e) => setCities(e.target.value)"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                    <option class="text-black" v-for="country in countries" :value="country.code">{{
                                        country.name }}</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                <i class="bi bi-globe-americas text-gray-100"></i>
                                <select v-model="activity.city_start_id" name="city_start_id"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                    <option class="text-black" v-for="city in cities" :value="city.id">{{ city.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <label class="text-slate-200 text-xs font-semibold">Ciudad de destino</label>
                    <div class="grid grid-cols-2 gap-x-2">
                        <div>
                            <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                <i class="bi bi-globe text-gray-100"></i>
                                <select @change="(e) => setCities(e.target.value)"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                    <option class="text-black" v-for="country in countries" :value="country.code">{{
                                        country.name }}</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center mb-3 rounded border border-gray-300 px-2">
                                <i class="bi bi-globe-americas text-gray-100"></i>
                                <select v-model="activity.city_destination_id" name="city_destination_id"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                    <option class="text-black" v-for="city in cities" :value="city.id">{{ city.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-x-2">
                        <div>
                            <label class="text-slate-200 text-xs font-semibold">Contacto</label>
                            <div class="flex items-center rounded border border-gray-300 px-2">
                                <select v-model="activity.contact_id" name="contact_id"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                    <option class="text-black" v-for="contact in contacts" :value="contact.id">{{
                                        contact.name
                                    }}</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="text-slate-200 text-xs font-semibold">Lugar</label>
                            <div class="flex items-center rounded border border-gray-300 px-2">
                                <select v-model="activity.place_id" name="place_id"
                                    class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3">
                                    <option class="text-black" v-for="place in places" :value="place.id">{{
                                        place.name
                                    }}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-center">
                        <button type="button" @click="show = false"
                            class="mt-8 me-2 overlay-button bg-gradient-to-tr from-slate-100 to-slate-300 text-black px-3 py-3 w-full rounded-xl rounded-tr">
                            Cerrar
                        </button>
                        <button type="submit"
                            class="mt-8 overlay-button bg-gradient-to-tr from-slate-100 to-slate-300 text-black px-3 py-3 w-full rounded-xl rounded-tr">
                            <template v-if="activity.id == undefined">
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
        <ActivityDetails @close="activity = {}" v-if="activity.id != undefined" :activity="activity" />
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
