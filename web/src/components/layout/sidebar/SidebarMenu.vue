<template>
    <div class="sidebar-wrapper col-md-3 d-none d-md-block ">
        <nav class="sidebar">
            <div class="sidebar-sticky">
                <div class="sidebar-content">
                    <img src="/logo.png" alt="Logo" class="logo mt-4 mb-4">

                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <SidebarItem @click="handleClick" icon="bi bi-person me-2">
                                Subscribers
                            </SidebarItem>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</template>
  
<script lang="ts">
import SidebarItem from './SidebarItem.vue';

export default {
    name: 'SidebarMenu',
    components: {
        SidebarItem
    }
}
</script>
  
<style lang="scss" scoped>
@import '@/assets/styles/main.scss';


.sidebar-wrapper {
  height: 100vh;
  background-color: $white;
  border: 1px solid black;
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

</style>
  