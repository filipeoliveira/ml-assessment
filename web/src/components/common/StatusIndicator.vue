<template>
    <div class="d-flex justify-content-between align-items-center">
        <slot name="breadcrumb"></slot>
        <div class="mt-2 d-flex flex-column justify-content-center">
            <div v-if="loading" class="loading">
                <div class="spinner-border text-primary me-3" role="status"></div>
                <span>Creating ...</span>
            </div>
            <div v-else-if="success" class="success">
                <i class="fa fa-check"></i> Created successfully!
            </div>
            <div v-else-if="error" class="error">
                <i class="fa fa-times"></i> {{ error }}
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'

export default defineComponent({
    name: 'StatusIndicator',
    props: {
        loading: Boolean,
        success: Boolean,
        error: String
    }
})
</script>

<style lang="scss" scoped>
@import '@/assets/styles/_variables.scss';

.loading,
.success,
.error {
    margin-top: 1em;
    margin-bottom: 1em;
}

.loading {
    color: #000;
}

.success {
    color: $primary;
}

.error {
    color: $red-500;
}
</style>