export const deepSearch = (needle, haystack, found = []) => {
  Object.keys(haystack).forEach((key) => {
    if (key === needle) {
      found.push(haystack[key])
      return found
    }
    if (typeof haystack[key] === 'object') {
      deepSearch(needle, haystack[key], found)
    }
  })
  return found
}

export const formatUrl = (url) => {
  if (url === 'site/index') {
    return 'home'
  }

  if (url.endsWith('/index')) {
    return url.substr(0, url.length - 6)
  }

  return url
}

export const tabledObject = (object, options = []) => {
  const result = []

  Object.entries(object).forEach(([key, value]) => {
    const option = options.find((option) => {
      return option.property === key
    })

    if (option) {
      if (option.callback) {
        result.push({ name: option.name, value: option.callback(value) })
      } else {
        result.push({ name: option.name, value: value })
      }
    } else {
      result.push({ name: key, value: value })
    }
  })

  return result
}
