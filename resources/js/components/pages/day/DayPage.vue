<script>
import DayItem from './DayItem.vue';
import axios from 'axios'

export default {
    data() {
        return {
            activities: [],
            date: new Date()
        };
    },
    components: { DayItem },
    created() {
        const timestamp = location.hash.substring(location.hash.lastIndexOf('/') + 1)
        const date = new Date(Number(timestamp))
        console.log(date)
        this.date = date
        axios.get(`api/itineraries/${date.getDate()}/${date.getMonth() + 1}/${date.getFullYear()}`, {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            for (let i in response.data.data) {
                const activity = response.data.data[i]
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
                this.activities.push(item)

            }
        })
    }
}
</script>
<template>
    <div class="w-full p-2">
        <h1
            class="font-bold bg-gradient-to-tr from-slate-500 to-black text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black mb-2">
            {{ Utils.datetime(date, Utils.TEXT_DATE) }}
        </h1>
        <div class="flex justify-center">
            <div v-if="activities.length > 0">
                <DayItem v-for="activity in activities" :activity="activity" />
            </div>
            <div v-else class="no-result flex justify-center items-center">
                <div class="text-center ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="none"
                        stroke="rgb(107, 114, 128)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-search-x m-auto">
                        <path d="m13.5 8.5-5 5" />
                        <path d="m8.5 8.5 5 5" />
                        <circle cx="11" cy="11" r="8" />
                        <path d="m21 21-4.3-4.3" />
                    </svg>
                    <p class="text-center text-gray-500">No hay eventos para este día</p>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
h1 {
    font-family: 'Archivo Black', sans-serif;
}

.no-result {
    height: calc(100vh - 10rem);
}
</style>
