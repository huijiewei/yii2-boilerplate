<script>
export { default } from 'vue-context'
export { default as VueContext } from 'vue-context'
</script>

<style lang="scss">
.v-context {
  &,
  & ul {
    background-color: #ffffff;
    background-clip: padding-box;
    border-radius: 2px;
    border: 1px solid #ebeef5;
    box-shadow: 0 0 9px 1px rgba(69, 65, 78, 0.1);
    display: block;
    margin: 0;
    padding: 0;
    z-index: 1500;
    position: fixed;
    list-style: none;
    box-sizing: border-box;
    max-height: calc(100% - 50px);
    overflow-y: auto;

    > li {
      margin: 0;
      position: relative;

      > span {
        cursor: pointer;
        font-size: 13px;
        display: block;
        padding: 0 15px;
        line-height: 32px;
        height: 32px;
        color: #212529;
        text-decoration: none;
        white-space: nowrap;
        background-color: transparent;
        border: 0;

        &.disabled {
          color: #818a91;

          &:hover,
          &:focus {
            color: #818a91;
            text-decoration: none;
            cursor: not-allowed;
            background-color: transparent;
            background-image: none;
            filter: 'progid:DXImageTransform.Microsoft.gradient(enabled = false)';
          }
        }

        &:hover,
        &:focus {
          text-decoration: none;
          color: #66b1ff;
          background-color: #ecf5ff;
        }

        &:focus {
          outline: 0;
        }
      }
    }

    &:focus {
      outline: 0;
    }
  }

  &__sub {
    > span:after {
      content: '\2bc8';
      float: right;
      padding-left: 1rem;
    }

    > ul {
      display: none;
    }
  }
}
</style>
