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
        // Torre de control analógica: nada de geométricas de SaaS (Inter/
        // Poppins/Manrope). Stencil industrial para headers/labels, mono de
        // teletipo real (no una mono de programador tipo JetBrains/Space
        // Mono, esa es la que usa cualquier dashboard "IA" — Courier Prime
        // es la que de verdad se parece a un impreso de matriz de agujas)
        // para todo lo demás. Se mantienen las claves 'sans'/'heading' que
        // ya usa cada template — así el cambio de fuente no pide tocar 20
        // archivos, solo esto.
        sans: ['"Courier Prime"', 'ui-monospace', 'monospace'],
        heading: ['"Big Shoulders Stencil"', 'sans-serif'],
      },
      colors: {
        // Tokens nuevos, propios del concepto.
        anthracite: '#1C1B18',
        panel: '#232019',
        metal: '#3A3833',
        amber: '#FFB000',
        hazard: '#E8A400',
        critical: '#B33A1E',
        // Se pisan blue/slate/red/green default de Tailwind: todo el theme
        // ya está escrito en blue-900, slate-600, red-600, etc. — repintar
        // estos tokens repinta el sitio entero sin tocar cada archivo.
        // blue-900/700 (antes: azul marca, botones/links) -> ámbar (único
        // color de fósforo, acento). blue-500 (antes: mitad del gradiente)
        // -> metal (el gradiente del hero/footer se redefine aparte, no
        // depende más de esto, pero queda coherente por si algo lo usa).
        blue: {
          50: '#2A2620',
          100: '#BFB6A3',
          200: '#C9A876',
          500: '#3A3833',
          700: '#FFB000',
          800: '#D99A1F',
          900: '#FFB000',
        },
        // slate (antes: texto/bordes en modo claro) -> rampa invertida:
        // 900 pasa a ser el tono MÁS CLARO (headings sobre fondo oscuro) y
        // 50 el MÁS OSCURO (fondos de panel sutiles). Mismo criterio de uso
        // en cada template, dirección de la escala invertida a propósito.
        slate: {
          50: '#242019',
          100: '#3A3833',
          300: '#5C574B',
          500: '#8C8577',
          600: '#A69C89',
          700: '#BFB6A3',
          800: '#D8CFC0',
          900: '#EDE6D9',
        },
        red: {
          200: '#D98C6E',
          600: '#B33A1E',
        },
        green: {
          700: '#7FBF3F',
        },
      },
    },
  },
  plugins: [],
};
