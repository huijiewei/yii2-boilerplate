const childrenSameWidth = function (el, childClassName) {
  if (el.dataset.sameWidth === 'DONE') {
    return
  }

  const items = el.getElementsByClassName(childClassName)

  if (items.length < 2) {
    return
  }

  let maxWidth = 0

  for (const item of items) {
    const width = item.offsetWidth

    if (width > maxWidth) {
      maxWidth = width
    }
  }

  for (const item of items) {
    item.style.width = maxWidth + 2 + 'px'
  }

  el.dataset.sameWidth = 'DONE'
}

const SameWidth = {
  inserted: function (el, binding) {
    childrenSameWidth(el, binding.value)
  },
  componentUpdated: function (el, binding) {
    childrenSameWidth(el, binding.value)
  },
}

export default SameWidth
