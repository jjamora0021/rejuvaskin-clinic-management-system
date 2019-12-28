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

mix.js('resources/js/app.js', 'public/js')
	.scripts([
		'public/js/app.js',
		'resources/js/bootstrap-select.min.js',
		'resources/js/jquery.dataTables.min.js',
		'resources/js/popper.min.js',
		'resources/js/moment.js',
		'resources/js/fullcalendar.min.js',
		'resources/js/datepicker.js',
		'resources/js/datepicker.en.js',
		'resources/js/dataTables.bootstrap4.min.js',
		'resources/js/resposive.datatables.min.js',
		'resources/js/responsive.bootstrap4.min.css',
	], 'public/js/app.js')
    .sass('resources/sass/app.scss', 'public/css')
    .styles([
    	'resources/sass/bootstrap-select.min.css',
    	'resources/sass/jquery.dataTables.min.css',
    	'resources/sass/dataTables.bootstrap4.min.css',
    	'resources/sass/responsive.bootstrap4.min.css',
    	'resources/sass/datepicker.css',
	], 'public/css/all.css')
