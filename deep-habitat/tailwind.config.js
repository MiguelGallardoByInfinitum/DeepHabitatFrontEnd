/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  darkMode: 'selector',
  theme: {
    colors: {
      primary: 'rgb(var(--color-primary))',
      primary2: 'rgb(var(--color-primary2))',
      primarySelection: 'rgb(var(--color-primarySelection))',
      secondary: 'rgb(var(--color-secondary))',
      tertiary: 'rgb(var(--color-tertiary))',
      light: 'rgb(var(--color-light))',
      dark: 'rgb(var(--color-dark))',
      gray: 'rgb(var(--color-gray))',
      primaryShaded: 'rgb(var(--color-primary-shaded))',
      error: 'rgb(var(--color-error))',
      created: 'rgb(var(--color-created))'
    },
    extend: {},
  },
  plugins: [],
}
