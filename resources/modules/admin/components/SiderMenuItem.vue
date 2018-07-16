<template>
  <el-menu-item :index="'/' + menu.url">
    <template slot="title">
      <sider-menu-icon :icon="menu.icon" v-if="menu.icon"></sider-menu-icon>
      <span>{{menu.label}}</span>
    </template>
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

