<template>
  <el-menu-item :index="'/' + menuUrl">
    <sider-menu-icon v-if="menu.icon" :icon="menu.icon" />
    <span slot="title">{{ menu.label }}</span>
  </el-menu-item>
</template>

<script>
import SiderMenuIcon from './SiderMenuIcon'
import { formatUrl } from '@core/utils/util'

export default {
  name: 'SiderMenuItem',
  components: { SiderMenuIcon },
  props: {
    menu: {
      type: Object,
      default: null,
    },
  },
  computed: {
    menuUrl() {
      return formatUrl(this.menu.url)
    },
  },
}
</script>
