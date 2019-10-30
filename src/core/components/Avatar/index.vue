<template>
  <span class="ag-avatar">
    <img
      v-if="avatar && avatar.length > 0"
      alt="头像"
      :src="avatar"
    >
    <img
      v-else
      alt="头像"
      src="../../assets/images/avatar.png"
    >
  </span>
</template>

<script>
export default {
  name: 'AgAvatar',
  props: {
    avatar: {
      type: String,
      default: ''
    }
  }
}
</script>

<style lang="scss">
  .ag-avatar {
    height: 32px;
    display: inline-block;

    img {
      border-radius: 50%;
      height: 32px;
      vertical-align: middle;
    }
  }
</style>
