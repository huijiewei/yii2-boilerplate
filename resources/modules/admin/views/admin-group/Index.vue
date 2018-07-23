<template>
  <div class="box">
    <div class="box-toolbar">
      <router-link
        v-if="$can('admin-group/create')"
        :to="{ path: '/admin-group/create' }">
        <el-button type="primary" size="medium">
          新建管理组
        </el-button>
      </router-link>
    </div>
    <el-table v-loading="loading" :stripe="true" :data="adminGroups">
      <el-table-column
        class-name="text-mono"
        prop="id"
        label="Id">
      </el-table-column>
      <el-table-column
        prop="name"
        label="名称">
      </el-table-column>
      <el-table-column align="right" label="操作">
        <template slot-scope="scope">
          <router-link
            :to="{ path: '/admin-group/edit', query: { id: scope.row.id } }">
            <el-button
              title="编辑"
              type="warning"
              size="mini"
              :plain="true">
              编辑
            </el-button>
          </router-link>
          <el-button
            v-if="$can('admin-group/delete')"
            title="删除"
            size="mini"
            type="danger"
            :plain="true"
            @click="deleteAdminGroup(scope.row)">
            删除
          </el-button>
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        loading: true,
        adminGroups: []
      }
    },
    methods: {
      deleteAdminGroup(group) {
        this.$confirm(`你确定要删除 ${group.name} 吗？`, {
          showClose: false,
          confirmButtonText: '删除',
          confirmButtonClass: 'el-button--danger',
          cancelButtonText: '取消',
          type: 'error'
        }).then(() => {
          this.loading = true

          this.$http.delete('admin-group/delete', { id: group.id }).then(response => {
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

          }).finally(() => {
            this.loading = false
          })
        }).catch(() => {

        })
      }
    },
    created() {
      this.$http.get('admin-group').then((data) => {
        this.adminGroups = data.items
      }).catch(() => {
      }).finally(() => {
        this.loading = false
      })
    }
  }
</script>
