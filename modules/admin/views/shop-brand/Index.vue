<template>
  <div class="box">
    <div class="box-toolbar">
      <div class="box-toolbar-search">
        <search-form v-if="searchFields" :search-fields="searchFields" />
      </div>
      <div class="box-toolbar-button">
        <el-button
          :disabled="!$can('shop-brand/create')"
          type="primary"
          size="medium"
          @click="handleShopBrandCreate()"
        >
          新建品牌
        </el-button>
      </div>
    </div>

    <el-table class="shop-brands" v-loading="loading" :data="shopBrands">
      <el-table-column
        fixed
        width="90"
        class-name="text-mono"
        prop="id"
        label="Id"
      />
      <el-table-column prop="name" width="220" label="品牌名称" />
      <el-table-column prop="slug" width="120" label="品牌别名" />
      <el-table-column width="110" align="center" label="图片">
        <template slot-scope="scope">
          <img
            :alt="scope.row.name"
            v-if="scope.row.logo"
            :src="scope.row.logo"
            class="logo"
          />
          <img
            :alt="scope.row.name"
            v-else
            src="../../assets/images/banner.png"
            class="logo"
          />
        </template>
      </el-table-column>
      <el-table-column width="260" label="品牌分类">
        <template slot-scope="scope">
          <div class="brand-category-tags">
            <template v-for="shopCategory in scope.row.shopCategories">
              <el-tag size="medium" :key="scope.row.id + '-' + shopCategory.id">
                {{ shopCategory.name }} </el-tag
              >&nbsp;&nbsp;
            </template>
          </div>
        </template>
      </el-table-column>
      <el-table-column label="品牌介绍">
        <template slot-scope="scope">
          <div class="description">{{ scope.row.description }}</div>
          <div class="website" v-if="scope.row.website">
            网址：<a :href="scope.row.website" target="_blank">{{
              scope.row.website
            }}</a>
          </div>
        </template>
      </el-table-column>
      <el-table-column width="135" label="操作" fixed="right" align="right">
        <template slot-scope="scope">
          <el-button
            :disabled="!$can('shop-brand/edit')"
            type="primary"
            size="mini"
            plain
            class="button"
            @click="handleShopBrandEdit(scope.row)"
            >编辑
          </el-button>
          <el-button
            :disabled="!$can('shop-brand/delete')"
            type="danger"
            size="mini"
            plain
            class="button"
            @click="handleShopBrandDelete(scope.row)"
            >删除
          </el-button>
        </template>
      </el-table-column>
    </el-table>
    <pagination :pages="pages"></pagination>
  </div>
</template>

<script>
import ShopBrandService from '@admin/services/ShopBrandService'
import SearchFormFieldsMixin from '@admin/mixins/SearchFormFieldsMixin'
import SearchForm from '@admin/components/SearchForm'
import Pagination from '@admin/components/Pagination'

export default {
  name: 'ShopBrand',
  components: { SearchForm, Pagination },
  mixins: [SearchFormFieldsMixin],
  data() {
    return {
      loading: true,
      shopBrands: [],
      pages: null,
    }
  },
  beforeRouteUpdate(to, from, next) {
    this.getShopBrands(to.query)
    next()
  },
  created() {
    this.getShopBrands(this.$route.query)
  },
  methods: {
    async getShopBrands(query) {
      this.loading = true

      const { data } = await ShopBrandService.all(this.buildRouteQuery(query))

      if (data) {
        this.shopBrands = Object.freeze(data.items)
        this.pages = data.pages

        this.setSearchFields(data.searchFields)
      }

      this.loading = false
    },
    handleShopBrandCreate() {
      this.$router.push({ path: '/shop-brand/create' })
    },
    handleShopBrandEdit(shopBrand) {
      this.$router.push({
        path: `/shop-brand/edit/${shopBrand.id}`,
      })
    },
    handleShopBrandDelete(shopBrand) {
      this.$deleteDialog({
        message: `你确定要删除品牌 <strong>${shopBrand.name}</strong> 吗`,
        callback: async () => {
          this.loading = true

          const { data } = await ShopBrandService.delete(shopBrand.id)

          if (data) {
            this.shopBrands = Object.freeze(
              this.shopBrands.filter((item) => item.id !== shopBrand.id)
            )

            this.$message({
              type: 'success',
              message: '删除成功',
            })
          }

          this.loading = false
        },
      })
    },
  },
}
</script>
<style lang="less">
.shop-brands {
  .logo {
    border: 1px solid #dddddd;
    width: 88px;
    height: 31px;
    vertical-align: middle;
  }

  .website {
    margin-top: 9px;
  }

  .brand-category-tags {
    margin-left: -9px;
    margin-top: -9px;

    .el-tag {
      margin-left: 9px;
      margin-top: 9px;
    }
  }
}
</style>
