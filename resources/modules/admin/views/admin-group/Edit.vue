<template>
  <div class="box">
    <div class="box-header">
      <h4>{{ title }}</h4>
    </div>
    <el-form :rules="rules" :model="adminGroupFrom" label-width="120px"
             ref="adminGroupFrom"
             @submit.native.prevent="submitForm('adminGroupFrom')">
      <el-form-item label="管理组名称">
        <el-input v-model="adminGroupFrom.name"></el-input>
      </el-form-item>
      <el-form-item label="管理组权限">
        <div class="check-group-box">
          <div class="cgb-panel" v-for="(group, index) in adminGroupFrom.acl" :key="index">
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
        <el-button type="primary" native-type="submit" :loading="submitLoading">{{ title }}</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
  export default {
    metaInfo() {
      return {
        title: this.title
      }
    },
    data() {
      return {
        title: '新建管理组',
        submitLoading: false,
        rules: {
          name: [
            { required: true, message: '请输入管理组名称', trigger: 'blur' }
          ]
        },
        adminGroupFrom: {
          name: '',
          acl: []
        },
        postUrl: 'admin-group/create',
        postParams: {}
      }
    },
    created() {
      const apiQueries = [this.$http.get('site/all-acl')]

      if (this.$route.query.id) {
        apiQueries.push(this.$http.get('admin-group/edit', { id: this.$route.query.id }))
      }

      this.$http.all(apiQueries).then(this.$http.spread((allAclResponse, adminGroupResponse) => {
        if (adminGroupResponse) {
          this.title = '编辑管理组'
          this.postUrl = 'admin-group/edit'
          this.postParams = { id: adminGroupResponse.data.id }
          this.adminGroupFrom = adminGroupResponse.data
        }

        const allAcl = allAclResponse.data
        const adminGroupAcl = this.adminGroupFrom.acl
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

        this.adminGroupFrom.acl = result
      }))
    },
    methods: {
      handleCheckAllChange(group) {
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
            name: this.adminGroupFrom.name,
            acl: []
          }

          this.adminGroupFrom.acl.forEach(group => {
            group.checkedAcl.forEach(acl => {
              adminGroup.acl.push(acl)
            })
          })

          this.$http.post(this.postUrl, adminGroup, this.postParams).then(response => {
            this.$message.success(response.data.message)

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
      border-bottom: 1px solid #dcdfe6;
      margin-bottom: 10px;
      padding-bottom: 3px;

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
