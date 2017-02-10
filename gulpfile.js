var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.copy('node_modules/font-awesome/fonts', 'public/fonts')
    .copy('node_modules/bootstrap-sass/assets/fonts/bootstrap/', 'public/build/fonts/bootstrap')
    .copy('node_modules/animate.css/animate.min.css', 'resources/assets/css/animate.min.css')
    .copy('node_modules/bootstrap-daterangepicker/daterangepicker.css', 'resources/assets/css/daterangepicker.css')
    .sass([
        'app.scss',
        'custom.scss'
    ], 'resources/assets/css/app.css')
    .styles([
        'app.css',
        'animate.min.css',
        'daterangepicker.css'
    ], 'public/css/main.css')
    .browserify('main.js', 'public/js/main.js')
    .browserify('campaign.js', 'public/js/campaign.js')
    .scripts([
        'custom.js',
        'helper.js',
    ], 'public/js/app.js')
    .version([
        'css/main.css',
        'js/app.js',
        'js/main.js',
        'js/campaign.js'
    ])
});

