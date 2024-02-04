<script>
import TeamItem from './TeamItem.vue';

export default {
    data() {
        return {
            members: [
                {
                    avatar: 'src/landing/avatar-2.jpg',
                    name: 'Nancy Martino',
                    role: 'Team Leader',
                },
                {
                    avatar: 'src/landing/avatar-10.jpg',
                    name: 'Henry Baird',
                    role: 'Full Stack Developer',
                },
                {
                    avatar: 'src/landing/avatar-3.jpg',
                    name: 'Frank Hook',
                    role: 'Project Manager',
                },
                {
                    avatar: 'src/landing/avatar-8.jpg',
                    name: 'Donald Palmer',
                    role: 'UI/UX Designer',
                },
                {
                    avatar: 'src/landing/avatar-5.jpg',
                    name: 'Erica Kernan',
                    role: 'Web Designer',
                },
                {
                    avatar: 'src/landing/avatar-4.jpg',
                    name: 'Alexis Clarke',
                    role: 'Backend Develper',
                },
                {
                    avatar: 'src/landing/avatar-6.jpg',
                    name: 'Marie Ward',
                    role: 'Full Stack Developer',
                },
                {
                    avatar: 'src/landing/avatar-7.jpg',
                    name: 'Jack Gough',
                    role: 'React Js Developer',
                },
            ]
        };
    },
    components: { TeamItem }
}
</script>
<template>
    <section id="team" class="px-6 sm:px-12 md:px-24 lg:px-40 py-40">
        <div class="px-6 sm:px-10 md:px-20 lg:px-44">
            <h3 class="text-gray-700 text-center font-bold text-2xl">Our <span class="text-red-500">Team</span></h3>
            <p class="text-gray-500 text-center">In an ideal world this website wouldn’t exist, a client would acknowledge
                the importance of having web copy before the Proin vitae ipsum vel ex finibus semper design starts.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-4">
            <TeamItem v-for="member in members" :avatar="member.avatar" :name="member.name" :role="member.role" />
        </div>
        <div class="flex justify-center mt-8">
            <button
                class="px-5 py-2 mx-auto text-white bg-blue-600 hover:bg-blue-700 transition-all rounded border-none focus:outline-none">View
                All Members <i class="bi bi-arrow-right-short"></i></button>
        </div>
    </section>
</template>
<style scoped>
p,
h3 {
    font-family: 'Nunito', sans-serif;
}

section {
    background-color: rgb(243, 246, 249);
}</style>
