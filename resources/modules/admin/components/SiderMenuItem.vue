<template>
  <el-menu-item :index="'/' + menu.url">
    <sider-menu-icon :icon="menu.icon" v-if="menu.icon"></sider-menu-icon>
    <span slot="title">{{menu.label}}</span>
  </el-menu-item>
</template>

<script>
  import SiderMenuIcon from '@admin/components/SiderMenuIcon'

  export default {
    name: 'SiderMenuItem',
    components: { SiderMenuIcon },
    props: ['menu']
  }
</script>

