/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.{html,js,vue}"],
  theme: {
    extend: {
      colors: {
        'primary-black': '#100F0F',
        'primary-white': '#fafafa',
        'secondary-black': '#363537',
        'secondary-white': '#fcfcfa'
      }
    },
  },
  plugins: [],
}

