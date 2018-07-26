<template>
    <span class="bp-avatar">
      <img v-if="avatar && avatar.length > 0" :src="avatar">
      <img v-else src="../assets/images/avatar.png">
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
    border-radius: 50%;

    img {
      height: 32px;
      vertical-align: middle;
    }
  }
</style>
