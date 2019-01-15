<template>
  <div class="box">
    <div class="box-toolbar">
      <div class="button-bar">
        <router-link
          v-if="$can('user/create')"
          :to="{ path: '/user/create' }">
          <el-button type="primary" size="medium">
            新建会员
          </el-button>
        </router-link>
        <export-button v-if="$can('user/export')"
                       :disabled="loading"
                       :api="'user/export'"
                       type="default" size="small">
          会员导出
        </export-button>
      </div>
      <div class="search-bar">
        <search-form v-if="searchFields" :search-fields="searchFields"></search-form>
      </div>
    </div>
    <el-table v-loading="loading" :stripe="true" :data="users">
      <el-table-column width="90" label="操作">
        <template slot-scope="scope">
          <el-dropdown trigger="click">
            <el-button plain size="mini" type="primary">
              操作<i class="el-icon-arrow-down el-icon--right"></i>
            </el-button>
            <el-dropdown-menu slot="dropdown">
              <el-dropdown-item v-if="$can('user/edit')" @click.native="handleUserEdit(scope.row)">
                编辑
              </el-dropdown-item>
              <el-dropdown-item v-if="$can('user/delete')" @click.native="handleUserDelete(scope.row)">
                删除
              </el-dropdown-item>
            </el-dropdown-menu>
          </el-dropdown>
        </template>
      </el-table-column>
      <el-table-column
        width="90"
        class-name="text-mono"
        prop="id"
        label="Id">
      </el-table-column>
      <el-table-column
        prop="phone"
        width="150"
        class-name="text-mono"
        label="电话号码">
      </el-table-column>
      <el-table-column
        prop="display"
        width="150"
        label="显示名">
      </el-table-column>
      <el-table-column
        width="60"
        align="center"
        label="头像">
        <template slot-scope="scope">
          <bp-avatar :avatar="scope.row.avatar"></bp-avatar>
        </template>
      </el-table-column>
      <el-table-column
        width="160"
        class-name="text-mono"
        prop="createdIp"
        label="注册 IP">
      </el-table-column>
      <el-table-column
        align="center"
        width="79"
        class-name="text-mono"
        prop="createdFromName"
        label="注册来源">
      </el-table-column>
      <el-table-column
        class-name="text-mono"
        prop="createdAt"
        label="创建时间">
      </el-table-column>
    </el-table>
    <div class="bp-pages" v-if="pages">
      <el-pagination
        @current-change="handleCurrentChange"
        :background="true"
        :current-page="pages.currentPage"
        :page-size="pages.perPage"
        layout="total, prev, pager, next, jumper"
        :total="pages.totalCount">
      </el-pagination>
    </div>
  </div>
</template>

<script>
  import BpAvatar from '@admin/components/Avatar'
  import flatry from '@admin/utils/flatry'
  import UserService from '@admin/services/UserService'
  import SearchForm from '@admin/components/SearchForm'
  import SearchFieldsMixin from '@admin/mixins/SearchFieldsMixin'
  import ExportButton from '@admin/components/ExportButton'

  export default {
    components: { ExportButton, SearchForm, BpAvatar },
    mixins: [SearchFieldsMixin],
    data() {
      return {
        loading: true,
        users: [],
        pages: null
      }
    },
    watch: {
      '$route': 'getUsers'
    },
    methods: {
      handleUserEdit(user) {
        this.$router.push({ path: '/user/edit', query: { id: user.id } })
      },
      handleUserDelete(user) {
        this.$deleteDialog(`用户 ${ user.display || user.phone }`, async (action) => {
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
      handleCurrentChange(page) {
        this.$router.push({ path: this.$route.fullPath, query: { page: page } })
      },
      getUsers: async function() {
        this.loading = true

        const { data } = await flatry(UserService.all(this.buildRouteQuery(this.$route.query)))

        if (data) {
          this.users = data.items
          this.pages = data.pages

          this.setSearchFields(data.searchFields)
        }

        this.loading = false
      }
    },
    created() {
      this.getUsers()
    }
  }
</script>
