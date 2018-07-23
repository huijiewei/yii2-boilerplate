<template>
  <div class="box">
    <div class="box-toolbar">
      <router-link
        v-if="$can('admin/create')"
        :to="{ path: '/admin/create' }">
        <el-button type="primary" size="medium">
          新建管理员
        </el-button>
      </router-link>
    </div>
    <el-table v-loading="loading" :stripe="true" :data="admins">
      <el-table-column
        class-name="text-mono"
        prop="id"
        label="Id">
      </el-table-column>
      <el-table-column
        prop="phone"
        class-name="text-mono"
        label="电话号码">
      </el-table-column>
      <el-table-column
        prop="displayName"
        label="显示名">
      </el-table-column>
      <el-table-column
        prop="displayIcon"
        label="头像">
      </el-table-column>
      <el-table-column
        prop="group.name"
        label="所属管理组">
      </el-table-column>
      <el-table-column align="right" label="操作">
        <template slot-scope="scope">
          <router-link
            v-if="$can('admin/edit')"
            :to="{ path: '/admin/edit', query: { id: scope.row.id } }">
            <el-button
              title="编辑"
              type="warning"
              size="mini"
              :plain="true">
              编辑
            </el-button>
          </router-link>
          <el-button
            v-if="$can('admin/delete')"
            title="删除"
            size="mini"
            type="danger"
            :plain="true"
            @click="deleteAdmin(scope.row)">
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
        admins: []
      }
    },
    methods: {
      deleteAdmin(admin) {
        this.$confirm(`你确定要删除 ${admin.displayName || admin.phone} 吗？`, {
          showClose: false,
          confirmButtonText: '删除',
          confirmButtonClass: 'el-button--danger',
          cancelButtonText: '取消',
          type: 'error'
        }).then(() => {
          this.loading = true

          this.$http.delete('admin/delete', { id: admin.id }).then(response => {
            this.admins.forEach((item, index) => {
              if (item.id === admin.id) {
                this.admins.splice(index, 1)
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
      this.$http.get('admin', { expand: 'group' }).then((data) => {
        this.admins = data.items
      }).catch(() => {
      }).finally(() => {
        this.loading = false
      })
    }
  }
</script>
