const SameWidth = {
  inserted: function(el, binding) {
    const itemList = el.getElementsByClassName(binding.value)

    if (itemList.length < 2) {
      return
    }

    let maxWidth = 0

    for (const item of itemList) {
      const width = item.offsetWidth

      if (width > maxWidth) {
        maxWidth = width
      }
    }

    for (const item of itemList) {
      item.style.width = maxWidth + 2 + 'px'
    }
  }
}

export default SameWidth
