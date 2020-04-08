const PermissionCheck = {
  install(Vue, { store }) {
    Vue.prototype.$can = (actionId) => {
      return store.getters['auth/isRouteInAcl'](actionId)
    }
  },
}

module.exports = PermissionCheck
