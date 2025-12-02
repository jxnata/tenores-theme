import tailwindcss from '@tailwindcss/vite'
import { copyFileSync, existsSync, mkdirSync, readdirSync, statSync } from 'fs'
import { join } from 'path'
import { defineConfig } from 'vite'

function copyAssetsPlugin() {
	return {
		name: 'copy-assets',
		generateBundle() {
			// Copy images
			const imagesSrcDir = 'resources/images'
			const imagesDestDir = 'dist/images'

			if (!existsSync(imagesDestDir)) {
				mkdirSync(imagesDestDir, { recursive: true })
			}

			// Copy fonts
			const fontsSrcDir = 'resources/fonts'
			const fontsDestDir = 'dist/fonts'

			if (!existsSync(fontsDestDir)) {
				mkdirSync(fontsDestDir, { recursive: true })
			}

			function copyRecursive(src, dest) {
				const entries = readdirSync(src)

				for (const entry of entries) {
					const srcPath = join(src, entry)
					const destPath = join(dest, entry)

					if (statSync(srcPath).isDirectory()) {
						if (!existsSync(destPath)) {
							mkdirSync(destPath, { recursive: true })
						}
						copyRecursive(srcPath, destPath)
					} else if (!entry.startsWith('.')) {
						copyFileSync(srcPath, destPath)
					}
				}
			}

			if (existsSync(imagesSrcDir)) {
				copyRecursive(imagesSrcDir, imagesDestDir)
			}

			if (existsSync(fontsSrcDir)) {
				copyRecursive(fontsSrcDir, fontsDestDir)
			}
		},
	}
}

export default defineConfig(({ command }) => {
	const isBuild = command === 'build'

	return {
		base: isBuild ? '/wp-content/themes/tenores/dist/' : '/',
		server: {
			port: 3000,
			cors: true,
			origin: 'http://localhost:8888',
		},
		build: {
			manifest: true,
			outDir: 'dist',
			rollupOptions: {
				input: ['resources/js/app.js', 'resources/css/app.css', 'resources/css/editor-style.css'],
			},
		},
		plugins: [tailwindcss(), copyAssetsPlugin()],
	}
})
