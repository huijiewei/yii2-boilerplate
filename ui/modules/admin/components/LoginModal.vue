<template>
  <el-dialog
    title="管理员登陆"
    width="320px"
    :center="true"
    :append-to-body="true"
    :close-on-click-modal="false"
    :show-close="false"
    :close-on-press-escape="false"
    :visible="true"
  >
    <login-form />
  </el-dialog>
</template>

<script>
import LoginForm from '@admin/components/LoginForm'

export default {
  name: 'LoginModal',
  components: { LoginForm },
}
</script>
