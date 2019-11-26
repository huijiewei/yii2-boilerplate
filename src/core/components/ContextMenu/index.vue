<template>
  <vue-context ref="contextMenu">
    <template slot-scope="child">
      <li @click.prevent="handleCategoryEdit(child.id)">
        编辑
      </li>
      <li>
        新建子分类
      </li>
    </template>
  </vue-context>
</template>

<script>
import { VueContext } from 'vue-context'
import 'vue-context/src/sass/vue-context.scss'
export default {
  name: 'ContextMenu'
}
</script>

<style scoped></style>
