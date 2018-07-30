const SearchFieldsMixin = {
  data() {
    return {
      searchFields: false
    }
  },
  methods: {
    buildRouteQuery: function(query) {
      return this.searchFields !== false ? query : Object.assign({}, query, { searchFields: true })
    },
    setSearchFields: function(searchFields) {
      if (this.searchFields === false) {
        this.searchFields = searchFields ? searchFields : null
      }
    }
  }
}

export default SearchFieldsMixin
