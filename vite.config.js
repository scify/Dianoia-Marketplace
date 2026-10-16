import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue2";

export default defineConfig({
	plugins: [
		laravel({
			input: [
				"resources/js/app.js",
				"resources/js/admin/user-management.js",
				"resources/js/home.js",
				"resources/js/create-edit-resource.js",
				"resources/js/content-guidelines.js",
				"resources/sass/main.scss",
				"resources/sass/form-new-exercise.scss",
				"resources/sass/login-page.scss",
				"resources/sass/exercise-template.scss",
				"resources/sass/homepage.scss",
				"resources/sass/profile-page.scss",
				"resources/sass/exercise-page.scss",
				"resources/sass/resources-index.scss",
				"resources/sass/create-edit.scss",
				"resources/sass/content-guidelines.scss",
				"resources/sass/tutorial.scss",
				"resources/sass/user-management.scss",
			],
			refresh: true,
		}),
		vue({
			template: {
				transformAssetUrls: {
					base: null,
					includeAbsolute: false,
				},
			},
		}),
	],
	resolve: {
		// The Blade layout uses in-DOM Vue templates, so the build must include the template compiler.
		alias: [{ find: /^vue$/, replacement: "vue/dist/vue.esm.js" }],
	},
	build: {
		sourcemap: true,
	},
	css: {
		preprocessorOptions: {
			scss: {
				quietDeps: true,
				silenceDeprecations: ["import"],
			},
		},
	},
});
