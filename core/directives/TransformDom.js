const TransformDom = {
  inserted: function (el, bindings) {
    const container = bindings.arg
      ? document.getElementById(bindings.arg)
      : document.body

    if (container) {
      bindings.modifiers.prepend && container.firstChild
        ? container.insertBefore(el, container.firstChild)
        : container.appendChild(el)
    }
  },

  unbind: function (el) {
    if (el.parentNode) {
      el.parentNode.removeChild(el)
    }
  },
}

export default TransformDom
