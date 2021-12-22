const mix = require( 'laravel-mix' );

mix.webpackConfig({
	resolve: {
		extensions: ['.js', '.svelte', '.json'],
		alias: {
			'@PublicPages': __dirname + '/Resources/js/Pages',
			'@PublicShared': __dirname + '/Resources/js/Shared',
      '@PublicAssets': __dirname + '/Resources',
		},
	},
})

mix.js(__dirname + '/Resources/js/app.js', 'js/app-init.js')
    .sass( __dirname + '/Resources/sass/app.scss', 'css/app-init.css');
