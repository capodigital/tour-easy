<script>
export default {
    props: {
        activity: Object
    }
}
</script>
<template>
    <article class="bg-white rounded-2xl shadow-md shadow-gray-500 p-3 transition-all hover:scale-105 cursor-pointer">
        <h3 class="font-bold text-lg text-gray-900 leading-4 pe-2">{{ activity.name }}</h3>
        <div class="float-right px-2 py-2 rounded-md bg-gradient-to-tr from-slate-700 to-black">
            <svg v-if="activity.type == 'drive'" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" class="lucide lucide-bus">
                <path d="M8 6v6" />
                <path d="M15 6v6" />
                <path d="M2 12h19.6" />
                <path
                    d="M18 18h3s.5-1.7.8-2.8c.1-.4.2-.8.2-1.2 0-.4-.1-.8-.2-1.2l-1.4-5C20.1 6.8 19.1 6 18 6H4a2 2 0 0 0-2 2v10h3" />
                <circle cx="7" cy="18" r="2" />
                <path d="M9 18h5" />
                <circle cx="16" cy="18" r="2" />
            </svg>
            <svg v-else-if="activity.type == 'photos'" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" class="lucide lucide-check-square">
                <path d="m9 11 3 3L22 4" />
                <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" />
            </svg>
            <svg v-else-if="activity.type == 'hotel'" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" class="lucide lucide-hotel">
                <path d="M18 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2Z" />
                <path d="m9 16 .348-.24c1.465-1.013 3.84-1.013 5.304 0L15 16" />
                <path d="M8 7h.01" />
                <path d="M16 7h.01" />
                <path d="M12 7h.01" />
                <path d="M12 11h.01" />
                <path d="M16 11h.01" />
                <path d="M8 11h.01" />
                <path d="M10 22v-6.5m4 0V22" />
            </svg>
            <svg v-else-if="activity.type == 'function'" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" class="lucide lucide-theater">
                <path d="M2 10s3-3 3-8" />
                <path d="M22 10s-3-3-3-8" />
                <path d="M10 2c0 4.4-3.6 8-8 8" />
                <path d="M14 2c0 4.4 3.6 8 8 8" />
                <path d="M2 10s2 2 2 5" />
                <path d="M22 10s-2 2-2 5" />
                <path d="M8 15h8" />
                <path d="M2 22v-1a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v1" />
                <path d="M14 22v-1a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v1" />
            </svg>
            <svg v-else xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-plane-takeoff">
                <path d="M2 22h20" />
                <path
                    d="M6.36 17.4 4 17l-2-4 1.1-.55a2 2 0 0 1 1.8 0l.17.1a2 2 0 0 0 1.8 0L8 12 5 6l.9-.45a2 2 0 0 1 2.09.2l4.02 3a2 2 0 0 0 2.1.2l4.19-2.06a2.41 2.41 0 0 1 1.73-.17L21 7a1.4 1.4 0 0 1 .87 1.99l-.38.76c-.23.46-.6.84-1.07 1.08L7.58 17.2a2 2 0 0 1-1.22.18Z" />
            </svg>
        </div>

        <p class="text-gray-500 text-sm leading-4 pe-10 min-h-[3.4em] mt-2">{{ activity.description }}</p>
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
            <div class="flex w-full">
                <button :class="{ 'from-gray-400': activity.complete == undefined, 'to-gray-800': activity.complete == undefined, 'from-green-500': activity.complete, 'to-green-700': activity.complete }"
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
            </div>
            <div class="flex">

                <small class="text-end text-gray-500 leading-4">{{ activity.start }}</small>
            </div>
        </div>
    </article>
</template>
<style scoped>
h3,
p {
    font-family: 'Roboto', sans-serif;
}
</style>
