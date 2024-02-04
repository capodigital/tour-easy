<template>
    <section>
        <div class="grid grid-cols-2 gap-10 lg:px-36 mt-24 py-10">
            <div>
                <img src="src/landing/image_2.png" />
            </div>
            <div class="flex items-center">
                <div>
                    <i class="bi bi-postcard text-green-500 text-4xl"></i>
                    <h3 class="text-gray-600 text-xl font-semibold mt-8">Huge collection of widgets</h3>
                    <p class="text-gray-500 mt-4">Collection widgets specialize in displaying many elements of the same
                        type,
                        such as a collection of pictures
                        from a collection of articles from a news app or a collection of messages from a communication app.
                    </p>
                    <div class="grid grid-cols-3 gap-3 mt-10">
                        <div class="text-center">
                            <p class="text-2xl text-gray-700 font-bold">5</p>
                            <small class="text-gray-500">Dashboards</small>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl text-gray-700 font-bold">150+</p>
                            <small class="text-gray-500">Pages</small>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl text-gray-700 font-bold">7+</p>
                            <small class="text-gray-500">Functional Apps</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-12 bg-blue-600 relative px-32">
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

        <div class="grid grid-cols-2 gap-10 lg:px-36 mt-16 py-10">
            <div class="flex items-center">
                <div>
                    <small class="text-green-500">DESIGN</small>
                    <h3 class="font-semibold text-gray-700 text-2xl">Well Designed Dashboards</h3>
                    <p class="text-gray-500 mt-6">Quality Dashboards (QD) is a condition-specific, actionable web-based
                        application for quality
                        reporting and population management that is integrated into the Electronic Health Record (EHR).</p>
                    <div class="grid grid-cols-2 gap-3 mt-6">
                        <p class="text-gray-700 text-sm flex items-center"><i class="bi bi-check-lg text-2xl text-green-500 me-3"></i> Ecommerce</p>
                        <p class="text-gray-700 text-sm flex items-center"><i class="bi bi-check-lg text-2xl text-green-500 me-3"></i> Crypto</p>
                        <p class="text-gray-700 text-sm flex items-center"><i class="bi bi-check-lg text-2xl text-green-500 me-3"></i> Analytics</p>
                        <p class="text-gray-700 text-sm flex items-center"><i class="bi bi-check-lg text-2xl text-green-500 me-3"></i> Projects</p>
                        <p class="text-gray-700 text-sm flex items-center"><i class="bi bi-check-lg text-2xl text-green-500 me-3"></i> CRM</p>
                    </div>
                    <button class="px-5 py-2 mt-6 text-white bg-blue-600 hover:bg-blue-700 transition-all rounded border-none focus:outline-none">Learn More <i class="bi bi-arrow-right-short"></i></button>
                </div>
            </div>
            <div class="flex items-center">
                <img src="src/landing/image_3.png" />
            </div>
        </div>

        <div class="grid grid-cols-2 gap-10 lg:px-36 mt-4 py-10">
            <div class="flex items-center">
                <img src="src/landing/image_4.png" />
            </div>
            <div class="flex items-center">
                <div class="ps-16">
                    <small class="text-green-500">STRUCTURE</small>
                    <h3 class="font-semibold text-gray-700 text-2xl">Well Documented</h3>
                    <p class="text-gray-500 mt-6">used to describe something that is known about or known to be true because there are many documents that describe it, prove it, etc.</p>
                    <div class="grid grid-cols-1 gap-3 mt-6">
                        <p class="text-gray-700 text-sm flex items-center"><i class="bi bi-check-lg text-2xl text-green-500 me-3"></i> Dynamic Conetnt</p>
                        <p class="text-gray-700 text-sm flex items-center"><i class="bi bi-check-lg text-2xl text-green-500 me-3"></i> Setup plugin's information</p>
                        <p class="text-gray-700 text-sm flex items-center"><i class="bi bi-check-lg text-2xl text-green-500 me-3"></i> Themes customization information</p>
                    </div>
                    <button class="px-5 py-2 mt-6 text-white bg-blue-600 hover:bg-blue-700 transition-all rounded border-none focus:outline-none">Learn More <i class="bi bi-arrow-right-short"></i></button>
                </div>
            </div>

        </div>
    </section>
</template>
<style scoped>
p,
h3,
h4,
small {
    font-family: 'Nunito', sans-serif;
}

section {
    background-color: rgb(243, 246, 249);
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
