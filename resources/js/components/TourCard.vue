<script>
export default {
    props: {
        tour: Object
    }
}
</script>
<template>
    <a href="#details" class="bg-white rounded-2xl shadow-md shadow-gray-500 p-3 transition-all hover:scale-105 cursor-pointer">
        <img class="rounded-full h-10 w-10 float-right shadow-md shadow-gray-400" :src="tour.artist.image" />
        <h3 class="font-bold text-lg text-gray-900">{{ tour.artist.name }}</h3>
        <p class="text-gray-500 text-sm leading-4 pe-10">{{ tour.description }}</p>
        <div class="flex justify-around text-xs mt-2">
            <div class="flex rounded bg-gray-300 p-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="#6b7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-calendar-plus">
                    <path d="M21 13V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h8" />
                    <line x1="16" x2="16" y1="2" y2="6" />
                    <line x1="8" x2="8" y1="2" y2="6" />
                    <line x1="3" x2="21" y1="10" y2="10" />
                    <line x1="19" x2="19" y1="16" y2="22" />
                    <line x1="16" x2="22" y1="19" y2="19" />
                </svg>
                <p class="ms-1 text-gray-700">{{ tour.start }}</p>
            </div>
            <div class="flex rounded bg-gray-300 p-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="#6b7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-calendar-check-2">
                    <path d="M21 14V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h8" />
                    <line x1="16" x2="16" y1="2" y2="6" />
                    <line x1="8" x2="8" y1="2" y2="6" />
                    <line x1="3" x2="21" y1="10" y2="10" />
                    <path d="m16 20 2 2 4-4" />
                </svg>
                <p class="ms-1 text-gray-700">{{ tour.end }}</p>
            </div>
        </div>
        <div class="flex mt-4">
            <div class="flex w-full">
                <button :class="{'border-gray-400': tour.favorite == undefined, 'border-red-600': tour.favorite}" class="rounded-lg border  w-7 h-7 me-1 flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        :stroke="tour.favorite ? '#ff0000' : '#000'" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-heart">
                        <path
                            d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
                    </svg>
                </button>
                <button class="rounded-lg border border-gray-400 w-7 h-7 flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-share-2">
                        <circle cx="18" cy="5" r="3" />
                        <circle cx="6" cy="12" r="3" />
                        <circle cx="18" cy="19" r="3" />
                        <line x1="8.59" x2="15.42" y1="13.51" y2="17.49" />
                        <line x1="15.41" x2="8.59" y1="6.51" y2="10.49" />
                    </svg>
                </button>
            </div>
            <div class="flex">
                <button
                    class="bg-gradient-to-br overlay-button from-slate-800 to-black text-white px-3 h-7 rounded-lg flex text-sm items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-eye me-1">
                        <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                    Detalles
                </button>
            </div>
        </div>
    </a>
</template>
<style scoped>
h3,
p {
    font-family: 'Roboto', sans-serif;
}</style>
