const mix = require( 'laravel-mix' );

mix.webpackConfig({
	resolve: {
		extensions: ['.js', '.svelte', '.json'],
		alias: {
			'@frontdeskuser-pages': __dirname + '/Resources/js/Pages',
			'@frontdeskuser-shared': __dirname + '/Resources/js/Shared',
      '@frontdeskuser-assets': __dirname + '/Resources',
		},
	},
})

mix.copyDirectory( __dirname + '/Resources/vendor/img', 'public_html/img' );

mix.scripts( [
  __dirname + '/../Miscellaneous/Resources/js/Shared/dropify/jquery-3.2.1.min.js',
  __dirname + '/../Miscellaneous/Resources/js/Shared/dropify/dropify.min.js',
  __dirname + '/Resources/vendor/js/app.js',
], 'public_html/js/dashboard-init.js' );


mix.js(__dirname + '/Resources/js/app.js', 'js/dashboard.js')
    .sass( __dirname + '/Resources/sass/app.scss', 'css/dashboard.css');
