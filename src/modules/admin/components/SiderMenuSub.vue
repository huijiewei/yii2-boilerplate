<template>
  <el-submenu
    v-if="menu.children"
    :show-timeout="200"
    :hide-timeout="200"
    :index="'m' + depth + index"
  >
    <template slot="title">
      <sider-menu-icon
        v-if="menu.icon"
        :icon="menu.icon"
      />
      <span>{{ menu.label }}</span>
    </template>
    <template v-for="(childMenu, childIndex) in menu.children">
      <sider-menu-item
        v-if="!childMenu.children"
        :key="'m' + (depth + 1) + childIndex"
        :menu="childMenu"
      />
      <sider-menu-sub
        v-else
        :key="'m' + (depth + 1) + childIndex"
        :menu="childMenu"
        :depth="depth + 1"
        :index="childIndex"
      />
    </template>
  </el-submenu>
</template>

<script>
import SiderMenuItem from './SiderMenuItem'
import SiderMenuIcon from './SiderMenuIcon'

export default {
  name: 'SiderMenuSub',
  components: { SiderMenuIcon, SiderMenuItem },
  // eslint-disable-next-line vue/require-prop-types
  props: ['menu', 'depth', 'index'],
  data () {
    return {
      opened: false
    }
  },
  methods: {
    changeOpened (opened) {
      this.opened = opened
    }
  }
}
</script>
