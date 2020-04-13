<template>
  <el-form
    ref="formModel"
    :model="formModel"
    label-width="100px"
    label-suffix="："
    @submit.native.stop.prevent="handleFormSubmit('formModel')"
  >
    <el-form-item
      label="名称"
      prop="name"
      :rules="[
        { required: true, message: '请输入管理组名称', trigger: 'blur' },
        {
          min: 3,
          max: 10,
          message: '管理组名称长度在 3 到 10 个字符',
          trigger: 'blur',
        },
      ]"
    >
      <el-col :md="9">
        <el-input v-model.trim="formModel.name" />
      </el-col>
    </el-form-item>
    <el-form-item label="权限" prop="permissions">
      <div class="check-group-box">
        <div
          v-for="(group, index) in permissions"
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
              v-model="group.checkedPermissions"
              v-same-width="'el-checkbox'"
              @change="handleCheckedPermissionGroupChange(group)"
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
                    @change="handleCheckedPermissionItemChange(checkbox)"
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
      <el-button type="primary" native-type="submit" :loading="submitLoading">
        {{ submitText }}
      </el-button>
    </el-form-item>
  </el-form>
</template>

<script>
import flatry from '@core/utils/flatry'
import MiscService from '@admin/services/MiscService'
import UnprocessableEntityHttpErrorMixin from '@admin/mixins/UnprocessableEntityHttpErrorMixin'
import AuthService from '@admin/services/AuthService'
import SameWidth from '@core/directives/SameWidth'

export default {
  name: 'AdminGroupForm',
  directives: {
    sameWidth: SameWidth,
  },
  mixins: [UnprocessableEntityHttpErrorMixin],
  props: {
    submitText: {
      type: String,
      required: true,
    },
    isEdit: {
      type: Boolean,
      default: false,
    },
    adminGroup: {
      type: Object,
      default: null,
    },
  },
  data() {
    return {
      submitLoading: false,
      formModel: null,
      permissions: [],
    }
  },
  async created() {
    this.init()

    const { data } = await flatry(MiscService.adminGroupPermissions())

    const permissions = this.formModel.permissions || []
    const result = []

    data.forEach((permission) => {
      const group = {
        name: permission.name,
        checkAll: false,
        checkIndeterminate: false,
        checkedPermissions: [],
        permissionsCount: 0,
        children: permission.children,
      }

      permission.children.forEach((child) => {
        if (child.children) {
          child.children.forEach((item) => {
            group.permissionsCount++
            if (permissions.includes(item.actionId)) {
              group.checkedPermissions.push(item.actionId)
            }
          })
        } else {
          group.permissionsCount++
          if (permissions.includes(child.actionId)) {
            group.checkedPermissions.push(child.actionId)
          }
        }
      })

      const checkedCount = group.checkedPermissions.length

      group.checkAll = group.permissionsCount === checkedCount
      group.checkIndeterminate =
        checkedCount > 0 && checkedCount < group.permissionsCount

      result.push(group)
    })

    this.permissions = result
  },
  methods: {
    init() {
      this.formModel = Object.assign({}, this.adminGroup)
    },
    handleFormSubmit(formName) {
      this.$refs[formName].validate((valid) => {
        if (!valid) {
          return false
        }

        this.submitLoading = true

        this.permissions.forEach((group) => {
          group.checkedPermissions.forEach((permission) => {
            this.formModel.permissions.push(permission)
          })
        })

        this.$emit(
          'on-submit',
          this.formModel,
          async () => {
            this.$refs[formName].clearValidate()
            if (
              this.adminGroup.id ===
              this.$store.getters['auth/getCurrentUser'].adminGroup.id
            ) {
              const { data } = await flatry(AuthService.account())

              if (data) {
                await this.$store.dispatch('auth/account', data)
              }
            }
          },
          (error) => {
            this.handleViolationError(error, formName)
          },
          () => {
            this.submitLoading = false
          }
        )
      })
    },
    handleCheckAclAllChange(group) {
      group.checkIndeterminate = false

      if (group.checkAll === true) {
        group.children.forEach((child) => {
          if (child.children) {
            child.children.forEach((item) => {
              group.checkedPermissions.push(item.actionId)
            })
          } else {
            group.checkedPermissions.push(child.actionId)
          }
        })
      } else {
        group.checkedPermissions = []
      }
    },
    handleCheckedPermissionGroupChange(group) {
      const checkedCount = group.checkedPermissions.length

      group.checkAll = group.permissionsCount === checkedCount
      group.checkIndeterminate =
        checkedCount > 0 && checkedCount < group.permissionsCount
    },
    handleCheckedPermissionItemChange(item) {
      if (!item.combines || item.combines.length === 0) {
        return
      }

      const refs = this.$refs

      const checked = refs[item.actionId][0].$el.getElementsByTagName(
        'input'
      )[0].checked

      if (!checked) {
        item.combines.forEach((combine) => {
          if (
            refs[combine] &&
            refs[combine][0] &&
            refs[combine][0].$el &&
            refs[combine][0].$el.getElementsByTagName('input') &&
            refs[combine][0].$el.getElementsByTagName('input')[0]
          ) {
            refs[combine][0].$el.getElementsByTagName(
              'input'
            )[0].disabled = false
          }
        })

        return
      }

      const permissions = this.formModel.permissions

      item.combines.forEach((combine) => {
        if (
          refs[combine] &&
          refs[combine][0] &&
          refs[combine][0].$el &&
          refs[combine][0].$el.getElementsByTagName('input') &&
          refs[combine][0].$el.getElementsByTagName('input')[0]
        ) {
          refs[combine][0].$el.getElementsByTagName('input')[0].disabled = true
        }

        permissions.forEach((group) => {
          if (group.children && group.children.length > 0) {
            group.children.every((child) => {
              if (
                child.actionId &&
                child.actionId === combine &&
                !group.checkedPermissions.includes(combine)
              ) {
                group.checkedPermissions.push(combine)

                return true
              }

              if (child.children && child.children.length > 0) {
                child.children.every((aclItem) => {
                  if (
                    aclItem.actionId &&
                    aclItem.actionId === combine &&
                    !group.checkedPermissions.includes(combine)
                  ) {
                    group.checkedPermissions.push(combine)

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
    },
  },
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