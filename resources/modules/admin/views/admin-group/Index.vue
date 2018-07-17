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
            v-if="$store.getters.checkAcl('admin-group/view')"
            :to="{ path: 'admin-group/view', query: { id: scope.row.id } }">
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
            :to="{ path: 'admin-group/edit', query: { id: scope.row.id } }">
            <el-button
              title="编辑"
              type="warning"
              size="mini"
              :plain="true">
              编辑
            </el-button>
          </router-link>
          <delete-button
            v-if="$store.getters.checkAcl('admin-group/delete')"
            title="删除"
            size="mini"
            type="danger"
            :confirm="`你确定要删除${scope.row.name}吗?`"
            :plain="true"
            :api-url="'admin-group/delete'"
            :api-params="{ id: scope.row.id }"
            @on-success="onSuccess(scope.row)">
            删除
          </delete-button>
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
  import DeleteButton from '@admin/components/DeleteButton'

  export default {
    components: { DeleteButton },
    metaInfo: {
      title: '管理组'
    },
    data() {
      return {
        adminGroups: [],
        loading: true
      }
    },
    methods: {
      onSuccess(group) {
        this.adminGroups.forEach((item, index) => {
          if (item.id === group.id) {
            this.adminGroups.splice(index, 1)
          }
        })
      }
    },
    created() {
      this.$http.get('admin-group').then((response) => {
        this.adminGroups = response.data.items
      }).catch(() => {
      }).finally(() => {
        this.loading = false
      })
    }
  }
</script>
