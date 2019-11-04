const UnauthorizedHttpCodeMixin = {
  data () {
    return {
      violations: []
    }
  },
  computed: {
    getFieldErrorMessage () {
      return (fieldName) => {
        const violation = this.violations.find(function (violation) {
          return violation.field === fieldName
        })

        if (violation) {
          return violation.message
        }

        return ''
      }
    }
  },
  methods: {
    handleError: function (error) {
      if (error) {
        if (error.response.status === 422) {
          if (error.response.data.violations) {
            this.violations = error.response.data.violations
          }

          if (Array.isArray(error.response.data)) {
            this.violations = error.response.data
          }
        }
      }
    }
  }
}

export default UnauthorizedHttpCodeMixin
