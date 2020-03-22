const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');

mix.js('resources/js/admin/app.js', 'public/js/admin.js')
    .sass('resources/sass/admin/app.scss', 'public/css/admin.css');

mix.js('resources/js/client/app.js', 'public/js/client.js')
    .sass('resources/sass/client/app.scss', 'public/css/client.css')
    .options({
      processCssUrls: false,
      postCss: [ tailwindcss('./tailwind.config.js') ],
    });