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

mix.js('resources/js/emails/create.js', 'public/js/emails')
    .js('resources/js/comparator/db.js', 'public/js/comparator')
    .js('resources/js/tags/create.js', 'public/js/tags')
    // .sass('resources/sass/app.scss', 'public/css');
