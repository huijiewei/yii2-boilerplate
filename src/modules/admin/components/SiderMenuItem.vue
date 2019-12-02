<template>
  <el-menu-item :index="'/' + menuUrl">
    <ag-icon v-if="menu.icon" :path="menu.icon" />
    <span slot="title">{{ menu.label }}</span>
  </el-menu-item>
</template>

<script>
import { formatUrl } from '@core/utils/util'
import AgIcon from '@core/components/Icon/index'

export default {
  name: 'SiderMenuItem',
  components: { AgIcon },
  props: {
    menu: {
      type: Object,
      default: null
    }
  },
  computed: {
    menuUrl() {
      return formatUrl(this.menu.url)
    }
  }
}
</script>
