<script>
export default {
    props: {
        review: String,
        name: String,
        company: String,
    }
}
</script>
<template>
    <article class="text-center pb-12">
        <h6 class="text-gray-300 text-xl lg:px-20">" {{ review }} "</h6>
        <p class="text-white text-lg mt-6">{{ name }}</p>
        <small class="mt-2 text-gray-300 text-sm">{{ company }}</small>
    </article>
</template>
<style scoped>
h6,
p,
small {
    font-family: 'Nunito', sans-serif;
}
</style>
