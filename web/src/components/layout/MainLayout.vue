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
@import '@/assets/styles/_variables.scss';

.container-full {
  height: 100vh;
}

.logo {
  width: 150px;
}



main {
  background-color: $gray-100;
  flex-grow: 1;
}
</style>