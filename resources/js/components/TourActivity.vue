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
        <div class="float-right">
            <div class="flex">
                <button @click="$emit('edit', activity)"
                    class="rounded-lg border border-gray-400 w-7 h-7 me-1 flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-clipboard-edit">
                        <rect width="8" height="4" x="8" y="2" rx="1" ry="1" />
                        <path d="M10.42 12.61a2.1 2.1 0 1 1 2.97 2.97L7.95 21 4 22l.99-3.95 5.43-5.44Z" />
                        <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-5.5" />
                        <path d="M4 13.5V6a2 2 0 0 1 2-2h2" />
                    </svg>
                </button>
                <button @click="$emit('destroy', activity)"
                    class="rounded-lg border border-gray-400 w-7 h-7 flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-trash-2">
                        <path d="M3 6h18" />
                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                        <line x1="10" x2="10" y1="11" y2="17" />
                        <line x1="14" x2="14" y1="11" y2="17" />
                    </svg>
                </button>
            </div>
            <div class="float-right px-2 py-2 mt-2 rounded-md bg-gradient-to-tr from-slate-700 to-black">
                <ActivityIcon :activity="activity" />
            </div>
        </div>
        <h3 class="font-bold text-lg text-gray-900 leading-4 pe-2">{{ activity.name }}</h3>
        <p class="text-gray-500 text-sm leading-4 pe-10 min-h-[4.4em] max-h-[4.5em] mt-4 overflow-hidden text-ellipsis"
            v-html="activity.description"></p>
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

                <div class="flex">
                    <div>
                        <small class="text-end text-gray-500 leading-4" v-html="activity.date"></small>

                    </div>
                </div>
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
