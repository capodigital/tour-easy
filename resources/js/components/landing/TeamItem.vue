<script>
export default {
    props: {
        avatar: String,
        name: String,
        role: String,
    }
}
</script>
<template>
    <article class="text-center p-4 bg-white rounded lg:px-10 shadow shadow-gray-300">
        <div class="relative mx-auto">
            <img class="h-32 w-32 rounded-full mx-auto" :src="avatar" />
            <button class="absolute bottom-0 right-0 rounded-full flex justify-center items-center h-8 w-8 bg-green-500 text-white"><i class="bi bi-envelope-fill"></i></button>
        </div>
        <h6 class="text-gray-800 font-semibold mt-5 text-lg">{{ name }}</h6>
        <small class="text-gray-500 mt-2 text-sm">{{ role }}</small>
    </article>
</template>
<style scoped>
p,
h6 {
    font-family: 'Nunito', sans-serif;
}
</style>
