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

mix.sass('resources/sass/app.scss', 'public/css')
	.sass('resources/sass/vendor.scss', 'public/css');

mix.js('resources/js/app.js', 'public/js/app.js')
	.extract([
		'admin-lte',
		'overlayscrollbars',
		'datatables.net-bs4',
		'datatables.net-buttons-bs4',
		'datatables.net-responsive-bs4',
		'datatables.net-fixedcolumns-bs4'
	]);

mix.scripts('resources/js/admin.js', 'public/js/admin.js');

mix.options({
	terser: {
		extractComments: false,
	},
});

mix.disableNotifications();

if (mix.inProduction()) {
	mix.version();
}
