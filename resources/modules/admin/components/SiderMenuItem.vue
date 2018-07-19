<template>
  <el-menu-item :index="'/' + menuUrl">
    <template>
      <sider-menu-icon :icon="menu.icon" v-if="menu.icon"></sider-menu-icon>
      <span slot="title">{{menu.label}}</span>
    </template>
  </el-menu-item>
</template>

<script>
  import SiderMenuIcon from '@admin/components/SiderMenuIcon'
  import { formatUrl } from '@admin/utils/util'

  export default {
    name: 'SiderMenuItem',
    components: { SiderMenuIcon },
    props: ['menu'],
    computed: {
      menuUrl: function() {
        return formatUrl(this.menu.url)
      }
    }
  }
</script>

