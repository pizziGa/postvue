/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.{html,js,vue}"],
  theme: {
    extend: {
      colors: {
        'primary-black': '#100F0F',
        'primary-white': '#fafafa',
        'secondary-black': '#363537',
        'secondary-white': '#fcfcfa',
        'mantis': '#288739',
        'dark-pastel-green': '#30B348',
        'night': '#161717',
        'timberwolf': '#D5D5D5',
        'nightmare': '#0A0A0A'
      }
    },
  },
  plugins: [],
}

