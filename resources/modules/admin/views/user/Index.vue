<template>
  <div class="box">
    <div class="box-toolbar">
      <div class="buttons">
        <router-link
          v-if="$can('user/create')"
          :to="{ path: '/user/create' }">
          <el-button type="primary" size="medium">
            新建会员
          </el-button>
        </router-link>
      </div>
      <div class="search-form">
        <search-form :search-fields="searchFields"></search-form>
      </div>
    </div>
    <el-table v-loading="loading" :stripe="true" :data="users">
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
        align="center"
        width="190"
        class-name="text-mono"
        prop="createdAt"
        label="创建时间">
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
      <el-table-column width="auto" class-name="text-nowrap" align="right" label="操作">
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
        </template>
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

  export default {
    components: { SearchForm, BpAvatar },
    data() {
      return {
        loading: true,
        users: [],
        pages: null,
        searchFields: null
      }
    },
    watch: {
      '$route': 'getUsers'
    },
    methods: {
      handleCurrentChange(page) {
        this.$router.push({ path: this.$route.fullPath, query: { page: page } })
      },
      getUsers: async function() {
        this.loading = true

        const query = this.searchFields !== null ?
          this.$route.query :
          Object.assign({ searchFields: true }, this.$route.query)

        const { data } = await flatry(UserService.all(query))

        if (data) {
          this.users = data.items
          this.pages = data.pages

          if (this.searchFields === null) {
            this.searchFields = data.searchFields
          }
        }

        this.loading = false
      }
    },
    created() {
      this.getUsers()
    }
  }
</script>
