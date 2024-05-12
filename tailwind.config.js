/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./**/*.{html,php}", "./node_modules/flowbite/**/*.js"],

  theme: {
    extend: {},
  },
  plugins: [require("flowbite/plugin")],
};
