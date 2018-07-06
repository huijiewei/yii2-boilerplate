<template>
  <i :class="'anticon anticon-' + icon"></i>
</template>

<script>
  export default {
    name: 'SiderMenuIcon',
    props: ['icon']
  }
</script>
