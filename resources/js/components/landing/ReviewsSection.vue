<script>
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Navigation, Pagination, Scrollbar, A11y } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/scrollbar';
import ReviewItem from './ReviewItem.vue';

export default {
    components: { Swiper, SwiperSlide, ReviewItem },
    setup() {
        return {
            reviews: [
                {
                    review: "I am givng 5 stars. Theme is great and everyone one stuff everything in theme. Future request should not affect current state of theme.",
                    name: "gregoriusus",
                    company: "- Skote User",
                },
                {
                    review: "Awesome support. Had few issues while setting up because of my device, the support team helped me fix them up in a day. Everything looks clean and good. Highly recommended!",
                    name: "GeekyGreenOwl",
                    company: "- Skote User",
                },
                {
                    review: "Amazing template, Redux store and components is nicely designed. It's a great start point for an admin based project. Clean Code and good documentation. Template is completely in React and absolutely no usage of jQuery",
                    name: "sreeks456",
                    company: "- Veltrix User",
                },
            ],
            modules: [Navigation, Pagination, A11y],
        };
    },
}
</script>
<template>
    <section>
        <div class="py-24 bg-blue-600 relative px-6 sm:px-10 md:px-20 lg:px-32">
            <div class="bg-overlay bg-overlay-pattern opacity-50"></div>
            <div>
                <div class="flex justify-center items-center mb-12">
                    <div class="text-center">
                        <i class="bi bi-quote text-green-600 text-6xl"></i>
                        <p class="text-white text-xl font-semibold">19k+ Satisfied clients</p>
                    </div>
                </div>
                <Swiper :slides-per-view="1" navigation :pagination="{ clickable: true }" :modules="modules">
                    <SwiperSlide v-for="review in reviews">
                        <ReviewItem :review="review.review" :name="review.name" :company="review.company" />
                    </SwiperSlide>
                </swiper>
            </div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-6">
            <div class="text-center">
                <p class="text-2xl text-gray-700 font-bold">100+</p>
                <small class="text-gray-500">Projects Completed</small>
            </div>
            <div class="text-center">
                <p class="text-2xl text-gray-700 font-bold">24</p>
                <small class="text-gray-500">Win Awards</small>
            </div>
            <div class="text-center">
                <p class="text-2xl text-gray-700 font-bold">20.4k</p>
                <small class="text-gray-500">Satisfied Clients</small>
            </div>
            <div class="text-center">
                <p class="text-2xl text-gray-700 font-bold">50</p>
                <small class="text-gray-500">Employees</small>
            </div>
        </div>
        <div class="mt-16 px-8 sm:px-24 md:px-32 lg:px-56">
            <h3 class="text-gray-700 text-center font-bold text-2xl">Our Work Process</h3>
            <p class="text-gray-500 text-center">In an ideal world this website wouldn’t exist, a client would acknowledge the importance of having web copy before the Proin vitae ipsum vel ex finibus semper design starts.</p>
        </div>
        <div class="mt-16 px-6 sm:px-10 md:px-20 lg:px-36 grid grid-cols-1 md:grid-cols-3">
            <div>
                <div class="flex justify-center mb-2">
                    <i class="bi bi-tree text-4xl text-green-600"></i>
                </div>
                <h5 class="text-gray-600 text-center text-lg font-semibold mb-3">Tell us what you need</h5>
                <p class="text-gray-500 text-center">The profession and the employer and your desire to make your mark.</p>
            </div>
            <div>
                <div class="flex justify-center mb-2">
                    <i class="bi bi-person-check text-4xl text-green-600"></i>
                </div>
                <h5 class="text-gray-600 text-center text-lg font-semibold mb-3">Get free quotes</h5>
                <p class="text-gray-500 text-center">The most important aspect of beauty was, therefore, an inherent part.</p>
            </div>
            <div>
                <div class="flex justify-center mb-2">
                    <i class="bi bi-journal-bookmark-fill text-4xl text-green-600"></i>
                </div>
                <h5 class="text-gray-600 text-center text-lg font-semibold mb-3">Deliver high quality product</h5>
                <p class="text-gray-500 text-center">We quickly learn to fear and thus automatically avoid potentially.</p>
            </div>
        </div>
    </section>
</template>
<style scoped>
p, h3, h5 {
    font-family: 'Nunito', sans-serif;
}

.bg-overlay {
    position: absolute;
    height: 100%;
    width: 100%;
    right: 0;
    bottom: 0;
    left: 0;
    top: 0;
    opacity: .7;
    background-color: #000;
    z-index: 1;
}

.bg-overlay-pattern {
    background-image: url(src/landing/bg-pattern.png);
    background-color: transparent;
    background-position: center;
    background-size: cover;
    opacity: .2;
}
</style>
