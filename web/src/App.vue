<template>
  <MainLayout>
    <img alt="Vue logo" src="./assets/logo.png">
    <HelloWorld msg="Welcome to Your Vue.js App" />

  </MainLayout>
</template>

<script lang="ts">
import MainLayout from './components/MainLayout.vue'

export default {
  name: 'App',
  components: {
    MainLayout
  }
}
</script>

<style lang="scss">
@import 'assets/styles/main.scss';
</style>
