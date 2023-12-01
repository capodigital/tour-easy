<script>
import axios from 'axios';
import TourCard from '../TourCard.vue';

export default {
    components: { TourCard },
    data() {
        return {
            tours: [
                {
                    artist: {
                        name: 'Marcos Capote',
                        image: 'src/personal/1.jpg',
                    },
                    description: 'Exercitation labore ad tempor labore reprehenderit anim.',
                    favorite: true,
                    start: '18/11/203',
                    end: '26/11/2023',
                },
                {
                    artist: {
                        name: 'Pedro Irlanda',
                        image: 'src/personal/2.jpg',
                    },
                    description: 'Proident officia dolore veniam ex ea dolore.',
                    start: '18/11/203',
                    end: '26/11/2023',
                },
                {
                    artist: {
                        name: 'Ernest Jule',
                        image: 'src/personal/3.jpg',
                    },
                    description: 'Dolor esse id sunt lorem commodo voluptate.',
                    start: '18/11/203',
                    end: '26/11/2023',
                },
                {
                    artist: {
                        name: 'Julia Ortiz',
                        image: 'src/personal/5.jpg',
                    },
                    favorite: true,
                    description: 'Adipisicing duis excepteur et commodo voluptate est.',
                    start: '18/11/203',
                    end: '26/11/2023',
                },
                {
                    artist: {
                        name: 'Artur Drawing',
                        image: 'src/personal/6.jpeg',
                    },
                    description: 'Et ea sit adipisicing reprehenderit non.',
                    start: '18/11/203',
                    end: '26/11/2023',
                },
                {
                    artist: {
                        name: 'Inner Luyano',
                        image: 'src/personal/7.jpeg',
                    },
                    description: 'Occaecat ullamco eiusmod do laboris labore quis laborum.',
                    start: '18/11/203',
                    end: '26/11/2023',
                },
                {
                    artist: {
                        name: 'Leticia Revis',
                        image: 'src/personal/8.jpeg',
                    },
                    description: 'Labore ex aute eiusmod magna ullamco amet.',
                    start: '18/11/203',
                    end: '26/11/2023',
                },
                {
                    artist: {
                        name: 'Steven Jobs',
                        image: 'src/personal/9.jpg',
                    },
                    favorite: true,
                    description: 'Et incididunt incididunt sint anim adipisicing dolore.',
                    start: '18/11/203',
                    end: '26/11/2023',
                },
                {
                    artist: {
                        name: 'Er Singer',
                        image: 'src/personal/10.jpg',
                    },
                    description: 'Sit minim amet elit do labore sit deserunt voluptate.',
                    start: '18/11/203',
                    end: '26/11/2023',
                },
                {
                    artist: {
                        name: 'Marth Smith',
                        image: 'src/personal/11.jpg',
                    },
                    favorite: true,
                    description: 'Reprehenderit dolor qui occaecat do irure fugiat.',
                    start: '18/11/203',
                    end: '26/11/2023',
                },
                {
                    artist: {
                        name: 'Francis Shopen',
                        image: 'src/personal/12.jpg',
                    },
                    description: 'Elit proident anim adipisicing sit et enim mollit.',
                    start: '18/11/203',
                    end: '26/11/2023',
                },
            ]
        };
    },

    mounted() {
        axios.post('api/tours/agency', {
            id: this.Utils.USER.agency_id
        }, {
            headers: {
                'Authorization': `Bearer ${this.Utils.TOKEN}`
            }
        }).then((response) => {
            console.log(response)
        })
    }
}
</script>
<template>
    <section class="p-4">
        <div class="relative">
            <h1
                class="font-bold bg-gradient-to-tr from-slate-500 to-black text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black">
                GIRAS ACTIVAS</h1>
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
