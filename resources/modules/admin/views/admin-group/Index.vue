<template>
  <div class="box">
    <div class="box-header">
      <h4>管理组</h4>
    </div>
    <div class="box-toolbar">
      <router-link
        v-show="$store.getters.checkAcl('admin-group/create')"
        :to="'admin-group/create'">
        <el-button type="primary" size="medium">
          新建管理组
        </el-button>
      </router-link>
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
          <router-link
            v-show="$store.getters.checkAcl('admin-group/view')"
            :to="'admin-group/view?id=' + scope.row.id">
            <el-button
              title="查看"
              type="primary"
              size="mini"
              :plain="true">
              查看
            </el-button>
          </router-link>
          <router-link
            v-if="$store.getters.checkAcl('admin-group/edit')"
            :to="'admin-group/edit?id=' + scope.row.id">
            <el-button
              title="编辑"
              type="warning"
              size="mini"
              :plain="true">
              编辑
            </el-button>
          </router-link>
          <el-button
            v-if="$store.getters.checkAcl('admin-group/delete')"
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
    metaInfo: {
      title: '管理组'
    },
    data() {
      return {
        adminGroups: []
      }
    },
    methods: {
      handleDelete(group) {
        this.$confirm(`你确定要删除:${group.name}吗?`, '删除管理组', {
          showClose: false,
          confirmButtonText: '删除',
          confirmButtonClass: 'el-button--danger',
          cancelButtonText: '取消',
          type: 'error'
        }).then(() => {
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

          })
        }).catch(() => {
        })
      }
    },
    created() {
      this.$http.get('admin-group').then((response) => {
        this.adminGroups = response.data.items
      }).catch(() => {
      })
    }
  }
</script>
