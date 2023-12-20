<script>
import DayItem from '../DayItem.vue';
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
        axios.get(`api/itineraries/${date.getDate()}/${date.getMonth() + 1}/${date.getFullYear()}`).then((response) => {
            for (let i in response.data.data) {
                const activity = response.data.data[i]
                const next = (Number(i) + 1 == response.data.data.length) ? { place: { name: '' } } : response.data.data[Number(i) + 1];
                let name = '', description = '';
                switch (activity.typeitinerary_id) {
                    case 1:
                        name = activity.name, description = `Prueba de sonidos: ${activity.showcheck}.<br />Puertas abiertas: ${activity.showtime}`;
                        break;
                    case 2:
                    case 3:
                    case 5:
                        name = activity.name, description = `Proveedor: ${activity.supplier.company_name}. <br />${activity.notes}`;
                        break;
                    case 4:
                        name = `${activity.place.name} → ${next.place.name}`, description = `Conductor: ${activity.carrier}.<br />Llegada a destino a las ${activity.enddate}`;
                        break;
                    case 6:
                        name = `${activity.place.name} → ${next.place.name}`, description = `Aerolinea: ${activity.carrier}.<br />Llegada a destino a las ${activity.enddate}`;
                        break;
                    case 7:
                        name = `${activity.place.name} → ${next.place.name}`, description = `Ferroviaria: ${activity.carrier}.<br />Llegada a destino a las ${activity.enddate}`;
                        break;
                    case 8:
                        name = activity.name, description = activity.notes;
                        break;
                }
                activity.name = name
                activity.description = description
                activity.type = activity.typeitinerary_id
                this.activities.push(activity)
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
