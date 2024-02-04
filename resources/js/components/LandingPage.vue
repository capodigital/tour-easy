<script>
import LandingNavbar from "./landing/LandingNavbar.vue"
import LandingHeader from "./landing/LandingHeader.vue"
import BrandsSection from "./landing/BrandsSection.vue"
import ServicesSection from "./landing/ServicesSection.vue"
import FeaturesSection from "./landing/FeaturesSection.vue"
import PlansSection from "./landing/PlansSection.vue"
import QuestionsSection from "./landing/QuestionsSection.vue"
import ReviewsSection from "./landing/ReviewsSection.vue"
import TeamSection from "./landing/TeamSection.vue"
import ContactSection from "./landing/ContactSection.vue"
import LandingFooter from "./landing/LandingFooter.vue"
import { Scroll } from "scroll-utility"

export default {
    components: { LandingNavbar, LandingHeader, BrandsSection, ServicesSection, FeaturesSection, PlansSection, QuestionsSection, ReviewsSection, TeamSection, ContactSection, LandingFooter },
    methods: {
        toUp() {
            const scrollManager = new Scroll({ duration: 500 })
            scrollManager.scrollTo(0)
        }
    },
}
</script>
<template>
    <main id="main">
        <LandingNavbar />
        <LandingHeader />
        <BrandsSection />
        <ServicesSection />
        <FeaturesSection />
        <PlansSection />
        <QuestionsSection />
        <ReviewsSection />
        <TeamSection />
        <ContactSection />
        <LandingFooter />
        <button @click="toUp()" class="h-10 w-10 shadow shadow-gray-800 rounded-full bg-red-500 hover:bg-red-600 text-white flex justify-center items-center fixed bottom-2 right-2"><i class="bi bi-chevron-up"></i></button>
    </main>
</template>
<style scoped></style>
