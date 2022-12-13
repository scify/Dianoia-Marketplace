const mix = require('laravel-mix');
const ESLintPlugin = require('eslint-webpack-plugin');

mix.disableSuccessNotifications();

mix.webpackConfig({
    plugins: [new ESLintPlugin({
        fix: true,
        extensions: ['js', 'vue'],
    })],
});
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/dist/js')
    .js('resources/js/admin/user-management.js', 'public/dist/js')
    .js('resources/js/home.js', 'public/dist/js')
    .js('resources/js/create-edit-resource.js', 'public/dist/js')
    .js('resources/js/content-guidelines.js','public/dist/js')
    .extract([
        'jquery', 'bootstrap'
    ])
    .sourceMaps()
    .webpackConfig({
        devtool: 'source-map'
    })
    .version()
    .vue();

mix.autoload({
    'jquery': ['$', 'window.jQuery', 'jQuery']
});

mix.sass('resources/sass/main.scss', 'public/dist/css')
    .sass('resources/sass/form-new-exercise.scss','public/dist/css')
    .sass('resources/sass/login-page.scss', 'public/dist/css')
    .sass('resources/sass/login-page-shapes.scss', 'public/dist/css')
    .sass('resources/sass/exercise-template.scss', 'public/dist/css')
    .sass('resources/sass/homepage.scss', 'public/dist/css')
    .sass('resources/sass/profile-page.scss', 'public/dist/css')
    .sass('resources/sass/exercise-page.scss', 'public/dist/css')
    .sass('resources/sass/resources-index.scss', 'public/dist/css')
    .sass('resources/sass/create-edit.scss', 'public/dist/css')
    .sass('resources/sass/content-guidelines.scss', 'public/dist/css')
    .sass('resources/sass/terms-of-use.scss', 'public/dist/css')
    .sass('resources/sass/user-management.scss', 'public/dist/css')
    .sourceMaps()
    .webpackConfig({
        devtool: 'source-map'
    })
    .version();
