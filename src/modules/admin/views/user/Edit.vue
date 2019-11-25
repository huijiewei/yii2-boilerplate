<template>
    <div class="box">
        <div class="box-header">
            <h4>{{ pageTitle }}</h4>
        </div>
        <user-form
            v-if="user"
            :submit-text="pageTitle"
            :user="user"
            :is-edit="true"
            @on-submit="editUser"
        />
        <placeholder-form v-else />
    </div>
</template>

<script>
import flatry from "@core/utils/flatry";
import PlaceholderForm from "@core/components/Placeholder/PlaceholderForm";
import UserForm from "@admin/views/user/_EditForm";
import UserService from "@admin/services/UserService";

export default {
    components: { UserForm, PlaceholderForm },
    data() {
        return {
            pageTitle: "编辑会员",
            user: null
        };
    },
    async created() {
        const { data } = await flatry(
            UserService.edit(this.$router.currentRoute.query.id)
        );

        if (data) {
            this.user = data;
        }
    },
    methods: {
        async editUser(user, done, fail, always) {
            const { data, error } = await flatry(
                UserService.edit(user.id, user)
            );

            if (data) {
                this.$message.success(data.message);
                done();
            }

            if (error) {
                fail(error);
            }

            always();
        }
    }
};
</script>
