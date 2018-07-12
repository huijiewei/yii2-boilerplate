<template>
  <div class="box">
    <div class="box-header">
      <h4>管理组</h4>
    </div>
    <el-table :stripe="true" :data="adminGroups">
      <el-table-column
        prop="id"
        label="Id">
      </el-table-column>
      <el-table-column
        prop="name"
        label="名称">
      </el-table-column>
      <el-table-column align="right" label="操作">
        <template slot-scope="scope">
          <el-button
            title="查看"
            type="primary"
            size="mini"
            :plain="true"
            @click="handleRoute('admin-group/view' , scope.row.id)">
            查看
          </el-button>
          <el-button
            v-show="$store.getters.checkAcl('admin-group/edit')"
            title="编辑"
            type="warning"
            size="mini"
            :plain="true"
            @click="handleRoute('admin-group/edit' , scope.row.id)">
            编辑
          </el-button>
          <el-button
            v-show="$store.getters.checkAcl('admin-group/delete')"
            title="删除"
            size="mini"
            type="danger"
            :plain="true"
            @click="handleDelete(scope.$index, scope.row)">
            删除
          </el-button>
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
  import BpIcon from '@core/components/Icon/index'

  export default {
    components: { BpIcon },
    meta: {
      title: '管理组'
    },
    data() {
      return {
        adminGroups: []
      }
    },
    methods: {
      handleRoute(action, id) {
        this.$router.push({ path: action, query: { id: id } })
      },
      handleDelete(index, row) {
        console.log(index, row)
      }
    },
    created() {
      this.$http.get('admin-groups').then((response) => {
        this.adminGroups = response.data.items
      }).catch(() => {
      })
    }
  }
</script>
