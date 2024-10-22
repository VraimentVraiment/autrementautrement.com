import transformerDirectives from '@unocss/transformer-directives'

import {
  defineConfig,
  presetIcons,
  presetTypography,
  presetWind,
} from 'unocss'

const colors = {
  black: '#3D3529',
  white: '#F3EDE3',
  blackLight: '#7D715E',
  blackLightest: '#CBC0B1',
}

const tokens = {
  'bg': colors.white,
  'font': colors.black,
  'font-light': colors.blackLight,
  'border': colors.blackLightest,
}

export default defineConfig({

  theme: {
    breakpoints: {
      sm: '375px',
      md: '767px',
      lg: '991px',
      xl: '1447px',
      xxl: '1920px',
    },
    colors: {
      ...colors,
      ...tokens,
    },
  },

  presets: [
    presetWind(),
    presetIcons({
      extraProperties: {
        'display': 'inline-block',
        'white-space': 'nowrap',
        'vertical-align': 'sub',
      },
    }),
    presetTypography(),
  ],

  transformers: [
    transformerDirectives(),
  ],

  safelist: [
    'inline',
    'py-12',
    'i-ri-close-fill',
    'i-ri-mail-line',
    'i-ri-phone-line',
    'i-ri-map-pin-2-line',
    'i-ri-arrow-right-line',
    'i-ri-external-link-line',
    'i-ri-twitter-fill',
    'i-ri-instagram-fill',
    'i-ri-linkedin-box-fill',
    'i-ri-github-fill',
    'col-span-1',
    'col-span-2',
    'col-span-3',
    'col-span-4',
    'col-span-5',
    'col-span-6',
    'md:col-span-1',
    'md:col-span-2',
    'md:col-span-3',
    'md:col-span-4',
    'md:col-span-5',
    'md:col-span-6',
  ],
})
