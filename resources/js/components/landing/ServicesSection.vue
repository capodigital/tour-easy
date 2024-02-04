<script>
import ServiceItem from './ServiceItem.vue';
export default {
    components: { ServiceItem },
}
</script>

<template>
    <section class="lg:px-16 mt-24">
        <h3 class="text-gray-700 text-4xl text-center font-bold px-6 sm:px-20 md:px-40 lg:px-56">A Digital web design studio creating modern &
            engaging online</h3>
        <p class="text-gray-500 text-center mt-4 px-6 sm:px-20 md:px-40 lg:px-56 font-semibold">To achieve this, it would be necessary to have uniform
            grammar, pronunciation and more
            common words. If several languages coalesce the grammar</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-10 px-6 lg:px-16 mt-8">
            <ServiceItem icon="bi bi-pencil-square" title="Creative Design"
                description="The creative design includes designs that are unique, effective and memorable." />
            <ServiceItem icon="bi bi-palette" title="Unlimited Colors"
                description="The collection of rules and guidelines which designers use to communicate with users through appealing." />
            <ServiceItem icon="bi bi-lightbulb" title="Strategy Solutions"
                description="Business development firm that provides strategic planning, market research services and project." />
            <ServiceItem icon="bi bi-headset" title="Awesome Support"
                description="Awesome Support is the most versatile and feature-rich support plugin for all version." />
            <ServiceItem icon="bi bi-database" title="Truly Multipurpose"
                description="You usually get a broad range of options to play with. This enables you to use a single theme across multiple." />
            <ServiceItem icon="bi bi-gear" title="Easy to customize"
                description="Personalise your own website, no matter what theme and what customization options." />
            <ServiceItem icon="bi bi-laptop" title="Responsive & Clean Design"
                description="Responsive design is a graphic user interface (GUI) design approach used to create content." />
            <ServiceItem icon="bi bi-google" title="Google Font Collection"
                description="Google Fonts is a collection of 915 fonts, all available to use for free on your website." />
            <ServiceItem icon="bi bi-basket" title="Top Industry Specialists"
                description="An industrial specialist works with industrial operations to ensure that manufacturing facilities work." />
        </div>
    </section></template>
<style scoped>h3,
p {
    font-family: 'Nunito', sans-serif;
}</style>
