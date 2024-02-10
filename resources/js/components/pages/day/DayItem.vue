<script>
import ActivityIcon from '../../common/ActivityIcon.vue';
import ActivityItineraryDetails from '../../itinerary/details/ActivityItineraryDetails.vue';
import FlyItineraryDetails from '../../itinerary/details/FlyItineraryDetails.vue';
import TransferItineraryDetails from '../../itinerary/details/TransferItineraryDetails.vue';
import BusItineraryDetails from '../../itinerary/details/TransferItineraryDetails.vue';
import TrainItineraryDetails from '../../itinerary/details/TrainItineraryDetails.vue';
import ShowItineraryDetails from '../../itinerary/details/ShowItineraryDetails.vue';
import HotelItineraryDetails from '../../itinerary/details/HotelItineraryDetails.vue';

export default {
    props: {
        activity: Object,
        collapsed: {
            type: Boolean,
            default: true,
        },
    },
    data() {
        return {
            collapse: this.collapsed
        };
    },
    components: { ActivityIcon, ActivityItineraryDetails, FlyItineraryDetails, TransferItineraryDetails, BusItineraryDetails, TrainItineraryDetails, ShowItineraryDetails, HotelItineraryDetails }
}
</script>
<template>
    <article :class="{ 'bg-white': print, 'gradient-1': !collapsed && !print, 'gradient-2': collapsed && !print }"
        class="rounded-lg mb-1 border border-gray-700 w-full">
        <div class="flex items-center w-full">
            <div class="p-2 w-11/12 flex items-center">
                <div class="me-2">
                    <ActivityIcon :activity="activity" />
                </div>
                <div class="w-full">
                    <small class="float-right text-xs text-gray-400">
                        {{ activity.tour.tourname }}
                    </small>
                    <h3 class="text-gray-200 text-sm">{{ activity.name }}</h3>
                    <p class="text-gray-400 text-xs">{{ activity.notes }}</p>
                </div>
            </div>
            <div v-if="collapsed" class="text-end w-1/12">
                <button @click="collapse = !collapse" :class="{ 'rotate-180': !collapse }"
                    class="text-white me-2 transition-transform"><i class="bi bi-chevron-down"></i></button>
            </div>
        </div>
        <div class="w-full transition-all overflow-hidden px-4" :class="{ 'h-0 p-0': collapse, 'h-auto p-2': !collapse }">
            <FlyItineraryDetails v-if="Number(activity.typeitinerary_id) == 1 || Number(activity.typeitinerary_id) == 2"
                :activity="activity" />
            <TransferItineraryDetails v-if="Number(activity.typeitinerary_id) == 3" :activity="activity" />
            <BusItineraryDetails v-else-if="Number(activity.typeitinerary_id) == 4" :activity="activity" />
            <TrainItineraryDetails v-else-if="Number(activity.typeitinerary_id) == 5" :activity="activity" />
            <HotelItineraryDetails v-else-if="Number(activity.typeitinerary_id) == 6" :activity="activity" />
            <ShowItineraryDetails v-else-if="Number(activity.typeitinerary_id) == 7" :activity="activity" />
            <ActivityItineraryDetails
                v-else-if="Number(activity.typeitinerary_id) == 8 || Number(activity.typeitinerary_id) == 9"
                :activity="activity" />
        </div>
    </article>
</template>
