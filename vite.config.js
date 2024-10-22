import path from 'node:path'
import { glob } from 'glob'

import postcssCombineDuplicatedSelectors from 'postcss-combine-duplicated-selectors'
import postcssCombineMediaQuery from 'postcss-combine-media-query'

import unoCSS from 'unocss/vite'
import eslint from 'vite-plugin-eslint'
import kirby from 'vite-plugin-kirby'
import stylelint from 'vite-plugin-stylelint'

const projectDir = path.dirname(new URL(import.meta.url).pathname)
const srcDir = path.resolve(projectDir, 'src')
const pluginsDir = path.resolve(projectDir, 'site/plugins')
const outDir = path.resolve(projectDir, 'www/assets')
const buildAssetsDir = '.'

export default ({ mode }) => ({

  base: mode === 'development' ? '/' : '/assets/',

  root: srcDir,

  resolve: {
    alias: [
      {
        find: '@',
        replacement: srcDir,
      },
      {
        find: '@plugins',
        replacement: pluginsDir,
      },
      {
        find: '@storage',
        replacement: path.resolve(projectDir, 'storage'),
      },
    ],
  },

  build: {
    outDir,
    assetsDir: buildAssetsDir,
    rollupOptions: {
      input: [
        path.resolve(srcDir, 'vite.entry.js'),
        path.resolve(srcDir, 'scripts/posts.js'),
        path.resolve(srcDir, 'scripts/post.js'),
        ...glob.sync(path.resolve(srcDir, 'scripts/pages/**/*.js')),
      ],
    },
  },

  css: {

    preprocessorOptions: {
      scss: {
        additionalData: `@use "@/styles/abstracts/" as *;`,
      },
    },
    postcss: {
      plugins: [
        postcssCombineMediaQuery,
        postcssCombineDuplicatedSelectors,
      ],
    },
  },

  plugins: [
    kirby({
      watch: [
        '../site/**/(templates|snippets|controllers|models|layouts)/**/*.php',
        '../content/**/*',
      ],
    }),
    unoCSS(),
    stylelint(),
    {
      apply: 'build',
      ...eslint(),
    },
    {
      apply: 'serve',
      ...eslint({
        failOnWarning: false,
        failOnError: false,
      }),
      enforce: 'post',
    },
  ],
})
