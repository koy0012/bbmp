/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./public/**/*.js",
    "./resources/**/*.vue",
    "./node_modules/flowbite/**/*.js"
  ],
  theme: {
    extend: {
      fontFamily: {
        body: [
          "Inter",
          "ui-sans-serif",
          "system-ui",
          "-apple-system",
          "Segoe UI",
          "Roboto",
          "Helvetica Neue",
          "Arial",
          "Noto Sans",
          "sans-serif",
          "Apple Color Emoji",
          "Segoe UI Emoji",
          "Segoe UI Symbol",
          "Noto Color Emoji"
        ],
        'sans': [
          'Inter',
          'ui-sans-serif',
          'system-ui',
          // other fallback fonts
        ]
      }
    },
  },
  plugins: [
    require("daisyui"),
    require('flowbite/plugin')({
      charts: true
    })
  ],
  daisyui: {
    themes: [
      {
        "uptown": {
          ...require("daisyui/src/theming/themes")["lofi"],
          'success': 'rgb(41,37,36)',
          'base-300': '#D92938',
          'base-content': '#222',
          'info': '#008',
          'secondary': '#1C2326'
        }
      }
    ]
  }
}

