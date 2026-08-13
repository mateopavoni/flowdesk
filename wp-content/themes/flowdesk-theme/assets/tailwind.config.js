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
        // Bricolage Grotesque (display geométrica) para headings; DM Sans
        // para el cuerpo. Se mantienen las claves 'sans'/'heading' que ya
        // usa cada template — solo cambia qué tipografía cargan.
        sans: ['"DM Sans"', 'ui-sans-serif', 'system-ui'],
        heading: ['"Bricolage Grotesque"', 'ui-sans-serif', 'system-ui'],
      },
      colors: {
        // Paleta "Violet Hour" (reemplaza "Ink & Paper", ver commit-plan.md):
        // dark SaaS, acento violeta + amarillo. Nombres propios a propósito
        // — NI pisan defaults de Tailwind (mismo criterio que Ink & Paper)
        // NI reusan los nombres del export de UX Pilot (ink/slate), que
        // hubieran colisionado con 'slate' default y con el 'ink' viejo
        // (mismo nombre, valores opuestos: texto oscuro vs. fondo oscuro).
        void:   '#1A1B2E', // fondo base
        panel:  '#2D2F4A', // superficies/cards/nav; también borde vía /60 (border-panel/60)
        bone:   '#F0EDFF', // texto principal sobre fondo oscuro
        haze:   '#B8B4D4', // texto secundario/mutado
        violet: '#7B6FE8', // acento primario — CTAs, links, glow
        amber:  '#E8D56F', // acento secundario — badges, eyebrows, detalles puntuales
      },
      boxShadow: {
        glow: '0 8px 30px -8px rgba(123, 111, 232, 0.45)',
      },
    },
  },
  plugins: [],
};
