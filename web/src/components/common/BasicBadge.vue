<template>
    <div class="badge" :class="status">
        <span class="status-text">{{ formattedStatus }}</span>
    </div>
</template>
  
<script>
export default {
    name: 'BasicBadge',
    props: {
        status: String
    },
    computed: {
    formattedStatus() {
      return this.status.charAt(0).toUpperCase() + this.status.slice(1);
    }
  }
}
</script>
  
<style lang="scss" scoped>
@import '@/assets/styles/_variables.scss';

.badge {
    width: 80px;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 6px 8px;
    border-radius: 0.25em;
    color: white;
    background-color: $gray-300;


    &.active {
        background-color: var(--bs-primary);
    }

    &.pending {
        background-color: #f0ad4e;
    }

    &.inactive {
        background-color: $red-500;
    }

}

.status-text {
    font-size: 12px;
    font-weight: 600;
    line-height: 1;
    text-align: center;
}
</style>