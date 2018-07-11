<template>
  <div class="error-view">
    <div class="error-wrap">
      <div class="error-message">
        <h3>404</h3>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'Error'
  }
</script>
<style lang="scss">
  .error-view {
    width: 100%;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f4f8fb;

    .error-wrap {
      border-radius: 2px;
      background: #fff;
      padding: 15px 35px;
      width: 300px;
      box-shadow: 0 4px 23px 0 rgba(0, 0, 0, 0.09);
      text-align: center;
    }
  }
</style>
