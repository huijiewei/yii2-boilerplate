<template>
  <el-row :gutter="0" style="padding: 5px">
    <div class="box-header">
      <h4>{{ pageTitle }}</h4>
    </div>
    <district-form
      v-if="district"
      :submit-text="pageTitle"
      :district="district"
      :district-parents="districtParents"
      :is-edit="true"
      :can-submit="$can('district/edit')"
      @on-submit="editDistrict"
      @on-delete="deleteDistrict"
    >
    </district-form>
    <placeholder-form v-else />
  </el-row>
</template>

<script>
import DistrictForm from '@admin/views/district/_EditForm'
import DistrictService from '@admin/services/DistrictService'
import PlaceholderForm from '@core/components/Placeholder/PlaceholderForm'

export default {
  name: 'DistrictEdit',
  components: { PlaceholderForm, DistrictForm },
  data() {
    return {
      pageTitle: '编辑地区',
      district: null,
      districtParents: [],
    }
  },
  beforeRouteUpdate(to, from, next) {
    this.district = null
    this.getDistrict(to.params.id)
    next()
  },
  created() {
    this.getDistrict(this.$route.params.id)
  },
  methods: {
    async getDistrict(id) {
      const { data } = await DistrictService.view(id)

      if (data) {
        let parents = [0]

        if (
          data.parents &&
          Array.isArray(data.parents) &&
          data.parents.length > 0
        ) {
          parents = data.parents.map((parent) => parent.id)
        }

        this.districtParents = parents

        this.$emit('on-expanded', parents, data.id)

        this.district = data
      }
    },
    async editDistrict(district, done, fail, always) {
      const { data, error } = await DistrictService.edit(district)

      if (data) {
        done()

        this.$message.success('修改成功')

        this.$emit('on-updated', data.id, data.parentId, this.district.parentId)
      }

      if (error) {
        fail(error)
      }

      always()
    },
    async deleteDistrict(district) {
      this.$deleteDialog({
        message: `删除地区 <strong>${district.name}</strong>`,
        callback: async () => {
          this.loading = true

          const { data } = await DistrictService.delete(district.id)

          if (data) {
            this.$message.success('删除成功')

            this.$emit('on-updated', 0, district.parentId)

            await this.$router.replace({
              path: '/district',
            })
          }

          this.loading = false
        },
      })
    },
  },
}
</script>
