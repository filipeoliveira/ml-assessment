<template>
  <div class="container-full">
    <div class="row">
      <SidebarMenu />

      <main role="main" class="col-md-9 ml-sm-auto col-lg-9 px-4">
        <router-view></router-view>
      </main>
    </div>
  </div>
</template>

<script lang="ts">
import SidebarMenu from './sidebar/SidebarMenu.vue';

export default {
  name: 'MainLayout',
  components: {
    SidebarMenu,
  }
};
</script>

<style lang="scss" scoped>
@import '@/assets/styles/theme.scss';

.container-full {
  height: 100vh;
  background-color: red;
}

.logo {
  width: 150px;
}

.sidebar {
  background-color: $white;


  .sidebar-content {
    margin-left: 1em;
  }


  .nav-item {
    margin-bottom: 1em;
    width: 100%;
    /* Add space between items */
  }

  .nav-link {
    color: #6f6f6f;
    /* Default color */
  }

  .nav-link:hover,
  .nav-link.active {
    color: #4a4a4c;
    /* Color when hovered or active */
  }

  .nav-link.active {
    border-right: 2px solid #09c269;
    /* Right border when active */
  }


}




main {
  background-color: $gray-150
}
</style>