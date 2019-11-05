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
              @change="handleCheckAllChange(group)"
            />
          </div>
          <div class="cgb-body">
            <el-checkbox-group
              v-model="group.checkedAcl"
              v-same-width
              @change="handleCheckedAclChange(group)"
            >
              <template v-for="(child, childIndex) in group.children">
                <el-checkbox
                  v-if="!child.children"
                  :key="index + '-' + childIndex"
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
                    :label="checkbox.actionId"
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
import AdminGroupService from '@admin/services/AdminGroupService'
import UnprocessableEntityHttpErrorMixin from '@admin/mixins/UnprocessableEntityHttpErrorMixin'

export default {
  name: 'AdminGroupForm',
  directives: {
    sameWidth: {
      inserted: function (el) {
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
      allAcl: []
    }
  },
  async mounted () {
    this.formModel = {
      id: this.adminGroup.id,
      name: this.adminGroup.name,
      acl: []
    }

    const { data } = await flatry(AdminGroupService.acl())

    if (data) {
      this.allAcl = data
    }

    const adminGroupAcl = this.adminGroup.acl
    const result = []

    this.allAcl.forEach(acl => {
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
            if (adminGroupAcl.includes(item.actionId)) {
              group.checkedAcl.push(item.actionId)
            }
          })
        } else {
          group.aclCount++
          if (adminGroupAcl.includes(child.actionId)) {
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
          acl: []
        }

        this.formModel.acl.forEach(group => {
          group.checkedAcl.forEach(acl => {
            adminGroup.acl.push(acl)
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
    handleCheckAllChange (group) {
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
    handleCheckedAclChange (group) {
      const checkedCount = group.checkedAcl.length

      group.checkAll = group.aclCount === checkedCount
      group.checkIndeterminate = checkedCount > 0 && checkedCount < group.aclCount
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
