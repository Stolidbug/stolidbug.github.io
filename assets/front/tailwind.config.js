const Encore = require('@symfony/webpack-encore');
const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
  content: [
    './public/**/*.html',
  ],
  theme: {
    extend: {
      maxWidth: {
        'prose': '70ch',
      },
      fontFamily: {
        sans: ['Inter var', ...defaultTheme.fontFamily.sans],
      },
      colors: {
        green: '#015f5a',
        orange: '#FFAF38',
        'dark-orange': '#f0a638',
        blue: '#abd1c6',
        white: '#fffffe',
        black: '#001e1d',
        brown: '#996A23',
      },
      backgroundImage: {
        'circle': "url('./images/circle.svg')",
      },
      backgroundSize: {
        '80': '80%',
      },
      screens: {
        '4xl': '2000px',
      },
    },
  },
  variants: {},
  corePlugins: {},
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
    require('@tailwindcss/aspect-ratio'),
  ],
  purge: Encore.isProduction(),
}