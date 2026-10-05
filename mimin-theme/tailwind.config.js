/** Mimin theme — Tailwind build config (mirrors the demo's CDN config) */
module.exports = {
  content: [
    './**/*.php',
    './assets/js/**/*.js',
    '!./node_modules/**',
  ],
  theme: {
    extend: {
      colors: {
        sage:  '#D5E4E1',
        mist:  '#F0F0F0',
        smoke: '#F3F3F3',
        soft:  '#8B8B8B',
        line:  '#EDEDED',
        line2: '#E1E1E1',
      },
      fontFamily: {
        sans: ['Jost', 'Futura', 'Century Gothic', 'ui-sans-serif', 'system-ui', 'sans-serif'],
      },
      maxWidth: {
        boxed: '1200px',
      },
    },
  },
  corePlugins: {
    preflight: true,
  },
  plugins: [],
};
