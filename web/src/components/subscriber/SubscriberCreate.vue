<template>
    <div>
        <StatusIndicator :loading="loading" :success="success" :error="error">
            <template #breadcrumb>
                <BasicBreadcrumb :items="breadcrumbs" />
            </template>
        </StatusIndicator>

        <BasicContainer>
            <span class="header">Create a new subscriber</span>
            <br>
            <div class="container">
                <form @submit.prevent="submitForm">
                    <div class="row mb-1 py-2 wrapper">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-6">
                                    <label for="firstName" class="label">First name</label>
                                </div>
                                <div class="col-6">
                                    <input id="firstName" v-model="subscriber.name" class="value form-control" type="text"
                                        required>
                                    <div v-if="!subscriber.name" class="invalid-feedback">First name is required
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-6">
                                    <label for="lastName" class="label">Last name</label>
                                </div>
                                <div class="col-6">
                                    <input id="lastName" v-model="subscriber.lastName" class="value form-control"
                                        type="text" required>
                                    <div v-if="!subscriber.lastName" class="invalid-feedback">Last name is required
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row mb-1 py-2 wrapper">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-6">
                                    <label for="email" class="label">Email</label>
                                </div>
                                <div class="col-6">
                                    <input id="email" v-model="subscriber.email" class="value form-control" type="email"
                                        required>
                                    <div v-if="!subscriber.email" class="invalid-feedback">Email is required</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-6">
                                    <label for="status" class="label">Status</label>
                                </div>
                                <div class="col-6">
                                    <input id="status" v-model="subscriber.status" class="value form-control" type="text"
                                        required>
                                    <div v-if="!subscriber.status" class="invalid-feedback">Status is required</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-1 py-2 my-4">
                        <div class="d-flex justify-content-center">
                            <button type="reset" class="btn btn-outline-secondary me-3 mr-2">Clear Form</button>
                            <button type="submit" class="btn btn-primary me-4 white">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </BasicContainer>
    </div>
</template>
<script lang="ts">
import { defineComponent, ref, computed } from 'vue'
import BasicContainer from '@/components/common/BasicContainer.vue'
import { Subscriber, createSubscriber } from '@/services/subscriberService'
import BasicBreadcrumb from '@/components/common/BasicBreadcrumb.vue'
import StatusIndicator from '@/components/common/StatusIndicator.vue'

export default defineComponent({
    name: 'SubscriberCreate',
    components: {
        BasicContainer,
        BasicBreadcrumb,
        StatusIndicator
    },
    setup() {
        const subscriber = ref<Subscriber>({ name: '', email: '', lastName: '', status: '' })
        const error = ref<string | null>(null)
        const loading = ref(false)
        const success = ref(false)

        const submitForm = async () => {
            loading.value = true
            try {
                await createSubscriber(subscriber.value)
                subscriber.value = { name: '', email: '', lastName: '', status: '' }
                success.value = true
            } catch (e) {
                if (e instanceof Error) {
                    error.value = e.message
                } else {
                    error.value = 'An unknown error occurred'
                }
            } finally {
                loading.value = false
            }
        }

        const breadcrumbs = computed(() => ["subscribers", "create"])

        return {
            subscriber,
            error,
            breadcrumbs,
            submitForm,
            loading,
            success
        }
    }
})
</script>

<style lang="scss" scoped>
@import '@/assets/styles/_variables.scss';

.header {
    font-weight: bold;
    color: black;
    margin-top: 1em;
}

.wrapper {
    border-bottom: 1px solid $gray-150;

    .label {
        color: #6f6f6f;
        font-size: 0.95em;
    }

    .value {
        color: #4a4a4c;
        font-size: 0.95em;
    }

    .form-control {
        border-radius: 5px;
        border-color: $gray-150;

        &:focus,
        &:active {
            border-color: $gray-400;
        }
    }
}

.white {
    color: $white !important;
}


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
    color: #4CAF50;
}

.error {
    color: #F44336;
}
</style>