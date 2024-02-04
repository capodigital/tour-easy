<script>
import PlanItem from './PlanItem.vue';

export default {
    data() {
        return {
            period: 'Month',
            plans: [
                {
                    title: 'Basic Plan',
                    description: 'For Startup',
                    icon: 'bi bi-bookmark-fill',
                    price: 19,
                    features: [
                        { has: true, name: 'Upto 3 Projects' },
                        { has: true, name: 'Upto 299 Customers' },
                        { has: true, name: 'Scalable Bandwidth' },
                        { has: true, name: '5 FTP Login' },
                        { has: false, name: '24/7 Support' },
                        { has: false, name: 'Unlimited Storage' },
                        { has: false, name: 'Domain' },
                    ]
                },
                {
                    title: 'Pro Business',
                    description: 'Professional plans',
                    icon: 'bi bi-bookmark-star-fill',
                    price: 29,
                    features: [
                        { has: true, name: 'Upto 15 Projects' },
                        { has: true, name: 'Unlimited Customers' },
                        { has: true, name: 'Scalable Bandwidth' },
                        { has: true, name: '12 FTP Login' },
                        { has: true, name: '24/7 Support' },
                        { has: false, name: 'Unlimited Storage' },
                        { has: false, name: 'Domain' },
                    ]
                },
                {
                    title: 'Platinum Plan',
                    description: 'Enterprise Businesses',
                    icon: 'bi bi-bookmarks',
                    price: 39,
                    features: [
                        { has: true, name: 'Unlimited Projects' },
                        { has: true, name: 'Unlimited Customers' },
                        { has: true, name: 'Scalable Bandwidth' },
                        { has: true, name: 'Unlimited FTP Login' },
                        { has: true, name: '24/7 Support' },
                        { has: true, name: 'Unlimited Storage' },
                        { has: true, name: 'Domain' },
                    ]
                }
            ]
        };
    },
    components: { PlanItem }
}
</script>
<template>
    <section class="mt-24 lg:px-44 py-20">
        <h3 class="text-gray-600 font-bold text-2xl text-center">Choose the plan that's right for you</h3>
        <p class="text-gray-500 text-center mt-3">Simple pricing. No hidden fees. Advanced features for you business.</p>
        <div class="flex items-end justify-center mt-4">
            <div class="ms-3">
                <p class="text-sm font-semibold mb-0.5">Month</p>
            </div>
            <div class="form-check form-switch ms-3 text-[20px]">
                <input @change="(e) => period = e.target.checked ? 'Year' : 'Month'" class="form-check-input"
                    type="checkbox" id="plan-switch">
                <label class="form-check-label" for="plan-switch"></label>
            </div>
            <div class="flex items-center">
                <p class="text-sm font-semibold mb-0.5">Annual</p>
                <small class="text-green-500 ms-3">Save 20%</small>
            </div>
        </div>
        <div class="grid grid-cols-3 gap-6 mt-6">
            <PlanItem v-for="plan in plans" :title="plan.title" :description="plan.description"
                :price="period == 'Month' ? plan.price : plan.price * 0.8" :period="period" :icon="plan.icon"
                :features="plan.features" />
        </div>
    </section>
</template>
<style scoped>
p,
h3,
small {
    font-family: 'Nunito', sans-serif;
}

section {
    background-color: rgb(243, 246, 249);
}
</style>
