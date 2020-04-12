<template>
  <div class="box">
    <div class="box-toolbar">
      <div class="box-toolbar-search">
        <search-form v-if="searchFields" :search-fields="searchFields" />
      </div>
      <div class="box-toolbar-button">
        <el-button
          :disabled="!$can('user/create')"
          type="primary"
          size="medium"
          @click.native="handleUserCreate()"
        >
          新建会员
        </el-button>
        &nbsp;&nbsp;
        <export-button
          v-if="$can('user/export')"
          :disabled="loading"
          :api="'users/export'"
          type="default"
          size="small"
          :confirm="'你确定导出所有用户吗？'"
        >
          会员导出
        </export-button>
      </div>
    </div>
    <el-table v-loading="loading" :data="users">
      <el-table-column
        fixed
        width="90"
        class-name="text-mono"
        prop="id"
        label="Id"
      />
      <el-table-column
        prop="phone"
        width="130"
        class-name="text-mono"
        label="手机号码"
      />
      <el-table-column
        prop="email"
        width="300"
        class-name="text-mono"
        label="电子邮箱"
      />
      <el-table-column prop="name" width="120" label="名称" />
      <el-table-column width="55" align="center" label="头像">
        <template slot-scope="scope">
          <ag-avatar :src="scope.row.avatar" />
        </template>
      </el-table-column>
      <el-table-column
        width="160"
        class-name="text-mono"
        prop="createdIp"
        label="注册 IP"
      />
      <el-table-column
        align="center"
        width="79"
        class-name="text-mono"
        prop="createdFrom.description"
        label="注册来源"
      />
      <el-table-column
        class-name="text-mono"
        prop="createdAt"
        label="创建时间"
        min-width="160"
      />
      <el-table-column width="135" label="操作" fixed="right" align="right">
        <template slot-scope="scope">
          <el-button
            :disabled="!$can('user/edit')"
            plain
            type="primary"
            size="mini"
            @click="handleUserEdit(scope.row)"
          >
            编辑
          </el-button>
          <el-button
            :disabled="!$can('user/delete')"
            plain
            type="danger"
            size="mini"
            @click="handleUserDelete(scope.row)"
          >
            删除
          </el-button>
        </template>
      </el-table-column>
    </el-table>
    <pagination :pages="pages"></pagination>
    <modal-router-view></modal-router-view>
  </div>
</template>

<script>
import AgAvatar from '@core/components/Avatar'
import flatry from '@core/utils/flatry'
import UserService from '@admin/services/UserService'
import SearchForm from '@admin/components/SearchForm'
import SearchFormFieldsMixin from '@admin/mixins/SearchFormFieldsMixin'
import ExportButton from '@admin/components/ExportButton'
import Pagination from '@admin/components/Pagination'

export default {
  components: { ExportButton, SearchForm, AgAvatar, Pagination },
  mixins: [SearchFormFieldsMixin],
  data() {
    return {
      loading: true,
      users: [],
      pages: null,
    }
  },
  modals: {
    UserCreate: () => import('@admin/views/user/Create'),
  },
  watch: {
    $route(to, from) {
      if (to.path === from.path) {
        this.getUsers()
      }
    },
  },
  created() {
    this.getUsers()
  },
  methods: {
    handleUserCreate() {
      this.$modalRouter.push({ name: 'user-create' })
    },
    handleUserEdit(user) {
      this.$router.push({ path: '/user/edit', query: { id: user.id } })
    },
    handleUserDelete(user) {
      this.$deleteDialog({
        message: `删除用户 <strong>${user.name || user.phone}</strong>`,
        callback: async () => {
          this.loading = true

          const { data } = await flatry(UserService.delete(user.id))

          if (data) {
            this.users.forEach((item, index) => {
              if (item.id === user.id) {
                this.users.splice(index, 1)
              }
            })

            this.$message({
              type: 'success',
              message: data.message,
            })
          }

          this.loading = false
        },
      })
    },
    handleCurrentChange(page) {
      this.$router.push({
        path: this.$route.fullPath,
        query: { page: page },
      })
    },
    async getUsers() {
      this.loading = true

      const { data } = await flatry(
        UserService.all(this.buildRouteQuery(this.$route.query))
      )

      if (data) {
        this.users = data.items
        this.pages = data.pages

        this.setSearchFields(data.searchFields)
      }

      this.loading = false
    },
  },
}
</script>
