<template>
    <section class="dashboard">
        <SubscriberTile title="Total Active Subscribers" :count="totalSubscribers" />
        <SubscriberTile title="New Subscribers Today" :count="newToday" />
        <SubscriberTile title="New Subscribers This Month" :count="newThisMonth" />
        <SubscriberTile title="Unsubscribed" :count="unsubscribed" />
    </section>
</template>
  
<script lang="ts">
import { defineComponent } from 'vue';
import SubscriberTile from './SubscriberTile.vue';

export default defineComponent({
    name: 'DashboardMain',
    components: {
        SubscriberTile
    },
    props: {
        totalSubscribers: Number,
        newToday: Number,
        newThisMonth: Number,
        unsubscribed: Number
    }
    // component logic
});
</script>
  
<style lang="scss">
.dashboard {
    // your styles here
}
</style>
  