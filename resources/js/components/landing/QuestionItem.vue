<script>
export default {
    props: {
        question: String,
        text: String,
    },
    data() {
        return {
            collapse: true,
        }
    }
}
</script>
<template>
    <article class="bg-white shadow-md shadow-gray-200 my-3 rounded border border-gray-200">
        <div class="p-4 flex justify-between transition-all rounded-t cursor-pointer" :class="{ 'text-blue-500': !collapse, 'text-gray-800': collapse, 'bg-blue-50': !collapse, 'bg-transparent': collapse }"
            @click="collapse = !collapse">
            <h6 class="font-semibold">{{ question }}</h6>
            <button class="transition-all" :class="{ '-rotate-90': !collapse }"><i class="bi bi-chevron-right"></i></button>
        </div>
        <div class="transition-all overflow-hidden" :class="{ 'h-0': collapse, 'p-0': collapse, 'h-auto': !collapse, 'p-3': !collapse }">
            <p class="text-gray-400">{{ text }}</p>
        </div>
    </article>
</template>
