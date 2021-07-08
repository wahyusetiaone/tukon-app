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
    .js('resources/js/all_produk.js', 'public/js')
    .js('resources/js/show_produk.js', 'public/js')
    .js('resources/js/add_produk.js', 'public/js')
    .js('resources/js/home_client.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .postCss('resources/css/home_client.css', 'public/css');
