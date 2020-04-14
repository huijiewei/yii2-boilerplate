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
    <div
      class="shop-brand-list clearfix"
      v-same-width="'brand'"
      v-loading="loading"
    >
      <template v-for="shopBrand in shopBrands">
        <el-card class="brand" :key="shopBrand.id" shadow="hover">
          <img
            :alt="shopBrand.name"
            v-if="shopBrand.logo"
            :src="shopBrand.logo"
            class="logo"
          />
          <img
            :alt="shopBrand.name"
            v-else
            src="../../assets/images/banner.png"
            class="logo"
          />
          <div class="body">
            <span>{{ shopBrand.name }}</span>
            <div>
              <el-popover trigger="click" popper-class="brand-popover">
                <div class="shop-brand-content">
                  <div class="description">{{ shopBrand.description }}</div>
                  <div class="website" v-if="shopBrand.website">
                    网址：<a :href="shopBrand.website" target="_blank">{{
                      shopBrand.website
                    }}</a>
                  </div>
                </div>
                <el-button
                  :disabled="shopBrand.description.length === 0"
                  type="text"
                  slot="reference"
                  icon="el-icon-info"
                  size="mini"
                ></el-button>
              </el-popover>
              <el-popover trigger="click" popper-class="brand-popover">
                <div class="brand-category-tags">
                  <template v-for="shopCategory in shopBrand.shopCategories">
                    <el-tag
                      size="medium"
                      :key="shopBrand.id + '-' + shopCategory.id"
                    >
                      {{ shopCategory.name }} </el-tag
                    >&nbsp;&nbsp;
                  </template>
                </div>
                <el-button
                  :disabled="
                    !shopBrand.shopCategories ||
                    shopBrand.shopCategories.length === 0
                  "
                  type="text"
                  slot="reference"
                  icon="el-icon-s-shop"
                  size="mini"
                ></el-button>
              </el-popover>
            </div>
            <div class="bottom clearfix">
              <el-button
                :disabled="!$can('shop-brand/edit')"
                type="primary"
                size="mini"
                plain
                class="button"
                @click="handleShopBrandEdit(shopBrand)"
                >编辑
              </el-button>
              <el-button
                :disabled="!$can('shop-brand/delete')"
                type="danger"
                size="mini"
                plain
                class="button"
                @click="handleShopBrandDelete(shopBrand)"
                >删除
              </el-button>
            </div>
          </div>
        </el-card>
      </template>
    </div>
  </div>
</template>

<script>
import ShopBrandService from '@admin/services/ShopBrandService'
import flatry from '@core/utils/flatry'
import SearchFormFieldsMixin from '@admin/mixins/SearchFormFieldsMixin'
import SearchForm from '@admin/components/SearchForm'
import SameWidth from '@core/directives/SameWidth'

export default {
  components: { SearchForm },
  directives: {
    sameWidth: SameWidth,
  },
  mixins: [SearchFormFieldsMixin],
  data() {
    return {
      loading: true,
      shopBrands: [],
      categoryTree: [],
    }
  },
  activated() {
    this.getShopBrands()
  },
  watch: {
    $route(to, from) {
      if (to.path === from.path) {
        this.getShopBrands()
      }
    },
  },
  methods: {
    async getShopBrands() {
      this.loading = true

      const { data } = await flatry(
        ShopBrandService.all(this.buildRouteQuery(this.$route.query))
      )

      if (data) {
        this.shopBrands = data.items

        this.setSearchFields(data.searchFields)
      }

      this.loading = false
    },
    handleShopBrandCreate() {
      this.$router.push({ path: '/shop-brand/create' })
    },
    handleShopBrandEdit(shopBrand) {
      this.$router.push({
        name: 'shop-brand-edit',
        params: { id: shopBrand.id },
      })
    },
    handleShopBrandDelete(shopBrand) {
      this.$deleteDialog({
        message: `你确定要删除品牌 <strong>${shopBrand.name}</strong> 吗`,
        callback: async () => {
          this.loading = true

          const { data } = await flatry(ShopBrandService.delete(shopBrand.id))

          if (data) {
            this.shopBrands.forEach((item, index) => {
              if (item.id === shopBrand.id) {
                this.shopBrands.splice(index, 1)
              }
            })

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
<style lang="scss">
.shop-brand-content {
  .website {
    margin-top: 12px;
  }
}
.shop-brand-list {
  .brand {
    float: left;
    margin-right: 12px;
    margin-bottom: 12px;

    .logo {
      border: 1px solid #dddddd;
      width: 88px;
      height: 31px;
    }

    .body {
      padding: 10px 0;
    }

    .icon {
      margin-right: 5px;
    }

    .bottom {
      padding-top: 10px;
    }
  }

  .el-card__body {
    text-align: center;
  }
}

.brand-popover {
  min-width: auto;
  max-width: 500px;
}

.brand-category-tags {
  margin-left: -9px;
  margin-top: -9px;

  .el-tag {
    margin-left: 9px;
    margin-top: 9px;
  }
}
</style>
