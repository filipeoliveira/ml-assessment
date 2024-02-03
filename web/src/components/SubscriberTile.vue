<template>
    <div class="subscriber-tile">
      <h3>{{ title }}</h3>
      <p>{{ count }}</p>
    </div>
  </template>
  
  <script lang="ts">
  import { defineComponent } from 'vue';
  
  export default defineComponent({
    name: 'SubscriberTile',
    props: {
      title: String,
      count: Number
    }
    // component logic
  });
  </script>
  
  <style lang="scss">
  .subscriber-tile {
    // your styles here
  }
  </style>
  