/** @type {import('tailwindcss').Config} */
export default {
  content: ["./index.html", "./src/**/*.{vue,js,ts,jsx,tsx}"],
  theme: {
    extend: {
      colors: {
        adminBackground: "#F5F6FA",
      },
    },
  },
  plugins: [],
};
