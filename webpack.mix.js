const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |mix.setResourceRoot('/public/');

 */

mix.copyDirectory('resources/fonts', 'public/fonts');


mix.js('resources/js/app.js', 'public/js')
    //auth
    .js('resources/js/registrasi.js', 'public/js')

    //base_url
    .js('resources/js/base_url.js', 'public/js')

    //pdf-mobile
    .js('resources/js/pdf_mobile.js', 'public/js')


    //echo
    .js('resources/js/echo.js', 'public/js')

    //search
    .js('resources/js/search.js', 'public/js')
    .js('resources/js/search_only_page_active.js', 'public/js')

    //guest
    .js('resources/js/all_produk_guest.js', 'public/js')

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
    .js('resources/js/all_penarikan_dana.js', 'public/js')
    .js('resources/js/show_profile_tukang.js', 'public/js')
    .js('resources/js/show_change_photo_tukang.js', 'public/js')
    .js('resources/js/app_root.js', 'public/js')


    //client
    .js('resources/js/form_pengajuan.js', 'public/js')
    .js('resources/js/show_pengajuan_client.js', 'public/js')
    .js('resources/js/edit_pengajuan_client.js', 'public/js')
    .js('resources/js/show_produk_client.js', 'public/js')
    .js('resources/js/show_pembayaran_client.js', 'public/js')
    .js('resources/js/payoffline_pembayaran_client.js', 'public/js')
    .js('resources/js/show_project_client.js', 'public/js')
    .js('resources/js/show_profile_client.js', 'public/js')
    .js('resources/js/show_change_photo_client.js', 'public/js')
    .js('resources/js/konfirmasi_pengembalian_client.js', 'public/js')
    .js('resources/js/all_client_project.js', 'public/js')
    .js('resources/js/app_client.js', 'public/js')

    //admin
    .js('resources/js/all_penarikan_admin.js', 'public/js')
    .js('resources/js/all_pembayaran_admin.js', 'public/js')
    .js('resources/js/konfirmasi_pembayaran_admin.js', 'public/js')
    .js('resources/js/all_penawaran_admin.js', 'public/js')
    .js('resources/js/all_pengajuan_admin.js', 'public/js')
    .js('resources/js/all_user_admin.js', 'public/js')
    .js('resources/js/show_profile_user_admin.js', 'public/js')
    .js('resources/js/konfirmasi_penarikan_admin.js', 'public/js')
    .js('resources/js/all_pengembalian_admin.js', 'public/js')
    .js('resources/js/konfirmasi_pengembalian_admin.js', 'public/js')
    .js('resources/js/all_bpa_admin.js', 'public/js')
    .js('resources/js/add_admin_user_admin.js', 'public/js')
    .js('resources/js/all_verification_admin.js', 'public/js')
    .js('resources/js/show_verification_admin.js', 'public/js')

    .sass('resources/sass/app.scss', 'public/css')

    .postCss('resources/css/home_client.css', 'public/css')
    .postCss('resources/css/show_proyek.css', 'public/css')
    .postCss('resources/css/wishlist.css', 'public/css')
    .postCss('resources/css/costume_app.css', 'public/css')
    .postCss('resources/css/sidebar.css', 'public/css')

    //font awesome
    .copy(
        'node_modules/@fortawesome/fontawesome-free/webfonts',
        'public/webfonts',
    )
