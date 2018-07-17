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
    return ''
  }

  if (url.endsWith('/index')) {
    return url.substr(0, url.length - 6)
  }

  return url
}
