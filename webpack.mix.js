const { mix } = require('laravel-mix');

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

mix.autoload({});

const fs = require('fs');
let folder = 'resources/assets';
let available_locales = ['uk', 'ru'];

mix.copy(`${folder}/img`, 'public/img', false);
mix.copy(`${folder}/views`, 'public/views', false);
mix.copy(`${folder}/fonts`, 'public/fonts', false);

fs.readdirSync(`${folder}/css`)
    .forEach(file => {
        if ('print-card.css' === file) mix.copy(`${folder}/css/${file}`, `public/css/${file}`);
        else mix.sass(`${folder}/css/${file}`, `public/css/${file}`)
	   .options({ processCssUrls: false });
    });

fs.readdirSync(`${folder}/js`)
    .forEach(file => {
        let path = `${folder}/js/${file}`;
        if(fs.lstatSync(path).isFile()){
            mix.js(path, 'public/js');
        }
    });

available_locales.map((locale) => {
    mix.js([
        `${folder}/lib/angular-i18n/${locale}.js`,
        `${folder}/lib/angular-i18n/angular-locale_${locale}.js`,
    ], `public/js/${locale}.js`)
});

mix.sass(`${folder}/sass/app.scss`, 'public/css');

if (mix.config.inProduction) {
    mix.version();
}
