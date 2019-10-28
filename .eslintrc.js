module.exports = {
  root: true,

  env: {
    browser: true,
    node: true,
    es6: true
  },

  plugins: [
    'vue'
  ],

  parserOptions: {
    parser: 'babel-eslint',
    sourceType: 'module'
  },

  'extends': [
    'plugin:vue/recommended',
    '@vue/standard'
  ]
}
