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
        // Fraunces (serif con carácter propio, sentence case) para
        // headings; Public Sans (humanista, diseñada para legibilidad de
        // UI en tamaños chicos) para el cuerpo. Se mantienen las claves
        // 'sans'/'heading' que ya usa cada template.
        sans: ['"Public Sans"', 'ui-sans-serif', 'system-ui'],
        heading: ['"Fraunces"', 'serif'],
      },
      colors: {
        // Paleta propia "Ink & Paper": azul de marca + blanco cálido.
        // A propósito NO pisa blue/slate/red/green default de Tailwind
        // (eso fue lo que causó el bug real de bg-slate-50 renderizando
        // casi negro en el rediseño anterior) — tokens con nombre propio,
        // los defaults de Tailwind se comportan normal en todo el theme.
        brand: {
          100: '#E7ECFB',
          500: '#6C87E8',
          700: '#2451D6',
          900: '#16213E',
        },
        paper: {
          DEFAULT: '#FAF8F3',
          100: '#F1ECE1',
        },
        ink: {
          400: '#8892A0',
          600: '#4B5768',
          900: '#1A2233',
        },
        line: '#E1DAC9',
        // Único acento cálido, uso puntual (badges), nunca como texto de
        // cuerpo: contraste insuficiente sobre paper para eso.
        accent: '#DD6B4C',
      },
    },
  },
  plugins: [],
};
