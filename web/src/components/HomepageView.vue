<template>
    <div class="title mt-5 mb-5">
        <span class="title">Hello :)</span>
    </div>

    <BasicContainer>
        <p class="description">
            Welcome to the web app designed for the MailerLite challenge. <br> This application is built using Vue 3, Vue Router, TypeScript, and Bootstrap.
        </p>
        <br>
        <p class="description">
            Here, you can:
        </p>
        <ul class="description">
            <li>List subscribers.</li>
            <li>View a specific subscriber details.</li>
            <li>Create a new subscriber.</li>
        </ul>

        <div class="pt-3 pb-2 mb-3 border-bottom">
            <span class="title">Mailerlite challenge</span>
        </div>

        <p class="contact">
            For any questions or improvements, you can contact me at <a href="mailto:filipe.jtolliveira@gmail.com">filipe.jtolliveira@gmail.com</a> or visit <a href="https://github.com/filipeoliveira" target="_blank">github.com/filipeoliveira</a>.<br>
            For more information, please check the <a href="https://github.com/filipeoliveira/ml-assessment">readme</a> for this project
        </p>

        <span class="description">
        </span>


    </BasicContainer>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import BasicContainer from '@/components/common/BasicContainer.vue'

export default defineComponent({
    name: 'HomepageView',
    components: {
        BasicContainer,
    },
})
</script>

<style lang="scss" scoped>
@import '@/assets/styles/_variables.scss';

.title {
    align-self: stretch;
    flex-grow: 0;
    font-size: 1.75em; 
    font-weight: bold;
    font-stretch: normal;
    font-style: normal;
    line-height: 1.3;
    letter-spacing: normal;
    text-align: left;
    color: $black;
}

.description {
    font-size: 1.25em;
    line-height: 1.5;
    color: $black;
}

.contact {
    font-size: 1em;
    line-height: 1.5;
    color: $black;
}
</style>