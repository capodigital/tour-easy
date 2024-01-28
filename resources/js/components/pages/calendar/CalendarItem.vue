<script>
import ActivityIcon from '../../common/ActivityIcon.vue'
import CalendarHours from './CalendarHours.vue'
import DayItem from '../day/DayItem.vue'


export default {
    components: { CalendarHours, ActivityIcon, DayItem },
    props: {
        itineraries: Array,
        today: Date,
    },
    watch: {
        itineraries() {
            this.init()
        }
    },
    data() {
        const days = []
        return {
            days: days,
            select: this.today.getDate(),
            activities: [],
            months: [
                'Enero',
                'Febrero',
                'Marzo',
                'Abril',
                'Mayo',
                'Junio',
                'Julio',
                'Agosto',
                'Septiembre',
                'Ocutubre',
                'Noviembre',
                'Diciembre'
            ]
        }
    },
    methods: {
        selected(day) {
            if (this.days[day].day != '') {
                this.select = this.days[day].day
                this.activities = this.days[day].activities
            }
        },
        init() {
            this.days = this.itineraries
        },
        title(date) {
            return date.toLocaleDateString("es", {
                month: "short",
                weekday: "long",
                day: "numeric",
            });
        },
        next() {
            if (this.today.getMonth() < 11) {
                this.$emit('month', this.today.getMonth() + 1)
                this.$emit('update')
            } else {
                this.$emit('year', this.today.getFullYear() + 1)
                this.$emit('month', 0)
                this.$emit('update')
            }
        },
        prev() {
            if (this.today.getMonth() != 0) {
                this.$emit('month', this.today.getMonth() - 1)
                this.$emit('update')
            } else {
                this.$emit('year', this.today.getFullYear() - 1)
                this.$emit('month', 11)
                this.$emit('update')
            }
        }
    },
    created() {
        this.init()
    }
}
</script>

<template>
    <div class="main mt-2">
        <div class="resume mb-2">
            <!-- <p class="font-bold text-gray-800 leading-3"><i class="bi bi-calendar-event-fill"></i> Calendario</p> -->
            <h6 class="text-gray-700 leading-4 text-center">5 actividades hoy</h6>
        </div>
        <div class="gradient-2 rounded-lg p-3 shadow-lg shadow-gray-700 grid grid-cols-1 sm:grid-cols-2 gap-2">
            <div>
                <div class="text-gray-200 flex w-full justify-between mb-1">
                    <i @click="prev" class="bi bi-chevron-left cursor-pointer"></i>
                    <p>{{ months[today.getMonth()] }} del {{ today.getFullYear() }}</p>
                    <i @click="next" class="bi bi-chevron-right cursor-pointer"></i>
                </div>
                <div class="weekdays flex justify-center items-center py-1">
                    <div class="mx-auto py-1 px-2 font-bold text-gray-300 text-sm">D</div>
                    <div class="mx-auto py-1 px-2 font-bold text-gray-300 text-sm">L</div>
                    <div class="mx-auto py-1 px-2 font-bold text-gray-300 text-sm">M</div>
                    <div class="mx-auto py-1 px-2 font-bold text-gray-300 text-sm">M</div>
                    <div class="mx-auto py-1 px-2 font-bold text-gray-300 text-sm">J</div>
                    <div class="mx-auto py-1 px-2 font-bold text-gray-300 text-sm">V</div>
                    <div class="mx-auto py-1 px-2 font-bold text-gray-300 text-sm">S</div>
                </div>
                <div class="mt-0.5 grid grid-cols-7 gap-1 text-sm text-gray-400">
                    <div @click="selected(index)" v-for="(day, index) in days"
                        class="border border-gray-600 relative cursor-pointer" :class="{ select: day.day == select }">
                        <button v-if="!day.out" class="text-gray-300 text-base px-1">
                            <i class="bi bi-plus"></i>
                        </button>
                        <div class="font-bold absolute top-0 right-0.5 text-xs">
                            {{ day.day }}
                        </div>
                        <div class="min-h-[2rem] grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 w-full gap-1 px-0.5 py-0.5">
                            <span @click="$emit('show', activity)" :title="activity.name"
                                v-for="activity in day.activities">
                                <ActivityIcon :activity="activity" size="15" />
                            </span>
                        </div>

                    </div>
                </div>
            </div>
            <div class="mt-3 sm:mt-0">
                <p class="text-gray-300 text-center"><i class="bi bi-calendar2-week-fill"></i> Actividades</p>
                <!-- <CalendarHours v-for="(hour, index) in hours" :hour="hour" :index="index" :hours="hours" /> -->
                <div class="flex justify-center">
                    <div class="w-full" v-if="activities.length > 0">
                        <DayItem v-for="activity in activities" :activity="activity" />
                    </div>
                    <div v-else class="min-h-[20rem] flex justify-center items-center">
                        <div class="text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="none"
                                stroke="rgb(107, 114, 128)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-search-x m-auto">
                                <path d="m13.5 8.5-5 5" />
                                <path d="m8.5 8.5 5 5" />
                                <circle cx="11" cy="11" r="8" />
                                <path d="m21 21-4.3-4.3" />
                            </svg>
                            <p class="text-center text-gray-500">No hay eventos para este día</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.weekdays {
    background: linear-gradient(to right, rgba(5, 98, 238, 0.048), rgba(5, 98, 238, 0.137), rgba(5, 98, 238, 0.048));
}

.active {
    background-color: rgb(54, 162, 235);
    color: #fff;
}

.today {
    border: 2px dashed rgb(54, 162, 235);
    color: #fff;
}

.select:not(.active) {
    border: 2px solid rgb(255, 99, 132);
    color: #fff;
    background-color: #415bc56c;
}

.select.active {
    box-shadow: 0 0 .3rem rgb(255, 99, 132);
}

.select.today {
    border: 2px dashed rgb(255, 99, 132);
}
</style>
