<template>
  <div class="box">
    <div class="box-toolbar">
      <div class="box-toolbar-search">
        <search-form v-if="searchFields" :search-fields="searchFields" />
      </div>
      <div class="box-toolbar-button">
        <el-button
          :disabled="!$can('shop-product/create')"
          type="primary"
          size="medium"
          @click.native="handleUserCreate()"
        >
          新建商品
        </el-button>
        &nbsp;&nbsp;
        <export-button
          :disabled="loading || !$can('shop-product/export')"
          :api="'shop-products/export'"
          type="default"
          size="small"
          :confirm="'你确定导出所有商品吗？'"
        >
          商品导出
        </export-button>
      </div>
    </div>
    <el-table v-loading="loading" :data="shopProducts">
      <el-table-column
        fixed
        width="90"
        class-name="text-mono"
        prop="id"
        label="Id"
      />
      <el-table-column
        prop="num"
        width="90"
        class-name="text-mono"
        label="编号"
      />
      <el-table-column prop="name" width="360" label="名称" />
      <el-table-column prop="name" width="120" label="图片" />
      <el-table-column
        width="300"
        class-name="text-mono"
        prop="shopCategory.name"
        label="分类"
      />
      <el-table-column
        align="center"
        width="100"
        class-name="text-mono"
        prop="shopBrand.name"
        label="品牌"
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
            :disabled="!$can('shop-product/edit')"
            plain
            type="primary"
            size="mini"
            @click="handleUserEdit(scope.row)"
          >
            编辑
          </el-button>
          <el-button
            :disabled="!$can('shop-product/delete')"
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
  </div>
</template>

<script>
import flatry from '@core/utils/flatry'
import ShopProductService from '@admin/services/ShopProductService'
import SearchForm from '@admin/components/SearchForm'
import SearchFormFieldsMixin from '@admin/mixins/SearchFormFieldsMixin'
import ExportButton from '@admin/components/ExportButton'
import Pagination from '@admin/components/Pagination'

export default {
  name: 'ShopProduct',
  components: { ExportButton, SearchForm, Pagination },
  mixins: [SearchFormFieldsMixin],
  data() {
    return {
      loading: true,
      shopProducts: [],
      pages: null,
    }
  },
  beforeRouteUpdate(to, from, next) {
    this.getShopProducts(to.query)
    next()
  },
  created() {
    this.getShopProducts(this.$route.query)
  },
  methods: {
    handleUserCreate() {
      this.$router.push({ path: '/shop/create' })
    },
    handleUserEdit(user) {
      this.$router.push({ name: 'ShopEdit', params: { id: user.id } })
    },
    handleUserDelete(user) {
      this.$deleteDialog({
        message: `删除用户 <strong>${user.name || user.phone}</strong>`,
        callback: async () => {
          this.loading = true

          const { data } = await flatry(ShopProductService.delete(user.id))

          if (data) {
            this.shopProducts.forEach((item, index) => {
              if (item.id === user.id) {
                this.shopProducts.splice(index, 1)
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
    async getShopProducts(query) {
      this.loading = true

      const { data } = await flatry(
        ShopProductService.all(this.buildRouteQuery(query))
      )

      if (data) {
        this.shopProducts = data.items
        this.pages = data.pages

        this.setSearchFields(data.searchFields)
      }

      this.loading = false
    },
  },
}
</script>
