<template>
    <div>
        <h2>Subscriber Details</h2>
        <div v-if="error">{{ error }}</div>
        <div v-else-if="subscriber">
            <p>Email: {{ subscriber.email }}</p>
            <p>First Name: {{ subscriber.firstName }}</p>
            <p>Last Name: {{ subscriber.lastName }}</p>
            <p>Status: {{ subscriber.status }}</p>
        </div>

        <div class="breadcrumb">
            Subscribers > <span id="subscriber-email">example@example.com</span>
        </div>
        <h3 id="email-heading">example@example.com</h3>
        <div class="container">
            <div class="row">
                <div class="column">
                    <p>Email: <span id="email">example@example.com</span></p>
                    <p>First Name: <span id="first-name">John</span></p>
                </div>
                <div class="column">
                    <p>Last Name: <span id="last-name">Doe</span></p>
                    <p>Status: <span id="status">Active</span></p>
                </div>
            </div>
        </div>
    </div>
</template>
  
<script lang="ts">
import { defineComponent, onMounted, ref } from 'vue'
import { Subscriber, getSubscriber } from '@/services/subscriberService'

export default defineComponent({
    name: 'SubscriberView',
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

        return {
            subscriber,
            error
        }
    }
})
</script>
  
<style scoped>
/* Your styles here */
</style>