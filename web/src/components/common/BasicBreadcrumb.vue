<template>
    <nav class="breadcrumb mt-5">
        <span v-if="canGoBack" @click="$router.back()" class="back-icon">
            <i class="bi bi-arrow-left"></i>
        </span>
        <span v-for="(item, index) in items" :key="index" :class="{ 'last-item': index === items.length - 1 }">
            <span>{{ item }}</span>
            <span class="me-1" v-if="index !== items.length - 1"> / </span>
        </span>
    </nav>
</template>

<script lang="ts">
import { defineComponent, computed } from 'vue'
import { useRouter } from 'vue-router'

export default defineComponent({
    name: 'BasicBreadcrumb',
    props: {
        items: {
            type: Array,
            required: true
        }
    },
    setup() {
        const router = useRouter();

        const canGoBack = computed(() => window.history.length > 1);
        const goBack = () => {
            if (canGoBack.value) {
                router.back();
            }
        };

        return {
            canGoBack,
            goBack
        }
    }
})
</script>

<style lang="scss" scoped>
.breadcrumb {
    font-size: 0.94em;
    line-height: 1.5;
    color: #6f6f6f;
}

.breadcrumb .last-item {
    font-weight: bold;
}

.back-icon {
    cursor: pointer;
    margin-right: 10px;
    font-size: 1.1em;
       color: black;
}
</style>