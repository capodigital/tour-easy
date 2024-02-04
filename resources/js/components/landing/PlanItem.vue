<script>
export default {
    props: {
        title: String,
        description: String,
        icon: String,
        price: Number,
        period: String,
        features: Array,
    }
}
</script>
<template>
    <article class="p-8 bg-white rounded shaodw-lg shadow-gray-400">
        <div class="flex justify-between items-center">
            <div>
                <h4 class="font-bold text-gray-800">{{ title }}</h4>
                <p class="text-gray-500">{{ description }}</p>
            </div>
            <div>
                <i :class="icon" class="text-blue-600 text-xl"></i>
            </div>
        </div>
        <div class="flex justify-center mt-4">
            <h6 class="text-4xl font-bold text-gray-700"><sup>$</sup>{{ Math.floor(price) }} /<small class="text-sm">{{
                period }}</small></h6>
        </div>
        <div class="mt-6">
            <p class="text-gray-400 my-3 flex items-center" v-for="feature in features">
                <i class="bi text-sm me-4"
                    :class="{ 'text-red-500': !feature.has, 'text-green-500': feature.has, 'bi-x-circle-fill': !feature.has, 'bi-check-circle-fill': feature.has }"></i>
                {{ feature.name }}
            </p>
        </div>
        <div class="w-full mt-10">
            <button class="transition-all text-green-600 rounded bg-gray-200 hover:text-white hover:bg-green-600 px-2 py-2 text-center w-full">Get Started</button>
        </div>
    </article>
</template>
<style scoped>
h6,
h4,
p, button {
    font-family: 'Nunito', sans-serif;
}</style>
