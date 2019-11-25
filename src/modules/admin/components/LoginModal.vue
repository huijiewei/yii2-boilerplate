<template>
    <el-dialog
        title="管理员登陆"
        width="320px"
        :center="true"
        :append-to-body="true"
        :close-on-click-modal="false"
        :show-close="false"
        :close-on-press-escape="false"
        :visible="visible"
    >
        <login-form @on-success="loginSuccess" />
    </el-dialog>
</template>

<script>
import LoginForm from "@admin/components/LoginForm";
import flatry from "@core/utils/flatry";

export default {
    name: "LoginModal",
    components: { LoginForm },
    props: {
        visible: {
            type: Boolean,
            default: false
        }
    },
    methods: {
        async loginSuccess() {
            await flatry(this.$store.dispatch("auth/hideLoginModal"));
        }
    }
};
</script>
