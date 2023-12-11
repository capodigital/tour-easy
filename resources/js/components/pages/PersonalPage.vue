<script>
import axios from 'axios'
import PersonalItem from '../PersonalItem.vue'

export default {
    data() {
        return {
            contacts: []
        };
    },
    created() {
        axios.get('api/contacts').then((response) => {
            this.contacts = response.data.data;
        });
    },
    components: { PersonalItem }
}
</script>
<template>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-3 p-3">
        <PersonalItem v-for="contact in contacts" :contact="contact" />
    </div>
</template>
<style scoped>
h1 {
    font-family: 'Archivo Black', sans-serif;
}

/*article {
    border-top-left-radius: 3rem;
    border-bottom-left-radius: 3rem;
    border-top-right-radius: .75rem;
    border-bottom-right-radius: .75rem;
}*/
</style>
