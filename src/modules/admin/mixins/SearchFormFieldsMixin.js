const SearchFormFieldsMixin = {
  data () {
    return {
      searchFields: false
    }
  },
  methods: {
    buildRouteQuery (query) {
      return this.searchFields !== false ? query : Object.assign({}, query, { withSearchFields: true })
    },
    setSearchFields (searchFields) {
      if (this.searchFields === false) {
        this.searchFields = searchFields || null
      }
    }
  }
}

export default SearchFormFieldsMixin
