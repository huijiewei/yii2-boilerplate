module.exports = {
  root: true,
  env: {
    browser: true,
    node: true,
    es6: true
  },
  extends: [
    'eslint:recommended',
    'plugin:vue/essential'
  ],
  plugins: [
    'vue'
  ],
  parserOptions: {
    parser: 'babel-eslint',
    sourceType: 'module'
  },
  rules: {
    'no-console': 'off',
    'indent': 'off',
    'linebreak-style': [
      'error',
      'unix'
    ],
    'quotes': [
      'error',
      'single'
    ],
    'block-spacing': [
      'warn',
      'always'
    ],
    'semi': [
      'error',
      'never'
    ],
    'vue/script-indent': [
      'warn',
      2,
      {
        'baseIndent': 1
      }
    ]
  }
}
