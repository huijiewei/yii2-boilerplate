<template>
  <el-form :rules="formRules" :model="formModel" label-width="120px"
           ref="formModel" :validate-on-rule-change="false" v-loading="loading"
           @submit.native.prevent="submitForm('formModel')">
    <el-form-item label="管理组名称" prop="name">
      <el-input v-model="formModel.name"></el-input>
    </el-form-item>
    <el-form-item label="管理组权限">
      <div class="check-group-box">
        <div class="cgb-panel" v-for="(group, index) in formModel.acl" :key="index">
          <div class="cgb-head">
            <el-checkbox :label="group.name" v-model="group.checkAll"
                         :indeterminate="group.checkIndeterminate"
                         @change="handleCheckAllChange(group)"></el-checkbox>
          </div>
          <div class="cgb-body">
            <el-checkbox-group v-model="group.checkedAcl" @change="handleCheckedAclChange(group)">
              <template v-for="(child, childIndex) in group.children">
                <el-checkbox v-if="!child.children" :label="child.actionId"
                             :key="index + '-' + childIndex">
                  {{ child.name }}
                </el-checkbox>
                <div class="cgb-line" v-if="child.children" :key="index + '-' + childIndex">
                  <el-checkbox v-for="(checkbox, checkboxIndex) in child.children" :label="checkbox.actionId"
                               :key="index + '-' + childIndex + '-' + checkboxIndex">
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
      <el-button type="primary" native-type="submit" :loading="submitLoading">{{ buttonText }}</el-button>
    </el-form-item>
  </el-form>
</template>

<script>
  export default {
    name: 'AdminGroupForm',
    props: ['buttonText', 'apiUrl', 'apiParams'],
    data() {
      return {
        loading: true,
        submitLoading: false,
        formRules: {
          name: [
            { required: true, message: '请输入管理组名称', trigger: 'blur' },
            { min: 3, max: 10, message: '管理组名称长度在 3 到 10 个字符', trigger: 'blur' }
          ]
        },
        formModel: {
          name: '',
          acl: []
        }
      }
    },
    created() {
      this.$http.get(this.apiUrl, this.apiParams).then(response => {
        if (response.data.adminGroup) {
          this.formModel = response.data.adminGroup
        }

        const allAcl = response.data.allAcl

        const adminGroupAcl = this.formModel.acl
        const result = []

        allAcl.forEach(acl => {
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
      }).catch(() => {
      }).finally(() => {
        this.loading = false
      })
    },
    methods: {
      handleCheckAllChange(group) {
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
      handleCheckedAclChange(group) {
        const checkedCount = group.checkedAcl.length

        group.checkAll = group.aclCount === checkedCount
        group.checkIndeterminate = checkedCount > 0 && checkedCount < group.aclCount
      },
      submitForm(formName) {
        this.$refs[formName].validate((valid) => {
          if (!valid) {
            return false
          }

          this.submitLoading = true

          const adminGroup = {
            name: this.formModel.name,
            acl: []
          }

          this.formModel.acl.forEach(group => {
            group.checkedAcl.forEach(acl => {
              adminGroup.acl.push(acl)
            })
          })

          this.$http.post(this.apiUrl, adminGroup, this.apiParams).then(response => {
            this.$message.success(response.data.message)

            this.$emit('on-success', response.data)
          }).catch(() => {
          }).finally(() => {
            this.submitLoading = false
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
