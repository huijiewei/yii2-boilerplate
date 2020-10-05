<template>
  <el-row :gutter="0" style="padding: 5px">
    <div class="box-header">
      <h4>{{ pageTitle }}</h4>
    </div>
    <district-from
      v-if="district"
      :submit-text="pageTitle"
      :district="district"
      :district-parents="districtParents"
      :is-edit="false"
      :can-submit="$can('district/create')"
      @on-submit="createDistrict"
    >
    </district-from>
    <placeholder-form v-else></placeholder-form>
  </el-row>
</template>

<script>
import DistrictFrom from '@admin/views/district/_EditForm'
import DistrictService from '@admin/services/DistrictService'
import MiscService from '@admin/services/MiscService'
import flatry from '@core/utils/flatry'
import PlaceholderForm from '@core/components/Placeholder/PlaceholderForm'

export default {
  name: 'DistrictCreate',
  components: { PlaceholderForm, DistrictFrom },
  props: {
    categoryTree: {
      type: Array,
    },
  },
  data() {
    return {
      pageTitle: '新建地区',
      district: null,
      districtParents: [],
    }
  },
  beforeRouteUpdate(to, from, next) {
    this.district = null
    this.getDistrictPath(to.params.id)
    next()
  },
  created() {
    this.getDistrictPath(this.$route.params.id)
  },
  methods: {
    async getDistrictPath(id) {
      let parents = [0]

      if (id > 0) {
        const { data } = await flatry(MiscService.districtPath(id))

        if (data && Array.isArray(data) && data.length > 0) {
          parents = data.map((parent) => parent.id)
        }
      }

      this.districtParents = parents

      this.$emit('on-expanded', parents, id)

      this.district = {
        parentId: id,
        name: '',
        code: '',
        zipCode: '',
        areaCode: '',
      }
    },
    async createDistrict(district, done, fail, always) {
      const { data, error } = await flatry(DistrictService.create(district))

      if (data) {
        done()

        this.$message.success('新建地区成功')

        this.$emit('on-updated', data.id, data.parentId)

        await this.$router.replace({
          name: 'DistrictEdit',
          params: { id: data.id },
        })
      }

      if (error) {
        fail(error)
      }

      always()
    },
  },
}
</script>
