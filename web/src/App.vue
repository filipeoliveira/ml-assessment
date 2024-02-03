<template>
  <div class="full">
    <MainLayout>
    </MainLayout>
  </div>
</template>

<script lang="ts">
import MainLayout from './components/layout/MainLayout.vue'

export default {
  name: 'App',
  components: {
    MainLayout
  }
}
</script>

<style lang="scss">
@import 'assets/styles/main.scss';

.full {
  background-color: green;
  height: 100vh;
}
</style>
