<template>
  <el-submenu :show-timeout="200" :hide-timeout="200" :index="'m' + depth + index" v-if="menu.children">
    <template slot="title">
      <sider-menu-icon :icon="menu.icon" v-if="menu.icon"></sider-menu-icon>
      <span>{{menu.label}}</span>
    </template>
    <template v-for="(childMenu, childIndex) in menu.children">
      <sider-menu-item v-if="!childMenu.children"
                       :menu="childMenu"
                       :key="'m' + (depth + 1) + childIndex"></sider-menu-item>
      <sider-menu-sub v-else :menu="childMenu"
                      :key="'m' + (depth + 1) + childIndex"
                      :depth="depth + 1"
                      :index="childIndex"></sider-menu-sub>
    </template>
  </el-submenu>
</template>

<script>
  import SiderMenuItem from '@admin/components/SiderMenuItem'
  import SiderMenuIcon from '@admin/components/SiderMenuIcon'

  export default {
    name: 'SiderMenuSub',
    data() {
      return {
        opened: false
      }
    },
    methods: {
      changeOpened(opened) {
        console.log(opened)
        this.opened = opened
      }
    },
    components: { SiderMenuIcon, SiderMenuItem },
    props: ['menu', 'depth', 'index']
  }
</script>

