<template>
  <div class="btn-wrapper d-flex align-items-center">
    <i :class="icon" style="font-size: 1.2em"></i>
    <button class="btn btn-sidebar" @click="$emit('click')">
      <slot></slot>
    </button>
  </div>
</template>
  
<script>
export default {
  name: 'SidebarButton',
  props: {
    label: {
      type: String,
      default: ''
    },
    icon: {
      type: String,
      default: ''
    }
  }
}
</script>
  
<style scoped>
.btn-wrapper {}

.btn-sidebar {
  color: #6f6f6f;
  background-color: transparent;
  border: none;
  padding: 0;
  font-size: 1em;
  text-align: left;
  width: 100%;
}

.btn-wrapper:hover,
.btn-wrapper:focus {
  color: #4a4a4c;
  outline: none;
}

.btn-wrapper:active {
  color: #4a4a4c;
  border-right: 2px solid #09c269;
}
</style>