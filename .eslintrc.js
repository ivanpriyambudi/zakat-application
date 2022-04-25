// eslint-disable-next-line no-undef
module.exports = {
  extends: ['eslint:recommended', 'plugin:vue/vue3-recommended'],
  // rules: {
  //     // override/add rules settings here, such as:
  //     // 'vue/no-unused-vars': 'error'
  // },
  rules: {
    'indent': ['error', 2],
    'quotes': ['warn', 'single'],
    'semi': ['warn', 'never'],
    'comma-dangle': ['warn', 'always-multiline'],
    'no-console': 'off',
    'no-undef': 'off',
  },
}
