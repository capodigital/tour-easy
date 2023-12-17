<script>
import axios from 'axios'
import ArtistsItem from '../ArtistsItem.vue'
export default {
    data() {
        return {
            artists: []
        };
    },
    created() {
        axios.post('api/artists/agency', {
            id: this.Utils.user().id
        }, {
            headers: {
                Authorization: `Bearer ${this.Utils.token()}`
            }
        }).then((response) => {
            console.log(response.data);
            this.artists = response.data;
        });
    },
    components: { ArtistsItem }
}
</script>
<template>
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4 p-3">
        <ArtistsItem :artist="artist" v-for="artist in artists.data" />
    </div>
</template>
