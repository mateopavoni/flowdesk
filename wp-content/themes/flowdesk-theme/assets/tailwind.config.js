/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    '../**/*.php',
    // El plugin (case studies, testimonios, pricing) usa clases de Tailwind
    // en su propio PHP — sin este path, esas clases nunca se compilan
    // (verificado a mano: el carrusel de testimonios no scrolleaba porque
    // overflow-x-auto no existía en el CSS final).
    '../../../plugins/flowdesk-toolkit/**/*.php',
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Inter', 'system-ui', 'sans-serif'],
        heading: ['Poppins', 'system-ui', 'sans-serif'],
      },
      // #1e3a8a / #3b82f6 del brief son, hex por hex, blue-900/blue-500 de la
      // paleta default de Tailwind — no hace falta declarar colores custom.
    },
  },
  plugins: [],
};
