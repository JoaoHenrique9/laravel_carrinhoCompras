const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .styles('resources/views/css/style.css', 'public/css/style.css')
    .scripts('resources/views/js/script.js', 'public/js/script.js')
    .scripts('resources/views/js/carrinho.js', 'public/js/carrinho.js')
    .sass('resources/views/scss/style.scss', 'public/site/style.css')
    .scripts('node_modules/jquery/dist/jquery.min.js', 'public/site/jquery.js')
    .scripts('node_modules/bootstrap/dist/js/bootstrap.bundle.min.js', 'public/site/bootstrap.js')
    .version();