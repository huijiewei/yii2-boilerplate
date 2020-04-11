const SearchFormFieldsMixin = {
  data() {
    return {
      searchFields: false,
    }
  },
  methods: {
    buildRouteQuery(query) {
      return this.searchFields !== false
        ? query
        : Object.assign({}, query, { withSearchFields: true })
    },
    setSearchFields(searchFields) {
      if (searchFields) {
        this.searchFields = searchFields || []
      }
    },
  },
}

export default SearchFormFieldsMixin
