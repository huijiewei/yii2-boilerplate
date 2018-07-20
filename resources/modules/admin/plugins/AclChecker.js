const AclChecker = {
  install(Vue, { store }) {
    const can = (actionId) => {
      return store.getters['auth/isRouteInAcl'](actionId)
    }

    Vue.directive('can', {
      componentUpdated(el, binding) {
        if (!can(binding.value)) {
          el.parentNode && el.parentNode.removeChild(el)
        }
      }
    })

    Vue.prototype.$can = can
  }
}

module.exports = AclChecker
