<script>
import ActivityIcon from './common/ActivityIcon.vue';

export default {
    props: {
        activity: Object,
    },
    data() {
        return {
            collapse: true
        };
    },
    components: { ActivityIcon }
}
</script>
<template>
    <article class="bg-gradient-to-tr rounded-lg from-slate-800 via-slate-900 to-slate-950 mb-2 max-w-3xl">
        <div class="flex items-center w-full">
            <div class="p-2 w-11/12 flex items-center">
                <div class="me-2">
                    <ActivityIcon :activity="activity" />
                </div>
                <div class="w-full">
                    <small class="float-right text-xs text-gray-400">
                        {{ activity.tour.tourname }}
                    </small>
                    <h3 class="text-gray-200 font-semibold">{{ activity.name }}</h3>
                    <p class="text-white text-sm" v-html="activity.description"></p>
                </div>
            </div>
            <div class="text-end w-1/12">
                <button @click="collapse = !collapse" :class="{ 'rotate-180': !collapse }"
                    class="text-white me-2 transition-transform"><i class="bi bi-chevron-down"></i></button>
            </div>
        </div>
        <div class="w-full transition-all overflow-hidden px-4" :class="{ 'h-0 p-0': collapse, 'h-auto p-2': !collapse }">
            <p class="text-white flex">
                <ActivityIcon :activity="activity" size="20" />
                <span class="ms-2">Tipo de actividad: {{ activity.typeitinerary.description }}</span>
            </p>
            <hr class="my-2 border-gray-500" />
            <div class="flex items-center">
                <p class="text-white flex mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-calendar-clock me-2">
                        <path d="M21 7.5V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h3.5" />
                        <path d="M16 2v4" />
                        <path d="M8 2v4" />
                        <path d="M3 10h5" />
                        <path d="M17.5 17.5 16 16.25V14" />
                        <path d="M22 16a6 6 0 1 1-12 0 6 6 0 0 1 12 0Z" />
                    </svg>
                    Desde: {{ Utils.time(activity.startdate, Utils.FULL_TIME) }}
                </p>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right mx-2">
                    <path d="M5 12h14" />
                    <path d="m12 5 7 7-7 7" />
                </svg>
                <p class="text-white flex mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-calendar-clock me-2">
                        <path d="M21 7.5V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h3.5" />
                        <path d="M16 2v4" />
                        <path d="M8 2v4" />
                        <path d="M3 10h5" />
                        <path d="M17.5 17.5 16 16.25V14" />
                        <path d="M22 16a6 6 0 1 1-12 0 6 6 0 0 1 12 0Z" />
                    </svg>
                    Hasta: {{ Utils.time(activity.enddate, Utils.FULL_TIME) }}
                </p>
            </div>
            <hr class="my-2 border-gray-500" />
            <template v-if="[4, 5, 6, 7].includes(activity.type)">
                <p class="text-white flex mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-square-user me-2">
                        <rect width="18" height="18" x="3" y="3" rx="2" />
                        <circle cx="12" cy="10" r="3" />
                        <path d="M7 21v-2a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2" />
                    </svg>
                    Encargado de transporte: {{ activity.carrier }}
                </p>
                <hr class="my-2 border-gray-500" />
            </template>

            <p class="text-white flex mt-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pinned me-2">
                    <path d="M18 8c0 4.5-6 9-6 9s-6-4.5-6-9a6 6 0 0 1 12 0" />
                    <circle cx="12" cy="8" r="2" />
                    <path
                        d="M8.835 14H5a1 1 0 0 0-.9.7l-2 6c-.1.1-.1.2-.1.3 0 .6.4 1 1 1h18c.6 0 1-.4 1-1 0-.1 0-.2-.1-.3l-2-6a1 1 0 0 0-.9-.7h-3.835" />
                </svg>
                Lugar: {{ activity.place.name }}
            </p>
        </div>
    </article>
</template>
