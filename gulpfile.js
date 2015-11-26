process.env.DISABLE_NOTIFIER = true;
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
    //mix.sass('app.scss', 'resources/assets/css');


    mix.styles
        ([

            'libs/bootstrap.min.css',
            'app.css'

        ]);


    mix.scripts
        ([
            'libs/jquery.min.js',
            'libs/bootstrap.min.js',
            'libs/html5.shiv.js',
            'libs/respond.min.js',
            'mapfunctions.js'

        ]);


});
