module.exports = {
  corePlugins: {
    float: false,
    appearance: false,
    wordBreak: false,
    userSelect: false,
    objectFit: false,
    objectPosition: false,
    listStylePosition: false,
    listStyleType: false,
    backgroundAttachment: false,
    fontSmoothing: false,
    outline: false,
    resize: false
  },
  theme: {
    fontFamily: {
      sans: ['Fira Sans', 'sans-serif'],
      serif: ['Fira Sans', 'serif'],
      heading: ['Ubuntu', 'sans-serif']
    },
    container: {
      center: true,
      padding: '0.625rem'
    },
    screens: {
      'md': '768px',
      'lg': '1024px',
      'xl': '1280px',
      'xxl': '1680px'
    },
    extend: {
      colors: {
        grey: {
          '900': '#ffffff',
        },
        green: {
          '500': '#333333',
        },
        yellow: {
          '500': '#daa520',
        }
      },
    },
  },
  variants: {
    boxShadow: ['responsive', 'hover'],
    borderColor: ['responsive', 'hover'],
    backgroundColor: ['responsive', 'hover'],
    backgroundRepeat: [],
    fontFamily: [],
    fontWeight: ['responsive'],
    letterSpacing: [],
    pointerEvents: [],
    textColor: ['responsive', 'hover'],
    textDecoration: [],
    textTransform: [],
    inset: ['responsive', 'hover']
  },
  plugins: [
      require('@tailwindcss/custom-forms')
  ]
};
