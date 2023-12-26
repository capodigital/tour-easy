<script>
export default {
    data() {
        return {
            show: false,
            hidden: false,
        }
    },
    methods: {
        _cancel() {
            this.show = false
            this.cancel()
            setTimeout(() => {
                this.hidden = true;
            }, 310)
        },
        _accept() {
            this.show = false
            this.accept()
            setTimeout(() => {
                this.hidden = true;
            }, 310)
        }
    },
    mounted() {
        setTimeout(() => {
            this.show = true
        }, 10)
    }
}
</script>

<template>
    <div class="absolute top-0 right-0 bg-black bg-opacity-50 w-screen h-screen" v-if="!hidden">
        <transition name="scale" mode="out-in">
            <div v-if="show"
                class="absolute bottom-2 z-50 right-8 w-96 bg-gradient-to-tr from-slate-800 to-slate-950 rounded-lg shadow shadow-gray-500 p-4 flex">
                <div class="cursor-pointer pe-2" @click="show = false">
                    <i class="bi bi-x-circle text-gray-300 text-2xl"></i>
                </div>
                <div>
                    <h5 class="font-bold text-white">{{ title }}</h5>
                    <p class="mt-2 text-gray-400">{{ subtitle }}</p>
                    <div class="flex justify-end w-full">
                        <button @click="_cancel"
                            class="px-2 text-sm text-center py-1 w-10 me-1 rounded border border-gray-400 text-gray-400">
                            No
                        </button>
                        <button @click="_accept"
                            class="px-2 text-sm text-center py-1 w-10 me-1 rounded bg-gray-100 text-gray-800">
                            Sí
                        </button>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>
<style scoped>
.scale-enter-active {
    animation: scaleIn 0.2s;
}

.scale-leave-active {
    animation: scaleOut 0.2s;
}

@keyframes scaleIn {
    0% {
        transform: scale(0);
        opacity: 0;
    }

    100% {
        transform: scale(1);
        opacity: 1;
    }
}

@keyframes scaleOut {
    0% {
        transform: scale(1);
        opacity: 1;
    }

    100% {
        transform: scale(0);
        opacity: 0;
    }
}
</style>
