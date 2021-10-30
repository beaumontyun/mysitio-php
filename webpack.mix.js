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

mix.browserSync({
    proxy: process.env.APP_URL,
    notify: false
});
mix.js('resources/js/app.js', 'public/js').vue()
.webpackConfig((webpack) => {
    return {
        plugins: [
            new webpack.DefinePlugin({
                VUE_OPTIONS_API: true,
                VUE_PROD_DEVTOOLS: false,
            })
        ]
    }
})
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
        require('autoprefixer'),
    ]);