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
    handleViolationError: function (error, formName) {
      if (!error) {
        return
      }

      if (!error.response.status || error.response.status !== 422) {
        return
      }

      if (Array.isArray(error.response.data.violations)) {
        this.violations = error.response.data.violations
      }

      if (Array.isArray(error.response.data)) {
        this.violations = error.response.data
      }

      this.$refs[formName].$children.forEach((child) => {
        let activeViolation = null

        this.violations.forEach(violation => {
          if (child.prop === violation.field) {
            activeViolation = violation
          }
        })

        if (activeViolation) {
          child.$data.validateMessage = activeViolation.message
          child.$data.validateState = activeViolation.message ? 'error' : 'success'
        } else {
          child.$data.validateMessage = ''
          child.$data.validateState = 'success'
        }
      })
    }
  }
}

export default UnauthorizedHttpCodeMixin
