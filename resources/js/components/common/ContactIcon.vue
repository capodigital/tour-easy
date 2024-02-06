<script>
export default {
    props: {
        contact: Object,
        stroke: {
            type: String,
            default: '#fff'
        },
        size: {
            type: Number,
            default: 24,
        },
        classes: {
            type: String,
            default: '',
        }
    },
    mounted() {
        if (this.contact.type == undefined) {
            this.contact.type = Number(this.contact.typecontact_id)
        }
    }
}
</script>
<template>
    <div :class="classes">
        <svg v-if="Number(contact.typecontact_id) == 1" xmlns="http://www.w3.org/2000/svg" :width="size" :height="size"
            viewBox="0 0 24 24" fill="none" :stroke="stroke" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="lucide lucide-bus">
            <path d="m12 8-9.04 9.06a2.82 2.82 0 1 0 3.98 3.98L16 12" />
            <circle cx="17" cy="7" r="5" />
        </svg>
        <svg v-else-if="Number(contact.typecontact_id) == 2" xmlns="http://www.w3.org/2000/svg" :width="size" :height="size"
            viewBox="0 0 16 16" :fill="stroke" class="lucide lucide-check-square">
            <path
                d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m.256 7a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1zm3.63-4.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382zM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0" />
        </svg>
        <svg v-else-if="Number(contact.typecontact_id) == 3" xmlns="http://www.w3.org/2000/svg" :width="size" :height="size"
            viewBox="0 0 24 24" fill="none" :stroke="stroke" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="lucide lucide-hotel">
            <path d="m3 11 18-5v12L3 14v-3z" />
            <path d="M11.6 16.8a3 3 0 1 1-5.8-1.6" />
        </svg>
        <svg v-else-if="Number(contact.typecontact_id) == 4" xmlns="http://www.w3.org/2000/svg" :width="size" :height="size"
            viewBox="0 0 24 24" fill="none" :stroke="stroke" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="lucide lucide-theater">
            <path d="M10 2h4" />
            <path d="m21 8-2 2-1.5-3.7A2 2 0 0 0 15.646 5H8.4a2 2 0 0 0-1.903 1.257L5 10 3 8" />
            <path d="M7 14h.01" />
            <path d="M17 14h.01" />
            <rect width="18" height="8" x="3" y="10" rx="2" />
            <path d="M5 18v2" />
            <path d="M19 18v2" />
        </svg>
        <svg v-else-if="Number(contact.typecontact_id) == 5" xmlns="http://www.w3.org/2000/svg" :width="size" :height="size"
            viewBox="0 0 24 24" fill="none" :stroke="stroke" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="lucide lucide-plane-takeoff">
            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
            <circle cx="9" cy="7" r="4" />
            <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
        </svg>
        <svg v-else-if="Number(contact.typecontact_id) == 6" xmlns="http://www.w3.org/2000/svg" :width="size" :height="size"
            viewBox="0 0 24 24" fill="none" :stroke="stroke" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="lucide lucide-train-front">
            <path
                d="M20 16V7a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v9m16 0H4m16 0 1.28 2.55a1 1 0 0 1-.9 1.45H3.62a1 1 0 0 1-.9-1.45L4 16" />
        </svg>
    </div>
</template>
