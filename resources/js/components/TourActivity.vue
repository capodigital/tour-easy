<script>
import ActivityIcon from './common/ActivityIcon.vue';

export default {
    props: {
        activity: Object
    },
    components: { ActivityIcon }
}
</script>
<template>
    <article class="bg-white rounded-2xl shadow-md shadow-gray-500 p-3 transition-all hover:scale-105 cursor-pointer">
        <h3 class="font-bold text-lg text-gray-900 leading-4 pe-2">{{ activity.name }}</h3>
        <div class="float-right px-2 py-2 rounded-md bg-gradient-to-tr from-slate-700 to-black">
            <ActivityIcon :activity="activity" />
        </div>

        <p class="text-gray-500 text-sm leading-4 pe-10 min-h-[5.4em] max-h-[5.5em] mt-2 overflow-hidden text-ellipsis"
            v-html="activity.description"></p>
        <!-- <div class="flex justify-around text-xs mt-2">
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
        </div> -->
        <div class="flex mt-4">
            <div class="flex w-full justify-between items-end">
                <button
                    :class="{ 'from-gray-400': activity.complete == undefined, 'to-gray-800': activity.complete == undefined, 'from-green-500': activity.complete, 'to-green-700': activity.complete }"
                    class="rounded-lg border px-3 h-9 overlay-button me-1 flex justify-center items-center bg-gradient-to-br text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-check-square me-2">
                        <path d="m9 11 3 3L22 4" />
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" />
                    </svg>
                    Completado
                </button>
                <!-- <button class="rounded-lg border border-gray-400 w-7 h-7 flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-share-2">
                        <circle cx="18" cy="5" r="3" />
                        <circle cx="6" cy="12" r="3" />
                        <circle cx="18" cy="19" r="3" />
                        <line x1="8.59" x2="15.42" y1="13.51" y2="17.49" />
                        <line x1="15.41" x2="8.59" y1="6.51" y2="10.49" />
                    </svg>
                </button> -->
                <div class="flex">

                    <small class="text-end text-gray-500 leading-4">{{ activity.start }}</small>
                </div>
            </div>

        </div>
    </article>
</template>
<style scoped>
h3,
p {
    font-family: 'Roboto', sans-serif;
}</style>
