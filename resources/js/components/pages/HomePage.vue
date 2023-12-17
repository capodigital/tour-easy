<script>
import axios from 'axios';
import TourCard from '../TourCard.vue';

export default {
    components: { TourCard },
    data() {
        return {
            tours: [
            ]
        };
    },

    mounted() {
        axios.get('api/tours', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            console.log(response)
            this.tours = response.data.data
        })
    }
}
</script>
<template>
    <section class="p-4">
        <div class="relative">
            <div class="flex">
                <h1
                class="font-bold bg-gradient-to-tr w-full from-slate-500 to-black text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black">
                GIRAS ACTIVAS</h1>
                <button class="px-2 py-1 text-white bg-gradient-to-tr from-slate-800 to-slate-950 rounded z-50">Añadir</button>
            </div>
            <div class="mt-4 grid sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-3">
                <TourCard :tour="tour" v-for="tour in tours" />
            </div>
        </div>
    </section>
</template>
<style scoped>
h1 {
    font-family: 'Archivo Black', sans-serif;
}
</style>
