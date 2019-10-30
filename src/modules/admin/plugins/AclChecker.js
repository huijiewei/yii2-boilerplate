const AclChecker = {
  install (Vue, { store }) {
    Vue.prototype.$can = (actionId) => {
      return store.getters['auth/isRouteInAcl'](actionId)
    }
  }
}

module.exports = AclChecker
