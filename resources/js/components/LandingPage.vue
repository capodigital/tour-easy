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
export default {
    components: { LandingNavbar, LandingHeader, BrandsSection, ServicesSection, FeaturesSection, PlansSection, QuestionsSection, ReviewsSection, TeamSection, ContactSection, LandingFooter }
}
</script>
<template>
    <div>
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
    </div>
</template>
<style scoped></style>
