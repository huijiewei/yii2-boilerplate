<template>
  <i :class="'anticon icon-' + icon"></i>
</template>

<script>
  export default {
    name: 'SiderMenuIcon',
    props: ['icon']
  }
</script>
