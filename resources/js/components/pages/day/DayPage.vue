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
        axios.get(`api/itineraries/${date.getDate()}/${date.getMonth() + 1}/${date.getFullYear()}`, {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            for (let i in response.data.data) {
                const activity = response.data.data[i]
                //const next = (Number(i) + 1 == response.data.data.length) ? { place: { name: '' } } : response.data.data[Number(i) + 1];
                let name = '', description = '', type = activity.typeitinerary_id, start = activity.startdate
                let date = '';
                switch (activity.typeitinerary_id) {
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
                        name = activity.name, description = `<b>Proveedor: </b>${activity.supplier.company_name}.<br /><b>Lugar: </b>${activity.place.name}`,
                            date = `<br /><div class="flex flex-col items-center"><div>${start}</div><div>${activity.enddate}</div></div>`;
                        break;
                    case 4:
                        name = activity.place.name, description = `<b>Conductor: </b>${activity.carrier}`,
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
                        name = `${activity.citystart.name} → ${activity.cityend.name}`, description = `<b>Transporte: </b>${activity.contact.name}.<br /><b>Conductor: </b>${activity.place.name}`,
                            date = `<br /><div class="flex flex-col items-center"><div>${start}</div><div>${activity.enddate}</div></div>`;
                        break;
                }
                activity.name = name
                activity.description = description
                activity.type = activity.typeitinerary_id
                this.activities.push(activity)
                this.date = activity.startdate
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
            <div>
                <DayItem v-for="activity in activities" :activity="activity" />
            </div>
        </div>
    </div>
</template>
<style scoped>
h1 {
    font-family: 'Archivo Black', sans-serif;
}
</style>
