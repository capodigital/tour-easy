<script>
import { Swiper, SwiperSlide } from 'swiper/vue';
export default {
    components: { Swiper, SwiperSlide },
    data() {
        return {
            slidesPerView: 1
        }
    },
    methods: {
        update() {
            if (window.innerWidth > 1200) {
                this.slidesPerView = 4;
            } else if (window.innerWidth > 768) {
                this.slidesPerView = 3;
            } else if (window.innerWidth > 576) {
                this.slidesPerView = 2;
            } else {
                this.slidesPerView = 1;
            }
        }
    },
    mounted() {
        window.addEventListener('resize', (e) => {
            this.update();
        })
        this.update();
    }
}
</script>
<template>
    <section class="px-6 sm:px-10 md:px-20 lg:px-36">
        <Swiper :slides-per-view="slidesPerView">
            <SwiperSlide>
                <div class="px-6 sm:px-10 lg:px-14"><img class="max-w-full" src="src/landing/lenovo.svg" /></div>
            </SwiperSlide>
            <SwiperSlide>
                <div class="px-6 sm:px-10 lg:px-14"><img class="max-w-full" src="src/landing/paypal.svg" /></div>
            </SwiperSlide>
            <SwiperSlide>
                <div class="px-6 sm:px-10 lg:px-14"><img class="max-w-full" src="src/landing/shopify.svg" /></div>
            </SwiperSlide>
            <SwiperSlide>
                <div class="px-6 sm:px-10 lg:px-14"><img class="max-w-full" src="src/landing/verizon.svg" /></div>
            </SwiperSlide>
        </Swiper>
    </section>
</template>
