<template>
  <el-cascader
    style="width: 100%"
    :placeholder="placeholder"
    :props="
      Object.assign(
        {
          value: 'id',
          label: 'name',
          checkStrictly: true,
          lazy: true,
          lazyLoad: loadDistricts,
          leaf: 'leaf',
        },
        props
      )
    "
    :value="value"
    @change="handleChange"
  >
  </el-cascader>
</template>

<script>
import MiscService from '@admin/services/MiscService'

export default {
  name: 'DistrictCascader',
  props: {
    value: {},
    props: {},
    placeholder: {
      type: String,
      default: '选择地区',
    },
    leafLength: {
      type: Number,
      default: 9,
    },
    disabledCodes: {
      type: Array,
      default: () => {
        return []
      },
    },
  },
  model: {
    prop: 'value',
    event: 'change',
  },
  methods: {
    handleChange(value) {
      this.$emit('change', value)
    },
    async loadDistricts(node, resolve) {
      if (node.data && node.data.leaf) {
        resolve([])
        return
      }

      const parentId = node.data && node.data.id ? node.data.id : 0

      const { data } = await MiscService.districts(parentId)

      if (data) {
        data.forEach((item) => {
          item.leaf = item.code.length === this.leafLength
          item.disabled = this.disabledCodes.includes(item.code)
        })

        const districts =
          parentId === 0
            ? [...[{ id: 0, name: '全国', code: '0', leaf: true }], ...data]
            : data

        resolve(districts)
      }
    },
  },
}
</script>
