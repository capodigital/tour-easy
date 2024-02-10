<script>
import axios from 'axios'
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
            groups: [],
            types: [],
            group: null,
            type: null,
        }
    },
    watch: {
        initial() {
            for (const item of this.initial) {
                this.ids.push(item.id)
            }
        }
    },
    methods: {
        update(id, checked) {
            if (checked) {
                this.ids.push(id)
            } else {
                this.ids.splice(this.ids.indexOf(id), 1)
            }
        },
        person(id) {
            for (const item of this.options) {
                if (item.id == id) {
                    return item;
                }
            }
        }
    },
    mounted() {
        console.log(this.initial)
        for (const item of this.initial) {
            this.ids.push(item.id)
        }
    },
    created() {
        axios.get('api/typecontacts', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.types = response.data.data;
        }).catch((error) => {
            this.Utils.error(error.response)
        });
        axios.get('api/groups', {
            headers: {
                'Authorization': `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            this.groups = response.data.data;
        }).catch((error) => {
            this.Utils.error(error.response)
        });
    }
}
</script>
<template>
    <div v-click-outside="() => collapse = false" class="relative">
        <div class="flex items-center rounded border border-gray-300 px-0 cursor-pointer">
            <div class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-3 py-3 flex">
                <p v-if="ids.length == 0" @click="collapse = !collapse" class="w-full">{{ label }}</p>
                <div class="whitespace-pre-wrap w-full">
                    <span @click="update(id, false)" v-for="id in ids"
                        class="inline-block cursor-pointer text-xs whitespace-nowrap bg-gray-400 text-black rounded py-1 px-2 mx-0.5">{{
                            person(id).name }} <i class="bi bi-x"></i></span>
                </div>
                <button @click="collapse = !collapse" type="button" :class="{ 'rotate-180': collapse }"
                    class="transition-all"><i class="bi bi-chevron-down"></i></button>
            </div>
        </div>
        <ul class="overflow-hidden transition-all absolute bottom-[3.2rem] w-full left-0 gradient-1 rounded shadow shadow-gray-700"
            :class="{ 'h-0': !collapse, 'h-auto': collapse }">
            <li class="flex p-2">
                <div class="flex items-center rounded border border-gray-300 px-0.5 w-1/2 mx-1">
                    <select v-model="group"
                        class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-2 py-1">
                        <option class="text-black" :value="null">Seleccionar grupo</option>
                        <option class="text-black" v-for="item in groups" :value="item.id">
                            {{ item.name }}
                        </option>
                    </select>
                </div>
                <div class="flex items-center rounded border border-gray-300 px-0.5 w-1/2 mx-1">
                    <select v-model="type"
                        class="bg-transparent w-full text-gray-300 text-sm border-none focus:outline-none px-2 py-1">
                        <option class="text-black" :value="null">Seleccionar tipo</option>
                        <option class="text-black" v-for="item in types" :value="item.id">
                            {{ item.description }}
                        </option>
                    </select>
                </div>
            </li>
            <template v-for="option in options">
                <li v-if="(group == null || group == option.group_id) && (type == null || type == option.typecontact_id)"
                    :key="option.id" class="px-2 py-1 flex items-center border-b border-b-gray-600 last:border-b-0">
                    <input @change="(e) => update(option.id, e.target.checked)" :checked="ids.includes(option.id)"
                        class="form-check-input me-2" type="checkbox" />
                    <slot :item="option"></slot>
                </li>
            </template>
        </ul>
    </div>
</template>
