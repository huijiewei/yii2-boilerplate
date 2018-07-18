<template>
  <el-breadcrumb class="bp-breadcrumb">
    <template v-for="(breadcrumb, index) in getBreadcrumbs">
      <el-breadcrumb-item :to="{ name: breadcrumb.link }" :key="index">
        <bp-icon v-if="breadcrumb.icon" :type="breadcrumb.icon"></bp-icon>
        <span>{{ breadcrumb.title }}</span>
      </el-breadcrumb-item>
    </template>
  </el-breadcrumb>
</template>

<script>
  import BpIcon from '@core/components/Icon/index'

  export default {
    name: 'Breadcrumb',
    components: { BpIcon },
    computed: {
      getBreadcrumbs() {
        const breadcrumbs = []

        this.$route.matched.forEach((route) => {
          const breadcrumb = route.meta.breadcrumb

          if (breadcrumb) {
            if (breadcrumb.parent) {
              const parent = this.$router.resolve({ name: breadcrumb.parent }).route

              if (parent.meta.breadcrumb) {
                breadcrumbs.push(parent.meta.breadcrumb)
              }
            }

            breadcrumbs.push(breadcrumb)
          }
        })

        return breadcrumbs
      }
    }
  }
</script>

<style lang="scss">
  .bp-main {
    padding: 16px 20px;

    .bp-breadcrumb {
      margin-bottom: 15px;
      font-size: 13px;

      .is-link {
        font-weight: normal;
      }

      .anticon {
        font-size: 12px;
      }
    }
  }
</style>
