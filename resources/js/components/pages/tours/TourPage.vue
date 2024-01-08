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
                tourname: '',
            },
            images: [
            ]
        }
    },
    mounted() {
        const id = location.hash.substring(location.hash.lastIndexOf('/') + 1)
        axios.get('api/public/tours/' + id, {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.tour = response.data
        }).catch((error) => {
            this.Utils.error(error.response)
        })
        axios.post('api/photos/tour', { id: id }, {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.images = response.data.data
        }).catch((error) => {
            this.Utils.error(error.response)
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
                    <iframe width="100%" height="100%" style="border-radius: 1rem;" :src="tour.youtube_list"
                        title="Videos populares de Luis Fonsi" frameborder="0" class="min-h-screen"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen></iframe>
                </div>
                <div class="pt-6 md:pt-0">
                    <h1
                        class="font-bold bg-gradient-to-tr text-center from-slate-500 to-black text-2xl bg-clip-text text-transparent drop-shadow-md shadow-black">
                        PLAYLIST</h1>
                    <iframe style="border-radius:12px" :src="tour.spotify_list" width="100%" height="100%" frameBorder="0"
                        class="min-h-screen"
                        allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"
                        loading="lazy"></iframe>

                </div>
            </div>
            <div class="mt-10">
                <div v-viewer="options" class="images md:grid">
                    <div class="relative" v-for="(image, index) in images">
                        <div class="image cursor-pointer h-56 bg-cover bg-center"
                            :style="{ 'background-image': `url(${image.url})` }" :key="index">
                            <img class="opacity-0" :src="image.url" :alt="`${tour.tourname} - ${index}`" />
                        </div>
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
