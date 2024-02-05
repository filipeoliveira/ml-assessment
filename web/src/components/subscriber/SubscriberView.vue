<template>
    <div>
        <div v-if="error">{{ error }}</div>
        <div v-else-if="subscriber">
            <BasicBreadcrumb :items="breadcrumbs" />
            <h2 id="email-heading">example@example.com</h2>
            <BasicContainer>
                <span class="header">Subscriber Details</span>
                <br>
                <div class="container">

                    <div class="row mb-1 py-2 wrapper">
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between">
                                <span class="label">First name</span>
                                <span class="value">{{ subscriber.name }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between">
                                <span class="label">Email</span>
                                <span class="value">{{ subscriber.email }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-1 py-2 wrapper">
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between">
                                <span class="label">Last name</span>
                                <span class="value">{{ subscriber.lastName }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between">
                                <span class="label">Status</span>
                                <BasicBadge :status="subscriber.status" />
                            </div>
                        </div>
                    </div>

                </div>
            </BasicContainer>
        </div>
    </div>
</template>
  
<script lang="ts">
import { defineComponent, onMounted, ref, computed } from 'vue'
import BasicContainer from '@/components/common/BasicContainer.vue'
import { Subscriber, getSubscriber } from '@/services/subscriberService'
import BasicBreadcrumb from '@/components/common/BasicBreadcrumb.vue'
import BasicBadge from '@/components/common/BasicBadge.vue'

export default defineComponent({
    name: 'SubscriberView',
    components: {
        BasicContainer,
        BasicBreadcrumb,
        BasicBadge
    },
    props: {
        email: {
            type: String,
            required: true
        }
    },
    setup(props) {
        const subscriber = ref<Subscriber | null>(null)
        const error = ref<string | null>(null)

        onMounted(async () => {
            try {
                subscriber.value = await getSubscriber(props.email)
            } catch (e) {
                if (e instanceof Error) {
                    error.value = e.message
                } else {
                    error.value = 'An unknown error occurred'
                }
            }
        })

        const breadcrumbs = computed(() => {
            if (subscriber.value) {
                return ["subscribers", subscriber.value.email]
            } else {
                return ["subscribers"]
            }
        })

        return {
            subscriber,
            error,
            breadcrumbs
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

}
</style>