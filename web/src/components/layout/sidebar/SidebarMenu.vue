<template>
  <div class="sidebar-wrapper col-md-3 d-none d-md-block ">
    <nav class="sidebar">
      <div class="sidebar-sticky">
        <div class="sidebar-content">
          <img src="/logo.png" alt="Logo" class="logo mt-4 mb-5">

          <ul class="nav flex-column">
            <li class="nav-item" :class="{ active: isActive('') }">
              <SidebarItem @click="visit('/')" icon="bi bi-person me-2">
                <span>Homepage</span>
              </SidebarItem>
            </li>

            <li class="nav-item" :class="{ active: isActive('subscribers') }">
              <SidebarItem @click="visit('/subscribers')" icon="bi bi-person me-2">
                Subscribers
              </SidebarItem>
            </li>

          </ul>

          <div class="bottom-sticky">
            <StatusCheck />
          </div>
        </div>
      </div>
    </nav>
  </div>
</template>
  
<script lang="ts">
import { defineComponent } from 'vue';
import SidebarItem from './SidebarItem.vue';
import { useRouter } from 'vue-router'
import StatusCheck from '@/components/common/StatusCheck.vue'

export default defineComponent({
  components: {
    SidebarItem,
    StatusCheck

  },
  setup() {
    const router = useRouter()

    const isActive = (pageName: string): boolean => {
      return router.currentRoute.value.path === `/${pageName}`;
    }
    const visit = (destination: string) => {
      router.push(`${destination}`)
    }

    return {
      visit,
      isActive
    }
  }
});
</script>
  
<style lang="scss" scoped>
@import '@/assets/styles/main.scss';

.nav-item {
  color: #6f6f6f;

  span {
    color: #6f6f6f;

  }

  &.active {
    color: #6f6f6f !important;
    border-right: 3px solid #09c269;
  }
}


.sidebar-wrapper {
  height: 100vh;
  max-width: 305px;
  padding-top: 2.5em;
  padding-left: 2.5em;
  padding-right: 0em;
  background-color: $white;
  position: relative;
}

.logo {
  width: 124px;
  margin-bottom: 2em;
}

.sidebar {
  background-color: $white;

  .sidebar-content {
    margin-left: 1em;
  }

  .nav-item {
    margin-bottom: 1em;
    width: 100%;
  }

  .bottom-sticky {
    position: absolute;
    bottom: 2em;
    left: 0;
    right: 0;
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
  }
}
</style>
  