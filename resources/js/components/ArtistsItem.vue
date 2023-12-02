<script>
export default {
    props: {
        artist: Object
    },
    methods: {
        tags(tags) {
            return tags.split(',')
        }
    }
}
</script>
<template>
    <article class="shadow-md shadow-gray-500 rounded-md">
        <div class="relative h-80 w-full bg-cover bg-center rounded-t-md"
            :style="{ 'background': `url(${artist.image.replace('http://localhost/', '')})` }">
            <!-- <img :src="artist.image.replace('http://localhost/', '')" /> -->
            <div
                class="w-full h-24 bg-gradient-to-t from-black to-transparent absolute bottom-0 flex justify-center items-end pb-3">
                <h2 class="text-center text-white text-xl font-semibold">{{ artist.name }} {{ artist.lastname }}</h2>
            </div>
        </div>
        <div class="p-2">
            <p class="text-sm mb-2 text-white">{{ artist.notes }}</p>
            <div class="relative h-20 sm:h-24">
                <p1 class="text-gray-300 text-sm left-1 top-0 font-semibold">Redes sociales</p1>
                <div class="flex pt-2">
                    <a :href="artist.facebook" target="_blank"
                        class="px-2 rounded-md flex justify-center text-whiteitems-center me-1">
                        <img src="src/Facebook.png" class="" />
                    </a>
                    <a :href="artist.instagram" target="_blank"
                        class="px-2 rounded-md flex justify-center text-whiteitems-center me-1">
                        <img src="src/Instagram.png" class="" />
                    </a>
                    <a :href="artist.twitter" target="_blank"
                        class="px-2 rounded-md flex justify-center text-whiteitems-center me-1">
                        <img src="src/Twitter.png" class="" />
                    </a>
                    <a :href="artist.tiktok" target="_blank"
                        class="px-2 rounded-md flex justify-center text-whiteitems-center me-1">
                        <img src="src/Tiktok.png" class="" />
                    </a>
                    <a :href="artist.extraprofile.split(',')[0]" target="_blank"
                        class="px-2 rounded-md flex justify-center text-whiteitems-center me-1">
                        <img src="src/Link.png" class="" />
                    </a>
                </div>
            </div>
            <div class="px-2 relative pt-2">
                <p1 class="text-gray-300 text-sm left-1 top-0 font-semibold">Música</p1>
                <div class="flex">
                    <a :href="artist.spotify" target="_blank"
                        class="px-2 rounded-md flex justify-center text-whiteitems-center me-1">
                        <img src="src/Spotify.png" class="" />
                    </a>
                    <a :href="artist.youtube" target="_blank"
                        class="px-2 rounded-md flex justify-center text-whiteitems-center me-1">
                        <img src="src/Youtube.png" class="" />
                    </a>
                    <a :href="artist.applemusic" target="_blank"
                        class="px-2 rounded-md flex justify-center text-whiteitems-center me-1">
                        <img src="src/AppleMusic.png" class="" />
                    </a>
                    <a :href="artist.amazonmusic" target="_blank"
                        class="px-2 rounded-md flex justify-center text-whiteitems-center me-1">
                        <img src="src/AmazonMusic.png" class="" />
                    </a>
                    <a :href="artist.tidal" target="_blank"
                        class="px-2 rounded-md flex justify-center text-whiteitems-center me-1">
                        <img src="src/Tindal.png" class="" />
                    </a>
                </div>
            </div>
            
            <div class="px-2">
                <button class="bg-black px-2 py-1 text-white rounded me-2 text-sm" v-for="tag in tags(artist.tags)">{{ tag
                }}</button>
            </div>
        </div>
    </article>
</template>
<style scoped>
article {
    background-color: rgb(52, 52, 52);
}
</style>
