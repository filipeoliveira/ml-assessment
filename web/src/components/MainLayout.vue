<template>
  <div id="main-layout">
    <SideMenu />
    <div id="content">
      <slot />
    </div>
  </div>
</template>

<script lang="ts">
import SideMenu from './SideMenu.vue';

export default {
  name: 'MainLayout',
  components: {
    SideMenu
  }
};
</script>

<style lang="scss">
#main-layout {
  display: flex;
  height: 100vh;
}

#content {
  flex-grow: 1;
  padding: 20px;
  background-color: #f4f5f7; // This should match the main background color of your content area
}
</style>