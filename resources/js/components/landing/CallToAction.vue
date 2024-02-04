<template>
    <div class="py-12 bg-blue-600 relative px-6 sm:px-10 md:px-20 lg:px-32">
        <div class="bg-overlay bg-overlay-pattern opacity-50"></div>
        <div class="md:flex justify-between items-center">
            <div class="z-50">
                <h4 class="text-white text-xl font-bold">Build your web App/SaaS with Velzon dashboard</h4>
            </div>
            <div class="z-50 mt-4 md:mt-0">
                <a href="#" class="px-4 py-2 text-white bg-red-500 rounded"><i class="bi bi-cart3"></i> Buy Now</a>
            </div>
        </div>
    </div>
</template>
<style scoped>
.bg-overlay {
    position: absolute;
    height: 100%;
    width: 100%;
    right: 0;
    bottom: 0;
    left: 0;
    top: 0;
    opacity: .7;
    background-color: #000;
    z-index: 1;
}

.bg-overlay-pattern {
    background-image: url(src/landing/bg-pattern.png);
    background-color: transparent;
    background-position: center;
    background-size: cover;
    opacity: .2;

}
</style>
