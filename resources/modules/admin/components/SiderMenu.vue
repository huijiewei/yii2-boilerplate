<template>
  <div>
    <template v-for="(menu, index) in menus">
      <el-submenu v-bind:key="'m' + depth + index" :index="'m' + depth + index" v-if="menu.children">
        <template slot="title">
          <i v-bind:class="'el-icon-' + menu.icon" v-if="menu.icon"></i>
          <span slot="title">{{menu.label}}</span>
        </template>
        <sider-menu :menus="menu.children" :depth="depth + 1"></sider-menu>
      </el-submenu>
      <el-menu-item :route="{path :'/' + menu.url}" v-bind:key="'m' + depth + index"
                    :index="'/' + menu.url"
                    v-else>
        <i v-bind:class="'el-icon-' + menu.icon" v-if="menu.icon"></i>
        <span slot="title">{{menu.label}}</span>
      </el-menu-item>
    </template>
  </div>
</template>

<script>
  export default {
    name: 'SiderMenu',
    props: ['menus', 'depth']
  }
</script>

