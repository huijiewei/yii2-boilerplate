<template>
  <div class="box">
    <div class="box-toolbar">
      <div class="box-toolbar-search">
        <search-form v-if="searchFields" :search-fields="searchFields" />
      </div>
      <div class="box-toolbar-button"></div>
    </div>
    <el-table v-loading="loading" :data="userAddresses">
      <el-table-column
        fixed
        width="90"
        class-name="text-mono"
        prop="id"
        label="Id"
      />
      <el-table-column prop="alias" width="130" label="地址别名" />
      <el-table-column prop="name" width="130" label="联系人" />
      <el-table-column
        prop="phone"
        width="130"
        class-name="text-mono"
        label="联系电话"
      />
      <el-table-column width="150" label="用户">
        <template slot-scope="scope">
          <ag-avatar :src="scope.row.user.avatar" />
          &nbsp;
          <span>{{ scope.row.user.name }}</span>
        </template>
      </el-table-column>
      <el-table-column width="390" prop="districtAddress" label="区域地址" />
      <el-table-column prop="address" label="详细地址" min-width="200" />
      <el-table-column width="135" label="操作" fixed="right" align="right">
        <template slot-scope="scope">
          <el-button
            :disabled="!$can('user-address/edit')"
            plain
            type="primary"
            size="mini"
            @click="handleUserAddressEdit(scope.row)"
          >
            编辑
          </el-button>
          <el-button
            :disabled="!$can('user-address/delete')"
            plain
            type="danger"
            size="mini"
            @click="handleUserAddressDelete(scope.row)"
          >
            删除
          </el-button>
        </template>
      </el-table-column>
    </el-table>
    <pagination :pages="pages"></pagination>
  </div>
</template>

<script>
import AgAvatar from '@core/components/Avatar'
import UserAddressService from '@admin/services/UserAddressService'
import SearchForm from '@admin/components/SearchForm'
import SearchFormFieldsMixin from '@admin/mixins/SearchFormFieldsMixin'
import Pagination from '@admin/components/Pagination'

export default {
  name: 'UserAddress',
  components: { SearchForm, AgAvatar, Pagination },
  mixins: [SearchFormFieldsMixin],
  data() {
    return {
      loading: true,
      userAddresses: [],
      pages: null,
    }
  },
  beforeRouteUpdate(to, from, next) {
    this.getUserAddress(to.query)
    next()
  },
  created() {
    this.getUserAddress(this.$route.query)
  },
  methods: {
    handleUserAddressEdit(userAddress) {
      this.$router.push({
        path: `/user-address/edit/${userAddress.id}`,
      })
    },
    handleUserAddressDelete(userAddress) {
      this.$deleteDialog({
        message: `删除用户地址 <strong>${userAddress.alias}, ${userAddress.name}</strong>`,
        callback: async () => {
          this.loading = true

          const { data } = await UserAddressService.delete(userAddress.id)

          if (data) {
            this.users.forEach((item, index) => {
              if (item.id === userAddress.id) {
                this.userAddresses.splice(index, 1)
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
    async getUserAddress(query) {
      this.loading = true

      const { data } = await UserAddressService.all(this.buildRouteQuery(query))

      if (data) {
        this.userAddresses = data.items
        this.pages = data.pages

        this.setSearchFields(data.searchFields)
      }

      this.loading = false
    },
  },
}
</script>
