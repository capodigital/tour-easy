<script>
import { data } from 'autoprefixer';
import TourActivity from '../TourActivity.vue';
import AnimMixin from './AnimMixin';
import axios from 'axios'
export default {
    mixins: [AnimMixin],
    data() {
        return {
            activities: [
                // {
                //     name: 'Aeropuerto → Hotel',
                //     description: 'Llegada a destino a las 11:00AM',
                //     type: 'drive',
                //     start: '25/11/2023 10:40AM',
                //     complete: true,
                // },
                // {
                //     name: 'Marlin Square Hotel',
                //     description: 'Hospedaje 2 noches en Suite Lusure',
                //     type: 'hotel',
                //     start: '25/11/2023 11:10AM',
                //     complete: true,
                // },
                // {
                //     name: 'Hotel → Madison Artist',
                //     description: 'Llegada a destino a las 04:30PM',
                //     type: 'drive',
                //     start: '25/11/2023 04:00PM',
                //     complete: true,
                // },
                // {
                //     name: 'Sessión de fotos',
                //     description: 'Cadenas de Univisión y Mediaset',
                //     type: 'photos',
                //     start: '25/11/2023 04:40PM',
                //     complete: true,
                // },
                // {
                //     name: 'Madison Artist → Plaza Roja',
                //     description: 'Llegada a destino a las 05:15PM',
                //     type: 'drive',
                //     start: '25/11/2023 05:30PM'
                // },
                // {
                //     name: 'Sessión de fotos',
                //     description: 'Varias cadenas de televisión invitadas',
                //     type: 'photos',
                //     start: '25/11/2023 05:40PM'
                // },
                // {
                //     name: 'Festival latino-boricua',
                //     description: 'Prueba de sonidos: 07:30PM. <br />Puertas abiertas:08:00PM. <br />Función: 2 horas.',
                //     type: 'function',
                //     start: '25/11/2023 07:30PM'
                // },
                // {
                //     name: 'Plaza Roja → Hotel',
                //     description: 'Llegada a destino a las 11:00PM',
                //     type: 'drive',
                //     start: '25/11/2023 10:40PM'
                // },
                // {
                //     name: 'Marlin Square Hotel',
                //     description: 'Cena gratis con todo incluído',
                //     type: 'hotel',
                //     start: '25/11/2023 11:10PM'
                // },
                // {
                //     name: 'Hotel → Madrid',
                //     description: 'Llegada a destino a las 08:30AM',
                //     type: 'drive',
                //     start: '26/11/2023 08:00AM'
                // },
                // {
                //     name: 'Madrid → Aeropuerto',
                //     description: 'Llegada a destino a las 09:00AM',
                //     type: 'drive',
                //     start: '26/11/2023 08:40AM'
                // },
                // {
                //     name: 'Madrid → Barcelona',
                //     description: 'Vuelo: MA56T112023<br />Llegada a Barcelona a las 11:45AM',
                //     type: 'travel',
                //     start: '26/11/2023 09:30AM'
                // },
            ],
            tour: {}
        };
    },
    components: { TourActivity },
    mounted() {
        const id = location.hash.substring(location.hash.lastIndexOf('/') + 1)
        axios.post('api/tour', { id: id }).then((response) => {
            this.tour = response.data.data;
        })
        axios.post('api/itineraries/tour', { id: id }).then((response) => {
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
                        name = `<b>Lugar: </b>`, description = `<b>Conductor: </b>${activity.carrier}`,
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
                this.activities.push({
                    name: name,
                    description: description,
                    type: type,
                    start: start,
                    date: date
                })
            }
        })
    }
}
</script>
<template>
    <section>
        <div class="tour-images">
            <div class="stage bg-cover bg-no-repeat">
                <div class="absolute bottom-0 left-0 flex justify-center items-end z-30 w-full pb-3 md:pb-10">
                    <div class="text-center">
                        <h1
                            class="md:text-4xl font-bold bg-gradient-to-tr from-slate-100 to-slate-300 text-xl bg-clip-text text-transparent drop-shadow-md shadow-black">
                            {{tour.tourname}}</h1>
                        <p class="text-2xl">{{ tour.artist }}</p>
                    </div>
                </div>
                <div class="hero">
                    <div class="hero__inner">
                        <div class="hero__cuboid hero__cuboid--1">
                            <div class="face face--front"><img src="src/bad-bunny/1.jpg" alt=""></div>
                            <div class="face face--back"><img src="src/bad-bunny/2.jpg" alt=""></div>
                            <div class="face face--left"><img src="src/bad-bunny/3.jpeg" alt=""></div>
                            <div class="face face--right"><img src="src/bad-bunny/4.jpg" alt=""></div>
                            <div class="face face--top"></div>
                            <div class="face face--bottom"></div>
                        </div>
                        <div class="hero__cuboid hero__cuboid--2">
                            <div class="face face--front"><img src="src/bad-bunny/5.jpg" alt=""></div>
                            <div class="face face--back"><img src="src/bad-bunny/6.jpg" alt=""></div>
                            <div class="face face--left"><img src="src/bad-bunny/7.jpg" alt=""></div>
                            <div class="face face--right"><img src="src/bad-bunny/8.jpg" alt=""></div>
                            <div class="face face--top"></div>
                            <div class="face face--bottom"></div>
                        </div>
                        <div class="hero__cuboid hero__cuboid--3">
                            <div class="face face--front"><img src="src/bad-bunny/2.jpg" alt=""></div>
                            <div class="face face--back"><img src="src/bad-bunny/1.jpg" alt=""></div>
                            <div class="face face--left"><img src="src/bad-bunny/4.jpg" alt=""></div>
                            <div class="face face--right"><img src="src/bad-bunny/3.jpeg" alt=""></div>
                            <div class="face face--top"></div>
                            <div class="face face--bottom"></div>
                        </div>
                        <div class="hero__cuboid hero__cuboid--4">
                            <div class="face face--front"><img src="src/bad-bunny/7.jpg" alt=""></div>
                            <div class="face face--back"><img src="src/bad-bunny/8.jpg" alt=""></div>
                            <div class="face face--left"><img src="src/bad-bunny/5.jpg" alt=""></div>
                            <div class="face face--right"><img src="src/bad-bunny/6.jpg" alt=""></div>
                            <div class="face face--top"></div>
                            <div class="face face--bottom"></div>
                        </div>
                    </div>
                </div>
                <div class="overlay"></div>
            </div>
        </div>
        <div class="mt-4 grid sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-3 z-50 p-4">
            <TourActivity v-for="activity in activities" :activity="activity" />
        </div>
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
</style>
