const RouteBackMixin = {
  methods: {
    async routeBack(closeTab = false) {
      if (closeTab) {
        this.$store
          .dispatch('tabs/close', { path: this.$route.path })
          .then((next) => {
            this.routeReplace(next)
          })
      } else {
        this.routeReplace({ path: '/home' })
      }
    },
    routeReplace(route) {
      if (this.$routerHistory.hasPrevious()) {
        this.$router.replace(this.$routerHistory.previous())
      } else {
        this.$router.replace(route)
      }
    },
  },
}

export default RouteBackMixin
