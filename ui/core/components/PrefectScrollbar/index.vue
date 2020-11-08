<template>
  <div
    class="ps-container"
    @ps-scroll-y="scrollHandler"
    @ps-scroll-x="scrollHandler"
    @ps-scroll-up="scrollHandler"
    @ps-scroll-down="scrollHandler"
    @ps-scroll-left="scrollHandler"
    @ps-scroll-right="scrollHandler"
    @ps-y-reach-start="scrollHandler"
    @ps-y-reach-end="scrollHandler"
    @ps-x-reach-start="scrollHandler"
    @ps-x-reach-end="scrollHandler"
  >
    <slot />
  </div>
</template>

<script>
import PrefectScrollbar from 'perfect-scrollbar'

export default {
  name: 'PrefectScrollbar',
  props: {
    settings: {
      type: Object,
      default: () => ({}),
    },
  },
  mounted() {
    this.ps = new PrefectScrollbar(
      this.$el,
      Object.assign(this.settings, { wheelPropagation: false })
    )
  },
  updated() {
    this.$nextTick(() => {
      this.update()
    })
  },
  beforeDestroy() {
    this.ps.destroy()
    this.ps = null
  },
  methods: {
    scrollHandler(event) {
      this.$emit(event.type, event)
    },
    update() {
      this.ps.update()
    },
  },
}
</script>

<style lang="less">
@import '~perfect-scrollbar/css/perfect-scrollbar.css';

.ps-container {
  position: relative;

  .ps__rail-x {
    height: 6px;
  }

  .ps__rail-y {
    width: 6px;
  }

  .ps__thumb-x {
    background-color: #ddd;
    border-radius: 2px;
  }

  .ps__thumb-y {
    background: #ddd;
    border-radius: 2px;
    right: 0;
  }

  .ps__rail-x:hover,
  .ps__rail-y:hover,
  .ps__rail-x:focus,
  .ps__rail-y:focus,
  .ps__rail-x.ps--clicking,
  .ps__rail-y.ps--clicking {
    background-color: transparent;
  }

  .ps__rail-x:hover > .ps__thumb-x,
  .ps__rail-x:focus > .ps__thumb-x,
  .ps__rail-x.ps--clicking .ps__thumb-x {
    background-color: #ddd;
    height: 6px;
  }

  .ps__rail-y:hover > .ps__thumb-y,
  .ps__rail-y:focus > .ps__thumb-y,
  .ps__rail-y.ps--clicking .ps__thumb-y {
    background-color: #ddd;
    width: 6px;
  }
}
</style>
