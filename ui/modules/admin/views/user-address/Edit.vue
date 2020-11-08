<template>
  <div class="box">
    <div class="box-header">
      <h4>{{ pageTitle }}</h4>
    </div>
    <user-address-form
      v-if="userAddress"
      :submit-text="pageTitle"
      :user-address="userAddress"
      :is-edit="true"
      @on-submit="editUserAddress"
    />
    <placeholder-form v-else />
  </div>
</template>

<script>
import PlaceholderForm from '@core/components/Placeholder/PlaceholderForm'
import UserAddressForm from '@admin/views/user-address/_EditForm'
import UserAddressService from '@admin/services/UserAddressService'

export default {
  name: 'UserAddressEdit',
  components: { UserAddressForm, PlaceholderForm },
  data() {
    return {
      pageTitle: '用户编辑',
      userAddress: null,
    }
  },
  inject: ['historyBack'],
  created() {
    this.getUserAddress(this.$route.params.id)
  },
  methods: {
    async getUserAddress(id) {
      this.userAddress = null

      const { data } = await UserAddressService.view(id)

      if (data) {
        this.userAddress = data
      }
    },
    async editUserAddress(userAddress, done, fail, always) {
      const { data, error } = await UserAddressService.edit(userAddress)

      if (data) {
        done()

        this.$message.success('用户地址编辑成功')

        await this.$store.dispatch('tabs/deleteCache', 'UserAddress')
        await this.historyBack('/user-address', false, true)
      }

      if (error) {
        fail(error)
      }

      always()
    },
  },
}
</script>
