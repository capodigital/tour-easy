<script>
    import Mixin from "./AlertMixin.js"

    export default {
        /**
         * @mixin: ./AlertMixin.js
         */
        mixins: [Mixin],
    }
</script>

<template>
    <div class="toast items-center border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="flex relative bg-white rounded-md shadow-md shadow-gray-500" style="z-index: 100;">
            <div class="toast-body flex items-center">
                <div class="mx-2 flex items-center justify-center">
                    <i class="text-6xl" :class="config.icon" :style="{ color: config.color }"></i>
                </div>
                <div class="border-l border-l-gray-300 py-2 px-3">
                    <h6 class="mb-1 text-black font-bold">{{ config.title }}</h6>
                    <p class="mb-0 text-gray-600">{{ config.text }}</p>
                </div>
            </div>
            <div :style="{ background: config.color }" class="toast-progress"></div>
            <button @click="close" type="button" class="btn-close me-2 mt-2 ms-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</template>

<style scoped>
    .toast-progress {
        position: absolute;
        width: 100%;
        height: 5px;
        bottom: 0;
        border-bottom-left-radius: var(--bs-toast-border-radius);
        border-bottom-right-radius: var(--bs-toast-border-radius);
        transition: width ease-in-out 0.1s;
    }
</style>
