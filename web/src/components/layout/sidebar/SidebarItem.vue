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
  
<style scoped lang="scss">

.btn-sidebar {
  background-color: transparent;
  border: none;
  padding: 0;
  font-size: 1em;
  text-align: left;
  width: 100%;
  color: #6f6f6f!important;

}

.btn-wrapper {
  padding: 0.25em 0; 
}

.btn-wrapper:hover,
.btn-wrapper:focus {
  outline: none;
}

.btn-wrapper:active {
  font-weight: bold;
}


</style>