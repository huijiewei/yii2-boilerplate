<template>
  <div class="error-view">
    <div class="error-wrap">
      <div class="error-message">
        <h2>
          <img alt="Not Found" src="../../assets/images/logo.png" />
        </h2>
        <h3>404</h3>
        <p>页面不存在</p>
        <p>
          <el-button type="primary" size="small" @click="back">
            返回
          </el-button>
        </p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'NotFound',
  inject: ['historyBack'],
  methods: {
    back() {
      this.historyBack(null, false, true)
    },
  },
}
</script>
<style lang="less">
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
    padding: 25px 35px;
    width: 300px;
    box-shadow: 0 4px 23px 0 rgba(0, 0, 0, 0.09);
    text-align: center;

    .error-message {
      h2 {
        margin-top: 0;
        margin-bottom: 15px;

        img {
          height: 50px;
        }
      }

      h3 {
        margin-top: 0;
        margin-bottom: 15px;
      }
    }
  }
}
</style>
