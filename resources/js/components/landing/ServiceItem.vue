<script>
export default {
    props: {
        icon: String,
        title: String,
        description: String,
    }
}
</script>
<template>
    <article class="flex">
        <i :class="icon" class="text-green-500 text-3xl me-4"></i>
        <div>
            <h4 class="text-gray-600 font-bold text-lg">{{ title }}</h4>
            <p class="mt-4 text-gray-500 font-semibold mb-4">{{ description }}</p>
            <a href="#" class="text-blue-600 mt-10 flex leading-3">Learn More <i class="bi bi-caret-right text-xs ms-2"></i></a>
        </div>
    </article>
</template>
<style scoped>
p, h4 {
    font-family: 'Nunito', sans-serif;
}
</style>
