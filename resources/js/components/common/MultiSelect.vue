<script>
export default {
    props: {
        options: Array,
        ids: Array,
        label: String,
        initial: Array,
    },
    data() {
        return {
            collapse: false,
        }
    },
    watch: {
        initial() {
            for (const item of this.initial) {
                console.log(item)
                this.ids.push(item.id)
            }
        }
    },
    methods: {
        update(option, checked) {
            if (checked) {
                this.ids.push(option.id)
            } else {
                this.ids.splice(this.ids.indexOf(option.id), 1)
            }
        }
    },
    mounted() {
        for (const item of this.initial) {
            this.ids.push(item.id)
        }
        console.log(this.ids)
    }
}
</script>
<template>
    <div class="relative">
        <div @click="collapse = !collapse" class="flex items-center rounded border border-gray-300 px-2 cursor-pointer">
            <div class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3 flex">
                <p class="w-full">{{ label }}</p>
                <button type="button" :class="{ 'rotate-180': collapse }"
                    class="transition-all"><i class="bi bi-chevron-down"></i></button>
            </div>
        </div>
        <ul class="overflow-hidden absolute top-12 w-full left-0 bg-slate-800 rounded shadow shadow-gray-700"
            :class="{ 'h-0': !collapse, 'h-auto': collapse }">
            <li v-for="option in options" :key="option.id" class="px-2 py-1 flex items-center">
                <input @change="(e) => update(option, e.target.checked)" :selected="ids.includes(option.id)"
                    class="form-check-input me-2" type="checkbox" />
                <slot :item="option"></slot>
            </li>
        </ul>
    </div>
</template>
