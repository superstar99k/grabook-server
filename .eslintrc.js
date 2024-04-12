module.exports = {
  root: true,
  env: {
    browser: true,
    node: true,
  },
  parserOptions: {
    ecmaVersion: 11,
  },
  ignorePatterns: ['node_modules/', 'public/'],
  extends: [
    'eslint:recommended',
    'plugin:vue/vue3-recommended',
    'prettier',
    'plugin:prettier/recommended',
    'plugin:prettier-vue/recommended',
  ],
  plugins: ['prettier'],
  // add your custom rules here
  rules: {
    'no-console': 'off',
    'vue/no-v-html': 'off',
    'standard/no-callback-literal': 'off',
    'vue/multi-word-component-names': 'off',
    'vue/component-name-in-template-casing': [
      'error',
      'kebab-case',
      {
        registeredComponentsOnly: true,
        ignores: [],
      },
    ],
    'object-shorthand': 'error',
    camelcase: ['error'],
    'vue/v-on-event-hyphenation': 'off',
    'vue/padding-line-between-blocks': 'error',
    'prefer-const': 'error',
    'dot-notation': 'error',
    'vue/attribute-hyphenation': 'error',
  },
}
