<template>
    <nav id="side-menu">
      <ul>
        <li class="menu-item active">Dashboard</li>
        <li class="menu-item">Subscribers</li>
      </ul>
    </nav>
  </template>
  
  <script lang="ts" setup>
  </script>
  
  <style lang="scss">
  #side-menu {
    width: 200px; 
    background-color: #333;
    color: #fff;
  }
  
  .menu-item {
    padding: 10px;
    cursor: pointer;
    &.active {
      background-color: #555;
    }
    &:hover {
      background-color: #444;
    }
  }
  </style>
  