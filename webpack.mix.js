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

// mix.js('resources/js/app.js', 'public/js')
//     .sass('resources/sass/app.scss', 'public/css');

// sửa css thì sửa ở máy file này, không phải trong public, xong chạy "npm run prod", nó sẽ mix file ra public
// nó sẽ nén 3 file thành 1 file main.css, để tối ưu
mix.styles([
    'resources/css/frontend/reset.css',    
    'resources/css/frontend/style.css',    
    'resources/css/frontend/responsive.css',    
], 'public/frontend/css/main.css').version();

mix.styles([
    'resources/css/frontend/tiktok.iframe.css',       
], 'public/frontend/css/tiktok.iframe.css');

mix.scripts([
    'resources/js/frontend/active.js',    
], 'public/frontend/js/main.js').version();
