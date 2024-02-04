<script>
import CallToAction from './CallToAction.vue';
export default {
    components: { CallToAction }
}
</script>
<template>
    <section class="bg-white pt-14">
        <div class="px-6 sm:px-24 md:px-40 lg:px-64">
            <h3 class="text-gray-700 font-bold text-2xl text-center">Get In Touch</h3>
            <p class="text-gray-500 text-center mt-3">We thrive when coming up with innovative ideas but also understand
                that a
                smart concept should be supported with faucibus sapien odio measurable results.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6 px-2 sm:px-16 md:px-32 lg:px-44">
            <div class="lg:pe-32">
                <p class="text-gray-400 text-sm">OFFICE ADDRESS 1:</p>
                <p class="text-gray-800 mt-1 font-semibold">4461 Cedar Street Moro, AR 72368</p>
                <p class="text-gray-400 text-sm mt-4">OFFICE ADDRESS 2:</p>
                <p class="text-gray-800 mt-1 font-semibold">2467 Swick Hill Street New Orleans, LA</p>
                <p class="text-gray-400 text-sm mt-4">WORKING HOURS:</p>
                <p class="text-gray-800 mt-1 font-semibold">9:00am to 6:00pm</p>
            </div>
            <div>
                <div>
                    <label class="text-sm">Name</label>
                    <br />
                    <input name="name" type="text" placeholder="Your Name*"
                        class="bg-gray-100 rounded-md px-4 py-2 focus:outline-none w-full" />
                </div>
                <div class="mt-4">
                    <label class="text-sm mt-4">Subject</label>
                    <br />
                    <input name="subject" type="text" placeholder="Your Subject..."
                        class="bg-gray-100 rounded-md px-4 py-2 focus:outline-none w-full" />
                </div>
                <div class="mt-4">
                    <label class="text-sm mt-4">Message</label>
                    <br />
                    <input name="message" type="text" placeholder="Your Message..."
                        class="bg-gray-100 rounded-md px-4 py-2 focus:outline-none w-full" />
                </div>
            </div>
            <div>
                <div>
                    <label class="text-sm">Email</label>
                    <br />
                    <input name="email" type="email" placeholder="Your Email*"
                        class="bg-gray-100 rounded-md px-4 py-2 focus:outline-none w-full" />
                </div>
            </div>
        </div>
        <div class="flex justify-end w-full mt-2 px-2 sm:px-16 md:px-32 lg:px-44 mb-4">
            <button
                class="px-5 py-2 text-white bg-blue-600 hover:bg-blue-700 transition-all rounded border-none focus:outline-none">Send
                Message</button>
        </div>

        <CallToAction />
    </section>
</template>
<style scoped>
p,
h3,
label,
h4,
a {
    font-family: 'Nunito', sans-serif;
}
</style>
