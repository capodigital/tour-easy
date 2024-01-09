<script>
export default {
    props: {
        item: Object,
    },
    methods: {
        close(e) {
            if (e.target.classList.contains('custom-modal') && sessionStorage.getItem('lock') != 'locked') {
                this.$emit('close')
            }
        }
    }
}
</script>
<template>
    <div @click="close"
        class="bg-white custom-modal bg-opacity-90 h-screen w-screen fixed left-0 top-0 px-4 py-4 flex justify-center items-center z-[100]">
        <slot></slot>
    </div>
</template>
