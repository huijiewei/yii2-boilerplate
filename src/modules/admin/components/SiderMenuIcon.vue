<template>
  <ag-icon :class="'sider-menu-icon'" :path="icon" />
</template>

<script>
import AgIcon from '@core/components/Icon/index'
export default {
  name: 'SiderMenuIcon',
  components: { AgIcon },
  props: {
    icon: {
      type: String,
      default: ''
    }
  }
}
</script>
<style lang="scss">
.sider-menu-icon {
  margin-right: 5px;
}
</style>
