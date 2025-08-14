/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  theme: {
    extend: {
        colors:{
            orangeBtn: '#B29100',
            orangeHoverBtn: '#735e01',
            redPhoto: '#7A1719',
            cream: '#B78456',
            gold: '#c48e34',
            gold2: '#e8b349'
          },
          fontWeight: {
            'custom': '1000', // Menambahkan font-weight 450
          }
    },
    fontFamily: {
        elMessiri: ['"El Messiri"', 'sans-serif']
      },
  },
  plugins: [],
}

