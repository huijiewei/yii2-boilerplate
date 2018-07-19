<template>
  <div class="spinner-wrap">
    <div class="spinner-stretch">
      <div class="rect1"></div>
      <div class="rect2"></div>
      <div class="rect3"></div>
      <div class="rect4"></div>
      <div class="rect5"></div>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'StretchSpinner'
  }
</script>

<style lang="scss">
  .spinner-stretch {
    margin: 0 auto;
    width: 50px;
    height: 40px;
    font-size: 10px;

    & > div {
      background-color: #2196f3;
      height: 100%;
      width: 6px;
      display: inline-block;
      -webkit-animation: sk-stretchdelay 1.2s infinite ease-in-out;
      animation: sk-stretchdelay 1.2s infinite ease-in-out;
    }

    .rect2 {
      -webkit-animation-delay: -1.1s;
      animation-delay: -1.1s;
    }

    .rect3 {
      -webkit-animation-delay: -1s;
      animation-delay: -1s;
    }

    .rect4 {
      -webkit-animation-delay: -0.9s;
      animation-delay: -0.9s;
    }

    .rect5 {
      -webkit-animation-delay: -0.8s;
      animation-delay: -0.8s;
    }
  }
</style>
