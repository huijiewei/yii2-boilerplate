const UnprocessableEntityHttpErrorMixin = {
  data() {
    return {
      violations: [],
    }
  },
  methods: {
    clearViolationError(formName) {
      this.$refs[formName].$children.forEach((child) => {
        child.$data.validateMessage = ''
        child.$data.validateState = 'success'
      })
    },
    handleViolationError(error, formName) {
      if (
        !error ||
        !error.response ||
        !error.response.status ||
        error.response.status !== 422
      ) {
        return
      }

      if (Array.isArray(error.response.data.violations)) {
        this.violations = error.response.data.violations
      }

      if (Array.isArray(error.response.data)) {
        this.violations = error.response.data
      }

      if (this.violations.length === 0) {
        return
      }

      this.$refs[formName].$children.forEach((child) => {
        if (child.prop) {
          const childProp = child.prop && child.prop.split('.')[0]

          const activeViolation = this.violations.find((violation) => {
            const violationFieldPath = violation.field.split('.')

            return childProp === violationFieldPath.pop()
          })

          if (activeViolation) {
            child.$data.validateMessage = activeViolation.message
            child.$data.validateState = activeViolation.message
              ? 'error'
              : 'success'
          } else {
            child.$data.validateMessage = ''
            child.$data.validateState = 'success'
          }
        }
      })
    },
  },
}

export default UnprocessableEntityHttpErrorMixin
