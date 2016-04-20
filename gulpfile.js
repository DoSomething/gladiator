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
    mix.copy('node_modules/@dosomething/forge/dist', 'public/assets/vendor/forge');
    mix.copy('node_modules/dosomething-modal/dist', 'public/assets/vendor/modal');
    // mix.browserify('split.js', 'public/assets/js/split.js');
    mix.scripts([
      'split.js'
    ], 'public/assets/js/main.js');
    mix.sass('app.scss', 'public/assets/css');
});
