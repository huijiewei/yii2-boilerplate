<template>
  <div class="box">
    <div class="box-toolbar">
      <div class="box-toolbar-search">
        <search-form
          v-if="searchFields"
          :search-fields="searchFields"
        />
      </div>
      <div class="box-toolbar-button">
        <router-link
          v-if="$can('user/create')"
          :to="{ path: '/user/create' }"
        >
          <el-button
            type="primary"
            size="medium"
          >
            新建会员
          </el-button>
        </router-link>
        &nbsp;&nbsp;
        <export-button
          v-if="$can('user/export')"
          :disabled="loading"
          :api="'user/export'"
          type="default"
          size="small"
        >
          会员导出
        </export-button>
      </div>
    </div>
    <el-table
      border
      v-loading="loading"
      :stripe="true"
      :data="users"
    >
      <el-table-column
        fixed
        width="90"
        class-name="text-mono"
        prop="id"
        label="Id"
      />
      <el-table-column
        prop="phone"
        width="150"
        class-name="text-mono"
        label="电话号码"
      />
      <el-table-column
        prop="display"
        width="150"
        label="显示名"
      />
      <el-table-column
        width="60"
        align="center"
        label="头像"
      >
        <template slot-scope="scope">
          <ag-avatar :avatar="scope.row.avatar" />
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
        prop="createdFromName"
        label="注册来源"
      />
      <el-table-column
        class-name="text-mono"
        width="160"
        prop="createdAt"
        label="创建时间"
      />
      <el-table-column
        class-name="text-mono"
        width="160"
        prop="createdAt"
        label="创建时间"
      />
      <el-table-column
        class-name="text-mono"
        width="160"
        prop="createdAt"
        label="创建时间"
      />
      <el-table-column
        class-name="text-mono"
        width="160"
        prop="createdAt"
        label="创建时间"
      />
      <el-table-column
        class-name="text-mono"
        width="160"
        prop="createdAt"
        label="创建时间"
      />
      <el-table-column
        class-name="text-mono"
        width="160"
        prop="createdAt"
        label="创建时间"
      />
      <el-table-column
        class-name="text-mono"
        width="160"
        prop="createdAt"
        label="创建时间"
      />
      <el-table-column
        class-name="text-mono"
        width="160"
        prop="createdAt"
        label="创建时间"
      />
      <el-table-column
        class-name="text-mono"
        width="160"
        prop="createdAt"
        label="创建时间"
      />
      <el-table-column
        width="135"
        label="操作"
        fixed="right"
        align="right"
      >
        <template slot-scope="scope">
          <el-button
            :disabled="!$can('user/edit')"
            plain
            type="primary"
            size="mini"
            @click.native="handleUserEdit(scope.row)"
          >
            编辑
          </el-button>
          <el-button
            :disabled="!$can('user/delete')"
            plain
            type="danger"
            size="mini"
            @click.native="handleUserDelete(scope.row)"
          >
            删除
          </el-button>
        </template>
      </el-table-column>
    </el-table>
    <div
      v-if="pages"
      class="bp-pages"
    >
      <el-pagination
        :background="true"
        :current-page="pages.currentPage"
        :page-size="pages.perPage"
        layout="total, prev, pager, next, jumper"
        :total="pages.totalCount"
        @current-change="handleCurrentChange"
      />
    </div>
  </div>
</template>

<script>
import AgAvatar from '@core/components/Avatar'
import flatry from '@core/utils/flatry'
import UserService from '@admin/services/UserService'
import SearchForm from '@admin/components/SearchForm'
import SearchFieldsMixin from '@admin/mixins/SearchFieldsMixin'
import ExportButton from '@admin/components/ExportButton'

export default {
  components: { ExportButton, SearchForm, AgAvatar },
  mixins: [SearchFieldsMixin],
  data () {
    return {
      loading: true,
      users: [],
      pages: null
    }
  },
  watch: {
    '$route': 'getUsers'
  },
  created () {
    this.getUsers()
  },
  methods: {
    handleUserEdit (user) {
      this.$router.push({ path: '/user/edit', query: { id: user.id } })
    },
    handleUserDelete (user) {
      this.$deleteDialog(`用户 ${user.display || user.phone}`, async (action) => {
        if (action === 'confirm') {
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
              message: data.message
            })
          }

          this.loading = false
        }
      })
    },
    handleCurrentChange (page) {
      this.$router.push({ path: this.$route.fullPath, query: { page: page } })
    },
    getUsers: async function () {
      this.loading = true

      const { data } = await flatry(UserService.all(this.buildRouteQuery(this.$route.query)))

      if (data) {
        this.users = data.items
        this.pages = data.pages

        this.setSearchFields(data.searchFields)
      }

      this.loading = false
    }
  }
}
</script>
