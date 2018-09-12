const mix = require("laravel-mix");

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

mix
  .react("resources/js/admin.js", "public/js")
  .react("resources/js/user.js", "public/js")
  .sass("resources/sass/admin.scss", "public/css")
  .sass("resources/sass/user.scss", "public/css");

if (mix.inProduction()) {
  mix.version();
}

if (!mix.inProduction()) {
  mix.sourceMaps();
}
