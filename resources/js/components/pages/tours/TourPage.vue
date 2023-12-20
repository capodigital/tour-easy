<script>
import axios from 'axios'
export default {
    data() {
        return {
            tour: {
                artist: {
                    image: 'http://localhost/src/user_4.jpg',
                    socialmedias: [],
                },
                tourcartel: '',
            },
            options: {
                url: "data-src"
            },
            images: [
                { image: 'src/luis-fonsi/1.jpg', thumbnail: 'src/luis-fonsi/thumbnail/1.jpg', title: 'Luis fonsi - Gira 2023' },
                { image: 'src/luis-fonsi/2.jpg', thumbnail: 'src/luis-fonsi/thumbnail/2.jpg', title: 'Luis fonsi - Gira 2023' },
                { image: 'src/luis-fonsi/3.jpg', thumbnail: 'src/luis-fonsi/thumbnail/3.jpg', title: 'Luis fonsi - Gira 2023' },
                { image: 'src/luis-fonsi/4.jpg', thumbnail: 'src/luis-fonsi/thumbnail/4.jpg', title: 'Luis fonsi - Gira 2023' },
                { image: 'src/luis-fonsi/5.jpg', thumbnail: 'src/luis-fonsi/thumbnail/5.jpg', title: 'Luis fonsi - Gira 2023' },
                { image: 'src/luis-fonsi/6.jpg', thumbnail: 'src/luis-fonsi/thumbnail/6.jpg', title: 'Luis fonsi - Gira 2023' },
                { image: 'src/luis-fonsi/7.jpg', thumbnail: 'src/luis-fonsi/thumbnail/7.jpg', title: 'Luis fonsi - Gira 2023' },
                { image: 'src/luis-fonsi/8.jpg', thumbnail: 'src/luis-fonsi/thumbnail/8.jpg', title: 'Luis fonsi - Gira 2023' },
                { image: 'src/luis-fonsi/9.jpg', thumbnail: 'src/luis-fonsi/thumbnail/9.jpg', title: 'Luis fonsi - Gira 2023' },
                { image: 'src/luis-fonsi/10.jpg', thumbnail: 'src/luis-fonsi/thumbnail/10.jpg', title: 'Luis fonsi - Gira 2023' },
                { image: 'src/luis-fonsi/11.jpg', thumbnail: 'src/luis-fonsi/thumbnail/11.jpg', title: 'Luis fonsi - Gira 2023' },
                { image: 'src/luis-fonsi/12.jpg', thumbnail: 'src/luis-fonsi/thumbnail/12.jpg', title: 'Luis fonsi - Gira 2023' },
                { image: 'src/luis-fonsi/13.jpg', thumbnail: 'src/luis-fonsi/thumbnail/13.jpg', title: 'Luis fonsi - Gira 2023' },
                { image: 'src/luis-fonsi/14.jpg', thumbnail: 'src/luis-fonsi/thumbnail/14.jpg', title: 'Luis fonsi - Gira 2023' },
                { image: 'src/luis-fonsi/15.jpg', thumbnail: 'src/luis-fonsi/thumbnail/15.jpg', title: 'Luis fonsi - Gira 2023' },
                { image: 'src/luis-fonsi/16.jpg', thumbnail: 'src/luis-fonsi/thumbnail/16.jpg', title: 'Luis fonsi - Gira 2023' },
                { image: 'src/luis-fonsi/17.jpg', thumbnail: 'src/luis-fonsi/thumbnail/17.jpg', title: 'Luis fonsi - Gira 2023' },
                { image: 'src/luis-fonsi/18.jpg', thumbnail: 'src/luis-fonsi/thumbnail/18.jpg', title: 'Luis fonsi - Gira 2023' },
                { image: 'src/luis-fonsi/19.jpg', thumbnail: 'src/luis-fonsi/thumbnail/19.jpg', title: 'Luis fonsi - Gira 2023' },
                { image: 'src/luis-fonsi/20.jpg', thumbnail: 'src/luis-fonsi/thumbnail/20.jpg', title: 'Luis fonsi - Gira 2023' },
            ]
        }
    },
    mounted() {
        const id = location.hash.substring(location.hash.lastIndexOf('/') + 1)
        axios.get('api/tours/' + id, {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.tour = response.data
        })
    }
}
</script>
<template>
    <div>
        <nav class="w-screen h-16 flex items-center shadow-lg shadow-gray-300 bg-white">
            <div class="px-2">
                <img src="src/logo.svg" class="h-12 w-12" />
            </div>
            <div class="w-full">
                <h1
                    class="font-bold bg-gradient-to-tr text-center from-slate-500 to-black text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black">
                    {{ tour.tourname }}</h1>
                <p class="text-xs text-gray-500 text-center">{{ tour.notes }}</p>
            </div>
        </nav>
        <main class="scroll overflow-auto w-screen">
            <div class="grid lg:grid-cols-3 gap-3 p-3">
                <div>
                    <h1
                        class="font-bold bg-gradient-to-tr text-center from-slate-500 to-black text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black">
                        SOBRE EL ARTISTA</h1>
                    <article class="rounded-lg h-full">
                        <img :src="tour.tourcartel.replace('http://localhost/', '')" class="rounded-t-lg " />
                        <div class="grid grid-cols-2 p-2 rounded-lg w-full">
                            <div class="rounded-md shadow-lg shadow-gray-800 me-2 w-40 h-40 bg-cover bg-center"
                                :style="{ 'background': `url(${tour.artist.image.replace('http://localhost/', '')})` }">
                            </div>
                            <div>
                                <h2 class="text-xl text-gray-100 font-semibold">{{ tour.artist.name }}
                                    {{ tour.artist.lastname }}</h2>
                                <p class="text-sm text-gray-300">{{ tour.notes }}</p>
                            </div>
                        </div>
                        <div class="mt-3 grid grid-cols-6">
                            <a v-for="socialmedia in tour.artist.socialmedias" :href="socialmedia.url" target="_blank"
                                class="px-2 rounded-md flex justify-center text-whiteitems-center me-1">
                                <img :src="socialmedia.typered.logo.replace('http://localhost/', '')" class="" />
                            </a>
                        </div>
                    </article>
                </div>
                <div class="pt-6 md:pt-0">
                    <h1
                        class="font-bold bg-gradient-to-tr text-center from-slate-500 to-black text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black">
                        VIDEOS POPULARES</h1>
                    <iframe width="100%" height="100%" style="border-radius: 1rem;"
                        src="https://www.youtube.com/embed/videoseries?si=39cHU3tmhy86GT1H&amp;list=PLhazrcQIhlEGnFQQ-Kyeg07oPVmfMfaqr"
                        title="Videos populares de Luis Fonsi" frameborder="0" class="min-h-screen"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen></iframe>
                </div>
                <div class="pt-6 md:pt-0">
                    <h1
                        class="font-bold bg-gradient-to-tr text-center from-slate-500 to-black text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black">
                        PLAYLIST</h1>
                    <iframe style="border-radius:12px"
                        src="https://open.spotify.com/embed/playlist/3nzDoGB795nZ3cRY2OJrcW?utm_source=generator&theme=0"
                        width="100%" height="100%" frameBorder="0" class="min-h-screen"
                        allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"
                        loading="lazy"></iframe>

                </div>
            </div>
            <div class="mt-10">
                <div v-viewer="options" class="images md:grid">
                    <div v-for="(image, index) in images">
                        <img class="image cursor-pointer w-full" :key="index" :src="image.thumbnail" :data-src="image.image"
                            :alt="image.title">
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>
<style scoped>
h1 {
    font-family: 'Archivo Black', sans-serif;
}

main {
    max-height: calc(100vh - 5rem);
}

article {
    background-color: #282828;
}

.images {
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    grid-gap: 1px;
}

/*.images>div {
    display: block;
    position: relative;
}

.images>div>img {
    display: block;
    width: 100%;
    height: auto;
}*/
</style>
