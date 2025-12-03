import { defineConfig } from 'vite'
import { resolve } from 'path'
import fs from 'fs'
import path from 'path'

const STYLE_VERSION = `3.0.${Math.floor(Date.now() / 1000)}`

const stringReplacePlugin = () => {
  return {
    name: 'string-replace',
    apply: 'build',
    enforce: 'post',
    generateBundle(options, bundle) {
      for (const [fileName, asset] of Object.entries(bundle)) {
        if (asset.type === 'asset' && fileName.endsWith('.css')) {
          let code = asset.source.toString()
          code = code.replace(/STYLE_VERSION/g, STYLE_VERSION)
          code = code.replace(/owl\.video\.play\.png/g, './images/owl-carousel/owl.video.play.png')
          asset.source = code
        }
      }
    }
  }
}

const copyFilesPlugin = () => {
  return {
    name: 'copy-files',
    apply: 'build',
    enforce: 'post',
    async generateBundle() {
      const filesToCopy = [
        { src: 'node_modules/bootstrap/dist/css/bootstrap.css', dest: 'origamiez/css/bootstrap.css' },
        { src: 'node_modules/bootstrap/dist/js/bootstrap.js', dest: 'origamiez/js/bootstrap.js' },
        { src: 'node_modules/@fortawesome/fontawesome-free/css/all.css', dest: 'origamiez/css/fontawesome.css' },
        { src: 'node_modules/owl.carousel/dist/assets/owl.carousel.css', dest: 'origamiez/css/owl.carousel.css' },
        { src: 'node_modules/owl.carousel/dist/assets/owl.theme.default.css', dest: 'origamiez/css/owl.theme.default.css' },
        { src: 'node_modules/owl.carousel/dist/owl.carousel.js', dest: 'origamiez/js/owl.carousel.js' },
        { src: 'node_modules/superfish/dist/css/superfish.css', dest: 'origamiez/css/superfish.css' },
        { src: 'node_modules/superfish/dist/js/superfish.js', dest: 'origamiez/js/superfish.js' },
        { src: 'node_modules/Navgoco/src/jquery.navgoco.css', dest: 'origamiez/css/jquery.navgoco.css' },
        { src: 'node_modules/Navgoco/src/jquery.navgoco.js', dest: 'origamiez/js/jquery.navgoco.js' },
        { src: 'node_modules/jquery-poptrox/src/js/jquery.poptrox.js', dest: 'origamiez/js/jquery.poptrox.js' },
        { src: 'node_modules/jquery-poptrox/src/css/jquery.poptrox.css', dest: 'origamiez/css/jquery.poptrox.css' }
      ]

      for (const file of filesToCopy) {
        try {
          const srcPath = resolve(file.src)
          const destPath = resolve(file.dest)
          const destDir = path.dirname(destPath)
          
          if (!fs.existsSync(destDir)) {
            fs.mkdirSync(destDir, { recursive: true })
          }
          
          fs.copyFileSync(srcPath, destPath)
          console.log(`Copied ${file.src}`)
        } catch (error) {
          console.warn(`Warning: Could not copy ${file.src}:`, error.message)
        }
      }
    }
  }
}

export default defineConfig({
  plugins: [stringReplacePlugin(), copyFilesPlugin()],
  build: {
    outDir: 'origamiez',
    emptyOutDir: false,
    cssCodeSplit: true,
    minify: false,
    rollupOptions: {
      input: {
        style: resolve(__dirname, 'style.scss'),
        script: resolve(__dirname, 'assets/js/script.js')
      },
      output: {
        entryFileNames: (chunkInfo) => {
          if (chunkInfo.name === 'script') {
            return 'js/[name].js'
          }
          return '[name].js'
        },
        chunkFileNames: '[name]-[hash].js',
        assetFileNames: (assetInfo) => {
          if (assetInfo.name.endsWith('.css')) {
            if (assetInfo.name === 'style.css') {
              return 'style.css'
            }
          }
          return '[name]-[hash][extname]'
        },
        dir: 'origamiez'
      }
    }
  },
  css: {
    preprocessorOptions: {
      scss: {
        quietDeps: true,
        silenceDeprecations: ['legacy-js-api', 'import']
      }
    }
  }
})
