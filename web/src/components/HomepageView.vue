<template>
    <div class="title mt-5 mb-5">
        <span class="title">Hello :)</span>
    </div>

    <Breadcrumb>
        <span>Homepage</span>
    </Breadcrumb>

    <BasicContainer>
        <p>
        </p>
        <p>You can list, view, and create subscribers.</p>

        <div class="pt-3 pb-2 mb-3 border-bottom">
            <span class="title">Subscribers</span>
        </div>

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
</style>