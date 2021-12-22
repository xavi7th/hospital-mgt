const mix = require( 'laravel-mix' );

mix.webpackConfig({
	resolve: {
		extensions: ['.js', '.svelte', '.json'],
		alias: {
			'@superadmin-pages': __dirname + '/Resources/js/Pages',
			'@superadmin-shared': __dirname + '/Resources/js/Shared',
      '@superadmin-assets': __dirname + '/Resources',
		},
	},
})

mix.js(__dirname + '/Resources/js/app.js', 'js/sup-admin.js')
    .sass( __dirname + '/Resources/sass/app.scss', 'css/sup-admin.css');
