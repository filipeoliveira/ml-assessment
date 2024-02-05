<template>
    <div class="custom-container">
        <slot></slot>
    </div>
</template>
  
<script>
export default {
    name: 'BasicContainer',
}
</script>
  
<style scoped>
.custom-container {
    min-height: 2;
    align-self: stretch;
    flex-grow: 0;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: stretch;
    padding: 0.75em 1.5em;
    border-radius: 0.25em;
    border: solid 1px #eaecef;
    background-color: #fff;
    margin: 1.5em 0;
}</style>