<script>
import axios from 'axios'
export default {
    data() {
        return {
            artists: []
        }
    },
    created() {
        axios.get('api/')
    }
}
</script>
<template>

</template>
