<script>
import axios from 'axios'
export default {
    data() {
        const today = new Date()
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
        };
    },
    methods: {
        update() {
            this.date.setMonth(this.month)
            this.date.setFullYear(this.year)
            this.init()
        },
        init() {
            const today = new Date(this.date.getFullYear(), this.date.getMonth(), this.date.getDate())
            axios.get("api/itineraries/" + (today.getMonth() + 1) + '/' + (today.getFullYear())).then((response) => {
                this.forms = [];
                today.setDate(1);
                for (let i = 1; i < today.getDay(); i++) {
                    this.forms.push({
                        day: '',
                        out: true,
                    })
                }
                const initial = this.forms.length
                today.setMonth(today.getMonth() + 1)
                today.setDate(0);
                for (let i = 1; i < today.getDate() + 1; i++) {
                    this.forms.push({
                        day: i,
                        activities: [],
                        color: 'text-black',
                    })
                }
                for (let item of response.data) {
                    const date = new Date(item.startdate);
                    this.forms[date.getDate() - 1 + initial].activities.push(item);

                }
                for (let i = 1; i < 8 - today.getDay(); i++) {
                    this.forms.push({
                        day: '',
                        out: true,
                    })
                }

            });
        }
    },
    created() {
        this.init()
    },
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

        <div>
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
                        <a :href="'#day/' + "
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
                                    <a class="block rounded text-white bg-green-500 py-1 px-2 mb-0.5 text-xs truncate"
                                        v-for="activity in day.activities" :href="'#activity/' + + activity.id">{{
                                            types[activity.typeitinerary_id - 1].description }}</a>
                                </template>
                                <button class="w-full py-0.5 text-center border mt-0.5 border-gray-400 text-gray-400 rounded flex justify-center items-center">
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
}</style>
