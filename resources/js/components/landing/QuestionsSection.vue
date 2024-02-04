<script>
import QuestionItem from './QuestionItem.vue';
export default {
    components: { QuestionItem },
    data() {
        return {
            group_1: [
                {
                    question: 'What is the purpose of using themes ?',
                    text: "A theme is a set of colors, fonts, effects, and more that can be applied to your entire presentation to give it a consistent, professional look. You've already been using a theme, even if you didn't know it: the default Office theme, which consists.",
                },
                {
                    question: 'Can a theme have more than one theme?',
                    text: 'A story can have as many themes as the reader can identify based on recurring patterns and parallels within the story itself. In looking at ways to separate themes into a hierarchy, we might find it useful to follow the example of a single book.',
                },
                {
                    question: 'What are theme features?',
                    text: 'Theme features is a set of specific functionality that may be enabled by theme authors. Themes must register each individual Theme Feature that the author wishes to support. Theme support functions should be called in the theme\'s functions.',
                },
                {
                    question: 'What is simple theme?',
                    text: 'Simple is a free WordPress theme, by Themify, built exactly what it is named for: simplicity. Immediately upgrade the quality of your WordPress site with the simple theme To use the built-in Chrome theme editor.',
                },
            ],
            group_2: [
                {
                    question: 'Does Word have night mode?',
                    text: 'You can run Microsoft Word in dark mode, which uses a dark color palette to help reduce eye strain in low light settings. You can choose to make the document white or black using the Switch Modes button in the ribbon\'s View tab.',
                },
                {
                    question: 'Is theme an opinion?',
                    text: 'A theme is an opinion the author expresses on the subject, for instance, the author\'s dissatisfaction with the narrow confines of French bourgeois marriage during that period theme is an idea that a writer repeats.',
                },
                {
                    question: 'How do you develop a theme?',
                    text: 'A short story, novella, or novel presents a narrative to its reader. Perhaps that narrative involves mystery, terror, romance, comedy, or all of the above. These works of fiction may also contain memorable characters, vivid world-building, literary devices.',
                },
                {
                    question: 'Do stories need themes?',
                    text: 'A story can have as many themes as the reader can identify based on recurring patterns and parallels within the story itself. In looking at ways to separate themes into a hierarchy, we might find it useful to follow the example of a single book.',
                },
            ]
        }
    }
}
</script>

<template>
    <section class="bg-white py-20">
        <div class="lg:px-56">
            <h3 class="text-center text-2xl text-gray-600 font-bold">Frequently Asked Questions</h3>
            <p class="text-gray-400 mt-4 px-20 text-center">If you can not find answer to your question in our FAQ, you can
                always contact us or email us. We will answer you
                shortly!</p>
            <div class="flex justify-center mt-4">
                <a href="#" class="rounded-[1.2rem] text-white bg-blue-500 flex items-center pe-5 me-3"><span
                        class="h-10 w-10 me-3 flex items-center justify-center bg-blue-400 rounded-full"><i
                            class="bi bi-envelope"></i></span> Email Us</a>
                <a href="#" class="rounded-[1.2rem] text-white bg-sky-500 flex items-center pe-5"><span
                        class="h-10 w-10 me-3 flex items-center justify-center bg-sky-400 rounded-full"><i
                            class="bi bi-twitter"></i></span> Send Us Tweet</a>
            </div>
        </div>
        <div class="mt-6 grid grid-cols-2 gap-12 lg:px-32">
            <div>
                <h5 class="flex text-xl text-green-600 font-semibold"><i class="bi bi-question-circle me-3"></i> General
                    Questions</h5>
                <div>
                    <QuestionItem v-for="question in group_1" :question="question.question" :text="question.text" />
                </div>
            </div>
            <div>
                <h5 class="flex text-xl text-green-600 font-semibold"><i class="bi bi-shield-lock me-3"></i>
                    Privacy & Security</h5>
                <div>
                    <QuestionItem v-for="question in group_2" :question="question.question" :text="question.text" />
                </div>
            </div>
        </div>
    </section>
</template>
<style scoped>
p,
h3,
h5,
button {
    font-family: 'Nunito', sans-serif;
}
</style>
