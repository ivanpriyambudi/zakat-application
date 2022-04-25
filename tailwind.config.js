// eslint-disable-next-line no-undef
const colors = require('tailwindcss/colors')

module.exports = {
  important: true,
  purge: {
    content: [
      './resources/**/*.html',
      './resources/**/*.js',
      './resources/**/*.jsx',
      './resources/**/*.ts',
      './resources/**/*.tsx',
      './resources/**/*.php',
      './resources/**/*.vue',
      './resources/**/*.twig',
    ],
    options: {
      defaultExtractor: content => content.match(/[\w-/.:]+(?<!:)/g) || [],
      whitelistPatterns: [/-active$/, /-enter$/, /-leave-to$/, /show$/],
    },
  },
  prefix: 'tw-',
  darkMode: false,
  theme: {
    colors: {
      primary: '#5865F2',
      primary_dark: 'rgb(65 76 190)',
      transparent: 'transparent',
      current: 'currentColor',
      black: colors.black,
      white: colors.white,
      gray: colors.trueGray,
      indigo: colors.indigo,
      red: colors.rose,
      yellow: colors.amber,
      header: '#f5f7fa',
    },
  },
  variants: {
    extend: {},
  },
  plugins: [],
}
