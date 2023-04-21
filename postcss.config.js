let tailwindcss = require('tailwindcss');

module.exports = {
  plugins: [
    tailwindcss('./assets/frontend/tailwind.config.js'),
    require('autoprefixer'),
  ]
}
