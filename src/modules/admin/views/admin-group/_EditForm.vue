<template>
  <el-form
    v-if="formModel"
    ref="formModel"
    :rules="formRules"
    :model="formModel"
    label-width="100px"
    label-suffix="："
    @submit.native.stop.prevent="handleFormSubmit('formModel')"
  >
    <el-form-item
      label="名称"
      prop="name"
    >
      <el-col :md="9">
        <el-input v-model.trim="formModel.name" />
      </el-col>
    </el-form-item>
    <el-form-item label="权限">
      <div class="check-group-box">
        <div
          v-for="(group, index) in formModel.acl"
          :key="index"
          class="cgb-panel"
        >
          <div class="cgb-head">
            <el-checkbox
              v-model="group.checkAll"
              :label="group.name"
              :indeterminate="group.checkIndeterminate"
              @change="handleCheckAclAllChange(group)"
            />
          </div>
          <div class="cgb-body">
            <el-checkbox-group
              v-model="group.checkedAcl"
              v-same-width
              @change="handleCheckedAclGroupChange(group)"
            >
              <template v-for="(child, childIndex) in group.children">
                <el-checkbox
                  v-if="!child.children"
                  :key="index + '-' + childIndex"
                  :ref="child.actionId"
                  :label="child.actionId"
                >
                  {{ child.name }}
                </el-checkbox>
                <div
                  v-if="child.children"
                  :key="index + '-' + childIndex"
                  class="cgb-line"
                >
                  <el-checkbox
                    v-for="(checkbox, checkboxIndex) in child.children"
                    :key="index + '-' + childIndex + '-' + checkboxIndex"
                    :ref="checkbox.actionId"
                    :label="checkbox.actionId"
                    @change="handleCheckedAclItemChange(checkbox)"
                  >
                    {{ checkbox.name }}
                  </el-checkbox>
                </div>
              </template>
            </el-checkbox-group>
          </div>
        </div>
      </div>
    </el-form-item>
    <el-form-item>
      <el-button
        type="primary"
        native-type="submit"
        :loading="submitLoading"
      >
        {{ submitText }}
      </el-button>
    </el-form-item>
  </el-form>
</template>

<script>
import flatry from '@core/utils/flatry'
import OpenService from '@admin/services/OpenService'
import UnprocessableEntityHttpErrorMixin from '@admin/mixins/UnprocessableEntityHttpErrorMixin'

export default {
  name: 'AdminGroupForm',
  directives: {
    sameWidth: {
      inserted (el) {
        const checkboxList = el.getElementsByClassName('el-checkbox')

        if (checkboxList.length < 2) {
          return
        }

        let maxWidth = 0

        for (let elm of checkboxList) {
          const width = elm.offsetWidth

          if (width > maxWidth) {
            maxWidth = width
          }
        }

        for (let elm of checkboxList) {
          elm.style.width = maxWidth + 2 + 'px'
        }
      }
    }
  },
  mixins: [UnprocessableEntityHttpErrorMixin],
  props: {
    submitText: {
      type: String,
      required: true
    },
    isEdit: {
      type: Boolean,
      default: false
    },
    adminGroup: {
      type: Object,
      default: null
    }
  },
  data () {
    return {
      submitLoading: false,
      formRules: {
        name: [
          { required: true, message: '请输入管理组名称', trigger: 'blur' },
          { min: 3, max: 10, message: '管理组名称长度在 3 到 10 个字符', trigger: 'blur' }
        ]
      },
      formModel: null,
      acl: []
    }
  },
  async mounted () {
    this.formModel = {
      id: this.adminGroup.id,
      name: this.adminGroup.name,
      acl: []
    }

    const { data } = await flatry(OpenService.adminGroupAcl())

    if (data) {
      this.acl = data
    }

    const permissions = this.adminGroup.permissions || []
    const result = []

    this.acl.forEach(acl => {
      const group = {
        name: acl.name,
        checkAll: false,
        checkIndeterminate: false,
        checkedAcl: [],
        aclCount: 0,
        children: acl.children
      }

      acl.children.forEach(child => {
        if (child.children) {
          child.children.forEach(item => {
            group.aclCount++
            if (permissions.includes(item.actionId)) {
              group.checkedAcl.push(item.actionId)
            }
          })
        } else {
          group.aclCount++
          if (permissions.includes(child.actionId)) {
            group.checkedAcl.push(child.actionId)
          }
        }
      })

      const checkedCount = group.checkedAcl.length

      group.checkAll = group.aclCount === checkedCount
      group.checkIndeterminate = checkedCount > 0 && checkedCount < group.aclCount

      result.push(group)
    })

    this.formModel.acl = result
  },
  methods: {
    handleFormSubmit (formName) {
      this.$refs[formName].validate((valid) => {
        if (!valid) {
          return false
        }

        this.submitLoading = true

        const adminGroup = {
          id: this.formModel.id,
          name: this.formModel.name,
          permissions: []
        }

        this.formModel.acl.forEach(group => {
          group.checkedAcl.forEach(acl => {
            adminGroup.permissions.push(acl)
          })
        })

        this.$emit('on-submit', adminGroup, () => {
          this.$refs[formName].clearValidate()
        }, (error) => {
          this.handleViolationError(error, formName)
        }, () => {
          this.submitLoading = false
        })
      })
    },
    handleCheckAclAllChange (group) {
      group.checkIndeterminate = false

      if (group.checkAll === true) {
        group.children.forEach(child => {
          if (child.children) {
            child.children.forEach(item => {
              group.checkedAcl.push(item.actionId)
            })
          } else {
            group.checkedAcl.push(child.actionId)
          }
        })
      } else {
        group.checkedAcl = []
      }
    },
    handleCheckedAclGroupChange (group) {
      const checkedCount = group.checkedAcl.length

      group.checkAll = group.aclCount === checkedCount
      group.checkIndeterminate = checkedCount > 0 && checkedCount < group.aclCount
    },
    handleCheckedAclItemChange (item) {
      if (!item.combines || item.combines.length === 0) {
        return
      }

      const refs = this.$refs
      const checked = refs[item.actionId][0].$el.getElementsByTagName('input')[0].checked

      if (!checked) {
        item.combines.forEach((combine) => {
          if (refs[combine] && refs[combine][0] &&
              refs[combine][0].$el && refs[combine][0].$el.getElementsByTagName('input') &&
              refs[combine][0].$el.getElementsByTagName('input')[0]) {
            refs[combine][0].$el.getElementsByTagName('input')[0].disabled = false
          }
        })

        return
      }

      const acl = this.formModel.acl
      item.combines.forEach((combine) => {
        if (refs[combine] && refs[combine][0] &&
            refs[combine][0].$el && refs[combine][0].$el.getElementsByTagName('input') &&
            refs[combine][0].$el.getElementsByTagName('input')[0]) {
          refs[combine][0].$el.getElementsByTagName('input')[0].disabled = true
        }

        acl.forEach((aclGroup) => {
          if (aclGroup.children && aclGroup.children.length > 0) {
            aclGroup.children.every((aclChild) => {
              if (aclChild.actionId && aclChild.actionId === combine && !aclGroup.checkedAcl.includes(combine)) {
                aclGroup.checkedAcl.push(combine)

                return true
              }

              if (aclChild.children && aclChild.children.length > 0) {
                aclChild.children.every((aclItem) => {
                  if (aclItem.actionId && aclItem.actionId === combine && !aclGroup.checkedAcl.includes(combine)) {
                    aclGroup.checkedAcl.push(combine)

                    return true
                  }

                  return true
                })
              }

              return true
            })
          }
        })
      })
    }
  }
}
</script>

<style lang="scss">
  .check-group-box {
    line-height: 1;

    .cgb-panel {
      &:not(:last-child) {
        margin-bottom: 10px;
        padding-bottom: 3px;
      }

      .cgb-head {
        background-color: #f8f8f8;
        padding: 0 10px;
        line-height: 36px;
      }

      .cgb-body {
        padding: 7px 10px;
        line-height: 2;

        .el-checkbox {
          font-weight: normal;
        }
      }
    }
  }
</style>
