const SearchFieldsMixin = {
  data () {
    return {
      searchFields: false
    }
  },
  methods: {
    buildRouteQuery (query) {
      return this.searchFields !== false ? query : Object.assign({}, query, { searchFields: true })
    },
    setSearchFields (searchFields) {
      if (this.searchFields === false) {
        this.searchFields = searchFields || null
      }
    }
  }
}

export default SearchFieldsMixin
