<script>
import ActivityIcon from '../../common/ActivityIcon.vue';
import ContactItem from '../../pages/contacts/ContactItem.vue';

export default {
    props: {
        activity: Object
    },
    components: { ContactItem, ActivityIcon }
}
</script>
<template>
    <article class="rounded-lg max-w-xl mb-2 p-2">
        <div class="flex items-center mt-2">
            <ActivityIcon :activity="activity" :size="20" />
            <div class="ps-2">
                <p class="text-white">Tipo de itinerario</p>
                <p class="text-gray-400 text-sm">{{ activity.typeitinerary.description }}</p>
            </div>
        </div>
        <hr class="my-2 border-gray-500" />
        <div class="flex items-center w-full">
            <div class="flex items-center mt-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-calendar-clock me-2">
                    <path d="M21 7.5V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h3.5" />
                    <path d="M16 2v4" />
                    <path d="M8 2v4" />
                    <path d="M3 10h5" />
                    <path d="M17.5 17.5 16 16.25V14" />
                    <path d="M22 16a6 6 0 1 1-12 0 6 6 0 0 1 12 0Z" />
                </svg>
                <div>
                    <p class="text-white">Fecha y hora de inicio</p>
                    <p class="text-gray-400 text-sm">{{ Utils.datetime(activity.startdate, Utils.FULL_DATE_TIME) }}
                    </p>
                </div>
            </div>

            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right mx-5">
                <path d="M5 12h14" />
                <path d="m12 5 7 7-7 7" />
            </svg>

            <div class="flex justify-between items-center mt-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-calendar-clock me-2">
                    <path d="M21 7.5V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h3.5" />
                    <path d="M16 2v4" />
                    <path d="M8 2v4" />
                    <path d="M3 10h5" />
                    <path d="M17.5 17.5 16 16.25V14" />
                    <path d="M22 16a6 6 0 1 1-12 0 6 6 0 0 1 12 0Z" />
                </svg>
                <div>
                    <p class="text-white">Fecha y hora de fin</p>
                    <p class="text-gray-400 text-sm">{{ Utils.datetime(activity.enddate, Utils.FULL_DATE_TIME) }}
                    </p>
                </div>
            </div>
        </div>
        <hr class="my-2 border-gray-500" />
        <div class="flex items-center mt-2 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plane me-2">
                <path
                    d="M17.8 19.2 16 11l3.5-3.5C21 6 21.5 4 21 3c-1-.5-3 0-4.5 1.5L13 8 4.8 6.2c-.5-.1-.9.1-1.1.5l-.3.5c-.2.5-.1 1 .3 1.3L9 12l-2 3H4l-1 1 3 2 2 3 1-1v-3l3-2 3.5 5.3c.3.4.8.5 1.3.3l.5-.2c.4-.3.6-.7.5-1.2z" />
            </svg>
            <div>
                <p class="text-white">Ciudad</p>
                <p class="text-gray-400 text-sm">{{ activity.citystart.name }} ({{ activity.citystart.code }})</p>
            </div>
        </div>
        <span class="text-sm text-gray-200 bg-app-primary-600 px-2 py-1 rounded mt-2">Personas resposables</span>
        <div class="mt-2 mb-2">
            <ContactItem v-for="person in activity.persons_1" :person="person" :select="false" />
            <div class="flex w-full items-center justify-center text-gray-500" v-if="activity.persons_1.length == 0">
                <i class="bi bi-people-fill text-2xl me-2"></i>
                <p>No hay personas resposables</p>
            </div>
        </div>
        <span class="text-sm text-gray-200 bg-app-primary-600 px-2 py-1 rounded">Personas asociadas</span>
        <div class="mt-2">
            <ContactItem v-for="person in activity.persons_2" :person="person" :select="false" />
            <div class="flex w-full items-center justify-center text-gray-500" v-if="activity.persons_2.length == 0">
                <i class="bi bi-people-fill text-2xl me-2"></i>
                <p>No hay personas asociadas</p>
            </div>
        </div>
    </article>
</template>
