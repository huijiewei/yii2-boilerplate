const UnprocessableEntityHttpErrorMixin = {
  data() {
    return {
      violations: []
    };
  },
  methods: {
    handleViolationError(error, formName) {
      if (!error) {
        return;
      }

      if (!error.response.status || error.response.status !== 422) {
        return;
      }

      if (Array.isArray(error.response.data.violations)) {
        this.violations = error.response.data.violations;
      }

      if (Array.isArray(error.response.data)) {
        this.violations = error.response.data;
      }

      if (this.violations.length === 0) {
        return;
      }

      this.$refs[formName].$children.forEach(child => {
        let activeViolation = null;

        this.violations.forEach(violation => {
          const violationFieldPath = violation.field.split(".");
          if (child.prop === violationFieldPath.pop()) {
            activeViolation = violation;
          }
        });

        if (activeViolation) {
          child.$data.validateMessage = activeViolation.message;
          child.$data.validateState = activeViolation.message
            ? "error"
            : "success";
        } else {
          child.$data.validateMessage = "";
          child.$data.validateState = "success";
        }
      });
    }
  }
};

export default UnprocessableEntityHttpErrorMixin;
