/** @type {import('tailwindcss').Config} */

const color = require('tailwindcss/colors')
module.exports = {
  content: [
      "./public/**/*.{html,php,js}",
      "./src/**/*.{html,php,js}"
  ],
  theme: {
    extend: {
      fontFamily: {
        "inter": ['Inter', 'sans-serif']
      }
    },
    colors: {
      'brand': {
        25: '#FCFAFF',
        50: '#F9F5FF',
        100: '#F4EBFF',
        200: '#E9D7FE',
        300: '#D6BBFB',
        400: '#B692F6',
        500: '#9E77ED',
        600: '#7F56D9',
        700: '#6941C6',
        800: '#53389E',
        900: '#42307D',
      },
      'error': {
        25: '#FFFBFA',
        50: '#FEF3F2',
        100: '#FEE4E2',
        200: '#FECDCA',
        300: '#FDA29B',
        400: '#F97066',
        500: '#F04438',
        600: '#D92D20',
        700: '#B42318',
        800: '#912018',
        900: '#7A271A',
      },
      'success': {
        25: '#F6FEF9',
        50: '#ECFDF3',
        100: '#D1FADF',
        200: '#A6F4C5',
        300: '#6CE9A6',
        400: '#32D583',
        500: '#12B76A',
        600: '#039855',
        700: '#027A48',
        800: '#05603A',
        900: '#054F31',
      },
      'warning': {
        25: '#FFFCF5',
        50: '#FFFAEB',
        100: '#FEF0C7',
        200: '#FEDF89',
        300: '#FEC84B',
        400: '#FDB022',
        500: '#F79009',
        600: '#DC6803',
        700: '#B54708',
        800: '#93370D',
        900: '#7A2E0E',
      },
      'blue-light': {
        25: '#F5FBFF',
        50: '#F0F9FF',
        100: '#E0F2FE',
        200: '#B9E6FE',
        300: '#7CD4FD',
        400: '#36BFFA',
        500: '#0BA5EC',
        600: '#0086C9',
        700: '#026AA2',
        800: '#065986',
        900: '#0B4A6F',
      },
      black: color.black,
      gray: color.gray,
      white: color.white,
      slate: color.slate
    }
  },
  plugins: [],
}

