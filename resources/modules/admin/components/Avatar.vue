<template>
    <span class="bp-avatar">
      <img alt="头像" v-if="avatar && avatar.length > 0" :src="avatar">
      <img alt="头像" v-else src="../assets/images/avatar.png">
    </span>
</template>

<script>
  export default {
    name: 'BpAvatar',
    props: ['avatar']
  }
</script>

<style lang="scss">
  .bp-avatar {
    height: 32px;
    display: inline-block;

    img {
      border-radius: 50%;
      height: 32px;
      vertical-align: middle;
    }
  }
</style>
