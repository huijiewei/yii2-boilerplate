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

  export default {
    name: 'SiderMenuItem',
    components: { SiderMenuIcon },
    props: ['menu'],
    computed: {
      menuUrl: function() {
        if (this.menu.url === 'site/index') {
          return ''
        }

        if (this.menu.url.endsWith('/index')) {
          return this.menu.url.substr(0, this.menu.url.length - 6)
        }

        return this.menu.url
      }
    }
  }
</script>

