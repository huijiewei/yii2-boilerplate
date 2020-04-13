const TransformDom = {
  inserted: function (el, bindings, vnode) {
    const container = bindings.arg
      ? document.getElementById(bindings.arg)
      : document.body

    if (container) {
      bindings.modifiers.prepend && container.firstChild
        ? container.insertBefore(el, container.firstChild) // top of target
        : container.appendChild(el) // bottom of target
    } else {
      console.warn(
        'v-' + name + ' target element id "' + bindings.arg + '" not found.'
      )
    }
  },

  unbind: function (el) {
    if (el.parentNode) {
      el.parentNode.removeChild(el)
    }
  },
}

export default TransformDom
