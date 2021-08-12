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
    //search
    .js('resources/js/search.js', 'public/js')

    //tukang
    .js('resources/js/all_produk.js', 'public/js')
    .js('resources/js/show_produk.js', 'public/js')
    .js('resources/js/add_produk.js', 'public/js')
    .js('resources/js/all_pengajuan.js', 'public/js')
    .js('resources/js/all_project.js', 'public/js')
    .js('resources/js/show_pengajuan.js', 'public/js')
    .js('resources/js/home_client.js', 'public/js')
    .js('resources/js/wishlist.js', 'public/js')
    .js('resources/js/all_penawaran.js', 'public/js')
    .js('resources/js/add_penawaran_by_pengajuan.js', 'public/js')
    .js('resources/js/edit_penawaran.js', 'public/js')
    .js('resources/js/show_project.js', 'public/js')
    .js('resources/js/all_penawaran_offline.js', 'public/js')
    .js('resources/js/edit_penawaran_offline.js', 'public/js')
    .js('resources/js/add_penawaran_offline.js', 'public/js')

    //client
    .js('resources/js/form_pengajuan.js', 'public/js')
    .js('resources/js/show_pengajuan_client.js', 'public/js')
    .js('resources/js/show_produk_client.js', 'public/js')
    .js('resources/js/show_pembayaran_client.js', 'public/js')
    .js('resources/js/payoffline_pembayaran_client.js', 'public/js')
    .js('resources/js/show_project_client.js', 'public/js')

    .sass('resources/sass/app.scss', 'public/css')

    .postCss('resources/css/home_client.css', 'public/css')
    .postCss('resources/css/show_proyek.css', 'public/css')
    .postCss('resources/css/wishlist.css', 'public/css');
