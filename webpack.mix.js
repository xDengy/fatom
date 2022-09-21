const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/js')
    .styles('resources/css/bootstrap/bootstrap.css', 'public/css/bootstrap/bootstrap.css')
    .styles('resources/css/fancybox/fancybox.css', 'public/css/fancybox/fancybox.css')
    .styles('resources/css/jquery-ui/jquery-ui.min.css', 'public/css/jquery-ui/jquery-ui.min.css')
    .styles('resources/css/mCustomScrollbar/mCustomScrollbar.css', 'public/css/mCustomScrollbar/mCustomScrollbar.css')
    .styles('resources/css/slick/slick.css', 'public/css/slick/slick.css')
    .styles('resources/css/screen.css', 'public/css/screen.css')
    .styles('resources/css/minishop2/default.css', 'public/css/minishop2/default.css')
    .styles('resources/css/minishop2/lib/jquery.jgrowl.min.css', 'public/css/minishop2/lib/jquery.jgrowl.min.css')
    .styles('resources/css/msearch2/default.css', 'public/css/msearch2/default.css')
    .styles('resources/css/ajaxform/default.css', 'public/css/ajaxform/default.css')
    .styles('resources/css/ajaxform/lib/jquery.jgrowl.min.css', 'public/css/ajaxform/lib/jquery.jgrowl.min.css')
    .styles('resources/css/screen.css', 'public/css/screen.css')
    .styles('resources/css/cityfields/cityselect.css', 'public/css/cityfields/cityselect.css')
    .styles('resources/css/custom.css', 'public/css/custom.css')

mix.copy('resources/js', 'public/js')
mix.copy('resources/css/fonts', 'public/css/fonts')

    // mix.js('resources/js/bootstrap/bootstrap.js', 'public/js/bootstrap')
    // mix.js('resources/js/bootstrap/popper.min.js', 'public/js/bootstrap')
    // mix.js('resources/js/slick/slick.min.js', 'public/js/slick')
    // mix.js('resources/js/fancybox/fancybox.js', 'public/js/fancybox')
    // mix.js('resources/js/inputmask.min.js', 'public/js')
    // mix.js('resources/js/jquery-ui/jquery-ui.min.js', 'public/js/jquery-ui')
    // mix.copy('resources/js/scripts.js', 'public/js')
    // mix.js('resources/js/jquery-ui/jquery-ui.touch-punch.js', 'public/js/jquery-ui')
    // mix.js('resources/js/msearch2/default.js', 'public/js/msearch2')
    // mix.js('resources/js/minishop2/default.js', 'public/js/minishop2')
    // mix.js('resources/js/ajaxform/default.js', 'public/js/ajaxform')
    // mix.js('resources/js/mCustomScrollbar/mCustomScrollbar.js', 'public/js/mCustomScrollbar')
    // mix.js('resources/js/cityfields/cityselect.js', 'public/js/cityfields')

    .copy('resources/images', 'public/images')
