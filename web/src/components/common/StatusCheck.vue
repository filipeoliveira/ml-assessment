<template>
    <div class="status-check">
        <div class="status-circle" :class="{ online: isOnline, offline: !isOnline }"></div>
        <span class="status-label">Backend is {{ isOnline ? 'online' : 'offline' }}</span>
    </div>
</template>
  
<script >

export default {
    name: 'StatusCheck',
    data() {
        return {
            isOnline: false,
            intervalId: null
        };
    },
    created() {
        this.checkStatus();
        this.intervalId = setInterval( this.checkStatus, 30000 );
    },
    beforeUnmount() {
        clearInterval( this.intervalId );
    },
    methods: {
        async checkStatus() {
            try {
                const response = await fetch( `${process.env.VUE_APP_API_URL}/api/health` );
                this.isOnline = response.status === 200;
            } catch ( error ) {
                this.isOnline = false;
            }
        }
    }
}
</script>
  
<style lang="scss" scoped>
@import '@/assets/styles/_variables.scss';

.status-check {
  display: flex;
  align-items: center;

  .status-circle {
    width: 10px;
    height: 10px;
    margin-right: 5px;
    border-radius: 50%;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    margin-right: 0.5em;

    &.online {
      background-color: $green-500;
    }

    &.offline {
      background-color: #d9534f;
    }
  }

  .status-label {
    font-size: 16px;
    line-height: 1.5;
    color: #6f6f6f;
  }
}
</style>