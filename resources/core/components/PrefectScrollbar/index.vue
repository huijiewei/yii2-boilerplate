<template>
  <div ref="ps" class="ps-container" @ps-scroll-y="scrollHandler" @ps-scroll-x="scrollHandler"
       @ps-scroll-up="scrollHandler"
       @ps-scroll-down="scrollHandler" @ps-scroll-left="scrollHandler" @ps-scroll-right="scrollHandler"
       @ps-y-reach-start="scrollHandler" @ps-y-reach-end="scrollHandler" @ps-x-reach-start="scrollHandler"
       @ps-x-reach-end="scrollHandler">
    <slot></slot>
  </div>
</template>

<script>
  import PrefectScrollbar from 'perfect-scrollbar'

  export default {
    name: 'PrefectScrollbar',
    props: {
      settings: {
        type: Object,
        default: () => ({})
      },
      scrollTo: {
        type: String,
        default: ''
      }
    },
    methods: {
      scrollHandler(event) {
        this.$emit(event.type, event)
      },
      update() {
        this.ps.update()
      }
    },
    mounted() {
      this.ps = new PrefectScrollbar(this.$el, Object.assign(this.settings, { wheelPropagation: false }))

      this.$nextTick(() => {
        if (this.scrollTo !== '') {
          console.log(this.scrollTo)
          console.log(this.$el)

          const element = this.$refs.ps.querySelectorAll('li')

          console.log(element)

          if (element) {
            const elementPos = element.getBoundingClientRect()
            const containerPos = this.$el.getBoundingClientRect()

            console.log(elementPos, containerPos)
          }
        }
      })
    },
    updated() {
      this.update()
    },
    beforeDestroy() {
      this.ps.destroy()
      this.ps = null
    }
  }
</script>

<style lang="scss">
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
