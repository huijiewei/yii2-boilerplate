<template>
  <div class="box">
    <div class="box-header">
      <h4>管理组</h4>
    </div>
    <el-table v-loading="loading" :stripe="true" :data="adminGroups">
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
            @click="handleDelete(scope.row)">
            删除
          </el-button>
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
  export default {
    meta: {
      title: '管理组'
    },
    data() {
      return {
        adminGroups: [],
        loading: true
      }
    },
    methods: {
      handleRoute(action, groupId) {
        this.$router.push({ path: action, query: { id: groupId } })
      },
      handleDelete(group) {
        this.$confirm(`你确定要删除:${group.name}吗?`, '删除管理组', {
          showClose: false,
          confirmButtonText: '删除',
          confirmButtonClass: 'danger',
          cancelButtonText: '取消',
          type: 'error'
        }).then(() => {
          this.$http.delete('admin-groups/' + group.id).then(response => {
            this.adminGroups.forEach((item, index) => {
              if (item.id === group.id) {
                this.adminGroups.splice(index, 1)
              }
            })

            this.$message({
              type: 'success',
              message: response.data.message
            })
          }).catch(() => {

          })
        })
      }
    },
    created() {
      this.$http.get('admin-groups').then((response) => {
        this.adminGroups = response.data.items
      }).catch(() => {
      }).finally(() => {
        this.loading = false
      })
    }
  }
</script>
