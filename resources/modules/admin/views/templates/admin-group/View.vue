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
          <el-button-group>
            <el-button
              title="查看"
              icon="el-icon-view"
              type="default"
              size="mini"
              :plain="true"
              @click="handleRoute('admin-group/view/'+ scope.row.id)">
            </el-button>
            <el-button
              title="编辑"
              icon="el-icon-edit"
              type="primary"
              size="mini"
              :plain="true"
              @click="handleRoute('admin-group/edit/'+ scope.row.id)">
            </el-button>
            <el-button
              title="删除"
              size="mini"
              type="danger"
              icon="el-icon-delete"
              :plain="true"
              @click="handleDelete(scope.$index, scope.row)">
            </el-button>
          </el-button-group>
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
      handleRoute(action) {
        this.$router.push(action)
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
