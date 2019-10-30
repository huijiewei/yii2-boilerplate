<template>
  <i :class="'anticon anticon-' + icon" />
</template>

<script>
export default {
  name: 'SiderMenuIcon',
  props: {
    icon: {
      type: String,
      default: ''
    }
  }
}
</script>
