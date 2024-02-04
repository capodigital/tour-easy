<template>
    <section class="bg-white pt-14">
        <div class="lg:px-64">
            <h3 class="text-gray-700 font-bold text-2xl text-center">Get In Touch</h3>
            <p class="text-gray-500 text-center mt-3">We thrive when coming up with innovative ideas but also understand
                that a
                smart concept should be supported with faucibus sapien odio measurable results.</p>
        </div>
        <div class="grid grid-cols-3 gap-6 mt-6 lg:px-44">
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
        <div class="flex justify-end w-full mt-2 lg:px-44">
            <button
                class="px-5 py-2 text-white bg-blue-600 hover:bg-blue-700 transition-all rounded border-none focus:outline-none">Send
                Message</button>
        </div>
        <div class="py-12 bg-blue-600 relative px-32 mt-20">
            <div class="bg-overlay bg-overlay-pattern opacity-50"></div>
            <div class="flex justify-between items-center">
                <div class="z-50">
                    <h4 class="text-white text-xl font-bold">Build your web App/SaaS with Velzon dashboard</h4>
                </div>
                <div class="z-50">
                    <a href="#" class="px-4 py-2 text-white bg-red-500 rounded"><i class="bi bi-cart3"></i> Buy Now</a>
                </div>
            </div>
        </div>
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
